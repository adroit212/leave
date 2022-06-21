<?php
session_start();
require 'includes/database.php';
$uid = $_SESSION['uid'];
$appid = $_GET['appid'];

//process application leaflet for printing
$get_applications = mysqli_query($conn, "select * from applications where appid='$appid'");
$total_application = mysqli_num_rows($get_applications);
$counter = 1;
$applications = mysqli_fetch_array($get_applications);
$v_staffemail = $applications['userid'];
$v_leavetype = $applications['leavetype'];
$v_applicationdate_raw = $applications['applicationdate'];
$v_applicationdate = date_format(date_create($v_applicationdate_raw), "d M Y");
$v_startdate_raw = $applications['startdate'];
$v_startdate = date_format(date_create($v_startdate_raw), "d M Y");
$v_enddate_raw = $applications['enddate'];
$v_enddate = "";

if (trim($v_enddate_raw) != "") {
    $v_enddate = date_format(date_create($v_enddate_raw), "d M Y");
}

$v_leaveduration_raw = $applications['leaveduration'];
$v_leaveduration = "";

if ($v_leaveduration_raw >= 7) {
    $weeks = round($v_leaveduration_raw / 7);
    $days = $v_leaveduration_raw % 7;

    if ($days > 0) {
        $v_leaveduration = $weeks . " weeks, " . $days . " days";
    } else {
        $v_leaveduration = $weeks . " weeks";
    }
} else {
    $v_leaveduration = $v_leaveduration_raw . " days";
}

$v_leavestatus = $applications['leavestatus'];
$v_leavetext = $applications['leavetext'];

//get staff name
$single_staff = mysqli_fetch_array(mysqli_query($conn, "select fullname from users where userid='$uid'"));
$v_staffname = $single_staff['fullname'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>L.A.A.N SYSTEM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
    </head>

    <body>
        <div align="left" style="margin: auto; background-color: #ccc; padding: 10px; width: 500px; border: 1px #000 solid;" border="1">
            <h4 align="center">Leave Leaflet</h4>
            <p>
                <strong>Staff Name: </strong> <?php echo $v_staffname ?>
            </p>
            <p>
                <strong>Leave Type: </strong> <?php echo ucfirst($v_leavetype) ?> Leave
            </p>
            <p>
                <strong>Date Applied: </strong> <?php echo $v_applicationdate ?>
            </p>
            <p>
                <strong>Duration: </strong> <?php echo $v_leaveduration ?>
            </p>
            <p>
                <strong>Status: </strong> <?php echo $v_leavestatus ?>
            </p>
            <p>
                <strong>Start Date: </strong> <?php echo $v_startdate ?>
            </p>
            <p>
                <strong>End Date: </strong> <?php echo $v_enddate ?>
            </p>
            <p>
                <strong>Description: </strong> <?php echo $v_leavetext ?>
            </p><br/>`
            <p align="right">
                <br/>
                <span>__________________________</span><br/>
                <span>Management Sign and Stamp</span>
            </p>
        </div>
    </body>
</html>