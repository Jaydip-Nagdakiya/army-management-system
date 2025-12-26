const UpdateBtn = document.getElementById("UpdateBtn");
const today = new Date().toISOString().split("T")[0];
const soldier = document.getElementById("soldier_id");
const plocation = document.getElementById("location");
const startDate = document.getElementById("start_date");
const endDate = document.getElementById("end_date");
const unit = document.getElementById("unit");
const remarks = document.getElementById("remarks");
const pstatus = document.getElementById("status");
const start_dateError = document.getElementById("start_dateError");
const end_dateError = document.getElementById("end_dateError");

UpdateBtn.addEventListener("click", function (e) {
  e.preventDefault();
  let valid = true;
  const regex = /^\d{4}-\d{2}-\d{2}$/;

  if (
    !soldier.value ||
    !startDate.value ||
    !endDate.value ||
    !plocation.value ||
    !unit.value ||
    !remarks.value.trim() ||
    !pstatus.value
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
    let loader = document.getElementById("loading");
    const formData = new FormData(document.getElementById("postingForm"));
    loader.classList.add("d-flex");
    loader.classList.remove("d-none");
    // UpdateBtn.disabled = true;
    fetch("edit_posting_process.php", {
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
            loader.classList.remove("d-flex");
            loader.classList.add("d-none");
            // UpdateBtn.disabled = false;
            window.location.href = "manage_posting.php";
          });
        } else if (data.status === "approved_leave") {
          loader.classList.remove("d-flex");
          loader.classList.add("d-none");
          Swal.fire({
            titel: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          }).then(() => {
            loader.classList.remove("d-flex");
            loader.classList.add("d-none");
            // updateBtn.disabled = false;
          });
        } else if (data.status === "pending_leave") {
          loader.classList.remove("d-flex");
          loader.classList.add("d-none");
          Swal.fire({
            title: "Warning",
            text: data.message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Update Posting & Reject Leave",
            cancelButtonText: "Cancel"
          }).then((result) => {
            if (result.isConfirmed) {
              loader.classList.add("d-flex");
              loader.classList.remove("d-none");
              const forcedata = new FormData(
                document.getElementById("postingForm")
              );
              forcedata.append("force_reject", "1");
              fetch("edit_posting_process.php", {
                method: "post",
                body: forcedata,
              })
                .then((res) => res.json())
                .then((data2) => {
                  if (data2.status === "success") {
                    Swal.fire("Success", data2.message, "success").then(() => {
                      loader.classList.add("d-none");
                      loader.classList.remove("d-flex");
                      window.location.href = "manage_posting.php";
                    });
                  } else {
                    loader.classList.remove("d-flex");
                    loader.classList.add("d-none");
                    Swal.fire('Error', data2.message,'error'); 
                  }
                }).catch((err)=>{
                  console.error(err);
                })
            }
          });
        } else {
          loader.classList.remove("d-flex");
          loader.classList.add("d-none");
          // UpdateBtn.disabled = false;
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
    UpdateBtn.click();
  }
  if (event.key == "Backspace") {
    if (
      event.target.tagName !== "INPUT" &&
      event.target.tagName !== "TEXTAREA"
    ) {
      window.location.href = "manage_posting.php";
    }
  }
});

startDate.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  start_dateError.textContent = "";
  // const value = this.value;
  // const regex = /^\d{4}-\d{2}-\d{2}$/;

  // if (value && !regex.test(value)) {
  //   start_dateError.textContent = "Year must have 4 digits (e.g., 2025-10-11)";
  // } else {
  //   start_dateError.textContent = "";
  // }
});

endDate.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  end_dateError.textContent = "";
  // const value = this.value;
  // const regex = /^\d{4}-\d{2}-\d{2}$/;
  // if (value && !regex.test(value)) {
  //   end_dateError.textContent = "Year must have 4 digits (e.g., 2025-10-11)";
  // } else {
  //   end_dateError.textContent = "";
  // }
});
