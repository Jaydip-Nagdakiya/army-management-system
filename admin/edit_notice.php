<!-- Header -->
<?php
$page_title = "Edit Notice - Army Management System";
include('../includes/admin_header.php');
?>

<?php
$id = intval($_POST['id'] ?? 0);
$stmt = $con->prepare("SELECT * from notices where id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$notice = $result->fetch_assoc();
?>

<!-- Sidebar -->
<?php 
  include('../includes/admin_sidebar.php');
?>

<div class="main-wrapper flex-grow-1 d-flex flex-column">
  <main class="main-content">
    <div class="container-fluid mt-5">
      <div class="card-box animate-slidein">
        <h4>Edit Notice</h4>
        <form id="editNoticeForm" method="POST" novalidate>
          <div class="mb-3">
            <label for="noticeTitle" class="form-label">Notice Title</label>
            <input type="text" class="form-control input-field" id="noticeTitle" name="title"
              value="<?= htmlspecialchars($notice['title']) ?>" required maxlength="50" placeholder="Enter notice title">
            <small id="titleError" style="color:red;"></small>
          </div>
          <!-- rank select -->
          <div class="mb-3">
            <label for="rank" class="form-label">Rank</label>
            <select id="rank" name="rank" class="form-control input-field" required>
              <option value="">-- Select Rank --</option>
              <option value="All" <?php if ($notice['rank']=='All') echo 'selected'; ?>>All Ranks</option>
              <option value="Sepoy" <?php if ($notice['rank']=='Sepoy') echo 'selected'; ?>>Sepoy</option>
              <option value="Lance Naik" <?php if ($notice['rank']=='Lance Naik') echo 'selected'; ?>>Lance Naik</option>
              <option value="Naik" <?php if ($notice['rank']=='Naik') echo 'selected'; ?>>Naik</option>
              <option value="Havildar" <?php if ($notice['rank']=='Havildar') echo 'selected'; ?>>Havildar</option>
              <option value="Naib Subedar" <?php if ($notice['rank']=='Naib Subedar') echo 'selected'; ?>>Naib Subedar</option>
              <option value="Subedar" <?php if ($notice['rank']=='Subedar') echo 'selected'; ?>>Subedar</option>
              <option value="Subedar Major" <?php if ($notice['rank']=='Subedar Major') echo 'selected'; ?>>Subedar Major</option>
              <option value="Lieutenant" <?php if ($notice['rank']=='Lieutenant') echo 'selected'; ?>>Lieutenant</option>
              <option value="Captain" <?php if ($notice['rank']=='Captain') echo 'selected'; ?>>Captain</option>
              <option value="Major" <?php if ($notice['rank']=='Major') echo 'selected'; ?>>Major</option>
              <option value="Lieutenant Colonel" <?php if ($notice['rank']=='Lieutenant Colonel') echo 'selected'; ?>>Lieutenant Colonel</option>
              <option value="Colonel" <?php if ($notice['rank']=='Colonel') echo 'selected'; ?>>Colonel</option>
              <option value="Brigadier" <?php if ($notice['rank']=='Brigadier') echo 'selected'; ?>>Brigadier</option>
              <option value="Major General" <?php if ($notice['rank']=='Major General') echo 'selected'; ?>>Major General</option>
              <option value="Lieutenant General" <?php if ($notice['rank']=='Lieutenant General') echo 'selected'; ?>>Lieutenant General</option>
              <option value="General" <?php if ($notice['rank']=='General') echo 'selected'; ?>>General</option>
            </select>
            <small id="rankError" class="form-error"></small>
          </div>
          <div class="mb-3">
            <label for="noticeContent" class="form-label">Notice Content</label>
            <textarea class="form-control input-field" id="noticeContent" name="content" rows="5" required maxlength="1000" placeholder="Enter notice content"><?= htmlspecialchars($notice['message']) ?></textarea>
            <small id="contentError" style="color:red;"></small>
          </div>
          <input type="hidden" name="id" value="<?= htmlspecialchars($notice['id']) ?>" />
          <button type="submit" class="btn btn-army" id="noticeBtn"><i class="bi bi-pencil-square"></i> Update Notice</button>
          <a href="manage_notices.php" class="btn btn-army">Back</a>
        </form>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php
  $page_js = "update_notice.js";
  include('../includes/admin_footer.php');
  ?>