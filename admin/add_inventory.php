<?php
$current_page = "add_inventory";
$page_title="Add Inventory - Army Management System";
include('../includes/admin_header.php');
?>

<?php
include('../includes/admin_sidebar.php');
?>



<div class="main-wrapper">
    <main class="main-content">
        <div class="container-fluid mt-5">
            <h2 class=" mb-4 text-center aqua animate-fadein">Add Inventory</h2>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box animate-slidein">
                        <form method="POST" enctype="multipart/form-data" novalidate id="inventoryform">

                            <div class="mb-3">
                                <label class=" form-label fw-bold" for="item_name">Item Name</label>
                                <input class="form-control input-field" type="text" name="item_name" id="item_name" placeholder="Enter Item Name" required maxlength="50">
                                <span id="itemError" class=" text-danger"></span>
                                <!-- <div class="invalid-feedback">Please Enter Item Name</div> -->
                            </div>

                            <div class="mb-3">
                                <label class="form-lable fw-bold mb-2" for="category">Category</label>
                                <select name="category" class="form-control input-field" id="category" required>
                                    <option value="">-- Select --</option>
                                    <option value="Weapon">Weapon</option>
                                    <option value="Vehicle">Vehicle</option>
                                    <option value="Medical">Medical</option>
                                    <option value="Uniform">Uniform</option>
                                </select>
                                <span id="categoryError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class=" form-label fw-bold" for="quantity">Quantity</label>
                                <input type="text" name="quantity" required class=" form-control input-field" id="quantity" placeholder="Enter Quantity" maxlength="10">
                                <span id="quantityError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-lable  fw-bold mb-2">Select Location</label>
                                <select name="location" id="location" required class=" form-control input-field">
                                    <option value="">-- Select Location --</option>
                                    <option value="COD Delhi">COD Delhi (Central Ordnance Depot, Delhi)</option>
                                    <option value="COD Agra">COD Agra</option>
                                    <option value="COD Jabalpur">COD Jabalpur</option>
                                    <option value="Ahmedabad Cantonment">Ahmedabad Cantonment</option>
                                    <option value="Jodhpur Air Base">Jodhpur Air Base</option>
                                    <option value="Supply Depot Pune">Supply Depot Pune</option>
                                    <option value="Field Hospital - Tent 3">Field Hospital - Tent 3</option>
                                    <option value="7 Raj Rif - Store Room B">7 Raj Rif - Store Room B</option>
                                    <option value="Forward Camp A">Forward Camp A</option>
                                    <option value="Border Post 5">Border Post 5</option>
                                </select>
                                <span id="locationError" class=" text-danger"></span>
                            </div>

                            <div class="mb-3">
                                <label class=" form-label fw-bold" for="photo">Upload Photo</label>
                                <input type="file" name="photo" id="photo" class=" form-control input-field" required>
                                <span id="photoError" class=" text-danger"></span>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-army w-100" id="additemBtn" file="add">Add Item</button>
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