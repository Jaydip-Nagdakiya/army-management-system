<?php include('../includes/db_connect.php') ?>

<!-- Search Functionality -->

<?php
$search = "";
if (isset($_POST['search']) && !$_POST['search'] == "") {
    $search = trim($_POST['search']);
    $qry = "SELECT sm.*, s.name from  soldier_medals sm join soldiers s on sm.soldier_id = s.id where s.status='Active' and (s.name like '%$search%' or sm.medal_name like '%$search%' or sm.medal_type like '%$search%') order by sm.id desc";
} else {
    $qry = "SELECT sm.*, s.name from  soldier_medals sm join soldiers s on sm.soldier_id = s.id where s.status='Active' order by sm.id desc";
}
$result = $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['medal_type']) ?></td>
            <td><?= htmlspecialchars($row['medal_name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td>
                <form action="edit_soldier_medal.php" method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit" class="btn btn-primary deletebtn bi bi-pencil-square"></button>
                </form>
                <button class="btn btn-danger deleteBtn bi bi-trash" data-id="<?= htmlspecialchars($row['id']) ?>"></button>
            </td>
        </tr>
    <?php endwhile; ?>
<?php  } else { ?>
    <tr>
        <td colspan='5' class='text-center'>No medal record found.</td>
    </tr>
<?php } ?>