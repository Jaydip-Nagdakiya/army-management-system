<?php include('../includes/db_connect.php') ?>

<!-- Search Functionality -->

<?php
$search = "";
if (isset($_POST['search']) && !$_POST['search'] == "") {
    $search = trim($_POST['search']);
    $qry = "SELECT sm.id as assignment_id, s.name as soldier_name, m.mission_name as mission_name, m.description as mission_description, sm.role as soldier_role from soldiers_missions sm JOIN soldiers s on sm.soldier_id = s.id join missions m on sm.mission_id=m.mission_id where s.status='Active' and s.name like '%$search%' or m.mission_name like '%$search%' or sm.role like '%$search%' order by sm.id desc";
} else {
    $qry = "SELECT sm.id as assignment_id, s.name as soldier_name, m.mission_name as mission_name, m.description as mission_description, sm.role as soldier_role from soldiers_missions sm JOIN soldiers s on sm.soldier_id = s.id join missions m on sm.mission_id=m.mission_id where s.status='Active' order by sm.id desc";
}
$result = $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['soldier_name']) ?></td>
            <td><?= htmlspecialchars($row['mission_name']) ?></td>
            <td><?= htmlspecialchars($row['soldier_role']) ?></td>
            <td><?= htmlspecialchars($row['mission_description']) ?></td>
            <td>
                <form action="edit_assign_mission.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['assignment_id']) ?>">
                    <button class="btn btn-primary bi bi-pencil-square" type="submit"></button>
                </form>
                <button class="btn btn-danger mt-1 deleteBtn bi bi-trash" data-id="<?= htmlspecialchars($row['assignment_id']) ?> "></button>
            </td>
        </tr>
    <?php endwhile; ?>
<?php  } else { ?>
    <tr>
        <td colspan='5' class='text-center'>No Assign Mission Record Found.</td>
    </tr>
<?php } ?>