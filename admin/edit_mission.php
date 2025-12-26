<?php
$page_title = "Update Mission - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>

<?php
$id = $_POST['id'];

$stmt = $con->prepare("SELECT *from missions where mission_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$missions = $result->fetch_assoc();
?>

<div class="main-wrapper">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class="text-center animate-fadein aqua">Update Misson Details</h2>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box animate-slidein">
                        <form method="post" id="missiondata">
                            <!-- Mission Name -->
                            <div class="mb-3">
                                <label for="mission_name" class="form-label">Mission Name</label>
                                <input type="text" class="form-control input-field" id="mission_name" name="mission_name" required placeholder="Enter mission name" value="<?= htmlspecialchars($missions['mission_name']) ?>" maxlength="50">
                                <span id="missionError" class=" text-danger"></span>
                            </div>

                            <!-- Hidden id -->
                            <input type="hidden" value="<?= htmlspecialchars($missions['mission_id']) ?>" name="id">

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control input-field" id="description" name="description" rows="3" required placeholder="Enter discription" maxlength="300"><?= htmlspecialchars($missions['description']) ?></textarea>
                                <span id="descError" class=" text-danger"></span>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <select class="form-select input-field" id="location" name="location" required>
                                    <option value="" disabled selected>-- Select Location --</option>
                                    <option value="Headquarters" <?php if ($missions['location'] == "Headquarters")  echo 'selected'; ?>>Headquarters</option>
                                    <option value="Border Post 1" <?php if ($missions['location'] == "Border Post 1") echo 'selected'; ?>>Border Post 1</option>
                                    <option value="Border Post 2" <?php if ($missions['location'] == "Border Post 2") echo 'selected'; ?>>Border Post 2</option>
                                    <option value="Training Camp" <?php if ($missions['location'] == "Training Camp") echo 'selected'; ?>>Training Camp</option>
                                    <option value="Base Alpha" <?php if ($missions['location'] == "Base Alpha") echo 'selected'; ?>>Base Alpha</option>
                                    <option value="Base Bravo" <?php if ($missions['location'] == "Base Bravo") echo 'selected'; ?>>Base Bravo</option>
                                </select>
                                <span id="locationError" class=" text-danger"></span>
                            </div>

                            <!-- Start & End Date -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control input-field" id="start_date" name="start_date" required value="<?= htmlspecialchars($missions['start_date']) ?>">
                                    <span id="start_dateError" class=" text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control input-field" id="end_date" name="end_date" value="<?= htmlspecialchars($missions['end_date']) ?>">
                                    <span id="end_dateError" class=" text-danger"></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Mission Status</label>
                                <select class="form-select input-field" id="status" name="status">
                                    <option value="" selected disabled>--select--</option>
                                    <option value="Planned" <?php if ($missions['status'] == "Planned") echo 'selected'; ?>>Planned</option>
                                    <option value="Active" <?php if ($missions['status'] == "Active") echo 'selected'; ?>>Active</option>
                                    <option value="Completed" <?php if ($missions['status'] == "Completed") echo 'selected'; ?>>Completed</option>
                                    <option value="Cancelled" <?php if ($missions['status'] == "Cancelled") echo 'selected'; ?>>Cancelled</option>
                                </select>
                                <span id="statusError" class=" text-danger"></span>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-army" id="updateBtn">
                                <i class="bi bi-pencil-square"></i> Update Mission
                            </button>

                            <a href="manage_missions.php" class="btn btn-army">Back</a>

                        </form>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php
    $page_js = "mission.js";
    include('../includes/admin_footer.php');
    ?>