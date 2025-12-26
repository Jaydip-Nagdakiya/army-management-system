<?php
 include('check_login.php');
header('Content-Type:application/json');
$soldier_id = $_SESSION['soldier_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$leave_type = $_POST['leave_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];



$check = "SELECT * FROM leave_applications 
              WHERE soldier_id = ? 
              AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))";

$stmt = $con->prepare($check);
$stmt->bind_param("issss", $soldier_id, $start_date,$start_date,$end_date,  $end_date);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    echo json_encode(["status"=>"error","message"=>"You have already applied for leave in this date range."]);
    exit;
}

// Insert Query
$sql = "INSERT INTO leave_applications (soldier_id, leave_type, start_date, end_date, reason) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);
$stmt->bind_param("issss", $soldier_id, $leave_type, $start_date, $end_date, $reason);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success","message"=>"Leave Application Submitted SuccessFully"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Could not apply for leave."]);
}

$stmt->close();
$con->close();
}
?>
