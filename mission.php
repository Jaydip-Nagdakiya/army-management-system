<?php
$page_title = "Mission Status - Army Management System";
$current_page = "mission";
include('INCLUDES/soldier_header.php');

$soldier_id = $_SESSION['soldier_id'];

$query = "SELECT m.mission_id, m.mission_name, m.start_date, m.end_date, m.status, m.description
          FROM missions m
          JOIN soldiers_missions sm ON m.mission_id = sm.mission_id
          WHERE sm.soldier_id = ?
          ORDER BY m.start_date DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$missions = $stmt->get_result();
?>

<div class="container my-5 main-content">
    <h2 class="text-center mb-4 aqua animate-fadein">My Missions</h2>

    <?php if ($missions->num_rows > 0): ?>
        <?php while ($mission = $missions->fetch_assoc()): ?>
            <div class="card mb-4 shadow-sm animate-slideup">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><?= htmlspecialchars($mission['mission_name']); ?></h4>
                </div>
                <div class="card-body">
                    <p><strong>Start Date:</strong> <?= htmlspecialchars($mission['start_date']); ?></p>
                    <p><strong>End Date:</strong> <?= htmlspecialchars($mission['end_date']); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?php
                            if ($mission['status'] == 'Planned') echo 'info';
                            elseif ($mission['status'] == 'Active') echo 'primary';
                            elseif ($mission['status'] == 'Completed') echo 'success';
                            else echo 'secondary';
                        ?>">
                            <?= htmlspecialchars($mission['status']); ?>
                        </span>
                    </p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($mission['description']); ?></p>

                    <?php
                    $mission_id = $mission['mission_id'];
                    $q2 = "SELECT s.name, s.rank, sm.role 
                           FROM soldiers_missions sm
                           JOIN soldiers s ON sm.soldier_id = s.id
                           WHERE sm.mission_id = ?";
                    $st2 = $con->prepare($q2);
                    $st2->bind_param("i", $mission_id);
                    $st2->execute();
                    $soldiers = $st2->get_result();
                    ?>
                    <h5 class="mt-4 aqua">Soldiers in this Mission (<?= $soldiers->num_rows; ?>)</h5>
                    <?php if ($soldiers->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Soldier Name</th>
                                        <th>Rank</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($s = $soldiers->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($s['name']); ?></td>
                                            <td><?= htmlspecialchars($s['rank']); ?></td>
                                            <td><?= htmlspecialchars($s['role']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">No soldiers found in this mission.</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center animate-slideup">No missions assigned yet.</div>
    <?php endif; ?>
</div>

<?php include('INCLUDES/soldier_footer.php'); ?>
