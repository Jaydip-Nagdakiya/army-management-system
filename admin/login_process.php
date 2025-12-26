<?php
session_name("admin_session");
session_start();
include('../INCLUDES/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $check = $con->prepare("SELECT id from admins where email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result1 = $check->get_result();

    if ($result1->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => 'Email not found please enter registered email.']);
        exit;
    }

    // Prepare SQL to prevent SQL Injection
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // If email found
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];
                echo json_encode(['status' => 'success']);
                exit;
            } else {
                echo json_encode(["status" => "error", "message" => 'Invalid password.']);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => 'Invalid email.']);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => 'Something went wrong. Please try again.']);
        exit;
    }

    $stmt->close();
    $conn->close();
} else {

    echo json_encode(['status' => 'error', 'message' => 'Invalid request!. Please sumbit form properly.']);
    exit;
}
