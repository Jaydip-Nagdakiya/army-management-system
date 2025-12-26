<?php

$page_title = "Posting Status - Army Management System";
$current_page = "posting";
include('INCLUDES/soldier_header.php');
?>

<?php
$soldier_id = $_SESSION['soldier_id'];
$query = "SELECT * FROM soldiers WHERE id=?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$soldier_name = $row['name'];
?>


<?php
$query = "SELECT location, unit, start_date, end_date, status, remarks 
          FROM postings 
          WHERE soldier_id=? ORDER BY assigned_on DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!-- Main Content -->
<div class="container my-5 main-content">
    <h2 class="text-center mb-4 aqua animate-fadein">My Postings</h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive animate-slideup">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Unit</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td><?= htmlspecialchars($row['unit']); ?></td>
                            <td><?= htmlspecialchars($row['start_date']); ?></td>
                            <td><?= htmlspecialchars($row['end_date']); ?></td>
                            <td>
                                <span class="badge bg-<?= $row['status'] == 'Active' ? 'success' : 'secondary'; ?>">
                                    <?= $row['status']; ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['remarks']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center animate-slideup">No postings assigned yet.</div>   
    <?php endif; ?>

</div>


<?php
include('INCLUDES/soldier_footer.php');
?>