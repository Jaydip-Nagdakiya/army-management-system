<?php
include('check_login.php');
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $soldier_id = intval($_POST['soldier_id']);
    $mission_id = intval($_POST['mission_id']);
    $role = $_POST['role'];

    $posting_id = isset($_POST['posting_id']) && $_POST['posting_id'] !== ''
        ? intval($_POST['posting_id'])
        : null;


    $stmt = $con->prepare("SELECT email from soldiers where id=?");
    $stmt->bind_param('i', $soldier_id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    $stmt = mysqli_query($con,"SELECT id from soldiers_missions where role='Leader' and mission_id=$mission_id");
    if (mysqli_num_rows($stmt) > 0 && $role === 'Leader') {
        echo json_encode(['status' => 'error', 'message' => 'A Leader is already assigned for this mission.']);
        exit;
    }


    if ($posting_id === null) {
        $stmt = $con->prepare("INSERT INTO soldiers_missions (soldier_id, mission_id, posting_id, role) VALUES (?, ?, NULL, ?)");
        $stmt->bind_param('iis', $soldier_id, $mission_id, $role);
    } else {
        $stmt = $con->prepare("INSERT INTO soldiers_missions (soldier_id, mission_id, posting_id, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiis', $soldier_id, $mission_id, $posting_id, $role);
    }

    if ($stmt->execute()) {
        $subject = "New Mission Assigned";
        $message = "Dear Soldier,\n\nYou have been assigned a new mission\n\nPlease check  your dashboard for more details.\n\nRegards,\nArmy Management Team";
        $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'Mission assigned and email sent successfully.']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Mission assigned but could not be sent via email.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to assign mission.']);
    }
    $stmt->close();
    $con->close();
}
