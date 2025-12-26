const noticeBtn = document.getElementById("noticeBtn");
const title = document.getElementById("noticeTitle");
const content = document.getElementById("noticeContent");
const rank = document.getElementById('rank');


noticeBtn.addEventListener("click", function (e) {
  e.preventDefault();
  let valid = true;
  let titlevalue = title.value.trim();
  let contentvalye = content.value.trim();

  if (titlevalue === "") {
    document.getElementById("titleError").textContent =
      "Please Enter Notice Title";
    title.classList.add("is-invalid");
    title.value = title.value.replace(/\s+/g, "");
    valid = false;
  } else {
    document.getElementById("titleError").textContent = "";
    title.classList.remove("is-invalid");
  }
  if (contentvalye === "") {
    document.getElementById("contentError").textContent =
      "Please Enter Notice Content";
    content.classList.add("is-invalid");
    content.value = content.value.replace(/\s+/g, "");
    valid = false;
  } else {
    document.getElementById("contentError").textContent = "";
    content.classList.remove("is-invalid");
  }
  if(rank.value===""){
    document.getElementById('rankError').textContent="Please Select Rank";
    rank.classList.add('is-invalid');
    valid = false;
  }else{
    document.getElementById('rankError').textContent="";
    rank.classList.remove('is-invalid');
  }

  if (valid) {
    const formdata = new FormData(document.getElementById("noticeForm"));
    fetch("process_notice.php", {
      method: "post",
      body: formdata,
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
            title.value = "";
            content.value = "";
            rank.value="";
          });
        } else {
          Swal.fire("Success", data.message, "success");
        }
      })
      .catch((err) => {
        Swal.fire("Error!", "Somthing went wrong.", "error");
        console.error(err);
      });
  }
});

title.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("titleError").textContent = "";
});

content.addEventListener("input", function () {
  this.classList.remove("is-invalid");
  document.getElementById("contentError").textContent = "";
});

rank.addEventListener('input',function(){
  this.classList.remove('is-invalid');
  document.getElementById('rankError').textContent="";
});

document.addEventListener("keydown",function(event){
  if(event.key=="Enter"){
    noticeBtn.click();
  }
});