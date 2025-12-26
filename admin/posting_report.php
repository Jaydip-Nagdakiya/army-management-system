<?php
$page_title = "Posting Report - Army Management System";
include('../includes/admin_header.php');
$current_page = "posting_report";
include('../includes/admin_sidebar.php');

$locationData = [];
$loc_query = "SELECT location, COUNT(*) as total FROM postings p join soldiers s on p.soldier_id = s.id  where s.status ='Active' and p.status='Active' group by p.location";
$res1 = mysqli_query($con, $loc_query);
while ($row = mysqli_fetch_assoc($res1)) {
    $locationData[] = $row;
}

$unitData = [];
$unit_query = "SELECT unit, COUNT(*) as total FROM postings p join soldiers s on p.soldier_id = s.id where s.status= 'Active' and p.status='Active' group by p.unit";
$res2 = mysqli_query($con, $unit_query);
while ($row = mysqli_fetch_assoc($res2)) {
    $unitData[] = $row;
}
?>

<!-- Main Content -->
<div class="main-wrapper flex-grow-1 d-flex flex-column">
    <main class="main-content">
        <div class="container-fluid mt-5">
            <h2 class="text-center mb-5 aqua animate-fadein">Posting Report</h2>

            <div class="row">
                <!-- Location Table -->
                <div class="col-md-6 mb-5">
                    <div class="card shadow-lg border-0 rounded-3 bg-dark text-white">
                        <div class="card-header text-center bg-secondary rounded-top">
                            <h5>Location-wise Soldiers</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-dark table-hover text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Total Soldiers</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($locationData as $loc): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($loc['location']) ?></td>
                                            <td><?= $loc['total'] ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info viewSoldiersBtn"
                                                    data-type="location"
                                                    data-value="<?= htmlspecialchars($loc['location']) ?>">
                                                    View Soldiers
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($locationData)): ?>
                                        <tr>
                                            <td colspan="3" class="text-white">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Unit Table -->
                <div class="col-md-6 mb-5">
                    <div class="card shadow-lg border-0 rounded-3 bg-dark text-white">
                        <div class="card-header text-center bg-secondary rounded-top">
                            <h5>Unit-wise Soldiers</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-dark table-hover text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Total Soldiers</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($unitData as $unit): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($unit['unit']) ?></td>
                                            <td><?= $unit['total'] ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info viewSoldiersBtn"
                                                    data-type="unit"
                                                    data-value="<?= htmlspecialchars($unit['unit']) ?>">
                                                    View Soldiers
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($unitData)): ?>
                                        <tr>
                                            <td colspan="3" class="text-white">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Soldier List Modal -->
            <div class="modal fade" id="soldierModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Soldiers List</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="soldierList" class="text-center">
                                <span class="text-secondary">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php
    include('../includes/admin_footer.php');
    ?>
</div>

<!-- JS -->
<script>
    document.querySelectorAll('.viewSoldiersBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.dataset.type;
                    const value = this.dataset.value;

                    fetch("fetch_soldiers_report.php", {
                        method: "post",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body : "type=" + encodeURIComponent(type) + "&value="+ encodeURIComponent(value),
                         })
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('soldierList').innerHTML = html;
                            new bootstrap.Modal(document.getElementById('soldierModal')).show();
                       
                    });
                });
            });
</script>