<?php


$sql = "SELECT mission_id FROM missions 
        WHERE start_date <= CURDATE() AND status='Planned'";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $update = $con->prepare("UPDATE missions SET status='Active' WHERE mission_id=?");
    $update->bind_param("i", $row['mission_id']);
    $update->execute();
    $update->close();
}
?>