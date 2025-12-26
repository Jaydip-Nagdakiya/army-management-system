const soldiername = document.getElementById("soldier_id");
const soldierError = document.getElementById("soldierError");
const mission_name = document.getElementById("mission_id");
const missionError = document.getElementById("missionError");
const role = document.getElementById("role");
const roleError = document.getElementById("roleError");
const assigBtn = document.getElementById("assignmissionBtn");
const updateBtn = document.getElementById("updateBtn");

if (assigBtn) {
  assigBtn.addEventListener("click", function (e) {
    e.preventDefault();
    let valid = true;

    if (soldiername.value == "") {
      soldiername.classList.add("is-invalid");
      soldierError.textContent = "Please select soldier";
      valid = false;
    } else {
      soldiername.classList.remove("is-invalid");
      soldierError.textContent = "";
    }
    if (mission_name.value == "") {
      mission_name.classList.add("is-invalid");
      missionError.textContent = "Please select mission";
      valid = false;
    } else {
      mission_name.classList.remove("is-invalid");
      missionError.textContent = "";
    }
    if (role.value == "") {
      role.classList.add("is-invalid");
      roleError.textContent = "Please select role";
      valid = false;
    } else {
      role.classList.remove("is-invalid");
      roleError.textContent = "";
    }

    if (valid) {
      let loder = document.getElementById("loading");
      loder.classList.add("d-flex");
      loder.classList.remove("d-none");
      let posting_id =
        soldiername.options[soldiername.selectedIndex].dataset.posting;
      const formdata = new FormData(document.getElementById("missionform"));
      formdata.append("posting_id", posting_id);

      fetch("assign_mission_process.php", {
        method: "post",
        body: formdata,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status == "success") {
            loder.classList.remove("d-flex");
            loder.classList.add("d-none");
            Swal.fire("Success", data.message, "success").then(() => {
              document.getElementById("missionform").reset();
              document.location.reload();
            });
          } else {
            loder.classList.remove("d-flex");
            loder.classList.add("d-none");
            Swal.fire("Error", data.message, "error");
          }
        })
        .catch((err) => {
          console.error(err);
        });
    }
  });
}

if (updateBtn) {
  updateBtn.addEventListener("click", function (e) {
    e.preventDefault();
    let loder = document.getElementById("loading");
    loder.classList.add("d-flex");
    loder.classList.remove("d-none");
    const formdata = new FormData(document.getElementById("updatemissionform"));

    fetch("edit_assign_mission_process.php", {
      method: "post",
      body: formdata,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status == "success") {
          loder.classList.remove("d-flex");
          loder.classList.add("d-none");
          Swal.fire("Success", data.message, "success").then(() => {
            window.location.href = "manage_assign_mission.php";
          });
        } else {
          loder.classList.remove("d-flex");
          loder.classList.add("d-none");
          Swal.fire("Error", data.message, "error");
        }
      })
      .catch((err) => {
        console.error(err);
      });
  });
}
