

let timerInterval;
const sendOtpBtn = document.getElementById("sendOtpBtn");
const resendOtpBtn = document.getElementById("resendOtpBtn");
const otpSection = document.getElementById("otpSection");
const timerDisplay = document.getElementById("timer");
const emailInput = document.getElementById("email");
const emailError = document.getElementById("emailError");
const otpsending = document.getElementById("otpsending");
const reset1section = document.getElementById("reset1Section");
const reset2section = document.getElementById("reset2Section");
const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
const eyeIcon = document.getElementById("eyeIcon");
const togglePassword1 = document.getElementById("togglePassword1");
const confirmpassword = document.getElementById("confirmpassword");
const eyeIcon1 = document.getElementById("eyeIcon1");
const updateBtn = document.getElementById("updateBtn");
const otp = document.getElementById("otp");
const passError = document.getElementById("passError");
const confirmpassError = document.getElementById("confirmpassError");

//send otp logic

sendOtpBtn.addEventListener("click", function () {
  let email = emailInput.value.trim();
  let valid = true;

  if (email === "") {
    emailError.textContent = " Please Enter email";
    emailInput.classList.add("is-invalid");
    emailInput.focus();
    valid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = " Please Enter valid email";
    emailInput.classList.add("is-invalid");
    emailInput.focus();
    valid = false;
  } else {
    emailError.textContent = "";
    emailInput.blur();
    emailInput.classList.remove("is-invalid");
  }

  if (valid) {
    emailError.blur();
    otpsending.textContent = "Sending OTP, please wait...";
    sendOtpBtn.disabled = true;
    resendOtpBtn.style.display = "none";
    const status = "password_otp";
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
            // didClose: ()=>{
            //   otpSection.style.display="block";
            //   requestAnimationFrame(()=>{
            //     otp.focus()
            //   });
            // }
          }).then(()=>{
            otpSection.style.display="block";
            setTimeout(() => {
              otp.focus();
            }, 200);
          })
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
  const status = "password_otp";
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
        }).then(()=>{
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
  document.getElementById("verifyOtpBtn").blur();
  if (otp === "") {
    Swal.fire({
      title: "Error",
      text: "Please enter OTP",
      icon: "error",
      confirmButtonText: "OK",
    }).then(()=>{
      setTimeout(() => {
        document.getElementById("otp").focus();
      }, 200);
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
          reset1section.style.display = "none";
          reset2section.style.display = "block";
          document.getElementById("otpSection").style.display = "none";
          emailInput.readOnly = true;
          resendOtpBtn.style.display = "none";
           setTimeout(() => {
              password.focus();
            }, 200);
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

function setupToggle(toggleId, fieldId, eyeId) {
  const toggle = document.getElementById(toggleId);
  const field = document.getElementById(fieldId);
  const eye = document.getElementById(eyeId);

  if (toggle) {
    toggle.addEventListener("click", () => {
      const type =
        field.getAttribute("type") === "password" ? "text" : "password";
      field.setAttribute("type", type);
      eye.classList.toggle("bi-eye");
      eye.classList.toggle("bi-eye-slash");
    });
  }
}

setupToggle("togglePassword", "password", "eyeIcon");
setupToggle("togglePassword1", "confirmpassword", "eyeIcon1");

updateBtn.addEventListener("click", function (e) {
  e.preventDefault();
  updateBtn.blur();
  let isValid = true;
  let passvalue = password.value.trim();
  let confirmpassval = confirmpassword.value.trim();

  const passregex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,16}$/;
  if (passvalue === "") {
    passError.textContent = "Please Enter Password";
    password.classList.add("is-invalid");
    isValid = false;
  } else if (!passregex.test(passvalue)) {
    passError.textContent =
      "Password Must be 8-16 character long and include at least one uppercase, one lowercase, one number, and one Special character(@,$,!,%,*,?,&).";
    password.classList.add("is-invalid");
    isValid = false;
  } else {
    passError.textContent = "";
    password.classList.remove("is-invalid");
  }

  if (confirmpassval === "") {
    confirmpassError.textContent = "Plase Enter Confirm Password";
    confirmpassword.classList.add("is-invalid");

    isValid = false;
  } else if (confirmpassval != passvalue) {
    confirmpassError.textContent = "Password do not match";
    confirmpassword.classList.add("is-invalid");

    isValid = false;
  } else {
    confirmpassError.textContent = "";
    confirmpassword.classList.remove("is-invalid");
  }

  if (isValid) {
    // Submit form via fetch
    const formData = new FormData(
      document.getElementById("reset-password-form")
    );
    fetch("update_password.php", {
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
            document.getElementById("reset-password-form").reset();
            clearInterval(timerInterval);
            window.location.href = "index.php";
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

function focus(eventname) {
  eventname.addEventListener("focus", function () {
    eventname.classList.add("focus-style");
  });
}

function blur(eventname) {
  eventname.addEventListener("blur", function () {
    eventname.classList.remove("focus-style");
  });
}

focus(emailInput);
blur(emailInput);

focus(otp);
blur(otp);

focus(password);
blur(password);

focus(confirmpassword);
blur(confirmpassword);

emailInput.addEventListener("input", function () {
  emailError.textContent = "";
  this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, "");
  emailInput.classList.remove("is-invalid");
});

otp.addEventListener("input", function () {
  this.value = this.value.replace(/\D/g, "");
});
password.addEventListener("input", function () {
  password.classList.remove("is-invalid");
  let passvalue = password.value.trim();
  const passregex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,16}$/;

  if (!passregex.test(passvalue)) {
    passError.textContent =
      "Password Must be 8-16 character long and include at least one uppercase, one lowercase, one number, and one Special character(@,$,!,%,*,?,&).";
  } else {
    passError.textContent = "";
  }
});

confirmpassword.addEventListener("input", function () {
  confirmpassword.classList.remove("is-invalid");
  let confirmpassval = confirmpassword.value.trim();
  let passvalue = password.value.trim();
  if (confirmpassval != passvalue) {
    confirmpassError.textContent = "Password do not match";
  } else {
    confirmpassError.textContent = "";
  }
});

document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();

    // check currently visible section
    if (reset1section.style.display !== "none") {
          sendOtpBtn.click();
    }
    if(otpSection.style.display!=="none"){
       if(resendOtpBtn.style.display!=="none"){
        resendOtpBtn.click();
       }else{
        document.getElementById('verifyOtpBtn').click();
       }
    }
    if(reset2section.style.display !== "none"){
      updateBtn.click();
    }
  }

  if (event.key == "Backspace") {
    if (
      event.target.tagName !== "INPUT" &&
      event.target.tagName !== "TEXTAREA"
    ) {
      if (reset1section.style.display !== "none") {
        window.location.href = "index.php";
      }
      if (otpSection.style.display !== "none") {
        window.location.href = "index.php";
      }
      if (reset2section.style.display !== "none") {
        window.location.href = "forgot_password.php";
      }
    }
  }
});
