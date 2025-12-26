<?php

$page_title = "Leave Status - Army Management System";
$current_page = "leavestatus";
include('INCLUDES/soldier_header.php');

?>

<!-- Main Content -->
<div class="container my-5 main-content  leave_status-con">
  <h2 class="mb-4 aqua animate-fadein">My Leave Applications</h2>

  <div class="table-responsive animate-slideup">
    <table id="leaveStatusTable" class="table table-bordered shadow-sm text-center">
      <thead>
        <tr>
          <th>Leave Type</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Reason</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="leave_data">


      </tbody>
    </table>
    <form id="editForm" action="edit_leave.php" method="post">
      <input type="hidden" id="hiddenid" name="id">
    </form>
  </div>
</div>

<?php
$page_js = "leave_status.js";
include('INCLUDES/soldier_footer.php');
?>