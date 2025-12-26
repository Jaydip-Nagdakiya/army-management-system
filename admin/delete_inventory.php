<?php
include('check_login.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);


      $stmt = $con->prepare("SELECT photo FROM inventory WHERE id=?");
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $stmt->bind_result($photo);
      $stmt->fetch();
      $stmt->close();

        $stmt = $con->prepare('DELETE FROM inventory where id=?');
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            if (!empty($photo)) {
                $photo_path = "../upload/" . $photo;
                if (file_exists($photo_path)) {
                    unlink($photo_path);
                }
            }
           echo json_encode(['status' => 'success', 'message' => "Inventory Deleted Successfully!"]);
        } else {
           echo json_encode(['status' => 'error', 'message' => 'Falied To Delete Inventory']);
        }
    } else {
       echo json_encode(['status' => 'error', 'message' => 'invalid id!']);
    }
} else {
   echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
}
