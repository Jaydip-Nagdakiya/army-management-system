const addbtn = document.getElementById("addbtn");
const soldier_name = document.getElementById("soldier_id");
const soldierError = document.getElementById("soldierError");
const medal_type = document.getElementById("medal_type");
const typeError = document.getElementById("typeError");
const medal_name = document.getElementById("medal_name");
const medalnameError = document.getElementById("medalnamerError");
const desc = document.getElementById("description");
const descError = document.getElementById("descError");
const award_date = document.getElementById("award_date");
const dateError = document.getElementById("dateError");
const updatebtn = document.getElementById("updatebtn");

if (addbtn) {
  addbtn.addEventListener("click", function (e) {
    e.preventDefault();
    validation("add");
  });
}
if (updatebtn) {
  updatebtn.addEventListener("click", function (e) {
    e.preventDefault();
    validation("update");
  });
}

function validation(action) {
  const regex = /^\d{4}-\d{2}-\d{2}$/;

  let valid = true;
  if (soldier_name.value === "") {
    soldierError.textContent = "Please select soldier";
    soldier_name.classList.add("is-invalid");
    valid = false;
  } else {
    soldierError.textContent = "";
    soldier_name.classList.remove("is-invalid");
  }
  if (medal_type.value.trim() === "") {
    medal_type.classList.add("is-invalid");
    typeError.textContent = "Please select medal type";
    valid = false;
  } else {
    medal_type.classList.remove("is-invalid");
    typeError.textContent = "";
  }
  if (medal_name.value.trim() === "") {
    medal_name.classList.add("is-invalid");
    medalnameError.textContent = "Please enter medal name";
    valid = false;
  } else {
    medal_name.classList.remove("is-invalid");
    medalnameError.textContent = "";
  }
  if (desc.value.trim() === "") {
    desc.classList.add("is-invalid");
    descError.textContent = "Please enter description";
    valid = false;
  } else {
    desc.classList.remove("is-invalid");
    descError.textContent = "";
  }
  if (award_date.value == "") {
    award_date.classList.add("is-invalid");
    dateError.textContent = "Please select date";
    valid = false;
  } else if (award_date.value && !regex.test(award_date.value)) {
    award_date.classList.add("is-invalid");
    dateError.textContent = "Year must have 4 digits (e.g., 11-10-2025)";
    valid = false;
  } else {
    award_date.classList.remove("is-invalid");
    dateError.textContent = "";
  }

  if (valid) {
    const formdata = new FormData(document.getElementById("medalform"));
    let url =
      action === "add"
        ? "add_soldier_medal_process.php"
        : "update_soldier_medal_process.php";

    fetch(url, {
      method: "post",
      body: formdata,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire("Success", data.message, "success").then(() => {
            if (action == "add") {
              document.getElementById("medalform").reset();
            } else {
              window.location.href = "manage_medals.php";
            }
          });
        } else {
          Swal.fire("Error", data.message, "error");
        }
      })
      .catch((err) => console.error(err));
  }
}

function inputevent(event, errormsg) {
  if (event) {
    event.addEventListener("input", function () {
      this.classList.remove("is-invalid");
      errormsg.textContent = "";
    });
  }
}
inputevent(soldier_name, soldierError);
inputevent(medal_type, typeError);
inputevent(medal_name, medalnameError);
inputevent(desc, descError);
inputevent(award_date, dateError);
