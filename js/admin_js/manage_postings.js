const tableBody = document.getElementById("tableBody");
const searchBox = document.getElementById("searchBox");

function loadPostings(search = "") {
  fetch("search_manage_posting.php", {
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
const deleteBtn = document.querySelectorAll(".deleteBtn");
tableBody.addEventListener("click", function (e) {
  if (e.target.classList.contains("deleteBtn")) {
    let btn = e.target;
    let row = btn.closest("tr");
    let posting_id = btn.dataset.id;
    Swal.fire({
      title: "Are you sure?",
      text: "This posting record will be permanently deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("delete_posting.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "id=" + encodeURIComponent(posting_id),
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
                loadPostings();
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


document.addEventListener("DOMContentLoaded", function () {
  loadPostings();
  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadPostings(search);
  });
});