document.addEventListener("DOMContentLoaded", function () {
  const searchBox = document.getElementById("searchBox");
  const tableBody = document.getElementById("soldierTableBody");


  function loadSoldiers(search = "") {
    fetch("search_soldier.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "search=" + encodeURIComponent(search),
    })
      .then((response) => response.text())
      .then((data) => {
        tableBody.innerHTML = data;
      })
      .catch((error) => console.error("Error:", error));
  }

  loadSoldiers();

  searchBox.addEventListener("keyup", function () {
    const search = this.value;
    loadSoldiers(search);
  });
});


  const downloadBtn = document.getElementById("downloadPDF");


  downloadBtn.addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Soldier Report", 14, 15);

    const table = document.querySelector(".table");
    const headers = Array.from(table.querySelectorAll("thead th"))
      .map((th) => th.innerText)
      .filter((header) => header.trim() !== "Action"); 

    const rows = [];
    table.querySelectorAll("tbody tr").forEach((tr) => {
      const cells = Array.from(tr.querySelectorAll("td"))
        .slice(0, -1) 
        .map((td) => td.innerText);
      rows.push(cells);
    });

 
    doc.autoTable({
      head: [headers],
      body: rows,
      startY: 25,
      styles: { fontSize: 10, halign: "center" },
      headStyles: { fillColor: [0, 255, 204] },
    });

 
    const totalRows = document.querySelectorAll("#soldierTableBody tr").length;
    doc.text(`Total Soldiers: ${totalRows}`, 14, doc.lastAutoTable.finalY + 10);


    doc.save("Soldier_Report.pdf");
  });
