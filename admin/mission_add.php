<?php
$current_page = "add_missions";
$page_title = "Add Mission - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>


<div class="main-wrapper">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class="text-center animate-fadein aqua">Add Misson</h2>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box animate-slidein">
                        <form  method="post" id="missiondata">
                            <!-- Mission Name -->
                            <div class="mb-3">
                                <label for="mission_name" class="form-label">Mission Name</label>
                                <input type="text" class="form-control input-field" id="mission_name" name="mission_name" required placeholder="Enter mission name" maxlength="50">
                                <span id="missionError" class=" text-danger"></span>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control input-field" id="description" name="description" rows="3" required placeholder="Enter discription" maxlength="300"></textarea>
                                 <span id="descError" class=" text-danger"></span>
                            </div>

                            <!-- Location -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <select class="form-select input-field" id="location" name="location" required>
                                    <option value="" disabled selected>-- Select Location --</option>
                                    <option value="Headquarters">Headquarters</option>
                                    <option value="Border Post 1">Border Post 1</option>
                                    <option value="Border Post 2">Border Post 2</option>
                                    <option value="Training Camp">Training Camp</option>
                                    <option value="Base Alpha">Base Alpha</option>
                                    <option value="Base Bravo">Base Bravo</option>
                                </select>
                                <span id="locationError" class=" text-danger"></span>
                            </div>

                            <!-- Start & End Date -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control input-field" id="start_date" name="start_date" required>
                                    <span id="start_dateError" class=" text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control input-field" id="end_date" name="end_date">
                                    <span id="end_dateError" class=" text-danger"></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <!-- <div class="mb-3">
                                <label for="status" class="form-label">Mission Status</label>
                                <select class="form-select input-field" id="status" name="status">
                                    <option value="" selected disabled>--select--</option>
                                    <option value="Planned">Planned</option>
                                    <option value="Active">Active</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                <span id="statusError" class=" text-danger"></span>
                            </div> -->

                            <!-- Submit -->
                            <button type="submit" class="btn btn-army" id="addBtn">
                                <i class="bi bi-plus-circle-fill"></i> Add Mission
                            </button>
                            <button type="reset" class="btn btn-army" >
                                 Reset
                            </button>
                        </form>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php
    $page_js="mission.js";
    include('../includes/admin_footer.php');
    ?>