<?php
$page_title = "Manage Postings - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/posting_complete.php');
include('../includes/active_posting.php');
$sql = "SELECT p.*,s.name from postings p join soldiers s on p.soldier_id=s.id where s.status='Active' order by p.id desc";
$result = mysqli_query($con, $sql);
?>


<!-- Sidebar -->
<?php
$current_page = "manage_posting";
include('../includes/admin_sidebar.php');
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
    <main class="main-content">
        <div class="container-fluid mt-5 ">
            <h2 class="aqua animate-fadein">Manage Postings</h2>
            <div class="search-box-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" id="searchBox" class=" form-control mb-2" placeholder="Search By Soldier name or location or unit" style="max-width: 500px;">
            </div>
            <div class="table-responsive animate-slidein">
                <table class="table table-dark table-hover  text-center">
                    <thead>
                        <tr>
                            <th>Soldier Name</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Unit</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class=" table-group-divider" id="tableBody">

                    </tbody>
                </table>

            </div>


        </div>
    </main>

    <!-- Footer -->
    <?php
    $page_js = "manage_postings.js";
    include('../includes/admin_footer.php');
    ?>