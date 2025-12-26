let timerInterval;
const sendOtpBtn = document.getElementById("sendOtpBtn");
const resendOtpBtn = document.getElementById("resendOtpBtn");
const otpSection = document.getElementById("otpSection");
const timerDisplay = document.getElementById("timer");
const emailInput = document.getElementById("email");
const emailError = document.getElementById("emailError");
const registerBtn = document.getElementById("registerBtn");
const sname = document.getElementById("name");
const dob = document.getElementById("dob");
const mobileno = document.getElementById("mobile");
const address = document.getElementById("address");
const booldgroup = document.getElementById("bloodgrp");
const rank = document.getElementById("rank");
const otpsending = document.getElementById("otpsending");
const otp = document.getElementById("otp");
const genderError = document.getElementById("genderError");
const gender = document.getElementById("gender");
// Send OTP click

sendOtpBtn.addEventListener("click", function () {
  let email = emailInput.value.trim();
  let valid = true;

  if (email === "") {
    emailError.textContent = "Please Enter email";
    emailInput.classList.add("is-invalid");
    remove_space(emailInput);
    emailInput.focus();
    valid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = " Plese Enter valid email";
    emailInput.classList.add("is-invalid");
    remove_space(emailInput);
    valid = false;
  } else {
    emailError.textContent = "";
    emailInput.classList.remove("is-invalid");
    emailInput.blur();
  }

  if (valid) {
    otpsending.textContent = "Sending OTP, please wait...";
    sendOtpBtn.disabled = true;
    resendOtpBtn.style.display = "none";
    const status = "registration";
    // Send POST request
    fetch("send_otp.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body:
        "email=" +
        encodeURIComponent(email) +
        "&status=" +
        encodeURIComponent(status),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          otpsending.textContent = "";
          startTimer(60);
          Swal.fire({
            title: "Success",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            otpSection.style.display = "block";
            setTimeout(() => {
              otp.focus();
            }, 200);
          });
        } else {
          otpsending.textContent = "";
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          }).then(() => {
            sendOtpBtn.disabled = false;
            emailInput.disabled = false;

            otpSection.style.display = "none";
            resendOtpBtn.style.display = "none";
          });
        }
      })
      .catch((err) => console.error(err));
  }
});

