<?php
include('check_login.php');
header('Content-Type: application/json');

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request!"
    ]);
    exit();
}

$leave_id = intval($_POST['id']);
$status = ($_POST['status'] === 'Approved') ? 'Approved' : 'Rejected';
$admin_id = $_SESSION['admin_id'];

$stmt = $con->prepare("UPDATE leave_applications 
                       SET status=?, reviewed_by_admin=?, reviewed_on=NOW() 
                       WHERE id=?");
$stmt->bind_param("sii", $status, $admin_id, $leave_id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Leave request has been $status successfully!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update leave status!"
    ]);
}

$stmt->close();
$con->close();
?>
