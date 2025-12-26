<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Army Management System</title>
  <link rel="icon" href="../images/faveicon2.png" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/admin_css/reset_admin_pass.css">
</head>

<body class="reset-password-page">

  <div class="card reset-card">
    <div class="card-body">
      <h3 class="card-title text-center ">Change Password</h3>
      <form id="reset-password-form" method="POST" novalidate autocomplete="off">
        <div id="reset1Section">
          <div class="mb-3" id="emailSection">
            <label for="email" class="form-label text-white">Email address</label>
            <input type="email" class="form-control input-field" id="email" placeholder="Enter your email" name="email" required maxlength="50" autocomplete="off">
            <small id="emailError" style="color:red;"></small>
            <span id="otpsending" style="color: orange; font-weight:bold;"></span>
          </div>
          
          <!-- Send OTP Button -->
          <button type="button" id="sendOtpBtn" class="btn">Send OTP</button>
          <a href="index.php" class=" btn btn-light">Back</a>


          <!-- OTP Section (Initially Hidden) -->
          <div id="otpSection" style="display:none; margin-top:20px;">
            <div class="mb-3">
              <label class="form-label text-white" for="otp">Enter OTP</label>
              <input type="text" class="form-control input-field" name="otp" id="otp" placeholder="Enter OTP" maxlength="6" required inputmode="numeric" pattern="\d{6}">
            </div>
            <div class="mb-3 d-flex gap-2">
              <button type="button" class="btn " id="verifyOtpBtn">Verify</button>
              <button type="button" class="btn" id="resendOtpBtn" style="display:none;">Resend OTP</button>
              <span id="timer" class="ms-3 mt-2 text-danger fw-bold"></span>
              <span id="resendingOtp" style="color: orange; font-weight:bold;" class="mt-2"></span>
            </div>
          </div>

        </div>
        <div id="reset2Section" style="display: none;">
          <div class="mb-3">
            <label for="password" class="form-label text-white">Password</label>
            <div class="input-group">
              <input type="password" class="form-control input-field" id="password" placeholder="Enter your password" name="password" required maxlength="16">
              <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                <i class="bi bi-eye-slash icon-color" id="eyeIcon"></i>
              </span>
            </div>
            <small id="passError" style="color:red;"></small>
          </div>
          <div class="mb-3">
            <label for="confirmpassword" class="form-label text-white">Confirm Password</label>
            <div class="input-group">
              <input type="password" class="form-control input-field" id="confirmpassword" placeholder="Enter your password" name="confirmpassword" required maxlength="16">
              <span class="input-group-text" style="cursor: pointer;" id="togglePassword1">
                <i class="bi bi-eye-slash icon-color" id="eyeIcon1"></i>
              </span>
            </div>
            <small id="confirmpassError" style="color:red;"></small>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn" id="updateBtn">Update</button>
            <a href="forgot_password.php" class=" btn mt-2">Back</a>

          </div>
        </div>

      </form>

      <script src="../JS/sweetalert2.all.min.js"></script>
      <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../js/admin_js/reset_admin_pass.js"></script>


</body>

</html>