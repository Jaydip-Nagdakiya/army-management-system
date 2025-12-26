<?php
$page_title = "Manage Soldiers - Army Management System";
include('../includes/admin_header.php');
?>

<!-- Sidebar -->
<?php
$current_page = "manage_soldier";
include('../includes/admin_sidebar.php');
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid mt-5 ">
        <h2 class="aqua animate-fadein mb-3">Manage Soldiers</h2>
        <div class="search-box-container">
          <i class="bi bi-search search-icon"></i>
          <input type="text" name="search" id="searchBox"  class=" form-control mb-2" placeholder="Search By ID or Name or email or Rank" style="max-width: 500px;" >
        </div>
        <div class="table-responsive animate-slidein rounded">
          <table class="table  table-dark  table-hover  align-middle text-center">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date Of Birth</th>
                <th>Address</th>
                <th>Blood Group</th>
                <th>Rank</th>
                <th>Mobile Number</th>
                <th>Account Status</th>
                <th>Account Control</th>
                <th>Action</th>
                <th>Update Email</th>
              </tr>
            </thead>
            <tbody class=" table-group-divider" id="soldierTableBody">
            </tbody>
          </table>
        </div>
    </div>
  </main>

  <!-- Footer -->
  <?php
  $page_js = "manage_soldier.js";
  include('../includes/admin_footer.php');
