<?php include("header.php");
//  include('connect.php');

include("sidebar.php");
// 	  print_r($_SESSION);
?>

<?php
// Logged in admin ki active subscription
$subSql = "
SELECT 
    a.subscription_expiry_date,
    a.subscription_package_id,
    p.name AS package_name,
    p.subscription_type,
    p.price
FROM admin a
JOIN subscription_packages p ON p.id = a.subscription_package_id
WHERE a.id = '".$_SESSION['id']."'
AND a.subscription_expiry_date >= CURDATE()
LIMIT 1
";
$subQuery = $conn->query($subSql);
$subscription = $subQuery->fetch_assoc();

$remainingDays = 0;
if ($subscription) {
    $today = new DateTime();
    $end   = new DateTime($subscription['subscription_expiry_date']);
    $remainingDays = $today->diff($end)->days;
}
?>

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        

        <!-- Start Page Content -->
        <div class="row">
            <div class="col-md-4">
                <a href="employeelist.php">
                    <div class="card p-20" style="background-color: #22324A">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-users f-s-40"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white">
                                    <?php
                                    $sql = "SELECT * FROM employees WHERE isActive='0' AND admin_id='" . $_SESSION['id'] . "'";
                                    $query = $conn->query($sql);

                                    echo "" . $query->num_rows . "";
                                    ?>

                                </h2>
                                <p class="m-b-0">Total Employees</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="attendance.php?show_date=<?= date('Y-m-d') ?>">
                    <div class="card p-20" style="background-color: #6F931D">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-user f-s-40"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white">
                                    <?php
                                    $today = date("Y-m-d");
                                    $sql11 = "SELECT * FROM attendance WHERE date = '$today' AND 
										daytype NOT LIKE '%Leave%'
										AND
											daytype NOT LIKE '%LWP%'
										
										AND admin_id='" . $_SESSION['id'] . "'";
                                    $query11 = $conn->query($sql11);

                                    echo "" . $query11->num_rows . ""
                                    ?>

                                </h2>
                                <p class="m-b-0">Present On Today</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="attendance.php?show_date=<?= date('Y-m-d') ?>">
                    <div class="card p-20" style="background-color: #9E3E36">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-user f-s-40"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white">

                                    <?php

                                    $sql12 = "SELECT * FROM attendance WHERE date = '$today' AND 
										(daytype LIKE '%Leave%'
										OR
											daytype  LIKE '%LWP%'
										)
										AND admin_id='" . $_SESSION['id'] . "'";
                                    $query12 = $conn->query($sql12);

                                    echo "" . $query12->num_rows . ""
                                    ?>

                                </h2>
                                <p class="m-b-0">On Leave Today</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border-left:5px solid #17a2b8;">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fa fa-credit-card"></i> Subscription Details
                        </h4>

                        <?php if ($subscription) { ?>
                            <div class="row text-center">

                                <div class="col-md-3">
                                    <h5 class="text-muted">Package</h5>
                                    <h3><?= $subscription['package_name']; ?></h3>
                                </div>

                                <div class="col-md-3">
                                    <h5 class="text-muted">Type</h5>
                                    <span class="badge bg-info">
                                        <?= ucfirst($subscription['subscription_type']); ?>
                                    </span>
                                </div>

                                <div class="col-md-3">
                                    <h5 class="text-muted">Expiry Date</h5>
                                    <h4><?= date('d M Y', strtotime($subscription['subscription_expiry_date'])); ?></h4>
                                </div>

                                <div class="col-md-3">
                                    <h5 class="text-muted">Remaining Days</h5>
                                    <h3 class="<?= ($remainingDays <= 5) ? 'text-danger' : 'text-success'; ?>">
                                        <?= $remainingDays; ?>
                                    </h3>
                                </div>

                            </div>

                            <?php if ($remainingDays <= 5) { ?>
                                <hr>
                                <div class="alert alert-warning text-center">
                                    <strong>⚠ Your subscription is about to expire!</strong><br>
                                    Please renew to continue using services.
                                    <br><br>
                                    <a href="subscriptions.php" class="btn btn-sm btn-warning">
                                        Renew Now
                                    </a>
                                </div>
                            <?php } ?>

                        <?php } else { ?>
                            <div class="alert alert-danger text-center">
                                <strong>No active subscription found!</strong><br>
                                Please choose a package to continue.
                                <br><br>
                                <a href="subscriptions.php" class="btn btn-danger btn-sm">
                                    View Packages
                                </a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <form method="get" action="attendance.php">
                            <input type="date" name="show_date" class="form-control" required onchange="this.form.submit();"><br>
                            <!-- <input type="submit" name="submit" value="Show Attendance" class="btn btn-success"> -->
                        </form>
                    </div>

                </div>
                <!-- /# card -->
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="year-calendar"></div>
                    </div>

                </div>
                <!-- /# card -->
            </div>

        </div>


    </div>
    <!-- End Container fluid  -->


    <?php include("footer.php"); ?>