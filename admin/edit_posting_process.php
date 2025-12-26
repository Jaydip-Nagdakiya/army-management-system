<?php
include('check_login.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    // echo json_encode(['status'=>'success','message'=>'valid id']);
    // exit;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Posting ID']);
        exit;
    }
    $soldier_id = $_POST['soldier_id'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $unit = $_POST['unit'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];
    if ($soldier_id > 0) {
        $stmt = $con->prepare("SELECT email FROM soldiers WHERE id=?");
        $stmt->bind_param("i", $soldier_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $email = $row['email'] ?? '';
        $stmt->close();

        if (empty($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Soldier email not found.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Soldier ID.']);
        exit;
    }
    $checkPosting = $con->prepare("SELECT * FROM postings 
        WHERE soldier_id=? and id<>?
        AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))");
    $checkPosting->bind_param("iissss", $soldier_id, $id,$start_date, $start_date, $end_date, $end_date);
    $checkPosting->execute();
    $resultPosting = $checkPosting->get_result();

    if ($resultPosting->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Soldier already has a posting in this date range."
        ]);
        exit;
    }

    $checkApproved = $con->prepare("SELECT * FROM leave_applications 
        WHERE soldier_id=? 
        AND status='Approved'
        AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))");
    $checkApproved->bind_param("issss", $soldier_id, $start_date, $start_date, $end_date, $end_date);
    $checkApproved->execute();
    $resultApproved = $checkApproved->get_result();

    if ($resultApproved->num_rows > 0) {
        echo json_encode([
            "status" => "approved_leave",
            "message" => "Soldier has approved leave in this date range. Posting cannot be assigned."
        ]);
        exit;
    }

    $checkPending = $con->prepare("SELECT * FROM leave_applications 
        WHERE soldier_id=? 
        AND status='Pending'
        AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))");
    $checkPending->bind_param("issss", $soldier_id, $start_date, $start_date, $end_date, $end_date);
    $checkPending->execute();
    $resultPending = $checkPending->get_result();

    if ($resultPending->num_rows > 0 && empty($_POST['force_reject'])) {
        echo json_encode([
            "status" => "pending_leave",
            "message" => "Soldier has pending leave in this date range. If you assign posting, the leave will be rejected."
        ]);
        exit;
    }
    $forceReject = $_POST['force_reject'] ?? 0;
    if ($forceReject) {
        $updateLeave = $con->prepare("UPDATE leave_applications 
            SET status='Rejected' 
            WHERE soldier_id=? AND status='Pending' AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))");
        $updateLeave->bind_param("issss", $soldier_id, $start_date, $start_date, $end_date, $end_date);
        $updateLeave->execute();
    }

    // update database
    $stmt = $con->prepare("UPDATE postings SET location=?, start_date=?, end_date=?, unit=?, remarks=?, status=?  WHERE id=?");
    $stmt->bind_param("ssssssi", $location, $start_date, $end_date, $unit, $remarks, $status, $id);

    if ($stmt->execute()) {
        if ($status === "Completed") {
            $subject = "Posting Completed";
            $message = "Dear Soldier,\n\nYour posting has been marked as *Completed*.\n\nUnit:$unit\nLocation:$location\nStart Date:$start_date\nEnd Date:$end_date\n\nThank you for your service at this posting.\n\nRegards,\nArmy Management Team";
            $headers = "From: Army Management <armymanagement@gmail.com>\r\n";
        } else {
            $subject = "Posting Updated";
            $message = "Dear Soldier,\n\nYou have been assigned a new posting.\n\nUnit: $unit\nLocation: $location\nStart Date: $start_date\nEnd Date: $end_date\n\nPlease check your dashboard for more details.\n\nRegards,\nArmy Management Team";
            $headers = "From: Army Management <armymanagement@gmail.com>\r\n";
        }
        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'Posting Updated and email sent successfully.']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Posting Updated but email could not be sent.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to assign posting.']);
    }

    $stmt->close();
    $con->close();
}
