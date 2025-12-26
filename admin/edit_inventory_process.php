<?php
include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id        = intval($_POST['id']);
    $item_name = $_POST['item_name'];
    $category  = $_POST['category'];
    $quantity  = $_POST['quantity'];
    $location  = $_POST['location'];

    $stmt = $con->prepare("SELECT photo FROM inventory WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_photo = $row['photo'];

    $new_photo = $old_photo; 

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = "../inventory/";
        $photo_name = time() . "_" . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $photo_name;

        $imagefiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowtype = ['jpg', 'jpeg', 'png'];

        if (!in_array($imagefiletype, $allowtype)) {
            echo json_encode(['status'=>'error','message'=>'Only JPG, JPEG and PNG files allowed']);
            exit();
        }
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            if (!empty($old_photo) && file_exists($old_photo)) {
                unlink($old_photo);
            }
            $new_photo = $target_file;
        } else {
            echo json_encode(['status'=>'error','message'=>'Photo upload failed']);
            exit();
        }
    }

   
    $stmt = $con->prepare("UPDATE inventory SET item_name=?, category=?, quantity=?, location=?, photo=? WHERE id=?");
    $stmt->bind_param("ssissi", $item_name, $category, $quantity, $location, $new_photo, $id);

    if ($stmt->execute()) {
        echo json_encode(['status'=>'success','message'=>'Inventory updated successfully']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Update failed']);
    }
}
?>
