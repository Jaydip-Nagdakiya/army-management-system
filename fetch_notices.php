<?php 
include('check_login.php');

$id= $_SESSION['soldier_id'];
$stmt= $con->prepare("SELECT rank from soldiers where id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result=  $stmt->get_result();
$soldier= $result->fetch_assoc();
$rank= $soldier['rank'];
// Notices fetch
$stmt= $con->prepare("SELECT created_at , title, message from notices  where rank=? or rank='All' order by id desc limit 5");
$stmt->bind_param("s",$rank);
$stmt->execute();
$result=$stmt->get_result();
?>

<?php if(mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="notice-box text-center animate-slideup">
          <strong class=" d-block"><?= date('d/m/Y', strtotime($row['created_at'])) ?></strong> 
          <b><spna>Title:</spna> <?= htmlspecialchars($row['title']) ?></b> 
          <hr> <p class=" ms-3 text-start"><?= htmlspecialchars($row['message']) ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-warning">No notices available.</div>
    <?php endif; ?>


  