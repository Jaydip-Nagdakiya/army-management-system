<?php
session_start();
include('INCLUDES/db_connect.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $check = $con->prepare("SELECT id from soldiers where email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result1 = $check->get_result();

    if ($result1->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => 'Email Not Found Please Enter Registered Email']);
        exit;
    }

    $check = $con->prepare("select status from soldiers where email=?");
    $check->bind_param("s",$email);
    $check->execute();
    $check->bind_result($status);
    $check->fetch();
    $check->close();
    if($status=="Deactive"){
        echo json_encode(["status" => "error", "message" => 'Your Account is Deactive Please Contact Admin']);
        exit;
    }

    $sql = "select *from soldiers where email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['soldier_id'] = $row['id'];
            $_SESSION['soldier_name'] = $row['name'];
            $_SESSION['soldier_email'] = $row['email'];
            $_SESSION['profile_photo'] = $row['profile_photo'];
            echo json_encode(["status" => "success"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => 'Invalid Password']);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => 'Invalid Email']);
        exit;
    }
} else {
    header("Location:index.php");
    exit;
}
