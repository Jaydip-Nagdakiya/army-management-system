<?php
$current_page = "manage_inventory";
$page_title = "Manage Inventory - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>

<?php
$sql = "SELECT *FROM inventory";
$result = mysqli_query($con, $sql);
?>

<div class="main-wrapper">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class="aqua  animate-fadein">Manage Inventory</h2>
             <div class="search-box-container">
          <i class="bi bi-search search-icon"></i>
          <input type="text" name="search" id="searchBox"  class=" form-control mb-2" placeholder="Search By Item name or location or category" style="max-width: 500px;" >
        </div>
                <div class=" table-responsive animate-slidein">
                    <table class="table table-dark table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>Item name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Quantity</th>
                                <th>Added Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class=" table-group-divider" id="inventoryTablebody">
                        </tbody>
                    </table>
                </div>
        </div>
    </main>
    <?php
    $page_js="manage_inventory.js";
    include('../includes/admin_footer.php');
    ?>