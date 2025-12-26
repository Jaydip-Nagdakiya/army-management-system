
<?php include('../includes/db_connect.php')?>

<!-- Search Functionality -->

<?php 
  $search="";
  if(isset($_POST['search']) && !$_POST['search']==""){
    $search= trim($_POST['search']);
    $qry= "SELECT *FROM soldiers where id like '%$search%' or name like '%$search%' or email like '%$search%' or rank like '%$search%' or status like '%$search%' order by id desc";
  }else{
    $qry="SELECT *FROM soldiers order by id desc";
  }
  $result= $con->query($qry);
?>
<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td class="id"><?= $row['id'] ?></td>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td><?= htmlspecialchars($row['dob']) ?></td>
                  <td><?= htmlspecialchars($row['address']) ?></td>
                  <td><?= htmlspecialchars($row['blood_group']) ?></td>
                  <td><?= htmlspecialchars($row['rank']) ?></td>
                  <td><?= htmlspecialchars($row['mobile']) ?></td>
                  <td><?= htmlspecialchars($row['status']) ?></td>
                  <td><?php  if($row['status']==="Active"): ?>
                      <button class="btn btn-warning toggleStatusBtn bi bi-lock" data-id="<?=htmlspecialchars($row['id'])  ?>" data-status="Deactive"></button>
                      <?php else: ?>
                        <button class="btn btn-success toggleStatusBtn bi bi-unlock" data-id="<?= htmlspecialchars($row['id'])  ?>" data-status="Active"></button>
                        <?php endif;?>
                  </td>
                  <td>
                    <form action="edit_soldier.php" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']) ?>">
                    <button class="btn btn-primary bi bi-pencil-square" type="submit" <?php if($row['status']==="Deactive"): ?>disabled<?php endif; ?>></button>
                    </form>
                    <button class="btn btn-danger deleteBtn bi bi-trash" data-id="<?php echo htmlspecialchars($row['id']) ?>"></button>
                  </td>
                  <td>
                    <form action="update_email.php" method="post">
                      <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                      <button type="submit" class="btn btn-success bi bi-envelope" <?php  if($row['status']==="Deactive"): ?>disabled<?php endif; ?>></button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan='12' class='text-center'>No soldiers found.</td></tr>
                <?php endif; ?>