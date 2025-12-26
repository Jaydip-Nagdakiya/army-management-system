 const searchBox = document.getElementById("searchBox");
  const tableBody = document.getElementById("tableBody");

  function loadMissions(search = "") {
    fetch("search_manage_assign_mission.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "search=" + encodeURIComponent(search),
    })
      .then((response) => response.text())
      .then((data) => {
        tableBody.innerHTML = data;
      })
      .catch((error) => console.error("Error:", error));
  }

document.addEventListener("DOMContentLoaded", function () {

  tableBody.addEventListener("click", function (e) {
    if (e.target.classList.contains("deleteBtn")) {
      const btn = e.target;
      const row = btn.closest("tr");
      const id = btn.dataset.id;
      Swal.fire({
        title: "Are you sure?",
        text: "This mission details will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3086d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("delete_assign_mission.php", {
            method: "post",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + encodeURIComponent(id),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status == "success") {
                Swal.fire("Success", data.message, "success").then(() => {
                  loadMissions();
                });
              } else {
                Swal.fire("Error", data.message, "error");
              }
            })
            .catch((err) => {
              console.error(err);
            });
        }
      });
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
 

  loadMissions();

  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadMissions(search);
  });
});
