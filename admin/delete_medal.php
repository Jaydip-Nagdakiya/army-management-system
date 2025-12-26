 <?php 
    include('check_login.php');
    header('Content-Type: application/json');

       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

               $stmt = $con->prepare("DELETE FROM soldier_medals WHERE id=?");
               $stmt->bind_param('i', $id);
   
               if ($stmt->execute()) {
                   echo json_encode(['status' => 'success', 'message' => 'Medal record deleted successfully.']);
               } else {
                   echo json_encode(['status' => 'error', 'message' => 'Failed to delete medal record.']);
               }
       }
        else {
           echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
       }
 ?>