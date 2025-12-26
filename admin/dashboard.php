<!-- Header -->
<?php
$page_title = "Admin Dashboard - Army Management";
include('../includes/admin_header.php');
// include('../includes/db_connect.php');
?>

<?php
include('../includes/posting_complete.php');
include('../includes/complete_leave.php');
include('../includes/mission_completed.php');
include('../includes/active_posting.php');
include('../includes/mission_active.php');

$soldiercount = 0;
$qry = "select count(*) as total from soldiers";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $soldiercount = $row['total'];
}

$activeSoldiers = 0;
$qry = "select count(*) as active from soldiers where status='Active'";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $activeSoldiers = $row['active'];
}

$inactiveSoldiers = 0;
$qry = "select count(*) as Deactive from soldiers where status='Deactive'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $inactiveSoldiers = $row['Deactive'];
}

$noticecount = 0;
$qry = "select count(*) as noticecount from notices";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $noticecount = $row['noticecount'];
}

$pendingStatus = 0;
$qry = "select count(*) as pendingstatus from leave_applications where status='Pending'";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $pendingStatus = $row['pendingstatus'];
}

$approveStatus = 0;
$qry = "select count(*) as approvestatus from leave_applications where status='Approved'";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $approveStatus = $row['approvestatus'];
}
$rejectedStatus = 0;
$qry = "select count(*) as rejectedstatus from leave_applications where status='Rejected'";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $rejectedStatus = $row['rejectedstatus'];
}

$postingCount = 0;
$qry = "SELECT COUNT(*) as totalpostings FROM postings";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $postingCount = $row['totalpostings'];
}

$activePostings = 0;
$qry = "select count(*) as activepostings from postings where status='Active'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $activePostings = $row['activepostings'];
}   



$completedCount = 0;
$qry = "SELECT COUNT(*) as completedpostings FROM postings WHERE status='Completed'";
$result = $con->query($qry);
if ($result && $row = $result->fetch_assoc()) {
  $completedCount = $row['completedpostings'];
}

$totalmissons = 0;
$qry = "select count(*) as totalmissons from missions";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $totalmissons = $row['totalmissons'];
}

$plannedmissions = 0;
$qry = "select count(*) as plannedmissions from missions where status='Planned'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $plannedmissions = $row['plannedmissions'];
}

$activemissions = 0;
$qry = "select count(*) as activemissions from missions where status='Active'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $activemissions = $row['activemissions'];
}
$cancelledCounts = 0;
$qry = "select count(*) as cancelledCount from missions where status='Cancelled'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $cancelledCounts = $row['cancelledCount'];
}


$totalInventory = 0;
$qry = "select count(*) as totalInventory from inventory";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $totalInventory = $row['totalInventory'];
}


$vehicleInventory = 0;
$qry = "select count(*) as vehicleInventory from inventory where category='Vehicle'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $vehicleInventory = $row['vehicleInventory'];
}

$weaponInventory = 0;
$qry = "select count(*) as weaponInventory from inventory where category='Weapon'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $weaponInventory = $row['weaponInventory'];
}

$medicalInventory = 0;
$qry = "select count(*) as medicalInventory from inventory where category='Medical'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $medicalInventory = $row['medicalInventory'];
}

$uniformInventory = 0;
$qry = "select count(*) as uniformInventory from inventory where category='Uniform'";
$result = $con->query($qry);
if($result && $row = $result->fetch_assoc()){
  $uniformInventory = $row['uniformInventory'];
}
?>

<!-- Sidebar -->
<?php
$current_page = "dashboard";
include('../includes/admin_sidebar.php');
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid  pt-4">
      <div class="row cards">
        <div class="col-md-4 mb-3">
          <div class="card-box ds-card animate-slidein">
            <h4>Soldiers</h4>
            <p>Total: <?php echo $soldiercount ?></p>
            <p>Active: <?php echo $activeSoldiers; ?></p>
            <p>Deactive: <?php echo $inactiveSoldiers; ?></p>
          <p class="view-more"><a href="soldier_report.php" target="_blank">View More</a></p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card-box ds-card animate-slidein">
            <h4>Leaves</h4>
            <p>Pending: <?php echo $pendingStatus; ?></p>
            <p>Approved: <?php echo $approveStatus; ?></p>
            <p>Rejected : <?php echo $rejectedStatus; ?></p>
          <p class="view-more"><a href="approve_leave.php" target="_blank">View More</a></p>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card-box ds-card animate-slidein">
            <h4>Notices Sent</h4>
            <p>Total: <?php echo $noticecount; ?></p>
          <p class="view-more"><a href="manage_notices.php" target="_blank">View More</a></p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card-box ds-card animate-slidein">
            <h4>Postings</h4>
            <p>Total: <?php echo $postingCount; ?></p>
            <p>Active: <?php echo $activePostings; ?></p>
            <p>Completed : <?php echo $completedCount; ?></p>
          <p class="view-more"><a href="manage_posting.php" target="_blank">View More</a></p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
        <div class="card-box ds-card animate-slidein">
            <h4>Missions</h4>
            <p>Total: <?php echo $totalmissons; ?></p>
            <p>Planned: <?php echo $plannedmissions; ?></p>
            <p>Active: <?php echo $activemissions; ?></p>
            <p>Cancelled: <?php echo $cancelledCounts; ?></p>
          <p class="view-more"><a href="manage_missions.php" target="_blank">View More</a></p>
          </div>
          </div>
           <div class="col-md-4 mb-3">
        <div class="card-box ds-card animate-slidein">
            <h4>Inventory</h4>
            <p>Total: <?php echo $totalInventory; ?></p>
            <p>Vehicles: <?php echo $vehicleInventory; ?></p>
            <p>Weapons: <?php echo $weaponInventory; ?></p>
            <p>Medical: <?php echo $medicalInventory; ?></p>
            <p>Uniform: <?php echo $uniformInventory; ?></p>
          <p class="view-more"><a href="manage_inventory.php" target="_blank">View More</a></p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php
  include('../includes/admin_footer.php');
  ?>