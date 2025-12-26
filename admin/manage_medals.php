<?php
$page_title = "Manage Medals - Army Management System";
$current_page = "manage_medals";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');
?>


<div class=" main-wrapper">
    <main class=" main-content">
        <div class=" container-fluid mt-5">
            <h2 class=" aqua animate-fadein">Manage Soldiers Medals</h2>
            <div class="search-box-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" id="searchBox" class=" form-control mb-2" placeholder="Search By Soldier name or medal type or medal name" style="max-width: 500px;">
            </div>
            <div class=" table-responsive animate-slidein">
                <table class=" table table-dark table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Soldier Name</th>
                            <th>Medal Type</th>
                            <th>Medal Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <?php
    $page_js = "manage_soldier_medals.js";
    include('../includes/admin_footer.php');
    ?>