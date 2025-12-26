<?php
$page_title = "Edit Posting - Army Management System";
include('../includes/admin_header.php');

$id = intval($_POST['id'] ?? 0);
$stmt = $con->prepare("SELECT * FROM postings WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$posting = $result->fetch_assoc();
?>

<?php
// $current_page = "assign_posting";
include('../includes/admin_sidebar.php');
?>

<div class="main-wrapper flex-grow-1 d-flex flex-column">
    <div class="main-content p-4">
        <h2 class="mb-4 text-center aqua animate-fadein">Edit Posting</h2>

        <div class="card-box shadow p-4 mx-auto animate-slidein" style="max-width: 600px;">
            <form id="postingForm" method="POST">

                <!-- Soldier -->
                <div class="mb-3">
                    <label for="soldier_id" class="form-label">Select Soldier</label>
                    <select name="soldier_id" id="soldier_id" class="form-control input-field" disabled>
                        <option value="" disabled>Choose Soldier</option>
                        <?php
                        $soldiers = mysqli_query($con, "SELECT id, name, rank FROM soldiers WHERE status='Active'");
                        while ($s = mysqli_fetch_assoc($soldiers)) {
                            $selected = ($s['id'] == $posting['soldier_id']) ? "selected" : "";
                            echo "<option value='{$s['id']}' $selected>{$s['name']} ({$s['rank']})</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label">Posting Location</label>
                    <select name="location" id="location" class="form-control input-field" required>
                        <?php
                        $locations = ["Border Camp","Headquarters","Training Center","Base Camp","Field Hospital"];
                        foreach ($locations as $loc) {
                            $selected = ($posting['location'] == $loc) ? "selected" : "";
                            echo "<option value='$loc' $selected>$loc</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Unit -->
                <div class="mb-3">
                    <label for="unit" class="form-label">Select Unit</label>
                    <select name="unit" id="unit" class="form-control input-field" required>
                        <?php
                        $units = ["Infantry","Artillery","Engineering","Medical","Communication","Logistics","Special Forces"];
                        foreach ($units as $unit) {
                            $selected = ($posting['unit'] == $unit) ? "selected" : "";
                            echo "<option value='$unit' $selected>$unit Unit</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Start Date -->
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control input-field" required
                           value="<?= htmlspecialchars($posting['start_date']) ?>">
                    <span id="start_dateError" style="color: red;"></span>
                </div>

                <!-- End Date -->
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control input-field"
                           value="<?= htmlspecialchars($posting['end_date']) ?>">
                    <span id="end_dateError" style="color: red;"></span>
                </div>

                <!-- Remarks -->
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control input-field" rows="3"
                              maxlength="50"><?= htmlspecialchars($posting['remarks']) ?></textarea>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control input-field" required>
                        <?php
                        $statuses = ["Assign","Active","Completed"];
                        foreach ($statuses as $status) {
                            $selected = ($posting['status'] == $status) ? "selected" : "";
                            echo "<option value='$status' $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-army px-4" id="UpdateBtn">Update Posting</button>
                    <a href="manage_posting.php" class="btn btn-army">Back</a>
                    <div class="mt-2 d-flex justify-content-center">
                        <span id="loading" class="text-center d-none align-items-center gap-2"><span class="loader"></span>Updating...</span>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?= htmlspecialchars($posting['id']) ?>" />
                <input type="hidden" name="soldier_id" value="<?= htmlspecialchars($posting['soldier_id']) ?>">
            </form>
        </div>
    </div>
</div>

<?php
$page_js = "update_posting.js";
include('../includes/admin_footer.php');
?>
