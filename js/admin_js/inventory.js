const itemBtn = document.getElementById("additemBtn");
const item_name = document.getElementById("item_name");
const category = document.getElementById("category");
const quantity = document.getElementById("quantity");
const locationInput = document.getElementById("location");
const photo = document.getElementById("photo");
const itemError = document.getElementById("itemError");
const categoryError = document.getElementById("categoryError");
const quantityError = document.getElementById("quantityError");
const locationError = document.getElementById("locationError");
const photoError = document.getElementById("photoError");
const filename = itemBtn.getAttribute("file");

itemBtn.addEventListener("click", function (e) {
  e.preventDefault();
  let valid = true;

  if (item_name.value.trim() === "") {
    itemError.textContent = "Please Enter Item Name";
    item_name.classList.add("is-invalid");
    valid = false;
  } else {
    itemError.textContent = "";
    item_name.classList.remove("is-invalid");
  }

  if (category.value === "") {
    categoryError.textContent = "Please Select Category";
    category.classList.add("is-invalid");
    valid = false;
  } else {
    categoryError.textContent = "";
    category.classList.remove("is-invalid");
  }
  if (quantity.value.trim() === "") {
    quantityError.textContent = "Please Enter Quantity";
    quantity.classList.add("is-invalid");
    valid = false;
  } else {
    quantityError.textContent = "";
    quantity.classList.remove("is-invalid");
  }
  if (locationInput.value.trim() === "") {
    locationError.textContent = "Please Enter Location";
    locationInput.classList.add("is-invalid");
    valid = false;
  } else {
    locationError.textContent = "";
    locationInput.classList.remove("is-invalid");
  }
  if (filename == "add") {
    if (photo.value === "") {
      photoError.textContent = "Please Upload Photo";
      photo.classList.add("is-invalid");
      valid = false;
    } else {
      photoError.textContent = "";
      photo.classList.remove("is-invalid");
    }
  }

  if (valid) {
    const formdata = new FormData(document.getElementById("inventoryform"));
    if (filename == "add") {
      fetch("add_inventory_process.php", {
        method: "POST",
        body: formdata,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            Swal.fire({
              title: "Success",
              text: data.message,
              icon: "success",
            }).then(() => {
              document.getElementById("inventoryform").reset();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.message,
              icon: "error",
            });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    } else {
      fetch("edit_inventory_process.php", {
        method: "POST",
        body: formdata,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            Swal.fire({
              title: "Success",
              text: data.message,
              icon: "success",
            }).then(()=>{
              window.location.href="manage_inventory.php";
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.message,
              icon: "error",
            });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    }
  }
});

item_name.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  itemError.textContent = "";
});

category.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  categoryError.textContent = "";
});
locationInput.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  locationError.textContent = "";
});
quantity.addEventListener("input", function () {
  this.value = this.value.replace(/\D/g, "");
  this.classList.remove("is-invalid");
  quantityError.textContent = "";
});
photo.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  photoError.textContent = "";
});
