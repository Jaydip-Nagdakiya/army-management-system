<?php
include('check_login.php');

if($_SERVER['REQUEST_METHOD']!=='POST' ){
    header("Location: leave_status.php");
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id']:0;
$soldier_id= $_SESSION['soldier_id'];

if($id<=0){
    echo json_encode(['status'=>'error','message'=>'Invalid ID']);
    exit;
}

$stmt = $con->prepare("delete from leave_applications where id=? and soldier_id=? and status='Pending'");
$stmt->bind_param("ii", $id,$soldier_id);

if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Leave application deleted successfully']);
} else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete leave application']);
}

$stmt->close();
$con->close();
?>
