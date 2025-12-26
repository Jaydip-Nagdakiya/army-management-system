const tableBody = document.getElementById("soldierTableBody");
const searchBox = document.getElementById("searchBox");

function loadSoldiers(search = "") {
    fetch("search_manage_soldiers.php", {
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
  if (e.target.classList.contains("deleteBtn")) {
    let btn = e.target;
    let row = btn.closest("tr");
    const soldierid = btn.dataset.id;
    // console.log(soldierid);

    Swal.fire({
      title: "Are you sure?",
      text: "This soldier record will be permanently deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("delete_soldier.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "id=" + encodeURIComponent(soldierid),
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
                loadSoldiers();
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
  if (e.target.classList.contains("toggleStatusBtn")) {
    let btn = e.target;
    const soldierid = btn.dataset.id;
    const newStatus = btn.dataset.status;

    Swal.fire({
      title: "Are you sure?",
      text: `You are about to set this soldier as ${newStatus}`,
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: `Yes, ${newStatus} it!`,
      cancelButtonText: "No , Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("update_soldier_status.php", {
          method: "post",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body:
            "id=" +
            encodeURIComponent(soldierid) +
            "&status=" +
            encodeURIComponent(newStatus),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              Swal.fire("Updated!", data.message, "success").then(() => {
                loadSoldiers();
              });
            }
          });
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  loadSoldiers();
  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadSoldiers(search);
  });
});
