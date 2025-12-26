<?php 
    include('check_login.php');

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $missionname= $_POST['mission_name'];
        $desc = $_POST['description'];
        $location= $_POST['location'];
        $start_date = $_POST['start_date'];
        $end_date =$_POST['end_date'];
        // $status = $_POST['status'];

        $stmt = $con->prepare("SELECT  mission_name FROM missions where mission_name=?");
        $stmt->bind_param('s',$missionname);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            echo json_encode(['status'=>'error','message'=>'Mission Already Added']);
            exit();
        }
        $status = 'Planned';
        $stmt= $con->prepare("INSERT INTO missions (mission_name,description,location,start_date,end_date,status) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $missionname,$desc,$location,$start_date,$end_date,$status);

        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Mission Add Successfully']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Falied to Add Mission']);
        }
    }else{
        echo json_encode(['status'=>'error','message'=>'Invalid Request Method']);
    }
?>