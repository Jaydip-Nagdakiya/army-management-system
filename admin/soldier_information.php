<?php
$page_title = "Soldier Information - Army Management System";
include('../includes/admin_header.php');
// include('../includes/db_connect.php');
include('../includes/admin_sidebar.php');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $soldier_id = intval($_POST['id']);
    $stmt = $con->prepare("SELECT * FROM soldiers WHERE id=?");
    $stmt->bind_param("i", $soldier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $soldiers = $result->fetch_assoc();
}
// Fetch missions completed from soldiers_missions table
$mission_query = "SELECT COUNT(*) as missions_completed FROM soldiers_missions join missions on soldiers_missions.mission_id=missions.mission_id WHERE soldiers_missions.soldier_id = ? and missions.status='Completed'";
$mission_stmt = $con->prepare($mission_query);
$mission_stmt->bind_param("i", $soldier_id);
$mission_stmt->execute();
$mission_result = $mission_stmt->get_result();
$mission_row = $mission_result->fetch_assoc();
$missions_completed = $mission_row['missions_completed'];

// Fetch medals count from soldier_medals table
$medal_query = "SELECT COUNT(*) as medals FROM soldier_medals  WHERE soldier_id = ?";
$medal_stmt = $con->prepare($medal_query);  
$medal_stmt->bind_param("i", $soldier_id);
$medal_stmt->execute();
$medal_result = $medal_stmt->get_result();
$medal_row = $medal_result->fetch_assoc();
$medals = $medal_row['medals'];

// Performance rating calculation (customize as needed)
$performance_rating = min(10, ($missions_completed * 0.5) + ($medals * 1));

// Progress percent calculation (assume target 20 missions)
$target_missions = 20;
$progress_percent = min(100, ($missions_completed / $target_missions) * 100);

// Promotion eligibility (example logic)
$promotion_eligible = ($performance_rating >= 7 && $missions_completed >= $target_missions) ? "Yes" : "No";
// Remarks (optional)
$remarks = "";
if ($performance_rating >= 9) {
    $remarks = "Excellent performance";
} elseif ($performance_rating >= 7) {
    $remarks = "Good performance";
} elseif ($performance_rating >= 5) {
    $remarks = "Average performance";
} else {
    $remarks = "Needs improvement";
}
$soldiers['missions_completed'] = $missions_completed;
$soldiers['medals'] = $medals;
$soldiers['performance_rating'] = $performance_rating ;
$soldiers['progress_percent'] = $progress_percent;
$soldiers['promotion_eligible'] = $promotion_eligible;
$soldiers['remarks'] = $remarks;


?>


