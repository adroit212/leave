<?php
session_start();
require 'includes/database.php';
if (!isset($_SESSION['uid'])) {
    header("location:index.php");
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
                    <li class="breadcrumb-nav active  text-capitalize" aria-current="page">Staff</li>
                </ul>
            </div>
        </div>
        <!-- //inner banner -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mt-3 my-3">
                        <form method="post" name="regfrom">
                            <div class="card card-header">
                                <h4>Register Staff</h4>
                            </div>
                            <div class="card card-body">
                                <div class="form-group">
                                    <label>Full Name:</label>
                                    <input type="text" name="fname" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label>Phone:</label>
                                    <input type="text" name="phone" class="form-control" required/>
                                </div>
                            </div>
                            <div class="card card-footer text-right">
                                <button type="submit" name="reg" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                        <?php
                        //registeration form processor
                        if (isset($_POST['reg'])) {
                            $s_email = $_POST['email'];
                            $s_fullname = $_POST['fname'];
                            $s_phone = $_POST['phone'];

                            //check if this email already exist as userid
                            $uid_check = mysqli_query($conn, "select role from users where userid='$s_email'");
                            if (mysqli_num_rows($uid_check) > 0) {
                                //throw error if exist
                                echo "<script type='text/javascript'>Swal.fire('Email already exist')</script>";
                            } else {
                                //continue with registration if not exist
                                mysqli_query($conn, "insert into users value('$s_email', "
                                        . "'$s_fullname', '$s_phone', 'staff', '$s_email')");

                                if (!mysqli_error($conn)) {
                                    ?>
                                    <script type="text/javascript">
                        Swal.fire({
                            icon: 'success',
                            title: 'Operation Successful',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.href = "staff.php";
                                    </script>
                                    <?php
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
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mt-3 my-3">
                        <div class="card card-header">
                            <h4>Staff Records</h4>
                        </div>
                        <div class="card card-body">
                            <table class="table table-primary">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get_staff = mysqli_query($conn, "select * from users where role<>'admin'");
                                    $total_staff = mysqli_num_rows($get_staff);
                                    $counter = 1;
                                    if ($total_staff > 0) {
                                        while ($staffs = mysqli_fetch_array($get_staff)) {
                                            $v_fname = $staffs['fullname'];
                                            $v_email = $staffs['userid']; //email
                                            $v_phone = $staffs['phone'];
                                            ?>
                                            <tr>
                                                <td><?php echo $counter ?></td>
                                                <td title="staff leave history"><a href="staff_history.php?sid=<?php echo base64_encode($v_email) ?>"><?php echo $v_fname ?></a></td>
                                                <td><?php echo $v_email ?></td>
                                                <td><?php echo $v_phone ?></td>
                                                <td class                                                                                        ="text-center">
                                                    <form onsubmit="return confirm('Please confirm your action!')" method="post" name="delform">
                                                        <input type="hidden" name="delid" value="<?php echo $v_email ?>" />
                                                        <button title="delete staff" type="submit" name="del" class="btn btn-danger btn-sm"><i class="fa fa-trash                                                        "></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5"><p>No record to display!</p></                                                            td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php
                            //delete form processor
                            if (isset($_POST['del'])) {
                                $delid = $_POST['delid'];
                                mysqli_query($conn, "delete from users where userid='$delid'");
                                if (!mysqli_error($conn)) {
                                    ?>
                                    <script type="text/javascript">
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Operation Successful',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        window.location.href = "staff.php";
                                    </script>
                                    <?php
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