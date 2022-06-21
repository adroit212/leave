<?php
//corner to automate leave status swap
//approved to running
$aut_applieds = mysqli_query($conn, "select * from applications where leavestatus='approved'");
if (mysqli_num_rows($aut_applieds) > 0) {
    while ($aut_applied = mysqli_fetch_array($aut_applieds)) {
        $aut_appid = $aut_applied['appid'];
        $aut_curdate = date('Y-m-d');
        $aut_startdate = date_format(date_create($aut_applied['startdate']), 'Y-m-d');

        if ($aut_curdate >= $aut_startdate) {
            mysqli_query($conn, "update applications set leavestatus='running' where appid='$aut_appid'");
        }
    }
}
//pending or running to expired
$aut_applieds2 = mysqli_query($conn, "select * from applications where leavestatus='pending' or leavestatus = 'running'");
if (mysqli_num_rows($aut_applieds2) > 0) {
    while ($aut_applied2 = mysqli_fetch_array($aut_applieds2)) {
        $aut_appid2 = $aut_applied2['appid'];
        $aut_curdate2 = date('Y-m-d');
        $aut_enddate2 = date_format(date_create($aut_applied2['enddate']), 'Y-m-d');

        if ($aut_curdate2 >= $aut_enddate2) {
            mysqli_query($conn, "update applications set leavestatus='expired' where appid='$aut_appid2'");
        }
    }
}
?>

<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <h1><a class="navbar-brand" href="#">
                    <span><img src="img/logo.jpg" width="45" alt="logo"/></span>NACEST LAAN
                </a></h1>
            <button class="navbar-toggler ml-lg-auto ml-sm-5 bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php
            $positioner = "";
            if (isset($_SESSION['uid'])) {
                $positioner = "border: 1px #e8e solid !important;";
            }
            ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php if (isset($_SESSION['uid'])) { ?>
                    <ul class="navbar-nav text-center mx-auto">
                        <li class="nav-item  mr-lg-4 mt-lg-0 mt-sm-4 mt-3">
                            <a class="hover-fill" href="dashboard.php" data-txthover="Dashboard">Dashboard</a>
                        </li>
                        <?php if ($_SESSION['role'] == "admin") { ?>
                            <li class="nav-item  mr-lg-4 mt-lg-0 mt-sm-4 mt-3">
                                <a class="hover-fill" href="staff.php" data-txthover="Staff">Staff</a>
                            </li>
                            <li class="nav-item dropdown mr-lg-4 my-lg-0 my-sm-4 my-3">
                                <a class=" hover-fill" data-txthover="Leave" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Leave
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="hover-fill" href="pending_leave.php" data-txthover="Pending">Pending</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="hover-fill" href="approved_leave.php" data-txthover="Approved">Approved</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="hover-fill" href="declined_leave.php" data-txthover="Declined">Declined</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="hover-fill" href="running_leave.php" data-txthover="Running">Running</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="hover-fill" href="expired_leave.php" data-txthover="Expired">Expired</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="hover-fill" href="all_leave.php" data-txthover="All">All</a>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item  mr-lg-4 mt-lg-0 mt-sm-4 mt-3">
                                <a class="hover-fill" href="application.php" data-txthover="Application">Application</a>
                            </li>
                            <li class="nav-item  mr-lg-4 mt-lg-0 mt-sm-4 mt-3">
                                <a class="hover-fill" href="personal_history.php" data-txthover="History">History</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <a href="logout.php" class="btn bg-theme w3ls-btn text-uppercase font-weight-bold d-block">
                        Logout
                    </a>
                <?php } ?>
            </div>
        </nav>
    </div>
</header>