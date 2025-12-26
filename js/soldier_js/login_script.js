// Eye Toggle
const togglePassword = document.getElementById("togglePassword");
const passwordField = document.getElementById("password");
const eyeIcon = document.getElementById("eyeIcon");

if (togglePassword) {
  togglePassword.addEventListener("click", () => {
    const type =
      passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);

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
const password = document.getElementById("password");
const emailError = document.getElementById("emailError");
const passError = document.getElementById("passError");

loginbtn.addEventListener("click", function (e) {
  e.preventDefault();
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
            const rotate = Math.random() * 360 + "deg";

            span.style.setProperty("--x", x);
            span.style.setProperty("--y", y);
            span.style.setProperty("--rotate", rotate);
            span.style.animationDelay = `${i * 0.1}s`;

            container.appendChild(span);
          }

          setTimeout(() => {
            window.location.href = "homepage.php";
          }, 2000);
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
  passError.textContent = "";
  password.classList.remove("is-invalid");
  this.value = this.value.trim();
});

emailInput.addEventListener("input", function () {
  emailError.textContent = "";
  this.value = this.value.toLowerCase().replace(/[^a-z0-9@.]/g, "");
  this.classList.remove("is-invalid");
});

document.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    loginbtn.click();
  }
});
