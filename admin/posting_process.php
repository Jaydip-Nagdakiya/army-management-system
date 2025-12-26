<?php
include('check_login.php'); // Admin session check

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $soldier_id = intval($_POST['soldier_id']);
    $location   = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];
    $unit       = $_POST['unit'];
    $remarks    = $_POST['remarks'];

    if ($soldier_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Soldier ID.']);
        exit;
    }

    // Fetch soldier email
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

    // Check overlapping postings
    $checkPosting = $con->prepare("SELECT * FROM postings 
        WHERE soldier_id=? 
        AND ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?))");
    $checkPosting->bind_param("issss", $soldier_id, $start_date, $start_date, $end_date, $end_date);
    $checkPosting->execute();
    $resultPosting = $checkPosting->get_result();

    if ($resultPosting->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Soldier already has a posting in this date range."
        ]);
        exit;
    }

    // Check overlapping approved leaves
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

    // Check overlapping pending leaves
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

    // Check if soldier has any previous posting
    $checkPrevious = $con->prepare("SELECT * FROM postings WHERE soldier_id=? ORDER BY end_date DESC LIMIT 1");
    $checkPrevious->bind_param("i", $soldier_id);
    $checkPrevious->execute();
    $resultPrevious = $checkPrevious->get_result();
    $hasPreviousPosting = $resultPrevious->num_rows > 0;
    $checkPrevious->close();

    // Insert new posting
    $stmt = $con->prepare("INSERT INTO postings (soldier_id, unit, location, start_date, end_date, remarks) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $soldier_id, $unit, $location, $start_date, $end_date, $remarks);

    if ($stmt->execute()) {
        if ($hasPreviousPosting) {
            $subject = "Next Posting Assigned";
            $message = "Dear Soldier,\n\nYou have been assigned a new posting (next posting).\n\nLocation: $location\nStart Date: $start_date\nEnd Date: $end_date\n\nPlease check your dashboard for more details.\n\nRegards,\nArmy Management Team";
        } else {
            $subject = "New Posting Assigned";
            $message = "Dear Soldier,\n\nYou have been assigned your first posting.\n\nLocation: $location\nStart Date: $start_date\nEnd Date: $end_date\n\nPlease check your dashboard for more details.\n\nRegards,\nArmy Management Team";
        }

        $mailStatus = mail($email, $subject, $message, "From: Army Management <armymanagement@gmail.com>\r\n");

        if ($mailStatus) {
            echo json_encode(['status' => 'success', 'message' => ($hasPreviousPosting ? 'Next posting assigned' : 'New posting assigned') . ' and email sent successfully.']);
        } else {
            echo json_encode(['status' => 'success', 'message' => ($hasPreviousPosting ? 'Next posting assigned' : 'New posting assigned') . ' but email could not be sent.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to assign posting.']);
    }

    $stmt->close();
    $con->close();
}
