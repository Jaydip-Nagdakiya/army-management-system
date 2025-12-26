<?php
include('check_login.php'); // Admin session check

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $mobileno = $_POST['mobileno'];
    $address = $_POST['address'];
    $bloodgroup = $_POST['bloodgroup'];
    $rank = $_POST['rank'];
    $email = $_POST['email'];
    // $gender = $_POST['gender'];

    // Check if email already exists
    $check = $con->prepare("SELECT id FROM soldiers WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => 'Email Address Already exists']);
        exit;
    }

    // Check if mobile already exists
    $check = $con->prepare("SELECT id FROM soldiers WHERE mobile=?");
    $check->bind_param("s", $mobileno);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => 'Mobile Number Already exists']);
        exit;
    }

    // Auto-generate password
    $password = bin2hex(random_bytes(4)); // 8 character password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert soldier record
    $stmt = $con->prepare("INSERT INTO soldiers (name, dob, mobile, address, blood_group, rank, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $dob, $mobileno, $address, $bloodgroup, $rank, $email, $hashed_password);

    if ($stmt->execute()) {

        // Prepare email content
        $subject = "Your Army Account Credentials";
        $message = "Hello $name,\n\nYour Army Management account has been created.\n\nYour login details are:\nEmail: $email\nPassword: $password\n\nPlease change your password after first login.";
        $headers = "From: Army Management <armymanagement@gmail.com>\r\n";

        // Send email
        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'Soldier registered successfully. Password sent via email.']);
        } else {
            // If email sending failed, delete the record
            $del = $con->prepare("DELETE FROM soldiers WHERE email=?");
            $del->bind_param("s", $email);
            $del->execute();
            $del->close();

            echo json_encode([
                'status' => 'error',
                'message' => 'Unable to send email right now. Please check your internet connection or try again later.'
            ]);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
    }

    $stmt->close();
    $con->close();
}
?>
