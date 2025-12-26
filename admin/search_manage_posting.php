<?php include('../includes/db_connect.php') ?>

<!-- Search Functionality -->

<?php
$search = "";
if (isset($_POST['search']) && !$_POST['search'] == "") {
    $search = trim($_POST['search']);
    $qry = "SELECT p.*,s.name from postings p join soldiers s on p.soldier_id=s.id where s.status='Active' and (s.name like '%$search%' or p.location like '%$search%' or p.unit like '%$search%') order by p.id desc";
} else {
    $qry = "SELECT p.*,s.name from postings p join soldiers s on p.soldier_id=s.id where s.status='Active' order by p.id desc";
}
$result = $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['start_date']) ?></td>
            <td><?= htmlspecialchars($row['end_date']) ?></td>
            <td><?= htmlspecialchars($row['unit']) ?></td>
            <td><?= htmlspecialchars($row['remarks']) ?></td>
            <td>
                <?php
                if ($row['status'] == 'Assign') {
                    echo "<span class='badge bg-info'>Assigned</span>";
                } else if ($row['status'] == 'Active') {
                    echo "<span class='badge bg-success'>Active</span>";
                } else {
                    echo "<span class= 'badge bg-secondary'>Completed</span>";
                }
                ?>
            </td>
            <td>
                <form action="edit_posting.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button class="btn btn-primary bi bi-pencil-square" type="submit"></button>
                </form>
                <button class="btn btn-danger deleteBtn bi bi-trash" data-id="<?= htmlspecialchars($row['id']) ?>"></button>
            </td>
        </tr>
    <?php endwhile; ?>
<?php  } else { ?>
    <tr>
        <td colspan='8' class='text-center'>No postings records found.</td>
    </tr>
<?php } ?>