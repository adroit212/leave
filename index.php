<?php
session_start();
require 'includes/database.php';

if(isset($_SESSION['uid'])){
    header("location:dashboard.php");
}

if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $check = mysqli_query($conn, "select role from users where userid='$username' and password='$password'");
    if (mysqli_num_rows($check) > 0) {
        $get_role = mysqli_fetch_array($check);
        $role = $get_role['role'];

        $_SESSION['uid'] = $username;
        $_SESSION['role'] = $role;
        header("location:dashboard.php");
    } else {
        echo "<script>alert('Invalid username and password!');</script>";
    }
}
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
    </head>

    <body>
        <!-- header -->
        <?php require('includes/header.php') ?>
        <!-- //header -->
        <!-- banner -->
        <div style="background-image: url('img/banner.jpg');" class="container-fluid banner-w3pvt-bg">
            <div class="row">
                <div class="col-lg-12">
                    <div id="home" class="banner-w3pvt d-flex align-items-center">
                        <div class="container">
                            <div class="d-flex flex-column">
                                <div class="bnr-txt-w3pvt  d-sm-flex justify-content-center align-items-center">
                                    <div style="padding-top: 100px;" class="bnr-w3pvt-txt text-center">
                                        <h3>NACEST</h3>
                                        <div class="d-flex justify-content-between bnr-sub-txt align-items-center">
                                            <span></span>
                                            <p class="text-uppercase">
                                                Leave Application, Approval and Notification System
                                            </p>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <div class="row justify-content-between bnr-form-w3ls align-items-center">
                                        <div class="col-lg-4 bnr-sub-form">
                                            <p class="mt-lg-2 mb-lg-0 my-4">
                                                Login to start your session
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-md-4 form-group mb-md-0">
                                                </div>
                                                <div class="col-md-4 mb-md-0 form-group">
                                                </div>
                                                <div class="col-md-4 d-flex align-items-end">
                                                    <button type="button" class="btn btn-agile btn-block w-100 font-weight-bold text-uppercase"
                                                            data-toggle="modal" aria-pressed="false" data-target="#exampleModal">
                                                        Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-lg-4 banner2-w3pvt"></div>-->
            </div>
        </div>
        <!-- //banner -->
        <!-- Footer -->
        <?php require ('includes/footer.php'); ?>
        <!-- //footer -->
        <!-- login and register modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Login Form</h5>
                        <button style="background-color: #f00;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="p-3">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Username</label>
                                <input type="text" class="form-control" placeholder=" " name="username" id="recipient-name"
                                       required="">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password</label>
                                <input type="password" class="form-control" placeholder=" " name="password" id="password"
                                       required="">
                            </div>
                            <div class="right-w3l">
                                <input type="submit" name="login" class="form-control" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- //login modal -->
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