<!-- Header -->
<?php
$page_title = "Update Soldier Information - Army Management System";
include('../includes/admin_header.php');
?>

<?php
if (isset($_POST['id'])) {

  $id = intval($_POST['id']);

  $stmt = $con->prepare("select *from soldiers where id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
}
?>

<!-- Sidebar -->
<?php
include('../includes/admin_sidebar.php');
?>

<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container mt-5">
      <h2 class="mb-4 text-center aqua animate-fadein">Update Soldier Details</h2>
      <!-- <a href="manage_soldiers.php" class="btn btn-army text-center">Back</a> -->
      <div class="row justify-content-center">
        <div class="col-md-9 col-lg-9 col-xl-9">
          <div class="card-box p-4  animate-slidein ">
            <!-- Main Form -->
            <form id="soldierForm" novalidate>
              <input type="hidden" name="id" style="display: none;" value="<?php echo $id; ?>">

              <div class="mb-3">
                <label for="name" class="form-label">Name </label>
                <input type="text" id="name" name="name" class="form-control input-field" placeholder="Enter Soldier Name" maxlength="50" required value="<?php echo $row['name']; ?>">
                <small id="nameError" class="form-error"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" for="dob">Date of Birth</label>
                <input type="date" class="form-control input-field" id="dob" name="dob" required value="<?php echo $row['dob']; ?>">
                <small id="dobError" class="form-error"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" class="form-control input-field" name="mobileno" maxlength="10" pattern="[0-9]{10}" placeholder="Enter Mobile Number" required value="<?php echo $row['mobile']; ?>">
                <small id="mobileError" class="form-error"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" for="address">Address</label>
                <textarea class="form-control input-field" id="address" name="address" rows="2" placeholder="Enter Address" required maxlength="50"><?php echo $row['address']; ?></textarea>
                <small id="addressError" class="form-error"></small>
              </div>

              <div class="mb-3">
                <label class="form-label" for="bloodgrp">Blood Group</label>
                <select id="bloodgrp" class="form-control input-field" name="bloodgroup" required>
                  <option value="">Select Blood Group</option>
                  <option <?php if ($row['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                  <option <?php if ($row['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                  <option <?php if ($row['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                  <option <?php if ($row['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                  <option <?php if ($row['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                  <option <?php if ($row['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                  <option <?php if ($row['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                  <option <?php if ($row['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                </select>
                <small id="bloodgrpError" class="form-error"></small>
              </div>

              <div class="mb-3">
                <label for="rank" class="form-label">Rank</label>
                <select id="rank" name="rank" class="form-control input-field" required>
                  <option value="">-- Select Rank --</option>
                  <option <?php if ($row['rank'] == 'Sepoy') echo 'selected'; ?>>Sepoy</option>
                  <option <?php if ($row['rank'] == 'Lance Naik') echo 'selected'; ?>>Lance Naik</option>
                  <option <?php if ($row['rank'] == 'Naik') echo 'selected'; ?>>Naik</option>
                  <option <?php if ($row['rank'] == 'Havildar') echo 'selected'; ?>>Havildar</option>
                  <option <?php if ($row['rank'] == 'Naib Subedar') echo 'selected'; ?>>Naib Subedar</option>
                  <option <?php if ($row['rank'] == 'Subedar') echo 'selected'; ?>>Subedar</option>
                  <option <?php if ($row['rank'] == 'Subedar Major') echo 'selected'; ?>>Subedar Major</option>
                  <option <?php if ($row['rank'] == 'Lieutenant') echo 'selected'; ?>>Lieutenant</option>
                  <option <?php if ($row['rank'] == 'Captain') echo 'selected'; ?>>Captain</option>
                  <option <?php if ($row['rank'] == 'Major') echo 'selected'; ?>>Major</option>
                  <option <?php if ($row['rank'] == 'Lieutenant Colonel') echo 'selected'; ?>>Lieutenant Colonel</option>
                  <option <?php if ($row['rank'] == 'Colonel') echo 'selected'; ?>>Colonel</option>
                  <option <?php if ($row['rank'] == 'Brigadier') echo 'selected'; ?>>Brigadier</option>
                  <option <?php if ($row['rank'] == 'Major General') echo 'selected'; ?>>Major General</option>
                  <option <?php if ($row['rank'] == 'Lieutenant General') echo 'selected'; ?>>Lieutenant General</option>
                  <option <?php if ($row['rank'] == 'General') echo 'selected'; ?>>General</option>
                  <option <?php if ($row['rank'] == 'Special Forces Officer') echo 'selected'; ?>>Special Forces Officer</option>
                  <option <?php if ($row['rank'] == 'Medical Officer') echo 'selected'; ?>>Medical Officer</option>
                  <option <?php if ($row['rank'] == 'Logistics Officer') echo 'selected'; ?>>Logistics Officer</option>
                </select>
                <small id="rankError" class="form-error"></small>
              </div>
              <!-- <div class="mb-3">
                <label for="status" class="form-label">Select Status</label>
                <select id="status" name="status" class="form-control input-field" required>
                  <option value="">-- Select--</option>
                  <option <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                  <option <?php if ($row['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
                <small id="statusError" class="form-error"></small>
              </div> -->
              <button type="submit" id="updateBtn" class="btn btn-army w-100">Update Soldier Details</button>
              <div class="mt-3 d-flex justify-content-center">
                <span id="loading" class="text-center d-none align-items-center gap-2"><span class="loader"></span>Updating...</span>
              </div>
            </form>
            <a href="manage_soldiers.php" class="btn  btn-army text-center w-100 mt-2">Back</a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Footer -->
  <?php
  $page_js = "update_soldier.js";
  include('../includes/admin_footer.php');
  ?>