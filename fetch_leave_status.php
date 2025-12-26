<?php
include('check_login.php');

$soldier_id = $_SESSION['soldier_id'];

$sql = "SELECT id, leave_type, start_date, end_date, reason, status 
        FROM leave_applications 
        WHERE soldier_id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$result = $stmt->get_result();
if(mysqli_num_rows($result) > 0):
while($row = $result->fetch_assoc()) :
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['leave_type']) . "</td>";
    echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['reason']) . "</td>";

    $status = $row['status'];
    if ($status == "Approved") {
        echo "<td><span class='badge bg-success'>Approved</span></td>";
    } elseif ($status == "Rejected") {
        echo "<td><span class='badge bg-danger'>Rejected</span></td>";
    } else {
        echo "<td><span class='badge bg-warning text-dark'>Pending</span></td>";
    }

    echo "<td>";
    if ($status == "Pending") {
        echo "<button class='btn  btn-primary updateBtn' data-id='".$row['id']."'><i class=' bi bi-pencil-square'></i></button>";
        echo "<button class='btn  btn-danger btnDelete' data-id='".$row['id']."'><i class=' bi bi-trash3'></i></button>";
    } else {
        echo "<span class='text-white'>No Actions</span>";
    }
    echo "</td>";

    echo "</tr>";
endwhile;
else:
    echo "<tr>";
    echo "<td  colspan='6' class='text-center fw-bold'>No leave application available. </td> ";
    echo "</tr>";
endif;
$stmt->close();
$con->close();
?>
