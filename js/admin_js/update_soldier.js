const updateBtn = document.getElementById("updateBtn");
const sname = document.getElementById("name");
const dob = document.getElementById("dob");
const mobileno = document.getElementById("mobile");
const address = document.getElementById("address");
const booldgroup = document.getElementById("bloodgrp");
const rank = document.getElementById("rank");
// const Status = document.getElementById("status");
const remarks = document.getElementById("remarks");

//UpdateBtn logic

updateBtn.addEventListener("click", function (e) {
  e.preventDefault();

  let isValid = true;
  // Name validation
  if (sname.value.trim() === "") {
    document.getElementById("nameError").textContent = "Please enter name";
    sname.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("nameError").textContent = "";
    sname.classList.remove("is-invalid"); // Remove border if valid
  }

  // DOB validation

  if (dob.value === "") {
    document.getElementById("dobError").textContent =
      "Please select date of birth";
    dob.classList.add("is-invalid");
    isValid = false;
  } else if (dob.value && !/^\d{4}-\d{2}-\d{2}$/.test(dob.value)) {
    dob.classList.add("is-invalid");
    document.getElementById("dobError").textContent =
      "Year must have 4 digits (e.g., 11-10-2025)";
    isValid = false;
  } else {
    let dobDate = new Date(dob.value);
    let today = new Date();
    let age = today.getFullYear() - dobDate.getFullYear();
    let monthDiff = today.getMonth() - dobDate.getMonth();
    let dayDiff = today.getDate() - dobDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
      age--;
    }

    if (age < 18) {
      Swal.fire({
        title: "Error",
        text: "Age must be 18 years or above",
        icon: "error",
        confirmButtonText: "OK",
      });
      isValid = false;
    } else {
      document.getElementById("dobError").textContent = "";
      dob.classList.remove("is-invalid");
    }
  }

  // Mobile validation
  if (mobileno.value.trim() === "") {
    document.getElementById("mobileError").textContent =
      "Please enter mobile number";
    mobileno.classList.add("is-invalid");
    isValid = false;
  } else if (!/^[0-9]{10}$/.test(mobileno.value.trim())) {
    document.getElementById("mobileError").textContent =
      "Please enter valid 10-digit mobile number";
    mobileno.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("mobileError").textContent = "";
    mobileno.classList.remove("is-invalid");
  }

  // Address validation
  if (address.value.trim() === "") {
    document.getElementById("addressError").textContent =
      "Please enter address";
    address.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("addressError").textContent = "";
    address.classList.remove("is-invalid");
  }

  // Blood group validation
  if (booldgroup.value === "") {
    document.getElementById("bloodgrpError").textContent =
      "Please select blood group";
    booldgroup.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("bloodgrpError").textContent = "";
    booldgroup.classList.remove("is-invalid");
  }

  // Rank validation
  if (rank.value === "") {
    document.getElementById("rankError").textContent = "Please select rank";
    rank.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("rankError").textContent = "";
    rank.classList.remove("is-invalid");
  }

  // //status validation
  // if (Status.value === "") {
  //   document.getElementById("statusError").textContent = "Please select status";
  //   Status.classList.add("is-invalid");
  //   isValid = false;
  // } else {
  //   document.getElementById("statusError").textContent = "";
  //   Status.classList.remove("is-invalid");
  // }

  if (isValid) {
    submitform();
  }
});

function submitform() {
  updateBtn.disabled = true;
  let loader = document.getElementById("loading");
  loader.classList.remove("d-none");
  loader.classList.add("d-flex");
  // Submit form via fetch
  const formData = new FormData(document.getElementById("soldierForm"));
  fetch("edit_soldier_process.php", {
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
          document.getElementById("soldierForm").reset();
          updateBtn.disabled = false;
          loader.classList.add("d-none");
          loader.classList.remove("d-flex");
          window.location.href = "manage_soldiers.php";
        });
      } else {
        Swal.fire({
          title: "Error",
          text: data.message,
          icon: "error",
          confirmButtonText: "OK",
        }).then(() => {
          updateBtn.disabled = false;
          loader.classList.add("d-none");
          loader.classList.remove("d-flex");
        });
      }
    })
    .catch((err) => {
      console.error(err);
      updateBtn.disabled = false;
    });
}

sname.addEventListener("input", function () {
  this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
  this.classList.remove("is-invalid");
  document.getElementById("nameError").textContent = "";
});
mobileno.addEventListener("input", function () {
  this.value = this.value.replace(/\D/g, "");
  this.classList.remove("is-invalid");
  document.getElementById("mobileError").textContent = "";
});
dob.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("dobError").textContent = "";
});
rank.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("rankError").textContent = "";
});
address.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("addressError").textContent = "";
});
booldgroup.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("bloodgrpError").textContent = "";
});
// Status.addEventListener("input", function () {
//   this.classList.remove("is-invalid");
//   document.getElementById("statusError").textContent = "";
// });

function remove_space(f_id) {
  f_id.value = f_id.value.trim();
}

document.addEventListener("keydown", function (event) {
  verifyBtn = document.getElementById("verifyOtpBtn");
  if (event.key == "Enter") {
    event.preventDefault();
    updateBtn.click();
  }

  if (event.key == "Backspace") {
    if (
      event.target.tagName !== "INPUT" &&
      event.target.tagName !== "TEXTAREA"
    ) {
      window.location.href = "manage_soldiers.php";
    }
  }
});
