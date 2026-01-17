<?php
include('../connect.php');
include("header.php");
include("sidebar.php");

$id = $_GET['id'] ?? 0;

// fetch existing record
$result = mysqli_query($conn, "SELECT * FROM subscription_packages WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Invalid Subscription ID');window.location='subscription_list.php';</script>";
    exit;
}

if (isset($_POST['update'])) {

    // unlimited handling
    $maxEmp  = ($_POST['max_employees'] == '' ? 0 : $_POST['max_employees']);
    $maxDept = ($_POST['max_departments'] == '' ? 0 : $_POST['max_departments']);

    mysqli_query($conn, "
        UPDATE subscription_packages SET
            name = '" . $_POST['name'] . "',
            subscription_type = '" . $_POST['subscription_type'] . "',
            price = '" . $_POST['price'] . "',
            web_check = '" . $_POST['web_check'] . "',
            max_employees = '" . $maxEmp . "',
            max_departments = '" . $maxDept . "',
            mobile_check = '" . $_POST['mobile_check'] . "',
            future_updates = '" . $_POST['future_updates'] . "',
            reports = '" . $_POST['reports'] . "'
        WHERE id = '$id'
    ");

    echo "<script>window.location='subscription_list.php';</script>";
}
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">

                        <h4 class="mb-3">Edit Subscription Package</h4>

                        <form method="post">

                            <!-- PACKAGE NAME -->
                            <div class="form-group">
                                <label>Package Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="<?= $row['name']; ?>" required>
                            </div>

                            <!-- SUBSCRIPTION TYPE -->
                            <div class="form-group">
                                <label>Subscription Type</label>
                                <select name="subscription_type" class="form-control" required>
                                    <option value="monthly" <?= $row['subscription_type'] == 'monthly' ? 'selected' : ''; ?>>
                                        Monthly
                                    </option>
                                    <option value="yearly" <?= $row['subscription_type'] == 'yearly' ? 'selected' : ''; ?>>
                                        Yearly
                                    </option>
                                </select>
                            </div>

                            <!-- PRICE -->
                            <div class="form-group">
                                <label>Price (PKR)</label>
                                <input type="number" step="0.01" min="0" name="price"
                                       class="form-control"
                                       value="<?= $row['price']; ?>" required>
                            </div>

                            <!-- WEB CHECK -->
                            <div class="form-group">
                                <label>Web Check-In / Out</label>
                                <select name="web_check" class="form-control">
                                    <option value="1" <?= $row['web_check'] ? 'selected' : ''; ?>>ON</option>
                                    <option value="0" <?= !$row['web_check'] ? 'selected' : ''; ?>>OFF</option>
                                </select>
                            </div>

                            <!-- MAX EMPLOYEES -->
                            <div class="form-group">
                                <label>Max Employees (Leave empty = Unlimited)</label>
                                <input type="number" name="max_employees" class="form-control"
                                       value="<?= $row['max_employees'] == 0 ? '' : $row['max_employees']; ?>">
                            </div>

                            <!-- MAX DEPARTMENTS -->
                            <div class="form-group">
                                <label>Departments / Locations (Leave empty = Unlimited)</label>
                                <input type="number" name="max_departments" class="form-control"
                                       value="<?= $row['max_departments'] == 0 ? '' : $row['max_departments']; ?>">
                            </div>

                            <!-- MOBILE APP -->
                            <div class="form-group">
                                <label>Mobile App Check-In / Out</label>
                                <select name="mobile_check" class="form-control">
                                    <option value="1" <?= $row['mobile_check'] ? 'selected' : ''; ?>>ON</option>
                                    <option value="0" <?= !$row['mobile_check'] ? 'selected' : ''; ?>>OFF</option>
                                </select>
                            </div>

                            <!-- FUTURE UPDATES -->
                            <div class="form-group">
                                <label>Future Feature Updates</label>
                                <select name="future_updates" class="form-control">
                                    <option value="1" <?= $row['future_updates'] ? 'selected' : ''; ?>>ON</option>
                                    <option value="0" <?= !$row['future_updates'] ? 'selected' : ''; ?>>OFF</option>
                                </select>
                            </div>

                            <!-- REPORTS -->
                            <div class="form-group">
                                <label>Reports Level</label>
                                <select name="reports" class="form-control">
                                    <option value="Basic" <?= $row['reports'] == 'Basic' ? 'selected' : ''; ?>>Basic</option>
                                    <option value="Medium" <?= $row['reports'] == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Advance" <?= $row['reports'] == 'Advance' ? 'selected' : ''; ?>>Advance</option>
                                </select>
                            </div>

                            <button type="submit" name="update" class="btn btn-primary">
                                Update Subscription
                            </button>

                            <a href="subscription_list.php" class="btn btn-secondary">
                                Cancel
                            </a>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
