<?php
$page_title = "Send Notices - Army Management System";
include('../includes/admin_header.php');
?>

<!-- Sidebar -->
<?php
$current_page = "send_notice";
include('../includes/admin_sidebar.php');
?>
<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid mt-5">
      <div class="card-box animate-slidein">
        <h4>Send Notices</h4>
        <form id="noticeForm" method="POST" novalidate>

          <!-- Notice Title -->
          <div class="mb-3">
            <label for="noticeTitle" class="form-label">Notice Title</label>
            <input type="text" class="form-control input-field" id="noticeTitle" name="title"
              placeholder="Enter Notice Titles" required maxlength="50">
            <small id="titleError" style="color:red;"></small>
          </div>
          <!-- rank select -->
          <div class="mb-3">
            <label for="rank" class="form-label">Rank</label>
            <select id="rank" name="rank" class="form-control input-field" required>
              <option value="">-- Select Rank --</option>
              <option value="All">All Ranks</option>
              <option value="Sepoy">Sepoy</option>
              <option value="Lance Naik">Lance Naik</option>
              <option value="Naik">Naik</option>
              <option value="Havildar">Havildar</option>
              <option value="Naib Subedar">Naib Subedar</option>
              <option value="Subedar">Subedar</option>
              <option value="Subedar Major">Subedar Major</option>
              <option value="Lieutenant">Lieutenant</option>
              <option value="Captain">Captain</option>
              <option value="Major">Major</option>
              <option value="Lieutenant Colonel">Lieutenant Colonel</option>
              <option value="Colonel">Colonel</option>
              <option value="Brigadier">Brigadier</option>
              <option value="Major General">Major General</option>
              <option value="Lieutenant General">Lieutenant General</option>
              <option value="General">General</option>
            </select>
            <small id="rankError" class="form-error"></small>
          </div>
          <!-- Notice Content -->
          <div class="mb-3">
            <label for="noticeContent" class="form-label">Notice Content</label>
            <textarea class="form-control input-field" id="noticeContent" name="content" rows="5"
              placeholder="Enter Notice Details" required maxlength="1000"></textarea>
            <small id="contentError" style="color:red;"></small>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-army" id="noticeBtn"><i class="bi bi-send"></i> Send Notice</button>
        </form>
      </div>
    </div>




  </main>

  <!-- Footer -->
  <?php
  $page_js = "send_notice.js";
  include('../includes/admin_footer.php');
  ?>