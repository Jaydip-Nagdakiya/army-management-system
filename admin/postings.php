<?php
$page_title = "Assign Posting - Army Management System";
include('../includes/admin_header.php');
// include('../includes/db_connect.php');
?>

<!-- Sidebar -->
<?php
$current_page = "assign_posting";
include('../includes/admin_sidebar.php');
?>

<!-- fech soldiers -->
<?php
$result = mysqli_query($con, "SELECT  id , name, rank  from soldiers where status='Active'");

if (!$result) {
    echo mysqli_error($con);
}
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class="mb-4 text-center aqua animate-fadein">Assign Posting to Soldier</h2>
            <div class="row justify-content-center">
                <div class="col-md-9  col-xl-6">
                    <div class="card-box  animate-slidein">
                        <form id="postingForm" method="POST">

                            <!-- Soldier Selection -->
                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Posting Location</label>
                                <select name="location" id="location" class="form-control input-field" required>
                                    <option value="" disabled selected>-- Choose Location --</option>
                                    <option value="Headquarters">Headquarters</option>
                                    <option value="Border Camp">Border Camp</option>
                                    <option value="Training Center">Training Center</option>
                                    <option value="Base Camp">Base Camp</option>
                                    <option value="Field Hospital">Field Hospital</option>
                                    <option value="Forward Operating Base">Forward Operating Base</option>
                                    <option value="Command Center">Command Center</option>
                                    <option value="Supply Depot">Supply Depot</option>
                                    <option value="Military Hospital">Military Hospital</option>
                                </select>
                            </div>

                            <!-- Unit -->
                            <div class="mb-3">
                                <label for="unit" class="form-label">Select Unit</label>
                                <select id="unit" name="unit" class="form-control input-field" required>
                                    <option value="" selected disabled>-- Choose Unit --</option>
                                    <option value="Infantry">Infantry Unit</option>
                                    <option value="Artillery">Artillery Unit</option>
                                    <option value="Engineering">Engineering Unit</option>
                                    <option value="Medical">Medical Unit</option>
                                    <option value="Communication">Communication Unit</option>
                                    <option value="Logistics">Logistics & Supply Unit</option>
                                    <option value="Special Forces">Special Forces Unit</option>
                                </select>
                            </div>
                            <!-- start date -->
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control input-field" required>
                                <span id="start_dateError" style="color: red;"></span>
                            </div>

                            <!-- end date -->
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control input-field" required>
                                <span id="end_dateError" style="color: red;"></span>
                            </div>

                            <!-- Soldier -->
                            <div class="mb-3">
                                <label for="soldier_id" class="form-label">Select Soldier</label>
                                <select name="soldier_id" id="soldier_id" class="form-control input-field" required>
                                    <option value="" disabled selected>-- Select Location & Unit first --</option>
                                </select>
                            </div>

                             <!-- remarks -->
                              <div class="mb-3">
                                <label for="remarks" class=" form-label">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control input-field" placeholder="Enter Remarks" rows="3"></textarea>
                              </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-army  px-4" id="assignBtn">Assign Posting</button>
                                <div class="mt-3 d-flex justify-content-center">
                                    <span id="loading" class="text-center d-none align-items-center gap-2"><span class="loader"></span>Assigning...</span>
                                </div>
                            </div>

                           


                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php
    $page_js = "assign_posting.js";

    include('../includes/admin_footer.php');
    ?>