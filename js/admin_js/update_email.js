// old email code
let timerInterval;
const oldsendOtpBtn = document.getElementById("oldsendOtpBtn");
const oldresendOtpBtn = document.getElementById("oldresendOtpBtn");
const oldotpSection = document.getElementById("otpSection");
const oldtimerDisplay = document.getElementById("oldtimer");
const oldemailInput = document.getElementById("oldemail");
const oldotp = document.getElementById("oldotp");
const oldotpsending = document.getElementById("oldotpsending");
const oldsection = document.getElementById("old-email-section");
const newsection = document.getElementById("new-email-section");

oldsendOtpBtn.addEventListener("click", function () {
  let email = oldemailInput.value.trim();
  oldotpsending.textContent = "Sending OTP, please wait...";
  oldsendOtpBtn.disabled = true;
  oldresendOtpBtn.style.display = "none";
  const status = "update_soldier";
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
        oldotpsending.textContent = "";
        startTimer(60);
        Swal.fire({
          title: "Success",
          text: data.message,
          icon: "success",
          confirmButtonText: "OK",
        }).then(() => {
          oldotpSection.style.display = "block";
          setTimeout(() => {
            oldotp.focus();
          }, 200);
        });
      } else {
        oldotpsending.textContent = "";
        Swal.fire({
          title: "Error",
          text: data.message,
          icon: "error",
          confirmButtonText: "OK",
        }).then(() => {
          oldsendOtpBtn.disabled = false;
          oldemailInput.disabled = false;

          oldotpSection.style.display = "none";
          oldresendOtpBtn.style.display = "none";
        });
      }
    })
    .catch((err) => console.error(err));
});

