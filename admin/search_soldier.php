<?php include('../includes/db_connect.php') ?>

<!-- Search Functionality -->

<?php
$search = "";
if (isset($_POST['search']) && !$_POST['search'] == "") {
  $search = trim($_POST['search']);
  $qry = "SELECT *FROM soldiers where id like '%$search%' or name like '%$search%' or rank like '%$search%' or status like '%$search%' order by id desc";
} else {
  $qry = "SELECT *FROM soldiers order by id desc";
}
$result = $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?php echo htmlspecialchars($row['id']); ?></td>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo htmlspecialchars($row['email']); ?></td>
      <td><?php echo htmlspecialchars($row['dob']) ?? '-'; ?></td>
      <td><?php echo htmlspecialchars($row['mobile']); ?></td>
      <td><?php echo htmlspecialchars($row['rank']) ?? '-'; ?></td>
      <td>
        <?php
        if ($row['status'] == 'Active') {
          echo "<span class='badge bg-success'>Active</span>";
        } else {
          echo "<span class='badge bg-warning'>Inactive</span>";
        }
        ?>
      </td>
      <td>
        <form action="soldier_information.php" method="POST">
          <input type="hidden" value="<?php echo $row['id']; ?>" name="id" />
          <button type="submit" class=" btn btn-primary  bi bi-eye"></button>
        </form>
      </td>
    </tr>
<?php }
} else {
  echo "<tr><td colspan='9' class='text-center'>No soldiers found.</td></tr>";
} ?>