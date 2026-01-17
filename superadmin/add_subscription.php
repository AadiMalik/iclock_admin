<?php
include('../connect.php');
include("header.php");
include("sidebar.php");

if (isset($_POST['save'])) {

      // unlimited handling
      $maxEmp = ($_POST['max_employees'] == '' ? 0 : $_POST['max_employees']);
      $maxDept = ($_POST['max_departments'] == '' ? 0 : $_POST['max_departments']);

      mysqli_query($conn, "INSERT INTO subscription_packages 
    (name,
        subscription_type,
        price,
     web_check, max_employees, max_departments, mobile_check, future_updates, reports)
    VALUES(
        '" . $_POST['name'] . "',
        '" . $_POST['subscription_type'] . "',
        '" . $_POST['price'] . "',
        '" . $_POST['web_check'] . "',
        '" . $maxEmp . "',
        '" . $maxDept . "',
        '" . $_POST['mobile_check'] . "',
        '" . $_POST['future_updates'] . "',
        '" . $_POST['reports'] . "'
    )");

      echo "<script>window.location='subscription_list.php';</script>";
}
?>

<div class="page-wrapper">
      <div class="container-fluid">
            <div class="row justify-content-center">
                  <div class="col-lg-6">

                        <div class="card">
                              <div class="card-body">

                                    <h4 class="mb-3">Add Subscription Package</h4>

                                    <form method="post">

                                          <!-- PACKAGE NAME -->
                                          <div class="form-group">
                                                <label>Package Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                          </div>
                                          <div class="form-group">
                                                <label>Subscription Type</label>
                                                <select name="subscription_type" class="form-control" required>
                                                      <option value="">-- Select Type --</option>
                                                      <option value="monthly">Monthly</option>
                                                      <option value="yearly">Yearly</option>
                                                </select>
                                          </div>
                                          <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                                          </div>
                                          <!-- WEB CHECK -->
                                          <div class="form-group">
                                                <label>Web Check-In / Out</label>
                                                <select name="web_check" class="form-control">
                                                      <option value="1">ON</option>
                                                      <option value="0">OFF</option>
                                                </select>
                                          </div>

                                          <!-- MAX EMPLOYEES -->
                                          <div class="form-group">
                                                <label>Max Employees (Leave empty = Unlimited)</label>
                                                <input type="number" name="max_employees" class="form-control" min="0">
                                          </div>

                                          <!-- MAX DEPARTMENTS -->
                                          <div class="form-group">
                                                <label>Departments / Locations (Leave empty = Unlimited)</label>
                                                <input type="number" name="max_departments" class="form-control" min="0">
                                          </div>

                                          <!-- MOBILE APP -->
                                          <div class="form-group">
                                                <label>Mobile App Check-In / Out</label>
                                                <select name="mobile_check" class="form-control">
                                                      <option value="1">ON</option>
                                                      <option value="0">OFF</option>
                                                </select>
                                          </div>

                                          <!-- FUTURE UPDATES -->
                                          <div class="form-group">
                                                <label>Future Feature Updates</label>
                                                <select name="future_updates" class="form-control">
                                                      <option value="1">ON</option>
                                                      <option value="0">OFF</option>
                                                </select>
                                          </div>

                                          <!-- REPORTS -->
                                          <div class="form-group">
                                                <label>Reports Level</label>
                                                <select name="reports" class="form-control">
                                                      <option value="Basic">Basic</option>
                                                      <option value="Medium">Medium</option>
                                                      <option value="Advance">Advance</option>
                                                </select>
                                          </div>

                                          <button type="submit" name="save" class="btn btn-primary">
                                                Save Subscription
                                          </button>

                                    </form>

                              </div>
                        </div>

                  </div>
            </div>
      </div>
</div>

<?php include("footer.php"); ?>