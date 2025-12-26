
<?php include('../includes/db_connect.php')?>

<!-- Search Functionality -->

<?php 
  $search="";
  if(isset($_POST['search']) && !$_POST['search']==""){
    $search= trim($_POST['search']);
    $qry= "SELECT *FROM missions where mission_name like '%$search%' or location like '%$search%' order by mission_id desc";
  }else{
    $qry="SELECT *FROM missions order by mission_id desc";
  }
  $result= $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['mission_name']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= htmlspecialchars($row['location']) ?></td>
                                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Planned'): ?>
                                            <span class="badge bg-info">Planned</span>
                                        <?php elseif ($row['status'] == 'Active'): ?>
                                            <span class="badge bg-warning text-dark">Active</span>
                                        <?php elseif ($row['status'] == 'Completed'): ?>
                                            <span class="badge bg-success">Completed</span> 
                                        <?php elseif ($row['status'] == 'Cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="edit_mission.php" method="post" class="d-inline">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['mission_id']) ?>">
                                            <button class="btn btn-primary bi bi-pencil-square"></button>
                                        </form>
                                         <form action="view_mission.php" method="post" class="d-inline">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['mission_id']) ?>">
                                            <button class="btn btn-info bi bi-eye"></button>
                                        </form>
                                        <button class="btn btn-danger bi bi-trash deleteBtn" data-id="<?= htmlspecialchars($row['mission_id']) ?>"></button>
                                    </td>
                                </tr>
                        <?php endwhile; ?>
              <?php } else {
                echo "<tr><td colspan='8' class='text-center'>No missions found.</td></tr>";
              } ?>