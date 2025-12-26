<!-- Footer -->
<footer class="footer-section text-white pt-4 pb-3 ">
    <div class="container">
        <p class="text-center mb-0">&copy; 2025 Army Management System. All rights reserved.</p>
    </div>
</footer>
</div>

<script src="../JS/sweetalert2.all.min.js"></script>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<?php if (isset($page_js) && is_array($page_js)): ?>
    <?php foreach ($page_js as $js) : ?>
        <script src="../js/admin_js/<?php echo $js; ?>"></script>
    <?php endforeach; ?>
<?php elseif (isset($page_js)) : ?>
    <script src="../js/admin_js/<?php echo $page_js; ?>"></script>
<?php endif; ?>

</body>

</html>