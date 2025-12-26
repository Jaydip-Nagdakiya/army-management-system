<?php
include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);

        $stmt = $con->prepare("SELECT profile_photo FROM soldiers WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($photo);
        $stmt->fetch();
        $stmt->close();

        $stmt = $con->prepare("DELETE FROM soldiers WHERE id=?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                if (!empty($photo) && file_exists($photo) && strpos($photo, "profile.jpg") === false) {
                    unlink($photo);
                }
                echo json_encode(["status" => "success", "message" => "Soldier Deleted Successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "No soldier found with this ID"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete soldier"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}

$con->close();
