<?php
$page_title = "Assign Mission - Army Management System";
$current_page = "assign_mission";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');

// fectch soldiers
$result = mysqli_query($con, "SELECT s.id, s.name, p.location , p.id as posting_id FROM soldiers s left join postings p on p.id = (select id from postings where soldier_id = s.id order by id desc limit 1) WHERE s.status = 'Active'
      AND (
            (SELECT m.status 
             FROM soldiers_missions sm 
             JOIN missions m ON sm.mission_id = m.mission_id
             WHERE sm.soldier_id = s.id 
             ORDER BY sm.id DESC 
             LIMIT 1) = 'Completed'
            OR NOT EXISTS (
                SELECT 1 
                FROM soldiers_missions sm 
                WHERE sm.soldier_id = s.id
            )
          )
      AND (
            (SELECT l.status 
             FROM leave_applications l 
             WHERE l.soldier_id = s.id 
             ORDER BY l.id DESC 
             LIMIT 1) IN ('Rejected','Completed','Pending')
            OR NOT EXISTS (
                SELECT 1 FROM leave_applications l WHERE l.soldier_id = s.id
            )
      )
");


// Fetch missions
$missions = $con->query("SELECT mission_id, mission_name FROM missions where status ='Active'");
?>

<div class="main-wrapper">
  <main class="main-content">
    <div class="container-fluid mt-5">
      <h2 class="text-center animate-fadein aqua">Assign Mission</h2>
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8 col-xl-8">
          <div class="card-box animate-slidein">
            <form method="post" novalidate id="missionform">

              <!-- Soldier -->
              <div class="mb-3">
                <label for="soldier_id" class="form-label">Select Soldier</label>
                <select class="form-select input-field" id="soldier_id" name="soldier_id" required >
                  <option value="" selected disabled>-- Select Soldier --</option>
                  <?php if($result->num_rows > 0) {?>
                  <?php while ($s = $result->fetch_assoc()) { ?>
                    <option value="<?= $s['id'] ?>" data-posting="<?= $s['posting_id'] ?>" ><?= htmlspecialchars($s['name']) ?> (<?= $s['location'] ? htmlspecialchars($s['location']) : 'No Active Posting' ?>)</option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="" disabled>No Active Soldiers Available</option>
                  <?php } ?>
                </select>
                <span class=" text-danger" id="soldierError"></span>
              </div>

              <!-- Mission -->
              <div class="mb-3">
                <label for="mission_id" class="form-label">Select Mission</label>
                <select class="form-select input-field" id="mission_id" name="mission_id" required>
                  <option value="" selected disabled>-- Select Mission --</option>
                  <?php if($missions->num_rows > 0) {?>
                  <?php while ($m = $missions->fetch_assoc()) { ?>
                    <option value="<?= $m['mission_id'] ?>"><?= htmlspecialchars($m['mission_name']) ?></option>
                  <?php } ?>
                  <?php } else { ?>
                    <option value="" disabled>No Active Missions Available</option>
                  <?php } ?>
                </select>
                <span class=" text-danger" id="missionError"></span>
              </div>

              <!-- Role -->
              <div class="mb-3">
                <label for="role" class="form-label">Assign Role</label>
                <select class="form-select input-field" id="role" name="role" required>
                  <option value="" disabled selected>-- Select Role --</option>
                  <option value="Leader">Leader</option>
                  <option value="Supporter">Supporter</option>
                  <option value="Medic">Medic</option>
                  <option value="Sniper">Sniper</option>
                  <option value="Engineer">Engineer</option>
                </select>
                <span class=" text-danger" id="roleError"></span>
              </div>

              <!-- Submit -->
              <button type="submit" class="btn btn-army" id="assignmissionBtn">
                <i class="bi bi-check-circle-fill"></i> Assign Mission
              </button>
                <div class="mt-3 d-flex justify-content-center">
                    <span id="loading" class="text-center d-none align-items-center gap-2"><span class="loader"></span>Assigning...</span>
                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php
  $page_js = "assign_mission.js";
  include('../includes/admin_footer.php'); ?>