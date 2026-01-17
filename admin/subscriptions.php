<?php
include('../connect.php');
include("header.php");
include("sidebar.php");

$admin_id = $_SESSION['id'];

/* current plan */
$admin = mysqli_fetch_assoc(
      mysqli_query($conn, "SELECT subscription_package_id FROM admin WHERE id=$admin_id")
);
$currentPackage = $admin['subscription_package_id'];

/* payment submit */
if (isset($_POST['pay_now'])) {
      $package_id = $_POST['package_id'];
      $amount = $_POST['amount'];

      $img = time() . '_' . $_FILES['payment_proof']['name'];
      move_uploaded_file(
            $_FILES['payment_proof']['tmp_name'],
            'uploaded/payments/' . $img
      );

      mysqli_query($conn, "
        INSERT INTO subscription_payments
        (admin_id, subscription_package_id, amount, payment_method, payment_proof)
        VALUES ($admin_id,$package_id,$amount,'bank_transfer','$img')
    ");

      echo "<script>alert('Payment submitted. Waiting for approval');</script>";
}
?>
<style>
      .pricing-table th {
            background: #f8f9fa;
            font-weight: 600;
      }

      .pricing-table .price {
            font-size: 20px;
            font-weight: 700;
            color: #0d6efd;
      }

      .price-row td {
            background: #f1f7ff;
      }
</style>
<div class="page-wrapper">
      <div class="container-fluid">

            <h4 class="mb-4">Choose Your Subscription Plan</h4>

            <div class="table-responsive">
                  <table class="table table-bordered pricing-table text-center align-middle">
                        <thead class="table-light">
                              <tr>
                                    <th>Features</th>
                                    <?php
                                    $plans = mysqli_query($conn, "SELECT * FROM subscription_packages WHERE status=1 ORDER BY id ASC");
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<th>{$p['name']}</th>";
                                    }
                                    ?>
                              </tr>
                        </thead>

                        <tbody>
                              <!-- Price -->
                              <tr class="price-row">
                                    <td><b>Price</b></td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td class='price'>PKR " . number_format($p['price'], 2) . "</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Web -->
                              <tr>
                                    <td>Web Check-In</td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td>" . ($p['web_check'] ? '✔' : '✖') . "</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Employees -->
                              <tr>
                                    <td>Max Employees</td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td>" . ($p['max_employees'] == 0 ? 'Unlimited' : $p['max_employees']) . "</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Departments -->
                              <tr>
                                    <td>Departments</td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td>" . ($p['max_departments'] == 0 ? 'Unlimited' : $p['max_departments']) . "</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Mobile -->
                              <tr>
                                    <td>Mobile App</td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td>" . ($p['mobile_check'] ? '✔' : '✖') . "</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Reports -->
                              <tr>
                                    <td>Reports</td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          echo "<td>{$p['reports']}</td>";
                                    }
                                    ?>
                              </tr>

                              <!-- Action -->
                              <tr>
                                    <td></td>
                                    <?php
                                    mysqli_data_seek($plans, 0);
                                    while ($p = mysqli_fetch_assoc($plans)) {
                                          if ($p['id'] == $currentPackage) {
                                                echo "<td><span class='badge bg-success'>Current Plan</span></td>";
                                          } else {
                                                echo "
                    <td>
                        <a href='?buy={$p['id']}' class='btn btn-primary btn-sm'>
                            Select
                        </a>
                    </td>";
                                          }
                                    }
                                    ?>
                              </tr>
                        </tbody>
                  </table>
            </div>

            <?php
            /* checkout */
            if (isset($_GET['buy'])) {
                  $pid = $_GET['buy'];
                  $pkg = mysqli_fetch_assoc(
                        mysqli_query($conn, "SELECT * FROM subscription_packages WHERE id=$pid")
                  );
            ?>
                  <div class="card mt-4">
                        <div class="card-body">
                              <h5>Checkout – <?= $pkg['name']; ?></h5>
                              <p><b>Amount:</b> PKR <?= number_format($pkg['price'], 2); ?></p>

                              <p>
                                    <b>Bank:</b> Meezan Bank <br>
                                    <b>Account Title:</b> XYZ Company <br>
                                    <b>Account No:</b> 123456789
                              </p>

                              <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="package_id" value="<?= $pkg['id']; ?>">
                                    <input type="hidden" name="amount" value="<?= $pkg['price']; ?>">

                                    <input type="file" name="payment_proof" required class="form-control mb-2">

                                    <button class="btn btn-success" name="pay_now">
                                          Submit Payment
                                    </button>
                              </form>
                        </div>
                  </div>
            <?php } ?>

      </div>
</div>

<?php include("footer.php"); ?>