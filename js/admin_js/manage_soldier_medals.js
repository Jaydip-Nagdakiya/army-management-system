const tableBody = document.getElementById("tableBody");
const searchBox = document.getElementById("searchBox");



  tableBody.addEventListener("click", function (e) {
    if(e.target.classList.contains("deleteBtn")){
      let btn = e.target;
    let row = btn.closest("tr");
    let id = btn.dataset.id;
    Swal.fire({
      title: "Are you sure?",
      text: "This medal record will be permanently deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3086d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("delete_medal.php", {
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
                loadmedals();
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


  function loadmedals(search = "") {
    fetch("search_manage_medals.php", {
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
  loadmedals();
  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadmedals(search);
  });
});
