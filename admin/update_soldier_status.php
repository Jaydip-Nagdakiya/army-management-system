<?php
include('check_login.php');

if(isset($_POST['id']) && isset($_POST['status'])){
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $query = "UPDATE soldiers SET status = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("si", $status, $id);

    if($stmt->execute()){
        echo json_encode(["status"=>"success", "message"=>"Soldier status updated to $status."]);
    } else {
        echo json_encode(["status"=>"error", "message"=>"Failed to update status."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status"=>"error", "message"=>"Invalid data."]);
}
?>