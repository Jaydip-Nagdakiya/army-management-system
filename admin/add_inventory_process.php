<?php 
include('check_login.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $category  = $_POST['category'];
    $quantity  = $_POST['quantity'];
    $location = $_POST['location'];


    $check_stmt= $con->prepare("SELECT id , quantity from inventory where item_name=? and location=?");
    $check_stmt->bind_param('ss',$item_name,$location);
    $check_stmt->execute();
    $result= $check_stmt->get_result();
    $check_stmt->close();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $update_stmt = $con->prepare("UPDATE inventory SET quantity=? WHERE id=?");
        $update_stmt->bind_param('ii',$new_quantity,$row['id']);
        if($update_stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Item already exists - quantity updated successfully']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Failed to update item quantity']);
        }
        $update_stmt->close();
    }else{
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = '../inventory/'; 
        $photo_name = time() . '_' . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $photo_name;
        $imagefiletype= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $allowtype=['jpg','jpeg','png'];
        if(!in_array($imagefiletype,$allowtype)){
            echo json_encode(['status'=>'error','message'=>'Only JPG,JPEG and PNG files are allowed.']);
            exit();
        }
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {

            $stmt = $con->prepare("INSERT INTO inventory (item_name, category, quantity,location, photo) VALUES(?,?,?,?,?)");
            $stmt->bind_param("ssiss", $item_name, $category, $quantity,$location, $target_file);

            if($stmt->execute()){
                echo json_encode(['status' => 'success', 'message' => 'Item added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add item']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload photo']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No photo uploaded or upload error']);
    }
}

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
