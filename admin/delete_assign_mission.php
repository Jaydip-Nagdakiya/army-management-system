<?php 
    header('Content-Type: application/json');
    include('check_login.php');

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $id = $_POST['id'];

        $stmt = $con->prepare('DELETE FROM soldiers_missions where id=?');
        $stmt->bind_param('i',$id);

        if($stmt->execute()){
            echo json_encode(['status'=>'success', 'message'=>'Mission details deleted successfully!']);
        }else{
             echo json_encode(['status'=>'error', 'message'=>'Failed to delete mission details']);
        }
    }else{
         echo json_encode(['status'=>'error', 'message'=>'Invalid request method']);
    }
?>