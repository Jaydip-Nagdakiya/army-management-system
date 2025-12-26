<?php
session_name("admin_session");
session_start();
include('../INCLUDES/db_connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp']);
    if (!isset($_SESSION['otp']) || time() > $_SESSION['otp_expire']) {
        echo json_encode(["status"=>"error","message"=>"OTP expired"]);
        exit;
    }
    if ($otp == $_SESSION['otp']) {
        echo json_encode(["status"=>"success","message"=>"OTP verified"]);
        unset($_SESSION['otp']);
    } else {
        echo json_encode(["status"=>"error","message"=>"Invalid OTP"]);
  }
}
?>