<?php
$page_title = "Manage Missions - Army Management System";
$current_page = "manage_missions";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>

<?php
$sql = "SELECT * from missions";
$result = mysqli_query($con, $sql);
?>

<div class=" main-wrapper">
    <main class=" main-content">
        <div class=" container-fluid mt-5">
            <h2 class=" aqua animate-fadein">Manage Missions</h2>
             <div class="search-box-container">
          <i class="bi bi-search search-icon"></i>
          <input type="text" name="search" id="searchBox"  class=" form-control mb-2" placeholder="Search By Mission name or Location" style="max-width: 500px;" >
        </div>
            <div class=" table-responsive animate-slidein">
                <?php if ($result->num_rows > 0): ?>
                    <table class=" table table-dark table-hover table-bordered align-middle text-center">
                        <thead>
                            <tr>
                                <th>Mission Name</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Satatus</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class=" table-group-divider" id="missionTablebody"></tbody>
                    </table>
                <?php else: ?>
                    <div class=" alert    alert-info text-center">No Missions Found</div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php
    $page_js = "manage_mission.js";
    include('../includes/admin_footer.php');
    ?>