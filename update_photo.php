<?php
include('check_login.php');

$soldier_id = $_SESSION['soldier_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['new_photo'])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // ---- Get old photo from DB ----
    $old_stmt = $con->prepare("SELECT profile_photo FROM soldiers WHERE id=?");
    $old_stmt->bind_param("i", $soldier_id);
    $old_stmt->execute();
    $old_result = $old_stmt->get_result();
    $old_row = $old_result->fetch_assoc();
    $old_photo = $old_row['profile_photo'];

    // ---- New photo filename ----
    $file_name = time() . "_" . basename($_FILES["new_photo"]["name"]);
    $target_file = $target_dir . $file_name;

    // Validation
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png"];

    if (!in_array($imageFileType, $allowed_types)) {
        echo json_encode(["status" => "error", "message" => 'Only JPG, JPEG and PNG files are allowed.']);
        exit();
    }

    // Upload
    if (move_uploaded_file($_FILES["new_photo"]["tmp_name"], $target_file)) {
        $photo_path = "uploads/" . $file_name;

        // Delete old photo if exists (and not default.png type)
        if (!empty($old_photo) && file_exists($old_photo) && strpos($old_photo, "profile.jpg") === false) {
            unlink($old_photo);
        }

        // Save new path in DB
        $stmt = $con->prepare("UPDATE soldiers SET profile_photo=? WHERE id=?");
        $stmt->bind_param("si", $photo_path, $soldier_id);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => 'Profile Photo Updated Successfully!']);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => 'Sorry, there was an error uploading your file.']);
    }
}
