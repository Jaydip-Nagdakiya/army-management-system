<?php
$page_title = "Update Leave Application - Army Management System";
include('INCLUDES/soldier_header.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: leave_status.php");
  exit();
}
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  echo "<script> alert('invalid ID');
    window.location.href='leave_status.php';
     </script>";
  exit;
}
// Fetch leave data
$stmt = $con->prepare("SELECT leave_type, start_date,end_date, reason FROM leave_applications WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

?>

<!-- Main Content -->
<div class="container my-5 main-content animate-slidein">
  <h2 class="mb-4  text-center animate-fadein aqua animate-fadein">Update Leave Application</h2>

  <div class="card  p-4  rounded  hover-card animate-slideup">
    <form id="leaveForm" method="POST" novalidate>
      <div class="mb-3">
        <label for="leaveType" class="form-label fw-bold text-white">Leave Type</label>
        <select id="leaveType" class="form-control" name="leave_type">
          <option value="" class="leave_type">-- Select Leave Type --</option>
          <option value="Casual Leave" <?php if ($row['leave_type'] == 'Casual Leave') echo 'selected'; ?>>Casual Leave</option>
          <option value="Medical Leave" <?php if ($row['leave_type'] == 'Medical Leave') echo 'selected'; ?>>Medical Leave</option>
          <option value="Annual Leave" <?php if ($row['leave_type'] == 'Annual Leave') echo 'selected'; ?>>Annual Leave</option>
        </select>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="startDate" class="form-label fw-bold text-white">Start Date</label>
          <input type="date" id="startDate" class="form-control" name="start_date" required value="<?php echo $row['start_date']; ?>">
        </div>
        <div class="col-md-6">
          <label for="endDate" class="form-label fw-bold text-white">End Date</label>
          <input type="date" id="endDate" class="form-control" name="end_date" required value="<?php echo $row['end_date']; ?>">
        </div>
      </div>

      <div class="mb-3">
        <label for="reason" class="form-label fw-bold text-white">Reason</label>
        <textarea id="reason" class="form-control" rows="4" placeholder="Enter your reason for leave" name="reason" maxlength="70" required><?php echo $row['reason']; ?></textarea>
      </div>
      <input type="hidden" value="<?php echo $id; ?>" name="id">
      <div class="d-grid">
        <button type="submit" class="btn btn-army " id="updateBtn"><i class="bi bi-pencil-square"></i> Update Leave Application</button>
        <a href="leave_status.php" class="btn btn-army mt-2">Back</a>
      </div>
    </form>
  </div>
</div>


<?php
$page_js = "update_leave.js";
include('INCLUDES/soldier_footer.php');
?>