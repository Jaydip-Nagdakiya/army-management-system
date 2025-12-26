<?php
include('check_login.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);

        $stmt = $con->prepare("DELETE FROM postings WHERE id=?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Posting Deleted Successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "No Posting found with this ID"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete Posting"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}

$con->close();
