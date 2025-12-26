<?php
$page_title = "Leave Application - Army Managemnt System";
$current_page = "applyforleave";
include('INCLUDES/soldier_header.php');
?>

<!-- Main Content -->
<div class="container my-5 main-content ">
  <h2 class="mb-4  text-center  aqua animate-fadein">Apply for Leave</h2>

  <div class="card  p-4  rounded  hover-card animate-slideup">
    <form id="leaveForm" method="POST" novalidate>
      <div class="mb-3">
        <label for="leaveType" class="form-label fw-bold text-white">Leave Type</label>
        <select id="leaveType" class="form-control" name="leave_type">
          <option value="" class="leave_type">-- Select Leave Type --</option>
          <option value="Casual Leave">Casual Leave</option>
          <option value="Medical Leave">Medical Leave</option>
          <option value="Annual Leave">Annual Leave</option>
        </select>
      </div>

      <div class="row mb-3">
        <div class="col-md-6"> 
          <label for="startDate" class="form-label fw-bold text-white">Start Date</label>
          <input type="date" id="startDate" class="form-control" name="start_date" required>
          <span id="start_dateError" style="color: red;"></span>
        </div>
        <div class="col-md-6">
          <label for="endDate" class="form-label fw-bold text-white">End Date</label>
          <input type="date" id="endDate" class="form-control" name="end_date" required>
          <span id="end_dateError" style="color: red;"></span>

        </div>
      </div>

      <div class="mb-3">
        <label for="reason" class="form-label fw-bold text-white">Reason</label>
        <textarea id="reason" class="form-control" rows="4" placeholder="Enter your reason for leave" name="reason" maxlength="70" required></textarea>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-army" id="submitBtn">Submit Application</button>
      </div>
    </form>
    <script>

    </script>
  </div>
</div>



<?php
$page_js = "apply_leave.js";
include('INCLUDES/soldier_footer.php');
?>