<div class="main-wrapper flex-grow-1 d-flex flex-column">
    <main class="main-content">
        <div class="container mt-5">

            <!-- Header -->
            <div class=" text-center mb-4">
                <h2 class="fw-bold aqua animate-fadein">Soldier Information</h2>
            </div>

            <div class="card border-0  rounded-4 overflow-hidden animate-slidein">
                <div class="row g-0">

                    <!-- Left side: Profile Image -->
                    <div class="col-md-4 bg-dark text-center d-flex flex-column align-items-center justify-content-center p-3">
                        <img src="<?php echo "../".$soldiers['profile_photo'] ?>"
                            class="img-fluid rounded-circle shadow-lg border border-4 border-light"
                            alt="Profile Image" style="width:220px;height:220px;object-fit:scale-down; object-position:center;">
                        <h4 class="mt-3 text-white"><?= $soldiers['name'] ?></h4>
                        <span class="badge bg-info text-dark fs-6 px-3 py-2"><?= $soldiers['rank'] ?></span>
                    </div>

                    <!-- Right side: Soldier Details -->
                    <div class="col-md-8 bg-light p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    <tr>
                                        <th class="text-primary">Email</th>
                                        <td><?= $soldiers['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Mobile</th>
                                        <td><?= $soldiers['mobile'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Date Of Birth</th>
                                        <td><?= $soldiers['dob'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Date of Joining</th>
                                        <td><?= $soldiers['date_of_joining'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Missions Completed</th>
                                        <td><span class="badge bg-success"><?= $soldiers['missions_completed'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Medals</th>
                                        <td><?= $soldiers['medals'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Performance Rating</th>
                                        <td>
                                            <div class="progress" style="height:20px;">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: <?=($soldiers['performance_rating'])/ 10 * 100 ?>%;"
                                                    aria-valuenow="<?= $soldiers['performance_rating'] ?>"
                                                    aria-valuemin="0" aria-valuemax="10">
                                                    <?= $soldiers['performance_rating'] ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Promotion Eligible</th>
                                        <td>
                                            <?php if ($soldiers['promotion_eligible'] == "Yes") { ?>
                                                <span class="badge bg-success">Yes</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger">No</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Progress</th>
                                        <td>
                                            <div class="progress" style="height:20px;">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: <?= $soldiers['progress_percent'] ?>%;"
                                                    aria-valuenow="<?= $soldiers['progress_percent'] ?>"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    <?= $soldiers['progress_percent'] ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-primary">Remarks</th>
                                        <td><?= $soldiers['remarks'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <!-- Soldier Leave appication -->

        <?php
        $stmt = $con->prepare("SELECT * FROM leave_applications WHERE soldier_id=?");
        $stmt->bind_param("i", $soldier_id);
        $stmt->execute();
        $result1 = $stmt->get_result();
        ?>
        <div class="container mt-5">

            <!-- Header -->
            <div class=" text-center mb-4">
                <h2 class="fw-bold  aqua">Soldier Leave Application Details</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered  table-hover text-center">
                    <thead class=" table-dark">
                        <tr>
                       
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Applied On</th>
                            <th>Reviewed By Admin</th>
                            <th>Reviewed On</th>
                            <th>Status</th>
                        </tr>

                    </thead>
                    <tbody class=" table-group-divider">
                        <?php if ($result1 && $result1->num_rows > 0) {
                            while ($leave = $result1->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $leave['leave_type'] ?></td>
                                    <td><?php echo $leave['start_date'] ?></td>
                                    <td><?php echo $leave['end_date'] ?></td>
                                    <td><?php echo $leave['reason'] ?></td>
                                    <td><?php echo $leave['applied_on'] ?></td>
                                    <td><?php if($leave['reviewed_by_admin']==null) echo '-'; else {
                                       echo "Id:".$leave['reviewed_by_admin'];
                                    }?></td>
                                    <td><?php echo $leave['reviewed_on'] ?></td>
                                    <td>
                                        <?php
                                        $status = $leave['status'];
                                        if ($status == "Approved") { ?>
                                            <span class=" badge bg-success"> <?php echo $status; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class=" badge bg-danger"> <?php echo $status; ?></span>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="10" class=" text-center"> No leave Application Available</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="container mt-5">


            <!-- soldier posting -->
            <?php
            $stmt = $con->prepare("SELECT * FROM postings WHERE soldier_id=?");
            $stmt->bind_param("i", $soldier_id);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <div class=" text-center mb-4">
                <h2 class="fw-bold  aqua">Posting Details</h2>
            </div>
            <div class="table-responsive">
                <table class="table  table-bordered table-hover">
                    <thead class=" table-dark">
                        <tr>
                           
                            <th>Unit</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Remarks</th>
                            <th>Assigned On</th>
                            <th>Status</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) {
                            while ($posting = $result->fetch_assoc()) { ?>
                                <tr>
                                    
                                    <td><?php echo $posting['unit'] ?></td>
                                    <td><?php echo $posting['location'] ?></td>
                                    <td><?php echo $posting['start_date'] ?></td>
                                    <td><?php echo $posting['end_date'] ?></td>
                                    <td><?php echo $posting['remarks'] ?></td>
                                    <td><?php echo $posting['assigned_on'] ?></td>
                                    <td>
                                        <?php
                                        $status = $posting['status'];
                                        if ($status == "Active") { ?>
                                            <span class=" badge bg-success"> <?php echo $status; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class=" badge  bg-primary"> <?php echo $status; ?></span>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="10" class=" text-center"> Posting Data Not Found</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
           
            </div>
        </div>
       <div class="container mt-5">
            <!-- soldier mission -->
            <?php
            $stmt = $con->prepare("SELECT * FROM missions join soldiers_missions ON missions.mission_id = soldiers_missions.mission_id WHERE soldiers_missions.soldier_id=?");
            $stmt->bind_param("i", $soldier_id);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <div class=" text-center mb-4">
                <h2 class="fw-bold  aqua">Mission Details</h2>
            </div>
            <div class="table-responsive">
                <table class="table  table-bordered table-hover">
                    <thead class=" table-dark">
                        <tr>
                            <th>Mission Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) {
                            while ($mission = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $mission['mission_name'] ?></td>
                                    <td><?php echo $mission['description'] ?></td>
                                    <td><?php echo $mission['start_date'] ?></td>
                                    <td><?php echo $mission['end_date'] ?></td>
                                    <td><?php echo  htmlspecialchars($mission['assigned_at']) ?></td>
                                    <td>
                                        <?php
                                        $status = $mission['status'];
                                        if ($status == "Completed") { ?>
                                            <span class=" badge bg-success"> <?php echo $status; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class=" badge  bg-primary"> <?php echo $status; ?></span>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="10" class=" text-center"> Mission Data Not Found</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
       </div>

       <div class="container mt-5">
            <!-- soldier medals -->
            <?php
            $stmt = $con->prepare("SELECT * FROM soldier_medals WHERE soldier_id=?");
            $stmt->bind_param("i", $soldier_id);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <div class=" text-center mb-4">
                <h2 class="fw-bold  aqua">Medal Details</h2>
            </div>
            <div class="table-responsive">
                <table class="table  table-bordered table-hover">
                    <thead class=" table-dark">
                        <tr>
                            <th>Medal Type</th>
                            <th>Medal Name</th>
                            <th>Description</th>
                            <th>Awarded On</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) {
                            while ($medal = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $medal['medal_type'] ?></td>
                                    <td><?php echo $medal['medal_name'] ?></td>
                                    <td><?php echo $medal['description'] ?></td>
                                    <td><?php echo $medal['awarded_date'] ?></td>

                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="10" class=" text-center"> Medal Data Not Found</td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
       </div>

      <!-- Back Button -->
            <div class="text-center mt-4 mb-2">
                <a href="soldier_report.php" class="btn btn-army ">Back to Report</a>
            </div>

    </main>
<script>
    document.addEventListener("keydown",function(event){
        if(event.key=="Backspace"){
            window.location.href="soldier_report.php";
        }
    })
    </script>
    <?php include('../includes/admin_footer.php'); ?>