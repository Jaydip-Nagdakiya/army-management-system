<?php
include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $email = $_POST['email'];

    $stmt = $con->prepare("UPDATE soldiers set email=? where id=?");
    $stmt->bind_param("si", $email, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Email Updated Successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Falied To Update Email!']);
    }
} else {
    echo json_encode(['status' => 'erro', 'message' => 'Invalid Request Method!']);
}
