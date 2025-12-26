<?php


$sql = "SELECT id FROM postings 
        WHERE end_date < CURDATE() AND status='Active'";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $update = $con->prepare("UPDATE postings SET status='Completed' WHERE id=?");
    $update->bind_param("i", $row['id']);
    $update->execute();
    $update->close();
}
?>