// resend otp click
resendOtpBtn.addEventListener("click", () => {
  let email = emailInput.value.trim();
  let resendotp = document.getElementById("resendingOtp");
  if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
    Swal.fire({
      title: "Error",
      text: "Please enter a valid email before resending OTP",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  resendOtpBtn.style.display = "none";
  sendOtpBtn.disabled = true;
  resendotp.textContent = "Resending OTP, Please Wait..";
  timerDisplay.textContent = "";
  const status = "registration";
  // Send POST request to generate and send OTP again
  fetch("send_otp.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body:
      "email=" +
      encodeURIComponent(email) +
      "&status=" +
      encodeURIComponent(status),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        startTimer(60);
        resendotp.textContent = "";

        Swal.fire({
          title: "Success",
          text: data.message,
          icon: "success",
          confirmButtonText: "OK",
        }).then(() => {
          setTimeout(() => {
            otp.focus();
          }, 200);
        });
      } else {
        resendotp.textContent = "";
        Swal.fire({
          title: "Error",
          text: data.message,
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    })
    .catch((err) => console.error(err));
});

// timer fuction
function startTimer(duration) {
  clearInterval(timerInterval);
  let timeLeft = duration;
  timerDisplay.textContent = "";
  timerInterval = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    timerDisplay.textContent = `${minutes}:${
      seconds < 10 ? "0" : ""
    }${seconds}`;
    timeLeft--;

    if (timeLeft < 0) {
      clearInterval(timerInterval);
      timerDisplay.textContent = "OTP expired!";
      resendOtpBtn.style.display = "inline-block";
    }
  }, 1000);
}

//verify btn click
document.getElementById("verifyOtpBtn").addEventListener("click", function () {
  let otp = document.getElementById("otp").value.trim();

  if (otp === "") {
    Swal.fire({
      title: "Error",
      text: "Please enter OTP",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  fetch("verify_otp.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "otp=" + encodeURIComponent(otp),
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
          document.getElementById("remainingFields").disabled = false;
          document.getElementById("otpSection").style.display = "none";
          emailInput.readOnly = true;
          resendOtpBtn.style.display = "none";
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
    .catch((err) => console.error(err));
});

//registerBtn logic

registerBtn.addEventListener("click", function (e) {
  e.preventDefault();

  let isValid = true;

  let email = emailInput.value.trim();
  // email validation
  if (email === "") {
    emailError.textContent = " Please Enter email";
    emailInput.classList.add("is-invalid");
    remove_space(emailInput);
    emailInput.focus();
    isValid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = " Plese Enter valid email";
    emailInput.classList.add("is-invalid");
    remove_space(emailInput);
    emailInput.focus();
    isValid = false;
  } else {
    emailError.textContent = "";
    emailInput.classList.remove("is-invalid");
    emailInput.blur();
  }

  // Name validation
  if (sname.value.trim() === "") {
    document.getElementById("nameError").textContent = "Please enter name";
    sname.classList.add("is-invalid");
    remove_space(sname);
    sname.value;
    isValid = false;
  } else {
    document.getElementById("nameError").textContent = "";
    sname.classList.remove("is-invalid");
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
    let dobvalue = dob.value;
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
    remove_space(mobileno);
    isValid = false;
  } else if (!/^[0-9]{10}$/.test(mobileno.value.trim())) {
    document.getElementById("mobileError").textContent =
      "Please enter valid 10-digit mobile number";
    mobileno.classList.add("is-invalid");
    remove_space(mobileno);
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
    remove_space(address);
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
  // //gender validation
  // if (gender.value === "") {
  //   gender.classList.add("is-invalid");
  //   genderError.text = "Please select gender";
  //   isValid = false;
  // } else {
  //   gender.classList.remove("is-invalid");
  //   genderError.textContent = "";
  // }

  // Rank validation
  if (rank.value === "") {
    document.getElementById("rankError").textContent = "Please select rank";
    rank.classList.add("is-invalid");
    isValid = false;
  } else {
    document.getElementById("rankError").textContent = "";
    rank.classList.remove("is-invalid");
  }

  if (isValid) {
    registerBtn.disabled = true;
    let loader = document.getElementById("loading");
    loader.classList.remove("d-none");
    loader.classList.add("d-flex");
    // Submit form via fetch
    const formData = new FormData(document.getElementById("soldierForm"));
    fetch("register_process.php", {
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
            document.getElementById("remainingFields").disabled = true;
            otpSection.style.display = "none";
            emailInput.readOnly = false;
            sendOtpBtn.disabled = false;
            registerBtn.disabled = false;
            resendOtpBtn.style.display = "none";
            loader.classList.add("d-none");
            loader.classList.remove("d-flex");
            clearInterval(timerInterval);
          });
        } else {
          loader.classList.add("d-none");
          loader.classList.remove("d-flex");
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          }).then(() => {
            otpSection.style.display = "none";
            emailInput.readOnly = false;
            sendOtpBtn.disabled = false;
            registerBtn.disabled = false;
          });
        }
      })
      .catch((err) => {
        console.error(err);
        loader.classList.add("d-none");
        loader.classList.remove("d-flex");
        registerBtn.disabled = false;
      });
  }
});
emailInput.addEventListener("input", function () {
  emailError.textContent = "";
  emailInput.classList.remove("is-invalid");
  this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, "");
});
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
address.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("addressError").textContent = "";
});
booldgroup.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("bloodgrpError").textContent = "";
});
rank.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("rankError").textContent = "";
});

function remove_space(f_id) {
  f_id.value = f_id.value.replace(/\s+/g, "");
}

otp.addEventListener("input", function () {
  this.value = this.value.replace(/\D/g, "");
});

document.addEventListener("keydown", function (event) {
  verifyBtn = document.getElementById("verifyOtpBtn");
  if (event.key == "Enter") {
    event.preventDefault();

    if (sendOtpBtn.disabled == false) {
      sendOtpBtn.click();
    } else if (
      otpSection.style.display !== "none" &&
      verifyBtn.disabled == false
    ) {
      if (resendOtpBtn.style.display !== "none") {
        resendOtpBtn.click();
      } else {
        document.getElementById("verifyOtpBtn").click();
      }
    } else {
      registerBtn.click();
    }
  }
});
