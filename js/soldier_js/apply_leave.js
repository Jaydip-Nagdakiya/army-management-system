const submitBtn = document.getElementById("submitBtn");
const today = new Date().toISOString().split("T")[0];
const leaveType = document.getElementById("leaveType");
const startDate = document.getElementById("startDate");
const endDate = document.getElementById("endDate");
const reason = document.getElementById("reason");
const start_dateError = document.getElementById("start_dateError");
const end_dateError = document.getElementById("end_dateError");


submitBtn.addEventListener("click", function (e) {
  e.preventDefault();
  let valid = true;
  const regex = /^\d{4}-\d{2}-\d{2}$/;
  if (
    !leaveType.value ||
    !startDate.value ||
    !endDate.value ||
    !reason.value.trim()
  ) {
    Swal.fire({
      title: "Error",
      text: "Please fill out all Fields",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }
  if (startDate.value && !regex.test(startDate.value)) {
    startDate.classList.add("is-invalid");
    start_dateError.textContent = "Year must have 4 digits (e.g., 11-10-2025)";
    valid = false;
  } else {
    start_dateError.textContent = "";
    startDate.classList.remove("is-invalid");
  }

  if (endDate.value && !regex.test(endDate.value)) {
    endDate.classList.add("is-invalid");
    end_dateError.textContent = "Year must have 4 digits (e.g., 11-10-2025)";
    valid = false;
  } else {
    endDate.classList.remove("is-invalid");
    end_dateError.textContent = "";
  }

  if (startDate.value < today) {
    Swal.fire({
      title: "Error",
      text: "Start Date cannot be in the past.",
      icon: "error",
      confirmButtonText: "OK",
    });
    valid = false;
  }
  if (startDate.value > endDate.value) {
    Swal.fire({
      title: "Error",
      text: "Start date cannot be after end date.",
      icon: "error",
      confirmButtonText: "OK",
    });
    valid = false;
  }

  if (valid) {
    const formData = new FormData(document.getElementById("leaveForm"));

    fetch("apply_leave_process.php", {
      method: "POST",
      body: formData,
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
            window.location.href = "leave_status.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      })
      .catch((err) => {
        console.error(err);
      });
  }
});

document.addEventListener("keydown", function (event) {
  if (event.key == "Enter") {
    event.preventDefault();
    submitBtn.click();
  }
});
