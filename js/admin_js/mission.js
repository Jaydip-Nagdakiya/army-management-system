const missionname = document.getElementById("mission_name");
const missionError = document.getElementById("missionError");
const description = document.getElementById("description");
const descError = document.getElementById("descError");
const mlocation = document.getElementById("location");
const locationError = document.getElementById("locationError");
const startdate = document.getElementById("start_date");
const startdateError = document.getElementById("start_dateError");
const enddate = document.getElementById("end_date");
const enddateError = document.getElementById("end_dateError");
const mstatus = document.getElementById("status");
const statusError = document.getElementById("statusError");
const addBtn = document.getElementById("addBtn");
const updateBtn = document.getElementById("updateBtn");

function validateAndSubmit(action) {
  let valid = true;
  const start = new Date(startdate.value);
  const end = new Date(enddate.value);
  const today = new Date().toISOString().split("T")[0];
  const now = new Date(today);
  const regex = /^\d{4}-\d{2}-\d{2}$/;

  if (missionname.value.trim() === "") {
    missionError.textContent = "Please Enter Mission Name";
    missionname.classList.add("is-invalid");
    valid = false;
  } else {
    missionError.textContent = "";
    missionname.classList.remove("is-invalid");
  }

  if (description.value.trim() === "") {
    descError.textContent = "Please Enter Description";
    description.classList.add("is-invalid");
    valid = false;
  } else {
    descError.textContent = "";
    description.classList.remove("is-invalid");
  }

  if (mlocation.value === "") {
    locationError.textContent = "Please Select Location";
    mlocation.classList.add("is-invalid");
    valid = false;
  } else {
    mlocation.classList.remove("is-invalid");
    locationError.textContent = "";
  }

  if (startdate.value == "") {
    startdate.classList.add("is-invalid");
    startdateError.textContent = "Please Select Start date";
    valid = false;
  } else if (startdate.value && !regex.test(startdate.value)) {
    startdate.classList.add("is-invalid");
    startdateError.textContent = "Year must have 4 digits (e.g., 11-10-2025)";
    valid = false;
  } else {
    startdate.classList.remove("is-invalid");
    startdateError.textContent = "";
  }

  if (enddate.value == "") {
    enddate.classList.add("is-invalid");
    enddateError.textContent = "Please Select End Date";
    valid = false;
  } else if (enddate.value && !regex.test(enddate.value)) {
    enddate.classList.add("is-invalid");
    enddateError.textContent = "Year must have 4 digits (e.g., 11-10-2025)";
    valid = false;
  } else {
    enddate.classList.remove("is-invalid");
    enddateError.textContent = "";
  }
  if (mstatus) {
    if (mstatus.value === "") {
      mstatus.classList.add("is-invalid");
      statusError.textContent = "Please Select Status";
      valid = false;
    } else {
      mstatus.classList.remove("is-invalid");
      statusError.textContent = "";
    }
  }

  if (start < now) {
    Swal.fire("Error", "Start Date cannot be in the past.", "error");
    valid = false;
  }

  if (start > end) {
    Swal.fire("Error", "Start date cannot be after end date.", "error");
    valid = false;
  }

  if (valid) {
    const formdata = new FormData(document.getElementById("missiondata"));
    let url =
      action === "add"
        ? "mission_add_process.php"
        : "mission_update_process.php";

    fetch(url, {
      method: "post",
      body: formdata,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire("Success", data.message, "success").then(() => {
            if (action == "add") {
              document.getElementById("missiondata").reset();
            } else {
              window.location.href = "manage_missions.php";
            }
          });
        } else {
          Swal.fire("Error", data.message, "error");
        }
      })
      .catch((err) => console.error(err));
  }
}

if (addBtn) {
  addBtn.addEventListener("click", function (e) {
    e.preventDefault();
    validateAndSubmit("add");
  });
}

if (updateBtn) {
  updateBtn.addEventListener("click", function (e) {
    e.preventDefault();
    validateAndSubmit("update");
  });
}

function inputevent(name, errorname) {
  name.addEventListener("input", function () {
    this.classList.remove("is-invalid");
    errorname.textContent = "";
  });
}
inputevent(missionname, missionError);
inputevent(description, descError);
inputevent(mlocation, locationError);
inputevent(startdate, startdateError);
inputevent(enddate, enddateError);
// inputevent(mstatus, statusError);
