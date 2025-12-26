<?php 
include('../admin/check_login.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        <?php
       echo isset($page_title) ? $page_title : "Army Management";
        ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/faveicon2.png" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/admin_css/admin_style.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
</head>

<body>

    <!-- Header -->
  
    <header class="main-header">
        <div class="logo"><a href="dashboard.php"><img src="../IMAGES/army_logo2.png" alt="army_logo"></a></div>
        <div class="title">Army Management</div>
        <div class="logout">
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </header>
    
   