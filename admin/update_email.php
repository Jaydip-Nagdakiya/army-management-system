<?php
$page_title = "Update Email - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $stmt = $con->prepare("SELECT id from soldiers where email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "<script> alert('email not found');</script>";
    }
} else {
    echo "<script> alert('invalid request');</script>";
}

?>

<div class="main-wrapper">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class="aqua text-center animate-fadein">Update Email</h2>
            <div class="row justify-content-center">
                <div class=" col-md-6 col-lg-6 col-xl-6">
                    <div class="card-box animate-slidein">
                        <div id="old-email-section">
                            <div class="mb-3" id="emailSection">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" id="oldemail" name="email" class="form-control input-field" required value="<?php echo $email; ?>" readonly>
                                <span id="oldotpsending" style="color: orange; font-weight:bold;"></span>
                            </div>

                            <!-- Send OTP Button -->
                            <button type="button" id="oldsendOtpBtn" class="btn btn-army">Send OTP</button>
                            <a href="manage_soldiers.php" class="btn btn-army">Back</a>
                            <!-- OTP Section (Initially Hidden) -->
                            <div id="otpSection" style="display:none; margin-top:20px;">
                                <div class="mb-3">
                                    <label class="form-label">Enter OTP</label>
                                    <input type="text" class="form-control input-field" name="otp" id="oldotp" placeholder="Enter OTP" maxlength="6" required inputmode="numeric" pattern="\d{6}">
                                </div>
                                <div class="mb-3 d-flex gap-2">
                                    <button type="button" class="btn btn-army" id="verifyOtpBtn">Verify</button>
                                    <button type="button" class="btn btn-army" id="oldresendOtpBtn" style="display:none;">Resend OTP</button>
                                    <span id="oldtimer" class="ms-3 text-danger fw-bold mt-1"></span>
                                    <span id="oldresendingOtp" style="color: orange; font-weight:bold;" class="mt-1"></span>
                                </div>
                            </div>
                        </div>
                        <div id="new-email-section" class="d-none">
                            <form id="newemailform" method="post">
                                <div class="mb-3" id="emailSection2">
                                    <label for="email" class="form-label">New Email</label>
                                    <input type="email" id="newemail" name="email" class="form-control input-field" required placeholder="Enter New Email">
                                    <small id="emailError" class="form-error"></small>
                                    <span id="newotpsending" style="color: orange; font-weight:bold;"></span>
                                </div>
                                <!-- hidden id  -->
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <!-- Send OTP Button -->
                                <button type="button" id="newsendOtpBtn" class="btn btn-army">Send OTP</button>
                                <a href="manage_soldiers.php" class="btn btn-army">Back</a>


                                <!-- OTP Section (Initially Hidden) -->
                                <div id="otpSection2" style="display:none; margin-top:20px;">
                                    <div class="mb-3">
                                        <label class="form-label">Enter OTP</label>
                                        <input type="text" class="form-control input-field" name="otp" id="newotp" placeholder="Enter OTP" maxlength="6" required inputmode="numeric" pattern="\d{6}">
                                    </div>
                                    <div class="mb-3 d-flex gap-2">
                                        <button type="button" class="btn btn-army" id="verifyOtpBtn2">Verify</button>
                                        <button type="button" class="btn btn-army" id="newresendOtpBtn" style="display:none;">Resend OTP</button>
                                        <span id="newtimer" class="ms-3 text-danger fw-bold mt-1"></span>
                                        <span id="newresendingOtp" style="color: orange; font-weight:bold;" class="mt-1"></span>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-army w-100 mb-2" disabled id="updateBtn">Update Email</button>
                                <!-- <a href="manage_soldiers.php" class="btn btn-army w-100">Back</a> -->

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $page_js = "update_email.js";
    include('../includes/admin_footer.php');
    ?>