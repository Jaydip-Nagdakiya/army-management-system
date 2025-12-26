<?php
session_name("admin_session");
session_start();
include('../INCLUDES/db_connect.php');
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo json_encode(["status" => "error", "message" => "Invalid Email"]);
        exit;
    }

    if ($status === "registration") {
        $check = $con->prepare("SELECT id from soldiers where email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => 'Email Address Already exists']);
            exit;
        }

        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 69;

        // Send OTP by mail
        $subject = "Army Management - OTP";
        $message = "Dear Soldier,\n\nYour OTP is: $otp (valid for 1 minutes)";
        $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(["status" => "success", "message" => "OTP sent"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to send OTP"]);
        }
    } else if ($status === "update_soldier") {

        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 69;

        // Send OTP by mail
        $subject = "Army Management - OTP";
        $message = "Dear Soldier,\n\nYour OTP is: $otp (valid for 1 minutes)";
        $headers = "From: Army Management <jarmymanagement@gmail.com>\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(["status" => "success", "message" => "OTP sent"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to send OTP"]);
        }
    } elseif ($status === "password_otp") {
        $check = $con->prepare("SELECT id from admins where email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(["status" => "error", "message" => 'Email Not Found Please Enter Registered Email']);
            exit;
        }

        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_expire'] = time() + 69;

        // Send OTP by mail
        $subject = "Army Management - OTP";
        $message = "Dear Soldier\n\nYour OTP is: $otp (valid for 1 minutes)";
        $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(["status" => "success", "message" => "OTP sent"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to send OTP"]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Status']);
    }
}
