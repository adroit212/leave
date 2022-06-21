<?php
session_start();
require 'includes/database.php';
if (!isset($_SESSION['uid'])) {
    header("location:index.php");
}
$uid = $_SESSION['uid'];

//check if staff already has pending application
//if true, then staff will not be allowed to apply fresh
$checkpending = mysqli_query($conn, "select appid from applications where leavestatus='pending' and userid='$uid'");
$locker = "";
if (mysqli_num_rows($checkpending) > 0) {
    $locker = "disabled";
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

        <!--Sweet alert-->
        <script src="sweetalert2/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
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
                    <li class="breadcrumb-nav active  text-capitalize" aria-current="page">Leave Application</li>
                </ul>
            </div>
        </div>
        <!-- //inner banner -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 my-3">
                        <form method="post" name="regfrom">
                            <div class="card card-header">
                                <h4>Leave Application Form</h4>
                            </div>
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Leave Type:</label>
                                            <select class="form-control" name="leavetype" required>
                                                <option value=""></option>
                                                <option value="sick">Sick Leave</option>
                                                <option value="study">Study Leave</option>
                                                <option value="maternity">Maternity Leave</option>
                                                <option value="annual">Annual Leave</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Duration (days):</label>
                                            <input type="number" name="leaveduration" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Date:</label>
                                            <input type="date" name="startdate" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Leave Location:</label>
                                            <select class="form-control" name="stateid" required>
                                                <option value=""></option>
                                                <?php
                                                $f_states = mysqli_query($conn, "select * from states");
                                                while ($f_state = mysqli_fetch_array($f_states)) {
                                                    ?>
                                                    <option value="<?php echo $f_state['state_id'] ?>"><?php echo $f_state['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description (optional):</label>
                                            <textarea name="leavetext" class="form-control" style="resize: none;" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button <?php echo $locker ?> type="submit" name="submit" class="btn btn-primary btn-md">Submit Application</button>
                            </div>
                        </form>
                        <?php
                        //process leave form
                        if (isset($_POST['submit'])) {
                            $s_appid = "app-" . date("YmdHis");
                            $s_leavetype = $_POST['leavetype'];
                            $s_leaveduration = $_POST['leaveduration'];
                            $s_applicationdate = date('Y-m-d');
                            $s_startdate = $_POST['startdate'];
                            $s_leavetext = $_POST['leavetext']; //optional field
                            $s_stateid = $_POST['stateid'];
                            $a_enddate = date('Y-m-d', strtotime($s_startdate . ' + ' . $s_leaveduration . ' days'));

                            mysqli_query($conn, "insert into applications value('$s_appid', '$s_leavetype', "
                                    . "'$s_leaveduration', '$s_applicationdate', 'pending', '$uid', '$s_startdate', '$a_enddate', "
                                    . "'$s_leavetext', '$s_stateid')");

                            if (!mysqli_error($conn)) {
                                echo "<script>alert('Leave application submitted successfully'); window.location.href='dashboard.php';</script>";
                            } else {
                                ?>
                                <script type="text/javascript">
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                                </script>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

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