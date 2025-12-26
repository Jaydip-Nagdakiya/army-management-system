 <aside class="sidebar">
     <ul>
         <li><a href="<?php echo (isset($current_page) && $current_page == "dashboard") ? "#" : "dashboard.php" ?>" class="<?php echo (isset($current_page) && $current_page == "dashboard") ? "active" : ""; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "registration") ? "#" : "soldier_registration.php" ?>" class="<?php echo (isset($current_page) && $current_page == "registration") ? "active" : ""; ?>"><i class="bi bi-person-plus-fill"></i> Soldier Registration</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_soldier") ? "#" : "manage_soldiers.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_soldier") ? "active" : ""; ?>"><i class="bi bi-people-fill"></i> Manage Soldiers</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "assign_posting") ? "#" : "postings.php" ?>" class="<?php echo (isset($current_page) && $current_page == "assign_posting") ? "active" : ""; ?>"><i class="bi bi-geo-alt-fill"></i> Assign Posting</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_posting") ? "#" : "manage_posting.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_posting") ? "active" : ""; ?>"><i class="bi bi-list-check"></i> Manage Postings</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "posting_report") ? "#" : "posting_report.php" ?>" class="<?php echo (isset($current_page) && $current_page == "posting_report") ? "active" : ""; ?>"><i class="bi  bi-graph-up-arrow"></i> Posting Report</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "approve_leave") ? "#" : "approve_leave.php" ?>" class="<?php echo (isset($current_page) && $current_page == "approve_leave") ? "active" : ""; ?>"><i class="bi bi-calendar-check"></i> Manage Leave Requests</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "soldier_report") ? "#" : "soldier_report.php" ?>" class="<?php echo (isset($current_page) && $current_page == "soldier_report") ? "active" : ""; ?>"><i class="bi bi-file-earmark-bar-graph"></i> Soldier Report</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "add_missions") ? "#" : "mission_add.php" ?>" class="<?php echo (isset($current_page) && $current_page == "add_missions") ? "active" : ""; ?>"><i class="bi bi-plus-circle-fill"></i> Add Mission</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_messions") ? "#" : "manage_missions.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_missions") ? "active" : ""; ?>"><i class="bi bi-clipboard-data"></i> Manage Missions</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "assign_mission") ? "#" : "assign_missions.php" ?>" class="<?php echo (isset($current_page) && $current_page == "assign_mission") ? "active" : ""; ?>"><i class="bi bi-bullseye"></i> Assign Mission</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_assign_mission") ? "#" : "manage_assign_mission.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_assign_mission") ? "active" : ""; ?>"><i class="bi  bi-table"></i> Manage Assigned Missions</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "add_soldier_medal") ? "#" : "add_soldier_medal.php" ?>" class="<?php echo (isset($current_page) && $current_page == "add_soldier_medal") ? "active" : ""; ?>"><i class="bi bi-award-fill"></i> Add Soldier Medal</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_medals") ? "#" : "manage_medals.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_medals") ? "active" : ""; ?>"><i class="bi bi-award-fill"></i> Manage Soldier Medals</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "add_inventory") ? "#" : "add_inventory.php" ?>" class="<?php echo (isset($current_page) && $current_page == "add_inventory") ? "active" : ""; ?>"><i class="bi  bi-box-arrow-in-down"></i> Add Inventory</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_inventory") ? "#" : "manage_inventory.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_inventory") ? "active" : ""; ?>"><i class="bi bi-box-seam"></i> Manage Inventory</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "send_notice") ? "#" : "notices.php" ?>" class="<?php echo (isset($current_page) && $current_page == "send_notice") ? "active" : ""; ?>"><i class="bi bi-megaphone-fill"></i> Send Notice</a></li>
         <li><a href="<?php echo (isset($current_page) && $current_page == "manage_notice") ? "#" : "manage_notices.php" ?>" class="<?php echo (isset($current_page) && $current_page == "manage_notice") ? "active" : ""; ?>"><i class="bi bi-journal-text"></i> Manage Notices</a></li>
     </ul>
 </aside>
 <script>
  document.addEventListener("DOMContentLoaded", function() {
    const activeLink = document.querySelector(".sidebar a.active");
    if (activeLink) {
      activeLink.scrollIntoView({ behavior: "smooth", block: "center" });
    }
 });
</script>