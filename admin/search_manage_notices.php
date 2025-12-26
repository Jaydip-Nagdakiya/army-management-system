
<?php include('../includes/db_connect.php')?>

<!-- Search Functionality -->

<?php 
  $search="";
  if(isset($_POST['search']) && !$_POST['search']==""){
    $search= trim($_POST['search']);
    $qry= "SELECT *FROM notices where title like '%$search%' or rank like '%$search%'  order by id desc";
  }else{
    $qry="SELECT *FROM notices order by id desc";
  }
  $result= $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
               <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['message']) ?></td>
                                    <td><?= htmlspecialchars($row['rank']) ?></td>
                                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                                    <td>
                                        <form action="edit_notice.php" method="post">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                        </form>
                                        <button class="btn btn-danger deleteBtn bi bi-trash" data-id="<?= htmlspecialchars($row['id']) ?>"></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
              <?php  }else{ ?>
                <tr><td colspan='6' class='text-center'>No notices found.</td></tr>
              <?php } ?>