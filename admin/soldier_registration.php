<?php
$page_title = "Soldier Registration - Army Management System";
include('../includes/admin_header.php');
?>

<!-- Sidebar -->
<?php
$current_page = "registration";
include('../includes/admin_sidebar.php');
?>

<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class=" container-fluid mt-5">
      <h2 class="mb-4 text-center aqua animate-fadein">Soldier Registration</h2>
      <div class="row justify-content-center">
        <div class="col-md-9 col-lg-9 col-xl-7 col-xxl-9">
          <div class="card-box  animate-slidein">

            <!-- Main Form -->
            <form id="soldierForm" novalidate method="post">

              <!-- Email Field -->
              <div class="mb-3" id="emailSection">
                <label for="email" class="form-label w-25">Email </label>
                <input type="email" id="email" name="email" class="form-control input-field" placeholder="Enter Email" maxlength="50" required>
                <small id="emailError" class="form-error"></small>
                <span id="otpsending" style="color: orange; font-weight:bold;"></span>
              </div>

              <!-- Send OTP Button -->
              <button type="button" id="sendOtpBtn" class="btn btn-army">Send OTP</button>

              <!-- OTP Section (Initially Hidden) -->
              <div id="otpSection" style="display:none; margin-top:20px;">
                <div class="mb-3">
                  <label class="form-label" for="otp">Enter OTP</label>
                  <input type="text" class="form-control input-field" name="otp" id="otp" placeholder="Enter OTP" maxlength="6" required inputmode="numeric" pattern="\d{6}">
                </div>
                <div class="mb-3 d-flex gap-2">
                  <button type="button" class="btn btn-army " id="verifyOtpBtn">Verify</button>
                  <button type="button" class="btn btn-army " id="resendOtpBtn" style="display:none;">Resend OTP</button>
                  <span id="timer" class="ms-3 text-danger fw-bold mt-1"></span>
                  <span id="resendingOtp" style="color: orange; font-weight:bold;" class="mt-1"></span>
                </div>
              </div>

              <hr style="color: #00ffcc;">

              <!-- Remaining Fields (Initially Disabled) -->
              <fieldset id="remainingFields" disabled>

                <div class="mb-3">
                  <label for="name" class="form-label">Name </label>
                  <input type="text" id="name" name="name" class="form-control input-field" placeholder="Enter Soldier Name" maxlength="50" required>
                  <small id="nameError" class="form-error"></small>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="dob">Date of Birth</label>
                  <input type="date" class="form-control input-field" id="dob" name="dob" required>
                  <small id="dobError" class="form-error"></small>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="mobile">Mobile Number</label>
                  <input type="tel" id="mobile" class="form-control input-field" name="mobileno" maxlength="10" placeholder="Enter Mobile Number" required>
                  <small id="mobileError" class="form-error"></small>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="address">Address</label>
                  <textarea class="form-control input-field" id="address" name="address" rows="2" placeholder="Enter Address" required maxlength="50"></textarea>
                  <small id="addressError" class="form-error"></small>
                </div>

<!--               
                <div class="mb-3">
                  <label class="form-label" for="gender">Gender</label>
                  <select id="gender" name="gender" class="form-control input-field" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                  <small id="genderError" class="form-error"></small>
                </div> -->

                <div class="mb-3">
                  <label class="form-label" for="bloodgrp">Blood Group</label>
                  <select id="bloodgrp" class="form-control input-field" name="bloodgroup" required>
                    <option value="">Select Blood Group</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>O+</option>
                    <option>O-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                  </select>
                  <small id="bloodgrpError" class="form-error"></small>
                </div>

                <div class="mb-3">
                  <label for="rank" class="form-label">Rank</label>
                  <select id="rank" name="rank" class="form-control input-field" required>
                    <option value="">-- Select Rank --</option>
                    <option value="Sepoy">Sepoy</option>
                    <option value="Lance Naik">Lance Naik</option>
                    <option value="Naik">Naik</option>
                    <option value="Havildar">Havildar</option>
                    <option value="Naib Subedar">Naib Subedar</option>
                    <option value="Subedar">Subedar</option>
                    <option value="Subedar Major">Subedar Major</option>
                    <option value="Lieutenant">Lieutenant</option>
                    <option value="Captain">Captain</option>
                    <option value="Major">Major</option>
                    <option value="Lieutenant Colonel">Lieutenant Colonel</option>
                    <option value="Colonel">Colonel</option>
                    <option value="Brigadier">Brigadier</option>
                    <option value="Major General">Major General</option>
                    <option value="Lieutenant General">Lieutenant General</option>
                    <option value="General">General</option>
                    <option value="Special Forces Officer">Special Forces Officer</option>
                    <option value="Medical Officer">Medical Officer</option>
                    <option value="Logistics Officer">Logistics Officer</option>
                  </select>
                  <small id="rankError" class="form-error"></small>
                </div>

                <div class="text-center">
                  <button type="submit" id="registerBtn" class="btn btn-army w-100">Register Soldier</button>
                  <div class="mt-3 d-flex justify-content-center">
                    <span id="loading" class="text-center d-none align-items-center gap-2"><span class="loader"></span>Registering...</span>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>


  <!-- Footer -->
  <?php
  $page_js = "soldier_registration.js";
  include('../includes/admin_footer.php');
  ?>