<?php
include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $admin_id = intval($_SESSION['admin_id']);
    $notice_id = $_POST['id'];
    $rank= $_POST['rank'];

    // Update notice
    $stmt = $con->prepare("UPDATE notices SET title=?, message=?, admin_id=?, rank=?,created_at=NOW() WHERE id=?");
    $stmt->bind_param("ssisi", $title, $content, $admin_id,$rank, $notice_id);
    $success = $stmt->execute();
    $stmt->close();
    $con->close();

    // Redirect back with success flag
    if ($success) {
        echo json_encode(['status' => 'success', 'message' => 'Notice updated sucessfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update notice. Please try again later']);
    }
}else{
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request!. Please sumbit form properly']);
}
