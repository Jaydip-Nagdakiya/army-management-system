<?php
include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $mobileno = $_POST['mobileno'];
    $address = $_POST['address'];
    $bloodgroup = $_POST['bloodgroup'];
    $rank = $_POST['rank'];
    // $status = $_POST['status'];
    $id = $_POST['id'];


    $stmt = $con->prepare("SELECT email from soldiers where id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row= $result->fetch_assoc();
    $email= $row['email'];


    //check duplicate mobileno
    $check = $con->prepare("SELECT id from soldiers where mobile=? and id!=?");
    $check->bind_param("si", $mobileno, $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This mobile number is already linked with another soldier."]);
        exit;
    }


    // update database
    $stmt = $con->prepare("UPDATE soldiers SET name=?, dob=?, mobile=?, address=?, blood_group=?, rank=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $dob, $mobileno, $address, $bloodgroup, $rank, $id);

    if ($stmt->execute()) {
              // prepare email content
        $subject = "Profile Updated - Army Management";

        $message = "Dear $name,\n\n"
            . "Your profile details have been updated successfully in the Army Management System.\n"
            . "If any detail seems incorrect, please contact the admin.\n\n"
            . "Regards,\nArmy Management System";
        $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

        // send email
        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'Soldier details updated successfully. Email notification sent.']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Soldier details updated successfully, but email could not be sent.']);
        }
        
       
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed. Please try again later.']);
    }

    $stmt->close();
    $con->close();
}
