<?php
$page_title = "Edit Inventory - Army Management System";
include('../includes/admin_header.php');
?>
<?php
include('../includes/admin_sidebar.php');
?>

<?php
$id = intval($_POST['id'] ?? 0);
$stmt = $con->prepare("SELECT * from inventory where id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$inventory = $result->fetch_assoc();
?>

<div class="main-wrapper">
    <main class="main-content">
        <div class=" container-fluid mt-5">
            <h2 class=" text-center aqua animate-fadein">Update Inventory</h2>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box animate-slidein">
                        <form method="POST" enctype="multipart/form-data" novalidate id="inventoryform">
                            <!-- hidden id -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($inventory['id']) ?>" />


                            <div class="mb-3">
                                <label class=" form-label fw-bold" for="item_name">Item Name</label>
                                <input class="form-control input-field" type="text" name="item_name" id="item_name" placeholder="Enter Item Name" required maxlength="50" value="<?= htmlspecialchars($inventory['item_name']) ?>">
                                <span id="itemError" class=" text-danger"></span>
                                <!-- <div class="invalid-feedback">Please Enter Item Name</div> -->
                            </div>

                            <div class="mb-3">
                                <label class="form-lable fw-bold mb-2" for="category">Category</label>
                                <select name="category" class="form-control input-field" id="category" required>
                                    <option value="">-- Select --</option>
                                    <option value="Weapon" <?php if ($inventory['category'] == "Weapon") echo 'selected'; ?>>Weapon</option>
                                    <option value="Vehicle" <?php if ($inventory['category'] == "Vehicle") echo 'selected'; ?>>Vehicle</option>
                                    <option value="Medical" <?php if ($inventory['category'] == "Medical") echo 'selected'; ?>>Medical</option>
                                    <option value="Uniform" <?php if ($inventory['category'] == "Uniform") echo 'selected'; ?>>Uniform</option>
                                </select>
                                <span id="categoryError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class=" form-label fw-bold" for="quantity">Quantity</label>
                                <input type="number" name="quantity" required class=" form-control input-field" id="quantity" placeholder="Enter Quantity" min="1" max="100" value="<?= htmlspecialchars($inventory['quantity']) ?>">
                                <span id="quantityError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-lable  fw-bold mb-2">Select Location</label>
                                <select name="location" id="location" required class=" form-control input-field">
                                    <option value="">-- Select Location --</option>
                                    <option value="COD Delhi" <?php if ($inventory['location'] == "COD Delhi") echo 'selected'; ?>>COD Delhi (Central Ordnance Depot, Delhi)</option>
                                    <option value="COD Agra" <?php if ($inventory['location'] == "COD Agra") echo 'selected'; ?>>COD Agra</option>
                                    <option value="COD Jabalpur" <?php if ($inventory['location'] == "COD Jabalpur") echo 'selected'; ?>>COD Jabalpur</option>
                                    <option value="Ahmedabad Cantonment" <?php if ($inventory['location'] == "Ahmedabad Cantonment") echo 'selected'; ?>>Ahmedabad Cantonment</option>
                                    <option value="Jodhpur Air Base" <?php if ($inventory['location'] == "Jodhpur Air Base") echo 'selected'; ?>>Jodhpur Air Base</option>
                                    <option value="Supply Depot Pune" <?php if ($inventory['location'] == "Supply Depot Pune") echo 'selected'; ?>>Supply Depot Pune</option>
                                    <option value="Field Hospital - Tent 3" <?php if ($inventory['location'] == "Field Hospital - Tent 3") echo 'selected'; ?>>Field Hospital - Tent 3</option>
                                    <option value="7 Raj Rif - Store Room B" <?php if ($inventory['location'] == "7 Raj Rif - Store Room B") echo 'selected'; ?>>7 Raj Rif - Store Room B</option>
                                    <option value="Forward Camp A" <?php if ($inventory['location'] == "Forward Camp A") echo 'selected'; ?>>Forward Camp A</option>
                                    <option value="Border Post 5" <?php if ($inventory['location'] == "Border Post 5") echo 'selected'; ?>>Border Post 5</option>
                                </select>
                                <span id="locationError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="photo">Upload Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control input-field">
                                <span id="photoError" class="text-danger"></span>
                                <?php if (!empty($inventory['photo'])): ?>
                                    <div class="mt-2">
                                        <img src="<?= htmlspecialchars($inventory['photo']) ?>" alt="Current Photo" style="max-width:150px; height:auto; border:1px solid #ccc; padding:2px;">
                                        <p class="small text-white">Current photo</p>
                                    </div>
                                <?php endif;
                                ?>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-army w-100" id="additemBtn" file="edit">Update Item</button>
                                <a href="manage_inventory.php" class="btn btn-army w-100 mt-2" >Back</a>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    $page_js = "inventory.js";
    include('../includes/admin_footer.php');
    ?>