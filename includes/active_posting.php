<?php


$sql = "SELECT id FROM postings 
        WHERE start_date <= CURDATE() AND status='Assign'";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $update = $con->prepare("UPDATE postings SET status='Active' WHERE id=?");
    $update->bind_param("i", $row['id']);
    $update->execute();
    $update->close();
}
?>