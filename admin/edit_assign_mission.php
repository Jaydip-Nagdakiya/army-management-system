<?php
$page_title = "Update Assign Mission - Army Management System";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');
// include('check_login.php');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $assign_id = $_POST['id'];

    $stmt = $con->prepare("SELECT sm.id as assigned_id, 
                                  s.id as soldier_id, 
                                  sm.role as role,
                                  s.name as soldier_name, 
                                  m.mission_id, 
                                  m.mission_name, 
                                  p.id as posting_id, 
                                  p.location 
                           FROM soldiers_missions sm 
                           JOIN soldiers s ON sm.soldier_id = s.id 
                           JOIN missions m ON sm.mission_id = m.mission_id 
                           LEFT JOIN postings p ON sm.posting_id = p.id 
                           WHERE sm.id = ?");
    $stmt->bind_param('i', $assign_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $missions = $con->query("SELECT mission_id, mission_name FROM missions where status ='Active'");
}
?>

<div class="main-wrapper">
    <main class="main-content">
        <div class="container-fluid mt-5">
            <h2 class="text-center animate-fadein aqua">Update Assign Mission</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 col-xl-8">
                    <div class="card-box animate-slidein">
                        <form method="post" novalidate id="updatemissionform">

                            <!-- Soldier -->
                            <div class="mb-3">
                                <label for="soldier_id" class="form-label">Soldier</label>
                                <select name="soldier_id" id="soldier_id" class=" form-select input-field" readonly>
                                    <option value="<?= htmlspecialchars($row['soldier_id']) ?>"><?= htmlspecialchars($row['soldier_name']) ?> (<?= $row['location'] ? htmlspecialchars($row['location']) : 'No Active Posting' ?>)</option>
                                </select>
                            </div>

                            <!-- Mission Name -->
                            <div class="mb-3">
                                <label for="mission_id" class="form-label">Mission Name</label>
                                <select class="form-select input-field" id="mission_id" name="mission_id" required>
                                    <option value="" disabled>-- Select Ongoing Mission --</option>
                                    <?php while ($mission = $missions->fetch_assoc()) { ?>
                                        <option value="<?= $mission['mission_id'] ?>"
                                            <?= ($mission['mission_id'] == $row['mission_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($mission['mission_name']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Assign Role</label>
                                <select class="form-select input-field" id="role" name="role" required>
                                    <option value="Leader" <?php if ($row['role'] == "Leader") echo 'selected'; ?>>Leader</option>
                                    <option value="Supporter" <?php if ($row['role'] == "Supporter") echo 'selected'; ?>>Supporter</option>
                                    <option value="Medic" <?php if ($row['role'] == "Medic") echo 'selected'; ?>>Medic</option>
                                    <option value="Sniper" <?php if ($row['role'] == "Sniper") echo 'selected'; ?>>Sniper</option>
                                    <option value="Engineer" <?php if ($row['role'] == "Engineer") echo 'selected'; ?>>Engineer</option>
                                </select>
                                <span class=" text-danger" id="roleError"></span>
                            </div>

                            <!-- Hidden assign_id -->
                            <input type="hidden" name="id" value="<?= $row['assigned_id'] ?>">

                            <!-- Submit -->
                            <button type="submit" class="btn btn-army" id="updateBtn">
                                <i class="bi bi-check-circle-fill"></i> Update Mission
                            </button>
                            <a href="manage_assign_mission.php" class="btn btn-army">Back</a>
                            <div class="mt-3 d-flex justify-content-center">
                                <span id="loading" class="text-center d-none align-items-center gap-2">
                                    <span class="loader"></span>Updating...
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $page_js = "assign_mission.js";
    include('../includes/admin_footer.php');
    ?>