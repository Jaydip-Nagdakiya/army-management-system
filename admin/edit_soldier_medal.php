<?php
$page_title = "Update Soldier Medal - Army Management System";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');
?>

<!-- fetch data -->
<?php

if($_SERVER['REQUEST_METHOD']==="POST"){
   $id = $_POST['id'];

   $stmt = $con->prepare("SELECT sm.*, s.name from  soldier_medals sm join soldiers s on sm.soldier_id = s.id where sm.id = ?");
   $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $medal = $result->fetch_assoc();

}
?>
<div class=" main-wrapper">
    <main class=" main-content">
        <div class=" container-fluid mt-5">
            <h2 class=" aqua text-center animate-fadein">Update Soldier Medal</h2>
            <div class="row justify-content-center">
                <div class=" col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box  animate-slidein">
                        <form action="" novalidate id="medalform">
                            <!-- soldier name -->
                            <div class="mb-3">
                                <label for="soldier_id" class=" form-label">Soldier Name</label>
                                <select name="soldier_id" id="soldier_id" class="form-select input-field">
                                            <option selected><?= htmlspecialchars($medal['name']) ?></option>
                                </select>
                                <span class=" text-danger" id="soldierError"></span>
                            </div>
                            <!-- medal type -->
                            <div class="mb-3">
                                <label for="medal_type" class="form-lable">Medal Type</label>
                                <select name="medal_type" id="medal_type" class=" form-select input-field">
                                    <option value="">--Select Medal Type--</option>
                                    <option value="Gallantry" <?= $medal['medal_type'] === "Gallantry" ? "selected" : "" ?>>Gallantry</option>
                                    <option value="Service" <?= $medal['medal_type'] === "Service" ? "selected" : "" ?>>Service</option>
                                    <option value="Bravery" <?= $medal['medal_type'] === "Bravery" ? "selected" : "" ?>>Bravery</option>
                                    <option value="Achievement" <?= $medal['medal_type'] === "Achievement" ? "selected" : "" ?>>Achievement</option>
                                    <option value="Honorary" <?= $medal['medal_type'] === "Honorary" ? "selected" : "" ?>>Honorary</option>
                                </select>
                                <span class=" text-danger" id="typeError"></span>
                            </div>
                            <!-- medal name -->
                            <div class="mb-3">
                                <label for="medal_name" class=" form-lable">Medal Name</label>
                                <input type="text" name="medal_name" id="medal_name" placeholder="Enter Medal Name" required class=" form-control input-field" maxlength="50" value="<?= htmlspecialchars($medal['medal_name']) ?>">
                                <span class=" text-danger" id="medalnamerError"></span>
                            </div>

                            <!-- description -->
                            <div class="mb-3">
                                <label for="description" class="form-lable">Description</label>
                                <textarea name="description" id="description" class=" input-field form-control" placeholder="Enter Description" required maxlength="300"><?= htmlspecialchars($medal['description']) ?></textarea>
                                <span class=" text-danger" id="descError"></span>
                            </div>
                            <!-- award date -->
                            <div class="mb-3">
                                <label for="award_date" class="form-lable">Award Date</label>
                                <input type="date" name="award_date" id="award_date" class="form-control input-field" value="<?= htmlspecialchars($medal['awarded_date']) ?>" required>
                                <span class=" text-danger" id="dateError"></span>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?= $medal['id'] ?>">
                            <!-- submit button -->
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-army  w-100" id="updatebtn">Update</button>
                            </div>
                        </form>
                                <button class="btn btn-army w-100 mt-2" onclick="window.location.href='manage_medals.php'">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php 
$page_js ="soldier_medal.js";
    include('../includes/admin_footer.php');
?>