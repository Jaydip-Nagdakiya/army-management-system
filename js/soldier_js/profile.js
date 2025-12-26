// Auto submit when file is selected
document.getElementById("fileInput").addEventListener("change", function () {
  if (this.files.length > 0) {
    const formData = new FormData(document.getElementById("photoForm"));
    fetch("update_photo.php", {
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
            window.location.reload();
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


