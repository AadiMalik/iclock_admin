<?php
include('../connect.php');
include("header.php");
include("sidebar.php");
?>

<div class="page-wrapper">
      <div class="container-fluid">

            <div class="card">
                  <div class="card-body">

                        <h4 class="mb-3">Subscription Packages</h4>

                        <a href="add_subscription.php" class="btn btn-info btn-sm mb-3">
                              <i class="fa fa-plus"></i> Add New
                        </a>

                        <div class="table-responsive">
                              <table class="table table-bordered table-striped">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Web</th>
                                                <th>Employees</th>
                                                <th>Departments</th>
                                                <th>Mobile</th>
                                                <th>Updates</th>
                                                <th>Reports</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                          $q = mysqli_query($conn, "SELECT * FROM subscription_packages ORDER BY id DESC");
                                          while ($row = mysqli_fetch_assoc($q)) {
                                          ?>
                                                <tr>
                                                      <td><?= $row['name']; ?></td>

                                                      <td>
                                                            <?php if ($row['subscription_type'] == 'monthly') { ?>
                                                                  <span class="badge bg-info">Monthly</span>
                                                            <?php } else { ?>
                                                                  <span class="badge bg-success">Yearly</span>
                                                            <?php } ?>
                                                      </td>

                                                      <td>
                                                            <?= number_format($row['price'], 2); ?>
                                                      </td>

                                                      <td><?= $row['web_check'] ? 'ON' : 'OFF'; ?></td>
                                                      <td><?= $row['max_employees'] == 0 ? 'Unlimited' : $row['max_employees']; ?></td>
                                                      <td><?= $row['max_departments'] == 0 ? 'Unlimited' : $row['max_departments']; ?></td>
                                                      <td><?= $row['mobile_check'] ? 'ON' : 'OFF'; ?></td>
                                                      <td><?= $row['future_updates'] ? 'ON' : 'OFF'; ?></td>
                                                      <td><?= $row['reports']; ?></td>
                                                      <td>
                                                            <?php if ($row['status'] == 1) { ?>
                                                                  <span class="badge bg-success">Active</span>
                                                            <?php } else { ?>
                                                                  <span class="badge bg-danger">Deactive</span>
                                                            <?php } ?>
                                                      </td>

                                                      <!-- ACTION -->
                                                      <td>
                                                            <a href="edit_subscription.php?id=<?= $row['id']; ?>"
                                                                  class="btn btn-sm btn-primary">
                                                                  <i class="fa fa-edit"></i>
                                                            </a>

                                                            <?php if ($row['status'] == 1) { ?>
                                                                  <a href="subscription_status.php?id=<?= $row['id']; ?>&status=0"
                                                                        class="btn btn-sm btn-warning"
                                                                        onclick="return confirm('Deactivate this subscription?');">
                                                                        <i class="fa fa-ban"></i>
                                                                  </a>
                                                            <?php } else { ?>
                                                                  <a href="subscription_status.php?id=<?= $row['id']; ?>&status=1"
                                                                        class="btn btn-sm btn-success"
                                                                        onclick="return confirm('Activate this subscription?');">
                                                                        <i class="fa fa-check"></i>
                                                                  </a>
                                                            <?php } ?>
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

<?php include("footer.php"); ?>