// resend otp click
oldresendOtpBtn.addEventListener("click", () => {
  let email = oldemailInput.value.trim();
  let resendotp = document.getElementById("oldresendingOtp");
  if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
    Swal.fire({
      title: "Error",
      text: "Please enter a valid email before resending OTP",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  oldresendOtpBtn.style.display = "none";
  oldsendOtpBtn.disabled = true;
  resendotp.textContent = "Resending OTP, Please Wait..";
  oldtimerDisplay.textContent = "";
  const status = "update_soldier";
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
            oldotp.focus();
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
  oldtimerDisplay.textContent = "";
  timerInterval = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    oldtimerDisplay.textContent = `${minutes}:${
      seconds < 10 ? "0" : ""
    }${seconds}`;
    timeLeft--;

    if (timeLeft < 0) {
      clearInterval(timerInterval);
      oldtimerDisplay.textContent = "OTP expired!";
      oldresendOtpBtn.style.display = "inline-block";
    }
  }, 1000);
}

//verify btn click
document.getElementById("verifyOtpBtn").addEventListener("click", function () {
  let otp = document.getElementById("oldotp").value.trim();

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
          document.getElementById("otpSection").style.display = "none";
          oldresendOtpBtn.style.display = "none";
          oldsection.classList.add("d-none");
          newsection.classList.remove("d-none");
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
oldotp.addEventListener("input", function () {
  this.value = this.value.replace(/\D/g, "");
});

document.addEventListener("keydown", function (event) {
  verifyBtn = document.getElementById("verifyOtpBtn");
  if (event.key == "Enter") {
    event.preventDefault();

    if (oldsendOtpBtn.disabled == false) {
      oldsendOtpBtn.click();
    } else if (
      oldotpSection.style.display !== "none" &&
      verifyBtn.disabled == false
    ) {
      if (oldresendOtpBtn.style.display !== "none") {
        oldresendOtpBtn.click();
      } else {
        document.getElementById("verifyOtpBtn").click();
      }
    }
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

// new email update code
const emailError = document.getElementById("emailError");
const newsendOtpBtn = document.getElementById("newsendOtpBtn");
const newresendOtpBtn = document.getElementById("newresendOtpBtn");
const newotpSection = document.getElementById("otpSection2");
const newotp = document.getElementById("newotp");
const newtimerDisplay = document.getElementById("newtimer");
const newemailInput = document.getElementById("newemail");
const newotpsending = document.getElementById("newotpsending");
const updateBtn= document.getElementById('updateBtn');
 const newverifybtn= document.getElementById("verifyOtpBtn2");

// Send OTP for new email
newsendOtpBtn.addEventListener("click", function () {
  let email = newemailInput.value.trim();
  let valid = true;

  if (email === "") {
    emailError.textContent = "Please Enter email";
    newemailInput.classList.add("is-invalid");
    newemailInput.focus();
    valid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = " Plese Enter valid email";
    newemailInput.classList.add("is-invalid");
    valid = false;
  } else {
    emailError.textContent = "";
    newemailInput.classList.remove("is-invalid");
  }

  if (valid) {
    newotpsending.textContent = "Sending OTP, please wait...";
    newsendOtpBtn.disabled = true;
    newresendOtpBtn.style.display = "none";
    const status = "registration";
    newemailInput.readOnly=true;
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
          newotpsending.textContent = "";
          startNewTimer(60);
          Swal.fire({
            title: "Success",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            newotpSection.style.display = "block";
            setTimeout(() => {
              newotp.focus();
            }, 200);
          });
        } else {
          newotpsending.textContent = "";
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          }).then(() => {
            newsendOtpBtn.disabled = false;
            newemailInput.readOnly=false;
            newotpSection.style.display = "none";
            newresendOtpBtn.style.display = "none";
          });
        }
      })
      .catch((err) => console.error(err));
  }
});

// resend otp for new email

newresendOtpBtn.addEventListener("click", () => {
  let email = newemailInput.value.trim();
  let resendotp = document.getElementById("newresendingOtp");
  if (email === "" || !/^\S+@\S+\.\S+$/.test(email)) {
    Swal.fire({
      title: "Error",
      text: "Please enter a valid email before resending OTP",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }

  newresendOtpBtn.style.display = "none";
  newsendOtpBtn.disabled = true;
  resendotp.textContent = "Resending OTP, Please Wait..";
  newtimerDisplay.textContent = "";
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
        startNewTimer(60);
        resendotp.textContent = "";

        Swal.fire({
          title: "Success",
          text: data.message,
          icon: "success",
          confirmButtonText: "OK",
        }).then(() => {
          setTimeout(() => {
            newotp.focus();
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

// Verify OTP for new email
newverifybtn.addEventListener("click", function () {
  let otp = newotp.value.trim();
  if (otp === "") {
    Swal.fire({ title: "Error", text: "Please Enter OTP", icon: "error" });
    return;
  }
  fetch("verify_otp.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "otp=" + encodeURIComponent(otp),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          title: "Success",
          text: data.message,
          icon: "success",
        }).then(() => {
          clearInterval(timerInterval);
          newtimerDisplay.textContent="";
          newresendOtpBtn.style.display = "none";
          updateBtn.disabled=false;
          newverifybtn.disabled=true;
        });
      } else {
        Swal.fire({ title: "Error", text: data.message, icon: "error" });
      }
    })
    .catch((err) => {
      console.error(err);
    });
});

// Timer for new email
function startNewTimer(duration) {
  clearInterval(timerInterval);
  let timeLeft = duration;
  newtimerDisplay.textContent = "";
  timerInterval = setInterval(() => {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    newtimerDisplay.textContent = `${minutes}:${
      seconds < 10 ? "0" : ""
    }${seconds}`;
    timeLeft--;
    if (timeLeft < 0) {
      clearInterval(timerInterval);
      newtimerDisplay.textContent = "OTP expired!";
      newresendOtpBtn.style.display = "inline-block";
    }
  }, 1000);
}


// update email button

updateBtn.addEventListener('click',function(e){
  e.preventDefault();
  const formdata= new FormData(document.getElementById('newemailform'));
  let email= newemailInput.value.trim();
  fetch('update_email_process.php',{
    method: 'post',
    body: formdata,
  }).then((res)=> res.json())
  .then((data)=>{
    if(data.status==='success'){
      Swal.fire('Success',data.message,'success')
      .then(()=>{
        window.location.href="manage_soldiers.php";
      });
    }else{
      Swal.fire('Error',data.message,'error');
    }
  }).catch((err)=>{
    console.log(err);
  })
})

newemailInput.addEventListener("input", function () { 
  this.classList.remove('is-invalid');
  emailError.textContent="";
});