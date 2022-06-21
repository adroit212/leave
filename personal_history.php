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
                    <li class="breadcrumb-nav active  text-capitalize" aria-current="page">Personal Leave Application History</li>
                </ul>
            </div>
        </div>
        <!-- //inner banner -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 my-3">
                        <div class="card card-header">
                            <h4>Personal Leave Records</h4>
                        </div>
                        <div class="card card-body">
                            <table class="table table-primary">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Leave Type</th>
                                        <th>App. Date</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get_applications = mysqli_query($conn, "select * from applications where userid='$uid'");
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
                                                            //var jo = '<?php //echo $json_data                                ?>';
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
                            <input type="hidden" id="r_appid" name="r_appid" value=""/>
                            <div id="btn_cancel" class="right-w3l text-right">
                                <button title="cancel leave application" type="submit" name="cancel" class="btn btn-danger btn-sm"> 
                                    <i class="fa fa-times"></i> 
                                </button>
                            </div>
                            <div id="btn_print" class="right-w3l text-right">
                                <button onclick="printLeaflet()" title="print leave leaflet" type="button" name="print" class="btn btn-primary btn-sm"> 
                                    <i class="fa fa-print"></i> 
                                </button>
                            </div>
                        </form>
                        <?php
                        //cancel leave application
                        if (isset($_POST['cancel'])) {
                            $d_appid = $_POST['r_appid'];
                            mysqli_query($conn, "update applications set leavestatus='cancelled' where appid='$d_appid' and userid='$uid'");

                            if (!mysqli_error($conn)) {
                                ?>
                                <script type="text/javascript">
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Operation Successful',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    window.location.href = "personal_history.php";
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
        <button hidden type="button" id="trigger" data-toggle="modal" aria-pressed="false" data-target="#exampleModal">Trigger</button>
        <!-- //login modal -->

        <!-- js -->
        <script src="js/jquery-2.2.3.min.js"></script>
        <!--print leave leaflet-->
        <script>
                            function printLeaflet() {
                                var appid = document.getElementById('r_appid').value;
                                var url = 'leaveleaflet.php?appid=' + appid;
                                var printWindow = window.open(url, 'Leave Leaflet', 'left=200, top=200, width=950, height=600, toolbar=0, resizable=0');

                                printWindow.addEventListener('load', function () {
                                    if (Boolean(printWindow.chrome)) {
                                        printWindow.print();
                                        setTimeout(function () {
                                            printWindow.close();
                                        }, 500);
                                    } else {
                                        printWindow.print();
                                        printWindow.close();
                                    }
                                }, true);
                            }
        </script>

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

                // make buttons hidden if application status is not pending
                if (leavestatus === "pending") {
                    document.getElementById('btn_cancel').removeAttribute('hidden');
                    document.getElementById('btn_print').setAttribute('hidden', 'hidden');
                } else if (leavestatus === "approved") {
                    document.getElementById('btn_print').removeAttribute('hidden');
                    document.getElementById('btn_cancel').setAttribute('hidden', 'hidden');
                } else {
                    document.getElementById('btn_cancel').setAttribute('hidden', 'hidden');
                    document.getElementById('btn_print').setAttribute('hidden', 'hidden');
                }

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