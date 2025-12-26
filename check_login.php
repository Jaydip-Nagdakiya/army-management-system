<?php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['soldier_id'])) {
  echo "
<script src='js/sweetalert2.all.min.js'></script>
<script src='js/jquery.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
Swal.fire({
  title: 'Access Denied',
  text: 'Please login first!',
  icon: 'warning',
  confirmButtonText: 'Login Now'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = 'index.php';
  }
});
});
</script>
";
 
  exit;
}
?>