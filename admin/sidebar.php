        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        include('../connect.php');

        $admin_id = $_SESSION['id'] ?? 0;

        $hasSubscription = false;

        if ($admin_id > 0) {
            $adminQ = mysqli_query(
                $conn,
                "SELECT subscription_package_id, subscription_expiry_date
         FROM admin
         WHERE id = $admin_id
         LIMIT 1"
            );

            if ($admin = mysqli_fetch_assoc($adminQ)) {
                if (
                    !empty($admin['subscription_package_id']) &&
                    !empty($admin['subscription_expiry_date']) &&
                    $admin['subscription_expiry_date'] >= date('Y-m-d')
                ) {
                    $hasSubscription = true;
                }
            }
        }

        /* 🚨 force redirect if no subscription */
        $currentPage = basename($_SERVER['PHP_SELF']);
        if (!$hasSubscription && $currentPage != 'subscriptions.php') {
            header("Location: subscriptions.php");
            exit;
        }
        ?>
        <?php if (!$hasSubscription) { ?>

            <!-- Left Sidebar -->
            <div class="left-sidebar">
                <div class="scroll-sidebar">
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-label">Subscription Required</li>

                            <li>
                                <a href="subscriptions.php">
                                    <img src="images/f.png" class="adminsiderbar-icon" />
                                    <span class="hide-menu">Subscriptions</span>
                                </a>
                            </li>

                            <li class="mt-3 text-muted px-3">
                                Please activate a subscription to use the system.
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        <?php } else { ?>

            <!-- Left Sidebar  -->
            <div class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">

                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Dashboard</li>
                            <li> <a href="dashboard.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard </span></a>

                            </li>

                            <li class="nav-label">MANAGE</li>
                            <li> <a href="department.php" aria-expanded="false"><img src="images/a.png" class="adminsiderbar-icon" /></i><span class="hide-menu">Departments/ Locations </span></a>
                            </li>

                            <li> <a href="attendance.php" aria-expanded="false"><img src="images/b.png" class="adminsiderbar-icon" /><span class="hide-menu">Attendance </span></a>

                            </li>
                            <li> <a href="https://iclock.mu/admin/admin/employee_attendance_interface.php" aria-expanded="false"><img src="images/c.png" class="adminsiderbar-icon" /><span class="hide-menu">Take Attendance </span></a>

                            </li>
                            <li> <a href="OverallAttendance.php" aria-expanded="false"><img src="images/d.png" class="adminsiderbar-icon" /><span class="hide-menu">Overall Attendance </span></a>
                            </li>
                            <li> <a href="hoursReport.php" aria-expanded="false"><img src="images/e.png" class="adminsiderbar-icon" /><span class="hide-menu">Hrs Report </span></a>
                            </li>

                            <li> <a class="has-arrow" href="#" aria-expanded="false"><img src="images/f.png" class="adminsiderbar-icon" /><span class="hide-menu">Employees</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="position.php">Position</a></li>
                                    <li><a href="schedule.php">Schedules</a></li>
                                    <li><a href="employeelist.php">Employee List</a></li>
                                    <li><a href="track_employee.php">Track Employees</a></li>
                                </ul>
                            </li>

                            <li> <a class="has-arrow" href="#" aria-expanded="false"><img src="images/g.png" class="adminsiderbar-icon" /><span class="hide-menu"> Leave</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="leaves.php">Leave Types</a></li>
                                    <li><a href="addleave.php">Add Leave</a></li>
                                    <li><a href="approvals.php">Leave Approvals</a></li>
                                    <!---   <li><a href="balanceleave.php">Balance Leave</a></li> -->

                                    <li><a href="leave_report.php">Leave Report</a></li>
                                </ul>
                            </li>
                            <li> <a href="subscriptions.php" aria-expanded="false"><img src="images/f.png" class="adminsiderbar-icon" /><span class="hide-menu"> Subscriptions</span></a></li>


                            <!---	<li class="nav-label">PRINTABLE</li>
						
					<li> <a href="payroll.php" aria-expanded="false"><i class="fa fa-files-o"></i><span class="hide-menu">Payroll</span></a>
                        </li>
						
						 <li> <a href="schedule_employee.php" aria-expanded="false"><i class="fa fa-clock-o"></i><span class="hide-menu">Schedule</span></a>
                        </li> -->



                        </ul>


                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </div>
            <!-- End Left Sidebar  -->

        <?php } ?>