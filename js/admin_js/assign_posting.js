const assignBtn = document.getElementById("assignBtn");
const today = new Date().toISOString().split("T")[0];
const start_dateError = document.getElementById("start_dateError");
const end_dateError = document.getElementById("end_dateError");
const soldier = document.getElementById("soldier_id");
const plocation = document.getElementById("location");
const startDate = document.getElementById("start_date");
const endDate = document.getElementById("end_date");
const unit = document.getElementById("unit");
const remarks = document.getElementById("remarks");

assignBtn.addEventListener("click", function (e) {
  const regex = /^\d{4}-\d{2}-\d{2}$/;

  e.preventDefault();
  let valid = true;
  if (
    !soldier.value ||
    !startDate.value ||
    !endDate.value ||
    !plocation.value ||
    !unit.value ||
    !remarks.value.trim()
  ) {
    Swal.fire({
      title: "Error",
      text: "Please fill out all Fields",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
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

  if (valid) {
    let loader = document.getElementById("loading");
    const formData = new FormData(document.getElementById("postingForm"));
    loader.classList.remove("d-none");
    loader.classList.add("d-flex");
    assignBtn.disabled = true;
    fetch("posting_process.php", {
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
            assignBtn.disabled = false;
            document.getElementById("soldier_id").value = "";
            document.getElementById("location").value = "";
            document.getElementById("unit").value = "";
            document.getElementById("start_date").value = "";
            document.getElementById("end_date").value = "";
            document.getElementById("remarks").value = "";
          });
        } else if (data.status === "approved_leave") {
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          }).then(() => {
            loader.classList.remove("d-flex");
            loader.classList.add("d-none");
            assignBtn.disabled = false;
          });
        } else if (data.status === "pending_leave") {
          loader.classList.remove("d-flex");
          loader.classList.add("d-none");
          assignBtn.disabled = false;
          // Show confirmation dialog
          Swal.fire({
            title: "Warning",
            text: data.message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Assign Posting & Reject Leave",
            cancelButtonText: "Cancel",
          }).then((result) => {
            if (result.isConfirmed) {
              loader.classList.add("d-flex");
              loader.classList.remove("d-none");
              assignBtn.disabled = false;
              const forcedata = new FormData(
                document.getElementById("postingForm")
              );
              forcedata.append("force_reject", "1");
              fetch("posting_process.php", {
                method: "post",
                body: forcedata,
              })
                .then((res) => res.json())
                .then((data2) => {
                  if (data2.status === "success") {
                    Swal.fire({
                      title: "Success",
                      text: data2.message,
                      icon: "success",
                      confirmButtonText: "OK",
                    }).then(() => {
                      loader.classList.remove("d-flex");
                      loader.classList.add("d-none");
                      assignBtn.disabled = false;
                      document.getElementById("soldier_id").value = "";
                      document.getElementById("location").value = "";
                      document.getElementById("unit").value = "";
                      document.getElementById("start_date").value = "";
                      document.getElementById("end_date").value = "";
                      document.getElementById("remarks").value = "";
                    });
                  } else {
                    loader.classList.remove("d-flex");
                    loader.classList.add("d-none");
                    assignBtn.disabled = false;
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
        } else {
          loader.classList.remove("d-flex");
          loader.classList.add("d-none");
          assignBtn.disabled = false;
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
    assignBtn.click();
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

const locationEl = document.getElementById("location");
const unitEl = document.getElementById("unit");
const soldierEl = document.getElementById("soldier_id");

function loadSoldiers() {
  const location = locationEl.value;
  const unit = unitEl.value;

  if (location && unit) {
    fetch("get_eligible_soldiers.php", {
      method: "post",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body:
        "location=" +
        encodeURIComponent(location) +
        "&unit=" +
        encodeURIComponent(unit),
    })
      .then((res) => res.json())
      .then((data) => {
        soldierEl.innerHTML =
          '<option value="" disabled selected>-- Choose Soldier --</option>';
        if (data.success && data.soldiers.length > 0) {
          data.soldiers.forEach((s) => {
            const opt = document.createElement("option");
            opt.value = s.id;
            opt.textContent = `${s.name} (${s.rank})`;
            soldierEl.appendChild(opt);
          });
        } else {
          const opt = document.createElement("option");
          opt.disabled = true;
          opt.textContent = "No eligible soldiers found";
          soldierEl.appendChild(opt);
        }
      })
      .catch((err) => console.error(err));
  }
}

locationEl.addEventListener("change", loadSoldiers);
unitEl.addEventListener("change", loadSoldiers);
