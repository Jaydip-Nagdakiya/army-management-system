<?php 
    include('check_login.php');


    if($_SERVER['REQUEST_METHOD']=='POST'){
        $soldier_id = $_POST['soldier_id'];
        $medal_type = $_POST['medal_type'];
        $medal_name = $_POST['medal_name'];
        $desc = $_POST['description'];
        $award_date = $_POST['award_date'];

        if(strtotime($award_date) > time()){
            echo json_encode(['status'=>'error','message'=>'Award date cannot be in the future']);
            exit();
        }

        $stmt = $con->prepare("INSERT INTO soldier_medals(soldier_id,medal_type,medal_name,description,awarded_date) values(?,?,?,?,?)");
        $stmt->bind_param('issss',$soldier_id,$medal_type,$medal_name,$desc,$award_date);

        if($stmt->execute()){
            echo json_encode(['status'=>'success','message'=>'Medals add successfully']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Failed to add medals']);
        }
    }
?>