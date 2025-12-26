
<?php include('../includes/db_connect.php')?>

<!-- Search Functionality -->

<?php 
  $search="";
  if(isset($_POST['search']) && !$_POST['search']==""){
    $search= trim($_POST['search']);
    $qry= "SELECT *FROM inventory where item_name like '%$search%' or location like '%$search%' or category like '%$search%' order by id desc";
  }else{
    $qry="SELECT *FROM inventory order by id desc";
  }
  $result= $con->query($qry);
?>

<?php if ($result && $result->num_rows > 0) { ?>
               <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="td-fixed">
                                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td><?= htmlspecialchars($row['location']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                                    <td><img src="<?= htmlspecialchars($row['photo']) ?>" alt="inventory_img" width="90px" ></td>
                                    <td>
                                        <form action="edit_inventory.php" method="post">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                        </form>
                                        <button class="btn btn-danger deleteBtn bi bi-trash" data-id="<?= htmlspecialchars($row['id']) ?>"></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
              <?php  }else{ ?>
                <tr><td colspan='6' class='text-center'>No inventory items found.</td></tr>
              <?php } ?>