
function loadLeaveStatus() {
  fetch("fetch_leave_status.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("leave_data").innerHTML = data;
      attachDeleteEvents();
      attachUpdateEvents();
    })
    .catch((err) => console.error("Error fetching leave data:", err));
}


function attachDeleteEvents() {
  const btnDeleteAll = document.querySelectorAll(".btnDelete");

  btnDeleteAll.forEach((btn) => {
    btn.addEventListener("click", function () {
      const leaveId = this.getAttribute("data-id"); 

      Swal.fire({
        title: "Are you sure?",
        text: "This Leave Application will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("delete_leave.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + leaveId,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                Swal.fire("Deleted!", data.message, "success");
              } else {
                Swal.fire("Error!", data.message, "error");
              }
            })
            .catch((err) => {
              console.error("Delete error:", err);
              Swal.fire("Error!", "Something went wrong.", "error");
            });
        }
      });
    });
  });
}

function attachUpdateEvents() {
  const btnUpdateAll = document.querySelectorAll(".updateBtn");

  btnUpdateAll.forEach((btn) => {
    btn.addEventListener("click", function () {
      let leaveId = this.getAttribute("data-id"); 
      document.getElementById('hiddenid').value = leaveId;
      document.getElementById('editForm').submit();

    });
  });
}

loadLeaveStatus();
setInterval(loadLeaveStatus, 2000);
