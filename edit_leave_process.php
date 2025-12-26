<?php
include('check_login.php');
header("Content-Type:application/json");
// Validate ID
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
    exit();
}
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    exit;
}


// Get POST data
$leave_type = trim($_POST['leave_type'] ?? '');
$start_date = trim($_POST['start_date'] ?? '');
$end_date = trim($_POST['end_date'] ?? '');
$reason = trim($_POST['reason'] ?? '');


// Update leave Application
$stmt = $con->prepare("UPDATE leave_applications SET leave_type=?, start_date=?,end_date=?,reason=?, applied_on=NOW() WHERE id=?");
$stmt->bind_param("ssssi", $leave_type, $start_date, $end_date, $reason, $id);
$success = $stmt->execute();
$stmt->close();
$con->close();

// Redirect back with success flag
if ($success) {
    echo json_encode(['status'=>'success', 'message'=>'Leave Application Updated Successfully']);
} else {
    echo json_encode(['status'=>'error', 'message'=>'Failed to update leave application.Please try again.']);
}
