<?php
session_start();
require 'includes/database.php';
if (!isset($_SESSION['uid'])) {
    header("location:index.php");
}
$uid = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <title>L.A.A.N SYSTEM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
        <meta name="keywords" content="Directory Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
              SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
        <script>
            addEventListener("load", function () {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            }
        </script>
        <!-- Custom Theme files -->
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
        <!-- timeline -->
        <link href="css/timeline.css" type="text/css" rel="stylesheet" media="all">
        <!-- font-awesome icons -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <!-- //Custom Theme files -->
        <!-- online-fonts -->
        <link href="//fonts.googleapis.com/css?family=Libre+Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
              rel="stylesheet">
        <style type="text/css">
            .bg-myblue{
                background-color: RGB(66, 156, 245); 
            }

            .bg-myorange{
                background-color: RGB(244, 190, 82);
            }

            .bg-mygreen{
                background-color: RGB(117, 203, 112);
            }

            .bg-mylightblue{
                background-color: RGB(29, 219, 186);
            }
        </style>
    </head>

    <body style="background-color: #e8e8e8;">
        <!-- header -->
        <?php require('includes/header.php') ?>
        <!-- //header -->
        <!-- inner banner -->
        <div style="background-image: url('img/banner.jpg')" class="inner-banner-w3ls d-flex align-items-center text-center">
            <div class="container">
                <h6 class="agileinfo-title">Leave Application, Approval and Notification System </h6>
                <ul class="breadcrumb-parent d-flex justify-content-center">
                    <!--<li class="breadcrumb-nav">
                        <a href="index.html">Home</a>
                    </li>-->
                    <li class="breadcrumb-nav active  text-capitalize" aria-current="page">Dashboard</li>
                </ul>
            </div>
        </div>
        <!-- //inner banner -->
        <?php
        if ($_SESSION['role'] == 'admin') {
            $a_total_applications = mysqli_num_rows(mysqli_query($conn, "select appid from applications"));
            $a_total_approved = mysqli_num_rows(mysqli_query($conn, "select appid from applications where leavestatus='approved'"));
            $a_total_declined = mysqli_num_rows(mysqli_query($conn, "select appid from applications where leavestatus='declined'"));
            $a_total_expired = mysqli_num_rows(mysqli_query($conn, "select appid from applications where leavestatus='expired'"));
            ?>
            <div style="min-height: 270px;" class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-myblue text-white">
                            <div class="card-header">
                                <strong>Total Applications</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $a_total_applications ?></strong> Leave Applied
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-myorange text-white">
                            <div class="card-header">
                                <strong>Total Declined</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $a_total_declined ?></strong> Leave Declined
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-mygreen text-white">
                            <div class="card-header">
                                <strong>Total Approval</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $a_total_approved ?></strong> Leave Approved
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-mylightblue text-white">
                            <div class="card-header">
                                <strong>Total Expired</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $a_total_expired ?></strong> Leave Expired
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $s_total_applied = mysqli_num_rows(mysqli_query($conn, "select appid from applications where userid='$uid'"));
            $s_total_declined = mysqli_num_rows(mysqli_query($conn, "select appid from applications where userid='$uid' and leavestatus='declined'"));
            $s_total_approved = mysqli_num_rows(mysqli_query($conn, "select appid from applications where userid='$uid' and leavestatus='approved'"));
            $s_total_expired = mysqli_num_rows(mysqli_query($conn, "select appid from applications where userid='$uid' and leavestatus='expired'"));
            ?>
            <div style="min-height: 270px;" class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-myblue text-white">
                            <div class="card-header">
                                <strong>Total Applied</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $s_total_applied ?></strong> Leave Applied
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-myorange text-white">
                            <div class="card-header">
                                <strong>Total Declined</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $s_total_declined ?></strong> Leave Declined
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-mygreen text-white">
                            <div class="card-header">
                                <strong>Total Approval</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $s_total_approved ?></strong> Leave Approval
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3 my-3 bg-mylightblue text-white">
                            <div class="card-header">
                                <strong>Total Expired</strong>
                            </div>
                            <div class="card-body text-center">
                                <strong><?php echo $s_total_expired ?></strong> Leave Expired
                            </div>
                            <div class="card-footer text-right">
                                <a class="text-danger" href="personal_history.php">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Footer -->
        <?php require ('includes/footer.php'); ?>
        <!-- //footer -->

        <!-- js -->
        <script src="js/jquery-2.2.3.min.js"></script>
        <!-- script for password match -->
        <script>
            window.onload = function () {
                document.getElementById("password1").onchange = validatePassword;
                document.getElementById("password2").onchange = validatePassword;
            }

            function validatePassword() {
                var pass2 = document.getElementById("password2").value;
                var pass1 = document.getElementById("password1").value;
                if (pass1 !== pass2)
                    document.getElementById("password2").setCustomValidity("Passwords Don't Match");
                else
                    document.getElementById("password2").setCustomValidity('');
                //empty string means no validation error
            }
        </script>
        <!-- script for password match -->

        <!-- //js -->
        <script src="js/move-top.js"></script>
        <script src="js/easing.js"></script>
        <script>
            jQuery(document).ready(function ($) {
                $(".scroll").click(function (event) {
                    event.preventDefault();

                    $('html,body').animate({
                        scrollTop: $(this.hash).offset().top
                    }, 1000);
                });
            });
        </script>
        <!-- //end-smooth-scrolling -->
        <!-- smooth-scrolling-of-move-up -->
        <script>
            $(document).ready(function () {
                /*
                 var defaults = {
                 containerID: 'toTop', // fading element id
                 containerHoverID: 'toTopHover', // fading element hover id
                 scrollSpeed: 1200,
                 easingType: 'linear'
                 };
                 */

                $().UItoTop({
                    easingType: 'easeOutQuart'
                });

            });
        </script>
        <script src="js/SmoothScroll.min.js"></script>
        <!-- //smooth-scrolling-of-move-up -->
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/bootstrap.min.js"></script>
    </body>

</html>