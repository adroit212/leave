<?php
session_start();
require 'includes/database.php';
include 'includes/sms.php';
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
                    <li class="breadcrumb-nav active  text-capitalize" aria-current="page">Pending Leave Applications</li>
                </ul>
            </div>
        </div>
        <!-- //inner banner -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 my-3">
                        <div class="card card-header">
                            <h4>Pending Leave Records</h4>
                        </div>
                        <div class="card card-body">
                            <table class="table table-primary">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Staff</th>
                                        <th>Leave Type</th>
                                        <th>App. Date</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get_applications = mysqli_query($conn, "select * from applications where leavestatus='pending'");
                                    $total_application = mysqli_num_rows($get_applications);
                                    $counter = 1;
                                    if ($total_application > 0) {
                                        while ($applications = mysqli_fetch_array($get_applications)) {
                                            $v_appid = $applications['appid'];
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
                                            $single_staff = mysqli_fetch_array(mysqli_query($conn, "select fullname from users where userid='$v_staffemail'"));
                                            $v_staffname = $single_staff['fullname'];

                                            //create array and convert to json object for render on modal using js
                                            $prepare_json = array(
                                                'appid' => $v_appid,
                                                'leavetype' => $v_leavetype,
                                                'leaveduration' => $v_leaveduration,
                                                'applicationdate' => $v_applicationdate,
                                                'leavestatus' => $v_leavestatus,
                                                'staffname' => $v_staffname,
                                                'startdate' => $v_startdate,
                                                'enddate' => $v_enddate,
                                                'leavetext' => $v_leavetext
                                            );
                                            $json_data = json_encode($prepare_json, JSON_FORCE_OBJECT);
                                            ?>
                                            <tr>
                                                <td><?php echo $counter ?></td>
                                                <td><?php echo $v_staffname ?></td>
                                                <td><?php echo $v_leavetype ?></td>
                                                <td><?php echo $v_applicationdate ?></td>
                                                <td><?php echo $v_leaveduration ?></td>
                                                <td><?php echo ucfirst($v_leavestatus) ?></td>
                                                <td class="text-center">
                                                    <form method="post" name="delform">
                                                        <p hidden id="<?php echo $v_appid ?>"><?php echo $json_data ?></p>
                                                        <button onclick="firstParser('<?php echo $v_appid ?>');" title="delete" type="button" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </form>
                                                    <script>
                                                        function firstParser(key_picker) {
                                                            //var jo = '<?php //echo $json_data                                          ?>';
                                                            var jo = document.getElementById(key_picker).innerHTML;
                                                            openJsModal(jo);
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7"><p>No record to display!</p></                                                            td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require ('includes/footer.php'); ?>
        <!-- //footer -->

        <!-- login and register modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Leave Details</h5>
                        <button style="background-color: #f00;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return confirm('Please confirm your action!')" method="post" class="p-3">
                            <p style="color: #000;">
                                <strong>Staff Name: </strong> <span id="r_staffname"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Leave Type: </strong> <span id="r_leavetype"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Date Applied: </strong> <span id="r_applicationdate"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Duration: </strong> <span id="r_leaveduration"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Status: </strong> <span id="r_leavestatus"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Start Date: </strong> <span id="r_startdate"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>End Date: </strong> <span id="r_enddate"></span>
                            </p>
                            <p style="color: #000;">
                                <strong>Description: </strong> <span id="r_leavetext"></span>
                            </p>
                            <div class="right-w3l text-right">
                                <input type="hidden" id="r_appid" name="r_appid" value=""/>
                                <button title="decline leave" type="submit" name="decline" class="btn btn-danger btn-sm"> 
                                    <i class="fa fa-times"></i> 
                                </button>
                                &nbsp;&nbsp;&nbsp;
                                <button title="approve leave" type="submit" name="approve" class="btn btn-primary btn-sm"> 
                                    <i class="fa fa-check"></i> 
                                </button>
                            </div>
                        </form>
                        <?php
                        //approve leave application
                        if (isset($_POST['approve'])) {
                            $a_appid = $_POST['r_appid'];
                            $a_application = mysqli_fetch_array(mysqli_query($conn, "select * from applications where appid='$a_appid'"));
                            $a_user = mysqli_fetch_array(mysqli_query($conn, "select * from users where userid='$a_application[userid]'"));
                            $a_phone = $a_user['phone'];
                            $a_fullname = $a_user['fullname'];
                            $a_startdate = date_format(date_create($a_application['startdate']), 'd M Y');

                            //Send Text Message Notification
                            $message2 = "Dear $a_fullname, your leave application have been approved. ";
                            $message2 .= "Print the leaflet and come to the office for signing a day to $a_startdate .";
                            $recipients = $a_phone;
                            $sms_array = array(
                                'sender' => $senderid,
                                'to' => $recipients,
                                'message' => $message2,
                                'type' => '0', //This can be set as desired. 0 = Plain text ie the normal SMS
                                'routing' => '3', //This can be set as desired. 3 = Deliver message to DND phone numbers via the corporate route
                                'token' => $token
                            );

                            //Call sendsms_post function to send SMS        
                            $response = sendsms_post($url, $sms_array);
                            if (validate_sendsms($response) == TRUE) {

                                //change application status to approved
                                mysqli_query($conn, "update applications set leavestatus='approved' where appid='$a_appid'");

                                if (!mysqli_error($conn)) {
                                    ?>
                                    <script type="text/javascript">
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Operation Successful',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        window.location.href = "pending_leave.php";
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
                            } else {
                                $finish = "<script>alert('Operation failed due to incorrect number or network downtime. please check and try again.');</script>";
                                var_dump($response);
                            }
                        }

                        //decline leave application
                        if (isset($_POST['decline'])) {
                            $d_appid = $_POST['r_appid'];
                            $d_application = mysqli_fetch_array(mysqli_query($conn, "select * from applications where appid='$d_appid'"));
                            $d_user = mysqli_fetch_array(mysqli_query($conn, "select * from users where userid='$d_application[userid]'"));
                            $d_phone = $d_user['phone'];
                            $d_fullname = $d_user['fullname'];
                            $d_startdate = date_format(date_create($d_application['startdate']), 'd M Y');

                            //Send Text Message Notification
                            $message2 = "Dear $d_fullname, your leave application is declined. ";
                            $recipients = $d_phone;
                            $sms_array = array(
                                'sender' => $senderid,
                                'to' => $recipients,
                                'message' => $message2,
                                'type' => '0', //This can be set as desired. 0 = Plain text ie the normal SMS
                                'routing' => '3', //This can be set as desired. 3 = Deliver message to DND phone numbers via the corporate route
                                'token' => $token
                            );

                            //Call sendsms_post function to send SMS        
                            $response = sendsms_post($url, $sms_array);
                            if (validate_sendsms($response) == TRUE) {

                                ///change application status to declined
                                mysqli_query($conn, "update applications set leavestatus='declined' where appid='$d_appid'");

                                if (!mysqli_error($conn)) {
                                    ?>
                                    <script type="text/javascript">
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Operation Successful',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        window.location.href = "pending_leave.php";
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
                            } else {
                                $finish = "<script>alert('Operation failed due to incorrect number or network downtime. please check and try again.');</script>";
                                echo $finish;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <button hidden type="button" id="trigger" data-toggle="modal" aria-pressed="false" data-target="#exampleModal">Trigger</button>
        <!-- //login modal -->

        <!-- js -->
        <script src="js/jquery-2.2.3.min.js"></script>
        <!--Work on modal-->
        <script>
                                        function openJsModal(raw_jsondata) {
                                            jsondata = JSON.parse(raw_jsondata);
                                            var appid = jsondata['appid'];
                                            var leavetype = jsondata['leavetype'];
                                            var leaveduration = jsondata['leaveduration'];
                                            var applicationdate = jsondata['applicationdate'];
                                            var leavestatus = jsondata['leavestatus'];
                                            var staffname = jsondata['staffname'];
                                            var startdate = jsondata['startdate'];
                                            var enddate = jsondata['enddate'];
                                            var leavetext = jsondata['leavetext'];

                                            // asign values to hidden modal
                                            document.getElementById('r_appid').value = appid;
                                            document.getElementById('r_leavetype').innerHTML = leavetype;
                                            document.getElementById('r_leaveduration').innerHTML = leaveduration;
                                            document.getElementById('r_applicationdate').innerHTML = applicationdate;
                                            document.getElementById('r_leavestatus').innerHTML = leavestatus;
                                            document.getElementById('r_staffname').innerHTML = staffname;
                                            document.getElementById('r_startdate').innerHTML = startdate;
                                            document.getElementById('r_enddate').innerHTML = enddate;
                                            document.getElementById('r_leavetext').innerHTML = leavetext;

                                            // click the trigger button to lunch moda
                                            var trigger = document.getElementById('trigger');
                                            trigger.click();
                                        }
        </script>
        <!-- script for password match -->
        <script>
            window.onload = function () {
                document.getElementById("password1").onchange = validatePassword;
                document.getElementById("password2").onchange = validatePassword;
            };

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