
<?php 
    include('check_login.php');

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $id= $_POST['id'];
        $missionname= $_POST['mission_name'];
        $desc = $_POST['description'];
        $location= $_POST['location'];
        $start_date = $_POST['start_date'];
        $end_date =$_POST['end_date'];
        $status = $_POST['status'];

        $stmt = $con->prepare("SELECT  mission_name FROM missions where mission_name=? and mission_id!=?");
        $stmt->bind_param('si',$missionname, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            echo json_encode(['status'=>'error','message'=>'Mission Already Added']);
            exit();
        }

        $stmt= $con->prepare("UPDATE missions set mission_name=?, description=? ,location=?, start_date=? ,end_date=?, status=? where mission_id=?");
        $stmt->bind_param("ssssssi", $missionname,$desc,$location,$start_date,$end_date,$status,$id);

        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Mission Update Successfully']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Falied to Update Mission']);
        }
    }else{
        echo json_encode(['status'=>'error','message'=>'Invalid Request Method']);
    }
?>