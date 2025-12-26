<?php
$current_page = "manage_assign_mission";
$page_title = "Manage Assigned Missions - Army Management System";
include('../includes/admin_header.php');
// include('check_login.php');
include('../includes/admin_sidebar.php');
?>

<div class=" main-wrapper">
    <main class=" main-content">
        <div class=" container-fluid mt-5">
            <h2 class="animate-fadein aqua">Manage Assigned Missions</h2>
            <div class="search-box-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" id="searchBox" class=" form-control mb-2" placeholder="Search By Soldier name or mission name or role" style="max-width: 500px;">
            </div>
            <div class=" table-responsive animate-slidein">
                <table class=" table table-dark table-bordered table-hover text-align align-middle">
                    <thead>
                        <tr>
                            <th>Soldier Name</th>
                            <th>Mission Name</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class=" table-group-divider" id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php
    $page_js = "manage_assign_mission.js";
    include('../includes/admin_footer.php');
    ?>