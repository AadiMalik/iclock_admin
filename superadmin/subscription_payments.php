<?php
include('../connect.php');
include("header.php");
include("sidebar.php");

/* =======================
   HANDLE STATUS CHANGE
======================= */
if(isset($_GET['action']) && isset($_GET['id'])){
    $payment_id = intval($_GET['id']);
    $status = $_GET['action']; // approved, rejected

    // Update payment table
    mysqli_query($conn,"UPDATE subscription_payments SET status='$status', approved_at=NOW() WHERE id=$payment_id");

    // If approved, update admin table
    if($status=='approved'){
        $payment = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subscription_payments WHERE id=$payment_id"));
        $pkg = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM subscription_packages WHERE id={$payment['subscription_package_id']}"));

        // Calculate expiry date based on package type
        if($pkg['subscription_type']=='monthly'){
            $expiry = date('Y-m-d', strtotime('+1 month'));
        } else { // yearly
            $expiry = date('Y-m-d', strtotime('+1 year'));
        }

        mysqli_query($conn,"
            UPDATE admin
            SET subscription_package_id={$pkg['id']},
                subscription_expiry_date='$expiry'
            WHERE id={$payment['admin_id']}
        ");
    }

    echo "<script>alert('Payment status updated'); window.location='subscription_payments.php';</script>";
}

?>

<div class="page-wrapper">
<div class="container-fluid">

<h4 class="mb-4">Manage Subscription Payments</h4>

<div class="table-responsive">
<table class="table table-bordered table-striped text-center align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Company Name</th>
            <th>Package</th>
            <th>Amount</th>
            <th>Proof</th>
            <th>Status</th>
            <th>Submitted At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $q = mysqli_query($conn,"
            SELECT sp.*, a.firstname, a.lastname, p.name as package_name, p.subscription_type
            FROM subscription_payments sp
            JOIN admin a ON a.id = sp.admin_id
            JOIN subscription_packages p ON p.id = sp.subscription_package_id
            ORDER BY sp.id DESC
        ");
        $i=1;
        while($row = mysqli_fetch_assoc($q)){
        ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $row['firstname'].' '.$row['lastname']; ?></td>
            <td><?= $row['package_name']; ?></td>
            <td><?= number_format($row['amount'],2); ?></td>
            <td>
                <?php
                $proofPath = '../admin/uploaded/payments/'.$row['payment_proof'];
                if($row['payment_proof'] && file_exists($proofPath)){
                    echo "<a href='$proofPath' target='_blank'>View</a>";
                } else { echo 'No file'; }
                ?>
            </td>
            <td>
                <?php
                $badge='secondary';
                if($row['status']=='pending') $badge='warning';
                if($row['status']=='approved') $badge='success';
                if($row['status']=='rejected') $badge='danger';
                ?>
                <span class="badge bg-<?= $badge; ?>"><?= ucfirst($row['status']); ?></span>
            </td>
            <td><?= $row['created_at']; ?></td>
            <td>
                <?php if($row['status']=='pending'){ ?>
                <a href="subscription_payments.php?id=<?= $row['id']; ?>&action=approved" class="btn btn-success btn-sm">Approve</a>
                <?php } ?>
                <?php if($row['status']=='pending'){ ?>
                <a href="subscription_payments.php?id=<?= $row['id']; ?>&action=rejected" class="btn btn-danger btn-sm">Reject</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

</div>
</div>

<?php include("footer.php"); ?>
