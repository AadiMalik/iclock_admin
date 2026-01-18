<?php
include('../connect.php');
include("header.php");
include("sidebar.php");
?>


<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Account List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Account List</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <?php if (isset($_SESSION['reply']) && $_SESSION['reply'] == 'danger') { ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Something Goes Wrong
                    </div>
                <?php unset($_SESSION["reply"]);
                } ?>
                <?php if (isset($_SESSION['reply']) && $_SESSION['reply'] == 'success') { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Operation Performed Successfully
                    </div>
                <?php unset($_SESSION["reply"]);
                } ?>
                <div class="card">
                    <div class="card-body">

                        <a href="addaccount.php" class="btn btn-info btn-flat"><i class="fa fa-plus"></i> New</a>

                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Member Since</th>
                                        <th>Expiry Date</th>
                                        <th>Subscription</th>
                                        <th>Subscription Expiry Date</th>
                                        <th>Subscription Remaining Days</th>
                                        <th>Status</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Photo</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Member Since</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Tools</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sql = "
                                        SELECT 
                                            a.*,
                                            sp.name AS subscription_name,
                                            sp.subscription_type,
                                            sp.price,
                                            a.subscription_expiry_date
                                        FROM admin a
                                        LEFT JOIN subscription_packages sp 
                                            ON sp.id = a.subscription_package_id
                                        WHERE a.delete_status = 0
                                        ";
                                    $result = $conn->query($sql);
                                    while ($row = mysqli_fetch_assoc($result)) {

										$expiry_date = date('M d, Y', strtotime($row['expiry_date']));
                                        $createdDate = date('M d, Y', strtotime($row['created_on']));
                                        $expiryDate  = !empty($row['subscription_expiry_date'])
                                            ? date('M d, Y', strtotime($row['subscription_expiry_date']))
                                            : '-';

                                        // Remaining days
                                        if (!empty($row['subscription_expiry_date'])) {
                                            $today = new DateTime();
                                            $end   = new DateTime($row['subscription_expiry_date']);
                                            $remainingDays = ($today <= $end) ? $today->diff($end)->days : 0;
                                        } else {
                                            $remainingDays = '-';
                                        }

                                        $subscriptionName = $row['subscription_name'] ?? 'No Subscription';
                                    ?>
                                        <tr>
                                            <td>
                                                <img src="<?= (!empty($row['image']))
                                                                ? '../admin/uploaded/' . $row['image']
                                                                : '../admin/uploaded/profile.jpg'; ?>"
                                                    width="30" height="30">
                                            </td>

                                            <td><?= $row['firstname']; ?></td>
                                            <td><?= $row['lastname']; ?></td>
                                            <td><?= $row['username']; ?></td>
                                            <td><?= $createdDate; ?></td>
                                            <td><?= $expiry_date; ?></td>

                                            <td>
                                                <span class="badge badge-info">
                                                    <?= $subscriptionName; ?>
                                                </span>
                                            </td>

                                            <td><?= $expiryDate; ?></td>
                                            <td><?= $remainingDays; ?></td>

                                            <td>
                                                <?php if ($row['status'] == 0) { ?>
                                                    <span class="label label-success">Active</span>
                                                <?php } else { ?>
                                                    <span class="label label-warning">Deactive</span>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <a href="editaccount.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="delete.php?account=<?= $row['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>