<?php 
  $page_title="Notices - Army Management System";
  $current_page="notices";
  include('INCLUDES/soldier_header.php');
?>



  <!-- Main Content -->
  <div class="container notice-con text-white">
    <h2 class="mb-4 text-center  aqua animate-fadein"> Latest Notices</h2>

    <div id="notices">

    </div>
    <script>
      function loadNotices() {
        fetch('fetch_notices.php')
          .then(response => response.text()).then(data => {
            document.getElementById('notices').innerHTML = data;
          });
      }
      loadNotices();
      setInterval(loadNotices, 10000);

    </script>
  </div>

<?php 
  include('INCLUDES/soldier_footer.php');
?>