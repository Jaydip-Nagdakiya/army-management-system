<?php
 include('check_login.php');
 include('check_soldier_status.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
       echo isset($page_title) ? $page_title : "Army Management System";
        ?>
    </title>
    <link rel="icon" type="image/x-icon" href="images/faveicon2.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/soldier_css/soldier_style.css">
    <link rel="stylesheet" href="css/animate.css">
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top ">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center " href="homepage.php">
                <img src="images/army_logo.png" alt="Logo" class="me-2 ds-logo">
                <span class="fs-5 main-title">Army Management</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "home") echo 'active-page'; ?>" href="homepage.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "profile") echo 'active-page'; ?>" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "notices") echo 'active-page'; ?>" href="notice.php">Notices</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "applyforleave") echo 'active-page'; ?>" href="apply_leave.php">Apply For Leave</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "leavestatus") echo 'active-page'; ?>" href="leave_status.php">Leave Status</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "posting") echo 'active-page'; ?>" href="my_postings.php">My Postings</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($current_page == "mission") echo 'active-page'; ?>" href="mission.php">My Mission</a></li>
                    <li class="nav-item"><a class="nav-link " href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>