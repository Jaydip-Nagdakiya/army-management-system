<?php
include('check_login.php');

// Prepared statement for security
$stmt = $con->prepare("SELECT la.id, la.soldier_id, s.name, la.leave_type, la.start_date, la.end_date, la.reason, la.status
    FROM leave_applications la
    JOIN soldiers s ON la.soldier_id = s.id where s.status='Active' order by la.id desc  
");

$stmt->execute();
$result = $stmt->get_result();

 if($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['soldier_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['leave_type']) ?></td>
            <td><?= htmlspecialchars($row['start_date']) ?></td>
            <td><?= htmlspecialchars($row['end_date']) ?></td>
            <td><?= htmlspecialchars($row['reason']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <?php if($row['status']!="Completed") {?>
            <td>
              <button class="btn btn-success btn-sm ApproveBtn  bi-check-lg" data-id="<?php echo $row['id'];?>" status="Approved" <?php if($row['status']=="Approved") echo "disabled" ?>></button>
              <button class="btn btn-danger btn-sm RejectBtn  bi-x-lg" data-id="<?php echo $row['id'];?>" status="Rejected" <?php if($row['status']=="Rejected") echo "disabled" ?>></button>
            </td>
            <?php } else { ?>
              <td>No Action</td>
              <?php } ?>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="9" class="text-center">No pending leave requests.</td></tr>
        <?php endif; ?>
        