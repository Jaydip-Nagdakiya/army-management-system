<?php
$page_title = "Manage Notices - Army Management System";
include('../includes/admin_header.php');
?>
<?php
// Fetch all notices
$sql = "SELECT * FROM notices ORDER BY id DESC";
$result = mysqli_query($con, $sql);
?>

<!-- Sidebar -->
<?php
$current_page = "manage_notice";
include('../includes/admin_sidebar.php');
?>

<div class="main-wrapper d-flex flex-column flex-grow-1">
  <main class="main-content">
    <div class="container-fluid mt-5 ">
     
      <h2 class="aqua animate-fadein">Manage Notices</h2>
       <div class="search-box-container">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchBox" class=" form-control mb-2" placeholder="Search By Rank or Title" style="max-width: 500px;">
      </div>
        <div class="table-responsive animate-slidein">
          <table class="table table-dark table-hover text-center  align-middle table-bordered">
            <thead>
              <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Rank</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class=" table-group-divider" id="tableBody">
      
            </tbody>
          </table>
          <form id="editForm" action="edit_notice.php" method="post" style="display: none;">
            <input type="hidden" name="id" id="hiddenid">
          </form>
        </div>
    </div>
  </main>

  <!-- Footer -->
  <?php
  $page_js = "manage_notices.js";
  include('../includes/admin_footer.php');
  ?>