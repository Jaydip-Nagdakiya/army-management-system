<?php
include('check_login.php'); // ensures admin is logged in

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $admin_id = $_SESSION['admin_id'];
    $rank = $_POST['rank'];


    $stmt = $con->prepare("INSERT INTO notices (title, message, admin_id,rank) VALUES (?, ?, ?,?)");
    $stmt->bind_param("ssis", $title, $content, $admin_id, $rank);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => "Notice has been sent to all $rank soldiers."]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send notice. Please try again later.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request!. Please submit the form properly.']);
    exit();
}
