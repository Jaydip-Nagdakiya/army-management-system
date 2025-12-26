function loadLeave() {
  fetch("fetch_leave.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("leave_data").innerHTML = data;
      attachApproveEvents();
      attachRejectEvent();
    })
    .catch((err) => console.error("Error fetching leave data:", err));
}

function attachApproveEvents() {
  const btnApproveAll = document.querySelectorAll(".ApproveBtn");

  btnApproveAll.forEach((btn) => {
    btn.addEventListener("click", function () {
      const leaveId = this.getAttribute("data-id");
      const status = this.getAttribute("status");
      Swal.fire({
        title: "Are you sure?",
        text: "You want to Approved this leave request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Approve it!",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("leave_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + leaveId + "&status=" + status,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                Swal.fire("Success!", data.message, "success");
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

function attachRejectEvent() {
  const btnRejectAll = document.querySelectorAll(".RejectBtn");

  btnRejectAll.forEach((btn) => {
    btn.addEventListener("click", function () {
      const leaveId = this.getAttribute("data-id");
      const status = this.getAttribute("status");
      Swal.fire({
        title: "Are you sure?",
        text: "You want to Reject this leave request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, Reject it!",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("leave_process.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + leaveId + "&status=" + status,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                Swal.fire("Success!", data.message, "success");
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

loadLeave();
setInterval(loadLeave, 2000);
