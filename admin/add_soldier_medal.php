<?php
$current_page = "add_soldier_medal";
$page_title = "Add Soldier Medal - Army Management System";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');
?>

<!-- fetch soldiers -->
<?php

$query = "SELECT id, name from soldiers where status='Active'";
$result = mysqli_query($con, $query);

?>
<div class=" main-wrapper">
    <main class=" main-content">
        <div class=" container-fluid mt-5">
            <h2 class=" aqua text-center animate-fadein">Add Soldier Medal</h2>
            <div class="row justify-content-center">
                <div class=" col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box  animate-slidein">
                        <form action="" novalidate id="medalform">
                            <!-- soldier name -->
                            <div class="mb-3">
                                <label for="soldier_id" class=" form-label">Soldier Name</label>
                                <select name="soldier_id" id="soldier_id" class="form-select input-field">
                                    <option value="">--select--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <option value="<?php echo htmlspecialchars($row['id']) ?>"><?= htmlspecialchars($row['name']) ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class=" text-danger" id="soldierError"></span>
                            </div>
                            <!-- medal type -->
                            <div class="mb-3">
                                <label for="medal_type" class="form-lable">Medal Type</label>
                                <select name="medal_type" id="medal_type" class=" form-select input-field">
                                    <option value="">--Select Medal Type--</option>
                                    <option value="Gallantry">Gallantry</option>
                                    <option value="Service">Service</option>
                                    <option value="Bravery">Bravery</option>
                                    <option value="Achievement">Achievement</option>
                                    <option value="Honorary">Honorary</option>
                                </select>
                                <span class=" text-danger" id="typeError"></span>
                            </div>
                            <!-- medal name -->
                            <div class="mb-3">
                                <label for="medal_name" class=" form-lable">Medal Name</label>
                                <input type="text" name="medal_name" id="medal_name" placeholder="Enter Medal Name" required class=" form-control input-field" maxlength="50">
                                <span class=" text-danger" id="medalnamerError"></span>
                            </div>

                            <!-- description -->
                            <div class="mb-3">
                                <label for="description" class="form-lable">Description</label>
                                <textarea name="description" id="description" class=" input-field form-control" placeholder="Enter Description" required maxlength="300"></textarea>
                                <span class=" text-danger" id="descError"></span>
                            </div>
                            <!-- award date -->
                            <div class="mb-3">
                                <label for="award_date" class="form-lable">Award Date</label>
                                <input type="date" name="award_date" id="award_date" class="form-control input-field">
                                <span class=" text-danger" id="dateError"></span>
                            </div>

                            <!-- submit button -->
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-army  w-100" id="addbtn">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php 
$page_js ="soldier_medal.js";
    include('../includes/admin_footer.php');
?>