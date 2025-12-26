<?php
$page_title = "Manage Leave Requests - Army Management";
include('../includes/admin_header.php');
?>


<!-- Sidebar -->
<?php
$current_page = "approve_leave";
include('../includes/admin_sidebar.php');
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid mt-5 ">
      <h2 class="aqua animate-fadein">Manage Leave Requests</h2>
      <div class="table-responsive animate-slidein">
        <table class="table  table-dark table-hover">
          <thead>
            <tr>
              <th>Soldier ID</th>
              <th>Soldier Name</th>
              <th>Leave Type</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="leave_data" class=" table-group-divider">

          </tbody>

        </table>
      </div>
    </div>
  </main>
  <!-- Footer -->
  <?php
  $page_js = "approve_leave.js";
  include('../includes/admin_footer.php');
  ?>