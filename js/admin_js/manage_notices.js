document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.getElementById("tableBody");
  tableBody.addEventListener("click", function (e) {
    if (e.target.classList.contains("deleteBtn")) {
      const btn = e.target;
      const row = btn.closest("tr");
      const id = btn.dataset.id;
      Swal.fire({
        title: "Are you sure?",
        text: "This notice will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("delete_notice.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "id=" + encodeURIComponent(id),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                Swal.fire({
                  title: "Success",
                  text: data.message,
                  icon: "success",
                  confirmButtonText: "OK",
                }).then(() => {
                  row.remove();
                });
              } else {
                Swal.fire({
                  title: "Error",
                  text: data.message,
                  icon: "error",
                  confirmButtonText: "OK",
                });
              }
            });
        }
      });
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const searchBox = document.getElementById("searchBox");
  const tableBody = document.getElementById("tableBody");

  function loadNotices(search = "") {
    fetch("search_manage_notices.php", {
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

  loadNotices();

  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadNotices(search);
  });
});
