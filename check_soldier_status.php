<?php
include('INCLUDES/db_connect.php');

$soldier_id = $_SESSION['soldier_id'] ?? null;

if (!$soldier_id) {
    header("Location: index.php");
    exit;
}

// Check latest status
$stmt = $con->prepare("SELECT status FROM soldiers WHERE id=?");
$stmt->bind_param("i", $soldier_id);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

if (!$status) {
    session_destroy();
    echo '<script src="js/sweetalert2.all.min.js"></script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: "error",
            title: "Account Deleted",
            text: "Your account has been deleted. Please contact admin.",
            allowOutsideClick: false,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "index.php";
        });
    });
    </script>';
    exit;
}

if ($status === 'Deactive') {
    session_destroy();
    echo '<script src="js/sweetalert2.all.min.js"></script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: "error",
            title: "Account Inactive",
            text: "Your account is inactive. Please contact admin.",
            allowOutsideClick: false,
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "index.php";
        });
    });
    </script>';
    exit;
}
