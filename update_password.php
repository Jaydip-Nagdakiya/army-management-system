<?php
session_start();
include('INCLUDES/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // update database
    $stmt = $con->prepare("UPDATE soldiers SET password=? WHERE email=?");
    $stmt->bind_param("si", $hashed_password, $email);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password changed failed.']);
    }

    $stmt->close();
    $con->close();
}
