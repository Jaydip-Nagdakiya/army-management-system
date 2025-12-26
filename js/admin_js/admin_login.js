// Eye Toggle
const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
const eyeIcon = document.getElementById("eyeIcon");

if (togglePassword) {
  togglePassword.addEventListener("click", () => {
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    if (type === "text") {
      eyeIcon.classList.remove("bi-eye-slash");
      eyeIcon.classList.add("bi-eye");
    } else {
      eyeIcon.classList.remove("bi-eye");
      eyeIcon.classList.add("bi-eye-slash");
    }
  });
}

const loginbtn = document.getElementById("loginBtn");
const emailInput = document.getElementById("email");
const emailError = document.getElementById("emailError");
const passError = document.getElementById("passError");
const loader = document.getElementById("loader");

loginbtn.addEventListener("click", function (e) {
  e.preventDefault();
  loginbtn.blur();
  let email = emailInput.value.trim();
  let passvalue = password.value.trim();
  let valid = true;

  if (email === "") {
    emailError.textContent = "Please Enter Email";
    emailInput.classList.add("is-invalid");
    valid = false;
  } else if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = " Please Enter valid email";
    emailInput.classList.add("is-invalid");
    valid = false;
  } else {
    emailError.textContent = "";
    emailInput.classList.remove("is-invalid");
  }

  if (passvalue === "") {
    passError.textContent = "Please Enter Password";
    password.classList.add("is-invalid");
    valid = false;
  } else {
    passError.textContent = "";
    password.classList.remove("is-invalid");
  }

  if (valid) {
    // Submit form via fetch
    const formData = new FormData(document.getElementById("loginForm"));
    fetch("login_process.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          loader.style.display = "flex";

          const text = "Welcome";
          const container = document.getElementById("animatedText");
          container.innerHTML = "";

          for (let i = 0; i < text.length; i++) {
            const span = document.createElement("span");
            span.classList.add("loader-letter");
            span.textContent = text[i];
            const x = Math.random() * 200 - 100 + "px"; 
            const y = Math.random() * 200 - 100 + "px";
            const rotate = (Math.random() * 60 - 30) + "deg";

            span.style.setProperty("--x", x);
            span.style.setProperty("--y", y);
            span.style.setProperty("--rotate",rotate);
            span.style.animationDelay = `${i * 0.1}s`;

            container.appendChild(span);
          }

          setTimeout(() => {
            window.location.href = "dashboard.php";
          }, 1500); 
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

password.addEventListener("input", function () {
  this.value = this.value.trim();
  password.classList.remove("is-invalid");
  passError.textContent = "";
});

emailInput.addEventListener("input", function (e) {
  emailInput.classList.remove("is-invalid");
  emailError.textContent = "";
  this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, "");
  // if (/^\S+@\S+\.\S+$/.test(this.value)) {
  //   this.classList.add("is-valid");
  // }else{
  //   this.classList.remove('is-valid');
  // }
});

document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    loginbtn.click();
  }
});

// function focus(eventname) {
//   eventname.addEventListener("focus", function () {
//     eventname.classList.add("focus-style");
//   });
// }

// function blur(eventname) {
//   eventname.addEventListener("blur", function () {
//     eventname.classList.remove("focus-style");
//   });
// }

// focus(emailInput);
// blur(emailInput);
// focus(password);
// blur(password);
