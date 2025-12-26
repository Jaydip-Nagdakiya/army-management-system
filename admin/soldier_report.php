<?php
$page_title = "Soldier Report - Army Management System";
include('../includes/admin_header.php');
?>



<!-- Sidebar -->
<?php
$current_page = "soldier_report";
include('../includes/admin_sidebar.php');
?>


<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid mt-5">
      <div class="card shadow-lg p-3 animate-slidein">
        <div class=" d-flex justify-content-center align-items-center mb-3">
        <h3 class="mb-0">Soldier Report</h3>
        <div class="pdf-button  ms-auto">
        <button class="btn btn-outline-success" id="downloadPDF"><i class=" bi bi-download me-1"></i> Download PDF</button>
        </div>
        </div>
        <div class="search-box-container position-relative mb-3"> <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchBox"  class=" form-control ps-5" placeholder="Search By ID or Name">
      </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Mobile No</th>
                <th>Rank</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="soldierTableBody">
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <script src="../js/jspdf/jspdf.umd.min.js"></script>
  <script src="../js/jspdf/spdf.plugin.autotable.min.js"></script>

  <!-- Footer -->
  <?php
  $page_js="soldier_report.js";
  include('../includes/admin_footer.php');
  ?>