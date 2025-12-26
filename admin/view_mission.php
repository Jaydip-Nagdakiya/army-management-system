<?php
$page_title = "View Mission - Army Management System";
include('../includes/admin_header.php');
include('../includes/admin_sidebar.php');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $mission_id = intval($_POST['id']);
} else {
    echo "<div class='alert alert-danger text-center mt-5'>Invalid Request</div>";
    exit();
}

// Fetch Mission Details
$stmt = $con->prepare("SELECT * FROM missions WHERE mission_id=?");
$stmt->bind_param('i', $mission_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $mission = $result->fetch_assoc();
} else {
    echo "<div class='alert alert-warning text-center mt-5'>Mission Not Found</div>";
    exit();
}

// Fetch Assigned Soldiers
$stmt2 = $con->prepare("
    SELECT s.name AS soldier_name, s.rank, sm.role
    FROM soldiers_missions sm
    JOIN soldiers s ON sm.soldier_id = s.id
    WHERE sm.mission_id=?
");
$stmt2->bind_param('i', $mission_id);
$stmt2->execute();
$soldiers_result = $stmt2->get_result();

$soldiers = [];
while ($row = $soldiers_result->fetch_assoc()) {
    $soldiers[] = $row;
}
?>

<div class="main-wrapper">
    <main class="main-content">
        <div class="container-fluid mt-5">
            <h2 class="text-center animate-fadein aqua">Mission Details</h2>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-9 col-xl-9">
                    <div class="card-box animate-slidein mb-4">
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">Mission Name:</label>
                            <p class="form-control-plaintext d-inline"><?= htmlspecialchars($mission['mission_name']) ?></p>
                        </div>
                        <hr>
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">Description:</label>
                            <p class="form-control-plaintext d-inline"><?= nl2br(htmlspecialchars($mission['description'])) ?></p>
                        </div>
                        <hr>
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">Location:</label>
                            <p class="form-control-plaintext d-inline"><?= htmlspecialchars($mission['location']) ?></p>
                        </div>
                        <hr>
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">Start Date:</label>
                            <p class="form-control-plaintext d-inline"><?= htmlspecialchars($mission['start_date']) ?></p>
                        </div>
                        <hr>
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">End Date:</label>
                            <p class="form-control-plaintext d-inline"><?= htmlspecialchars($mission['end_date']) ?></p>
                        </div>
                        <hr>
                        <div class="mb-3"><label class="form-label d-inline aqua fw-bold">Status:</label>
                            <p class="form-control-plaintext d-inline"><?= htmlspecialchars($mission['status']) ?></p>
                        </div>
                    </div>

                    <div class="card-box animate-slidein">
                        <h4>Assigned Soldiers (<?= count($soldiers) ?>)</h4>
                        <?php if (count($soldiers) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Soldier Name</th>
                                            <th>Rank</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($soldiers as $s): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($s['soldier_name']) ?></td>
                                                <td><?= htmlspecialchars($s['rank']) ?></td>
                                                <td><?= htmlspecialchars($s['role']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger text-center">No Soldiers Assigned Yet.</div>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="manage_missions.php" class="btn btn-army ">Back to Missions</a>
                            <button class="btn btn-army" id="exportPdf">Export to PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- jsPDF & AutoTable -->
<script src="../js/jspdf/jspdf.umd.min.js"></script>
  <script src="../js/jspdf/spdf.plugin.autotable.min.js"></script>

<script>
document.getElementById('exportPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    const margin = 15;
    let y = 25;

    const darkGreen = [34, 85, 34];
    const lightGreen = [220, 235, 220];
    const textDark = [30, 30, 30];

    doc.setFillColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.rect(0, 0, 210, 25, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(20);
    doc.text("Mission Details Report", 105, 17, { align: "center" });

    y += 10;
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.setFontSize(14);
    doc.text("Mission Information", margin, y);
    y += 5;
    doc.setDrawColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.line(margin, y, 195, y);
    y += 10;

    const missionName = "<?= addslashes($mission['mission_name']) ?>";
    const missionDesc = "<?= addslashes($mission['description']) ?>";
    const location = "<?= addslashes($mission['location']) ?>";
    const startDate = "<?= addslashes($mission['start_date']) ?>";
    const endDate = "<?= addslashes($mission['end_date']) ?>";
    const status = "<?= addslashes($mission['status']) ?>";

    function drawField(label, value) {
        const maxWidth = 130;
        const splitValue = doc.splitTextToSize(value, maxWidth);
        const fieldHeight = splitValue.length * 6 + 4;

        doc.setFillColor(lightGreen[0], lightGreen[1], lightGreen[2]);
        doc.rect(margin - 2, y - 5, 180, fieldHeight + 6, 'F');

        doc.setFont('helvetica', 'bold');
        doc.setTextColor(darkGreen[0], darkGreen[1], darkGreen[2]);
        doc.text(`${label}:`, margin, y + 3);

        doc.setFont('helvetica', 'normal');
        doc.setTextColor(textDark[0], textDark[1], textDark[2]);
        doc.text(splitValue, margin + 45, y + 3);

        y += fieldHeight + 8;
    }

    drawField("Mission Name", missionName);
    drawField("Location", location);
    drawField("Start Date", startDate);
    drawField("End Date", endDate);
    drawField("Status", status);

    doc.setFont('helvetica', 'bold');
    doc.setTextColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.text("Description:", margin, y + 3);

    const maxWidth = 145;
    const splitDesc = doc.splitTextToSize(missionDesc, maxWidth);
    const descHeight = splitDesc.length * 6 + 4;

    doc.setFillColor(lightGreen[0], lightGreen[1], lightGreen[2]);
    doc.rect(margin - 2, y - 4, 180, descHeight + 6, 'F');

    doc.setFont('helvetica', 'bold');
    doc.setTextColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.text("Description:", margin, y + 3);

    doc.setFont('helvetica', 'normal');
    doc.setTextColor(textDark[0], textDark[1], textDark[2]);
    doc.text(splitDesc, margin + 45, y + 3);

    y += descHeight + 10;

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(14);
    doc.setTextColor(darkGreen[0], darkGreen[1], darkGreen[2]);
    doc.text("Assigned Soldiers", margin, y + 5);
    y += 10;

    const soldiers = [
        <?php foreach($soldiers as $s): ?>
        ["<?= addslashes($s['soldier_name']) ?>", "<?= addslashes($s['rank']) ?>", "<?= addslashes($s['role']) ?>"],
        <?php endforeach; ?>
    ];

    if (soldiers.length > 0) {
        doc.autoTable({
            startY: y,
            head: [['Soldier Name', 'Rank', 'Role']],
            body: soldiers,
            theme: 'grid',
            styles: { fontSize: 11, cellPadding: 4, halign: 'center' },
            headStyles: { fillColor: darkGreen, textColor: 255, fontStyle: 'bold' },
            alternateRowStyles: { fillColor: [235, 245, 235] },
            bodyStyles: { textColor: [30, 30, 30] },
            margin: { left: margin, right: margin }
        });
    } else {
        doc.setFont('helvetica', 'italic');
        doc.text("No soldiers assigned to this mission.", margin, y + 5);
    }

    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(10);
        doc.setTextColor(80);
        doc.text("Army Management System", margin, 290);
        doc.text(`Page ${i} of ${pageCount}`, 200 - margin, 290, { align: "right" });
    }

    doc.save("Mission_Details.pdf");
});
</script>


<?php include('../includes/admin_footer.php'); ?>