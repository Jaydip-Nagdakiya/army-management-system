<?php
$page_title = "Home - Army Management System";
$current_page = "home";
include('includes/soldier_header.php');
// include('includes/db_connect.php');






?>
<?php
include('includes/complete_leave.php');
include('includes/posting_complete.php');
include('includes/mission_active.php');
?>
<?php
$soldier_id = $_SESSION['soldier_id'];
$query = "SELECT * FROM soldiers WHERE id=?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$soldier_name = $row['name'];
?>

<!-- Slider -->
<div class="container-fluid">
  <div id="bannerCarousel" class="carousel slide shadow rounded mx-3 animate-slideup" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="IMAGES/b2.jpg" class="d-block w-100 ds-banner" alt="Slide 1">
      </div>
      <div class="carousel-item ">
        <img src="images/b6.jpg" class="d-block w-100 ds-banner" alt="Slide 2">
      </div>
      <div class="carousel-item">
        <img src="images/b9.jpg" class="d-block w-100 ds-banner" alt="Slide 3">
      </div>
      <div class="carousel-item">
        <img src="images/b8.png" class="d-block w-100 ds-banner" alt="Slide 3">
      </div>
      <div class="carousel-item">
        <img src="images/b5.jpg" class="d-block w-100 ds-banner" alt="Slide 3">
      </div>
      <div class="carousel-item">
        <img src="images/b1.jpg" class="d-block w-100 ds-banner" alt="Slide 3">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container my-5 main-content">

  <!-- Welcome -->
  <h2 class="mb-4  aqua">Welcome, <?php echo $soldier_name ?></h2>
  <p class="aqua">Select an action from the options below:</p>

  <!-- Cards -->
  <div class="row g-3 mt-3 ">
    <div class="col-md-4 ">
      <div class="card shadow-sm h-100 hover-card ">
        <div class="card-body">
          <h5 class="card-title">Apply for Leave</h5>
          <p class="card-text">Submit your leave application.</p>
          <a href="apply_leave.php" class="btn btn-army">Apply</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 hover-card">
        <div class="card-body">
          <h5 class="card-title">Leave Status</h5>
          <p class="card-text">Check your leave application status.</p>
          <a href="leave_status.php" class="btn btn-army">View</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card  h-100 hover-card">
        <div class="card-body">
          <h5 class="card-title">Profile</h5>
          <p class="card-text">View your profile.</p>
          <a href="profile.php" class="btn btn-army">Profile</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// $page_js = "wow.min.js";
include('INCLUDES/soldier_footer.php');
?>