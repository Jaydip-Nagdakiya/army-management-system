const updateBtn = document.getElementById("updateBtn");
const today = new Date().toISOString().split("T")[0];

updateBtn.addEventListener("click", function (e) {
  e.preventDefault();
  let valid = true;

  const leaveType = document.getElementById("leaveType").value;
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;
  const reason = document.getElementById("reason").value.trim();

  if (!leaveType || !startDate || !endDate || !reason) {
    Swal.fire({
      title: "Error",
      text: "Please fill out all Fields",
      icon: "error",
      confirmButtonText: "OK",
    });
    return;
  }
  if (startDate < today) {
    Swal.fire({
      title: "Error",
      text: "Start Date cannot be in the past.",
      icon: "error",
      confirmButtonText: "OK",
    });
    valid = false;
  }
  if (startDate > endDate) {
    Swal.fire({
      title: "Error",
      text: "Start date cannot be after end date.",
      icon: "error",
      confirmButtonText: "OK",
    });
    valid = false;
  }

  if (valid) {
    const formData = new FormData(document.getElementById("leaveForm"));

    fetch("edit_leave_process.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          Swal.fire({
            title: "Success",
            text: data.message,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            window.location.href = "leave_status.php";
          });
        } else {
          Swal.fire({
            title: "Error",
            text: data.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      })
      .catch((err) => {
        console.error(err);
      });
  }
});


document.addEventListener('keydown',function(event){
  if(event.key=="Enter"){
    event.preventDefault();
    updateBtn.click();
  }
  if (event.key == "Backspace") {
    if (
      event.target.tagName !== "INPUT" &&
      event.target.tagName !== "TEXTAREA"
    ) {
      window.location.href = "leave_status.php";
    }
  }
});