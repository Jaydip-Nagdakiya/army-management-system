<?php
$sql = "SELECT id FROM leave_applications 
        WHERE end_date < CURDATE() AND status='Approved'";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $update = $con->prepare("UPDATE leave_applications SET status='Completed' WHERE id=?");
    $update->bind_param("i", $row['id']);
    $update->execute();
    $update->close();
}
?>