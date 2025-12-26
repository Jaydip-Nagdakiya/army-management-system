const tableBody = document.getElementById("inventoryTablebody");
const searchBox = document.getElementById("searchBox");

function loadinventory(search = "") {
  fetch("search_manage_inventory.php", {
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


tableBody.addEventListener("click", function (e) {
  // console.log(e.target);
  if (e.target.classList.contains("deleteBtn")) {
    let btn = e.target;
    let row = btn.closest("tr");
    const id = btn.dataset.id;
    // console.log(id);
    Swal.fire({
      title: "Are You Sure ?",
      text: "This Inventory Will Be Permanently Deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, Delete It!",
      cancelButtonText: "No, Cancle",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("delete_inventory.php", {
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
                loadinventory();
              });
            } else {
              Swal.fire("Error", data.message, "error");
            }
          })
          .catch((err) => {
            Swal.fire("Error!", "Somthing went wrong.", "error");
            console.error(err);
          });
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  loadinventory();

  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadinventory(search);
  });
});
