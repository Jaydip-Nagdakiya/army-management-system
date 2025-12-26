<!-- Footer -->
<footer class="footer-section text-white pt-4 pb-3 mt-auto">
  <div class="container">
    <div class="row text-md-start text-center">

      <!-- About Project -->
      <div class="col-md-3 col-xl-3 mb-4 ">
        <h5 class="footer-heading">About Project</h5>
        <p class="footer-text">Army Management System helps in managing soldier profiles, leaves, and communication with admin.</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-3  col-xl-3 mb-4">
        <h5 class="footer-heading">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="homepage.php" class="footer-link">Home</a></li>
          <li><a href="profile.php" class="footer-link">Profile</a></li>
          <li><a href="apply_leave.php" class="footer-link">Apply Leave</a></li>
          <li><a href="notice.php" class="footer-link">Notices</a></li>
        </ul>
      </div>

      <!-- Developer Info -->
      <div class="col-md-3 col-xl-3 mb-4">
        <h5 class="footer-heading">Developed By</h5>
        <p class="footer-text mb-1">Jaydip Nagdakiya</p>
        <!-- <p class="footer-text">jaydip@example.com</p> -->
      </div>

      <!-- Social Media -->
      <div class="col-md-3 col-xl-3  mb-4 text-md-start text-center">
        <h5 class="footer-heading">Follow Us</h5>
        <div class="social-icons mt-2">
          <a href="https://facebook.com" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
          <a href="https://linkedin.com" target="_blank" class="social-icon"><i class="bi bi-linkedin"></i></a>
          <!-- <a href="https://github.com" target="_blank" class="social-icon"><i class="bi bi-github"></i></a> -->
        </div>
      </div>

    </div>
    <hr style="border-color: rgba(255,255,255,0.1);">
    <p class="text-center mb-0">&copy; 2025 Army Management System. All rights reserved.</p>
  </div>
</footer>

<script src="JS/sweetalert2.all.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

<?php if (isset($page_js) && is_array($page_js)): ?>
  <?php foreach ($page_js as $js) : ?>
    <script src="js/soldier_js/<?php echo $js; ?>"></script>
  <?php endforeach; ?>
<?php elseif (isset($page_js)) : ?>
  <script src="js/soldier_js/<?php echo $page_js; ?>"></script>
<?php endif; ?>

</body>

</html>