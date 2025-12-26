<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Soldier Login - Army Management System</title>
  <link rel="icon" href="images/faveicon2.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap-icons.css">
  <link rel="stylesheet" href="CSS/soldier_css/soldier_login.css">
</head>

<body class="login-page">
<div id="loader" class="loader-overlay" style="display:none;">
  <div class="loader-text" id="animatedText"></div>
</div>
  <div class="card login-card">
    <div class="card-body">
      <div class="text-center mb-0 ">
        <img src="IMAGES/army_logo.png" alt="Army Logo" width="140" class="logo img-fluid ">
      </div>
      <h3 class="card-title text-center au">Soldier Login</h3>
      <form id="loginForm" method="POST" novalidate autocomplete="off">
        <div class="mb-3">
          <label for="email" class="form-label text-white">Email address</label>
          <input type="email" class="form-control input-field" id="email" placeholder="Enter your email" name="email" required maxlength="50" autocomplete="off">
          <small id="emailError" style="color:red;"></small>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label text-white">Password</label>
          <div class="input-group">
            <input type="password" class="form-control input-field " id="password" placeholder="Enter your password" name="password" required maxlength="16">
            <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
              <i class="bi bi-eye-slash" id="eyeIcon"></i>
            </span>
          </div>
          <small id="passError" style="color:red;"></small>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-army" id="loginBtn">Login</button>
        </div>
        <div class="text-center mt-2">
          <a href="forgot_password.php" class="forgot-text small">Forgot Password?</a>
        </div>
        <p class="mt-3 small text-center text-white">
          If you are not registered, please contact admin.
        </p>
      </form>
    </div>
  </div>
  <script src="JS/sweetalert2.all.min.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/soldier_js/login_script.js"></script>

</body>

</html>