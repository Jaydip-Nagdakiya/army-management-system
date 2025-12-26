<?php
$page_title = "Profile - Army Management System";
$current_page = "profile";
include('INCLUDES/soldier_header.php');
// include('../includes/db_connect.php');
$soldier_id = $_SESSION['soldier_id'];

// Fetch soldier basic info
$query = "SELECT * FROM soldiers WHERE id=?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch missions completed from soldiers_missions table
$mission_query = "SELECT COUNT(*) as missions_completed FROM soldiers_missions join missions on soldiers_missions.mission_id=missions.mission_id WHERE soldiers_missions.soldier_id = ? and missions.status='Completed'";
$mission_stmt = $con->prepare($mission_query);
$mission_stmt->bind_param("i", $soldier_id);
$mission_stmt->execute();
$mission_result = $mission_stmt->get_result();
$mission_row = $mission_result->fetch_assoc();
$missions_completed = $mission_row['missions_completed'];

// Fetch medals count from soldier_medals table
$medal_query = "SELECT COUNT(*) as medals FROM soldier_medals  WHERE soldier_id = ?";
$medal_stmt = $con->prepare($medal_query);
$medal_stmt->bind_param("i", $soldier_id);
$medal_stmt->execute();
$medal_result = $medal_stmt->get_result();
$medal_row = $medal_result->fetch_assoc();
$medals = $medal_row['medals'];

// Performance rating calculation (customize as needed)
$performance_rating = min(10, ($missions_completed * 0.5) + ($medals * 1));

// Progress percent calculation (assume target 20 missions)
$target_missions = 20;
$progress_percent = min(100, ($missions_completed / $target_missions) * 100);

// Promotion eligibility (example logic)
$promotion_eligible = ($performance_rating >= 7 && $missions_completed >= $target_missions) ? "Yes" : "No";

// Remarks (optional)
$remarks = "";
if ($performance_rating >= 9) {
  $remarks = "Excellent performance";
} elseif ($performance_rating >= 7) {
  $remarks = "Good performance";
} elseif ($performance_rating >= 5) {
  $remarks = "Average performance";
} else {
  $remarks = "Needs improvement";
}


?>
<div class="container my-5 main-content profile-con">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card profile-card glass-effect p-4 shadow-lg animate-slideup">
        <div class="row">
          <div class="col-md-4 text-center">
            <img src="<?= $row['profile_photo'] ?>" class="img-fluid profile-img shadow" id="profilePhoto" />
            <form id="photoForm" method="POST" enctype="multipart/form-data">
              <input type="file" name="new_photo" id="fileInput" accept="image/*" style="display:none" required>
              <button type="button" class="btn btn-profile btn-sm mt-3" onclick="document.getElementById('fileInput').click()">
                Update Profile Picture
              </button>
            </form>
          </div>
          <div class="col-md-8">
            <div class="profilePDF">
            <h2 class="mb-4 aqua text-center animate-fadein">Personnel Information Report</h2>

            <table class="table table-hover text-white profile-table">
              <tr>
                <th>Name</th>
                <td><?= htmlspecialchars($row['name']) ?></td>
              </tr>
              <tr>
                <th>Rank</th>
                <td><?= htmlspecialchars($row['rank']) ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($row['email']) ?></td>
              </tr>
              <tr>
                <th>Mobile</th>
                <td><?= htmlspecialchars($row['mobile']) ?></td>
              </tr>
              <tr>
                <th>Date of Joining</th>
                <td><?= htmlspecialchars($row['date_of_joining']) ?></td>
              </tr>
              <tr>
                <th>Missions Completed</th>
                <td><?= $missions_completed ?></td>
              </tr>
              <tr>
                <th>Medals</th>
                <td><?= $medals ?></td>
              </tr>
              <tr>
                <th>Performance Rating</th>
                <td><?= round($performance_rating, 2) ?></td>
              </tr>
              <tr>
                <th>Promotion Eligible</th>
                <td><?= $promotion_eligible ?></td>
              </tr>
              <tr>
                <th>Progress (%)</th>
                <td><?= round($progress_percent, 2) ?>%</td>
              </tr>
              <tr>
                <th>Remarks</th>
                <td><?= $remarks ?></td>
              </tr>
            </table>
            <div class="text-end">
              <button class="btn btn-army mt-2" id="exportPDF">Export to PDF</button>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  const exportBtn = document.getElementById("exportPDF");
                  exportBtn.addEventListener("click", async () => {
                    const {
                      jsPDF
                    } = window.jspdf;
                    const doc = new jsPDF();

                    // Title
                    doc.setFontSize(18);
                    doc.setFont("helvetica", "bold");
                    doc.text("Personnel Information Report", 105, 18, {
                      align: "center"
                    });

                    // Table headers and data
                    const tableData = [
                      ["Name", "<?= htmlspecialchars($row['name']) ?>"],
                      ["Rank", "<?= htmlspecialchars($row['rank']) ?>"],
                      ["Email", "<?= htmlspecialchars($row['email']) ?>"],
                      ["Mobile", "<?= htmlspecialchars($row['mobile']) ?>"],
                      ["Joining Date", "<?= htmlspecialchars($row['date_of_joining']) ?>"],
                      ["Missions Completed", "<?= $missions_completed ?>"],
                      ["Medals", "<?= $medals ?>"],
                      ["Performance Rating", "<?= round($performance_rating, 2) ?>"],
                      ["Promotion Eligible", "<?= $promotion_eligible ?>"],
                      ["Progress (%)", "<?= round($progress_percent, 2) ?>%"],
                      ["Remarks", "<?= $remarks ?>"],
                    ];

                    let startY = 30;
                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal");

                    // Draw table
                    tableData.forEach(([label, value], idx) => {
                      doc.setFont("helvetica", "bold");
                      doc.text(label + ":", 20, startY + idx * 10);
                      doc.setFont("helvetica", "normal");
                      doc.text(String(value), 70, startY + idx * 10);
                    });

                    // Profile photo (right top)
                    const img = document.getElementById("profilePhoto");
                    if (img) {
                      const canvas = document.createElement("canvas");
                      canvas.width = img.naturalWidth;
                      canvas.height = img.naturalHeight;
                      const ctx = canvas.getContext("2d");
                      ctx.drawImage(img, 0, 0);
                      const imgData = canvas.toDataURL("image/jpeg", 1.0);
                      doc.addImage(imgData, "JPEG", 140, 30, 50, 50);
                    }

                    // Border under table
                    doc.setDrawColor(100);
                    doc.line(20, startY + tableData.length * 10 + 2, 190, startY + tableData.length * 10 + 2);

                    doc.save("soldier-profile.pdf");
                  });
                });
              </script>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$page_js = ["jspdf.umd.min.js", "profile.js"];
include('INCLUDES/soldier_footer.php');
?>