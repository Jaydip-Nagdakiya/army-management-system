<?php  
include('check_login.php');  
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $soldier_id = isset($_POST['soldier_id']) ? intval($_POST['soldier_id']) : 0;  
    $mission_id = isset($_POST['mission_id']) ? intval($_POST['mission_id']) : 0;  
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';  
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;  

    if ($soldier_id && $mission_id && $id) {

        $stmt = $con->prepare("SELECT email, name FROM soldiers WHERE id=?");  
        $stmt->bind_param('i', $soldier_id);  
        $stmt->execute();  
        $stmt->bind_result($email, $soldier_name);  
        $stmt->fetch();  
        $stmt->close();  

        if (!$email) {
            echo json_encode(['status' => 'error', 'message' => 'Soldier not found.']);
            exit;
        }

        $stmt = $con->prepare("UPDATE soldiers_missions SET mission_id=?, role=? WHERE id=?");  
        $stmt->bind_param('isi', $mission_id, $role, $id);  

        if ($stmt->execute()) {  
            $subject = "Mission Assignment Updated";  
            $message = "Dear $soldier_name,\n\nYour mission assignment has been updated.\n\n";
            $message .= "Please check your dashboard for more details.\n\n";
            $message .= "Regards,\nArmy Management Team";  
            $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

            if (mail($email, $subject, $message, $headers)) {  
                echo json_encode(['status' => 'success', 'message' => 'Mission updated and email sent successfully.']);  
            } else {  
                echo json_encode(['status' => 'success', 'message' => 'Mission updated but email could not be sent.']);  
            }  
        } else {  
            echo json_encode(['status' => 'error', 'message' => 'Failed to update mission.']);  
        }  
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
