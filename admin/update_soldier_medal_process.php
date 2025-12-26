<?php 
     include('check_login.php');
     header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medal_type = isset($_POST['medal_type']) ? trim($_POST['medal_type']) : '';
            $medal_name = isset($_POST['medal_name']) ? trim($_POST['medal_name']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $award_date = isset($_POST['award_date']) ? $_POST['award_date'] : '';
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

                $stmt = $con->prepare("UPDATE soldier_medals SET medal_type=?, medal_name=?, description=?, awarded_date=? WHERE id=?");
                $stmt->bind_param('ssssi', $medal_type, $medal_name, $description, $award_date, $id);
    
                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Medal award updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update medal award.']);
                }
        }
         else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    ?>