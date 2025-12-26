<?php
include('../includes/db_connect.php');

$type = $_POST['type'] ?? '';
$value = $_POST['value'] ?? '';

if ($type === 'location') {
    $sql = "SELECT s.name FROM postings p JOIN soldiers s ON p.soldier_id=s.id WHERE p.location=? and s.status='Active'";
} elseif ($type === 'unit') {
    $sql = "SELECT s.name FROM postings p JOIN soldiers s ON p.soldier_id=s.id WHERE p.unit=? and s.status='Active'";
} else {
    exit('Invalid Request');
}

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $value);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    echo "<ul class='list-group'>";
    while ($row = $res->fetch_assoc()) {
        echo "<li class='list-group-item bg-dark text-white border-secondary'>" . htmlspecialchars($row['name']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='text-muted'>No soldiers found for this $type.</p>";
}
$stmt->close();
$con->close();
?>
