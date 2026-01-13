<?php
include("header.php");
include("sidebar.php");
include('../connect.php');

if (isset($_POST["update"])) {
    function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $array = array();
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }
        // Return the array elements
        return $array;
    }
    if ($_POST["status"] == 1) {
        $slwp = "SELECT * FROM leave_application WHERE id='" . $_GET['change'] . "'";
        $qlwp = mysqli_query($conn, $slwp);
        $row = mysqli_fetch_assoc($qlwp);
        if (empty($row)) {
            ?>
            <script>
                alert('Record Not Found');
                window.location = "approvals.php";
            </script>
            <?php
        }
        $res_date = getDatesFromRange($row['from_date'], $row['to_date']);
        $period = new DatePeriod(new DateTime($row['from_date']), new DateInterval('P1D'), new DateTime($row['to_date']));
        $leave_type = $row['leave_type'];
        $day = $row['leavetype_status'];
        $sql = "SELECT * FROM employees WHERE eid = '" . $row['employee_id'] . "'";
        $query = $conn->query($sql);
        $row1 = $query->fetch_assoc();
        $eid = $row1['eid'];
        $department_id = $row1['department_id'];
        $allot_leave = $row1['allot_leave'];
        $avail_leave = $row1['avail_leave'];
        $leave_diff = $row1['leave_difference'];
        $employee = $row1['employee_id'];
        $sick_avail_leave = $row1['sick_avail_leave'];
        $emp_vacation_leaves = $row1['vacation_leaves'];
        $emp_maternity_leaves = $row1['maternity_leaves'];
        $emp_paternity_leaves = $row1['paternity_leaves'];
        $emp_off_leaves = $row1['off_leaves'];
        $emp_absence_leaves = $row1['absence_leaves'];
        $amt = $row1['rate'];

        if ($leave_type != 'half_day') {
            if ($leave_type != 'Sick Leave') {
//                $sql2 = "SELECT * FROM admin WHERE id='" . $_SESSION['id'] . "' AND name='" . $leave_type . "' AND delete_status=0";
                $sql2 = "SELECT * FROM admin WHERE id='" . $_SESSION['id'] . "' AND delete_status=0";

                $query2 = $conn->query($sql2);
                $row2 = $query2->fetch_assoc();
                $avail_leave_type = $row2['leave_type'];
                $sql3 = "SELECT count(*) as cnt FROM attendance WHERE employee_id='" . $_POST['employee_id'] . "' AND YEAR(date)='" . date('Y') . "' ";
                $query3 = $conn->query($sql3);
                $row3 = $query3->fetch_assoc();
                $emp_count = $row3['cnt'];
                if ($emp_count == 0) {
                    if ($avail_leave_type < count($res_date)) {
                        $lwp_leave = count($res_date) - $avail_leave_type;
                        $lp_leave = $avail_leave_type;

                    } else {
                        $lp_leave = $avail_leave_type - count($res_date);
                    }
                } else {
                    if ($emp_count < count($res_date)) {
                        $lwp_leave = count($res_date) - $emp_count;
                        $lp_leave = $avail_leave_type - $emp_count;
                    } else {
                        $lp_leave = $emp_count - count($res_date);
                    }
                }
            } else {
                if ($sick_avail_leave >= count($res_date)) {
                    $lwp_leave = count($res_date) - $sick_avail_leave;
                    $lp_leave = $sick_avail_leave;
                    $s1 = "UPDATE employees SET sick_avail_leave='0' WHERE employee_id = '" . $employee . "'";
                    $q1 = mysqli_query($conn, $s1);
                } else {
                    $lp_leave = $sick_avail_leave - count($res_date);
                    $s1 = "UPDATE employees SET sick_avail_leave='" . $lp_leave . "' WHERE employee_id = '" . $employee . "'";
                    $q1 = mysqli_query($conn, $s1);
                }
            }
            $i = 1;
            foreach ($res_date as $value) {
                $sq1 = "INSERT INTO attendance(admin_id,department_id,employee_id,date,status,daytype) VALUES ('" . $_SESSION['id'] . "','$department_id','$eid','$value','" . $day . "','$leave_type')";
                $qu1 = mysqli_query($conn, $sq1);
                if ($i > $lp_leave) {
                    $sd = "INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','" . $employee . "','$value','$day','$amt')";
                    $qd = mysqli_query($conn, $sd);
                }
                $i++;
            }
        } else {
            $leave_date = $date = $from_date;
            $sql = "SELECT * FROM emp_leave WHERE employee = '" . $employee . "'";
            $query = $conn->query($sql);
            if ($query->num_rows < 1) {
                $sq = "INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','" . $employee . "','$leave_date','" . $day . "')";
                $qu = mysqli_query($conn, $sq);
                $avail_leave = $allot_leave - $day;
                $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '" . $employee . "'";
                $q1 = mysqli_query($conn, $s1);
            } else {
                $sql = "SELECT * FROM emp_leave WHERE employee = '" . $employee . "'";
                $query = $conn->query($sql);
                if ($query->num_rows < 1) {
                    $sq = "INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','" . $employee . "','$value','$day')";
                    $qu = mysqli_query($conn, $sq);
                    $avail_leave = $allot_leave - $day;
                    $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '" . $employee . "'";
                    $q1 = mysqli_query($conn, $s1);
                } else {
                    $sql1 = "SELECT employee, max(date) as dt FROM emp_leave WHERE employee = '" . $employee . "'GROUP BY employee ";
                    $query1 = mysqli_query($conn, $sql1);
                    if ($query1->num_rows < 1) {
                        echo 'record not found';
                        exit;
                    } else {
                        $rows = mysqli_fetch_assoc($query1);
                        $emp = $rows['employee'];
                        $lastdate = $rows['dt'];
                        $pickupDate = new DateTime($lastdate);
                        $returnDate = new DateTime($date);
                        $interval = $pickupDate->diff($returnDate);
                        $days = $interval->format('%a');
                        if ($days >= $leave_diff) {
                            $s = "INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','$emp','$date','$day')";
                            $q = mysqli_query($conn, $s);
                            $avail_leave = $avail_leave - $day;
                            $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '" . $employee . "'";
                            $q1 = mysqli_query($conn, $s1);
                        } else {
                            $seq = "SELECT * FROM employees WHERE employee_id = '$emp'";
                            $qs = $conn->query($seq);
                            $r = $qs->fetch_assoc();
                            $e = $r['eid'];
                            $rate = $r['rate'];
                            $amt = $rate / 2;
                            $sd = "INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','" . $employee . "','$date','$day','$amt')";
                            $qd = mysqli_query($conn, $sd);
                        }
                    }
                }
            }
        }
        $s1 = "UPDATE leave_application SET status=1,comment='" . $_POST['comment'] . "' WHERE id = '" . $_GET['change'] . "'";
        if (mysqli_query($conn, $s1)) {
            $s2 = "UPDATE half_attendance SET approve_status=1 WHERE leave_app_id = '" . $_GET['change'] . "'";
            mysqli_query($conn, $s2);
            ?>
            <script>
                alert('Approved Successfully');
                window.location = "approvals.php";
            </script>
            <?php
        }
    }
    if ($_POST["status"] == 2) {
        $s1 = "UPDATE leave_application SET status=2,comment='" . $_POST['comment'] . "' WHERE id = '" . $_GET['change'] . "'";
        mysqli_query($conn, $s1);
        ?>
        <script>
            alert('Approval Decline');
            window.location = "approvals.php";
        </script>
        <?php
    }
}
?>
<?php
$change = $_GET['change'];
$sql2 = "SELECT * FROM leave_application WHERE id='$change'";
$result2 = mysqli_query($conn, $sql2);
if (mysqli_num_rows($result2) > 0) {
?>
<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Change Status</h3></div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Change Status</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?php if (isset($_SESSION['reply']) && $_SESSION['reply'] == 'danger') { ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        Something Goes Wrong <?php if (isset($errMSG)) {
                            echo $errMSG;
                        } ?>
                    </div>
                    <?php unset($_SESSION["reply"]);
                } ?>
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Status</label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="1">Accept</option>
                                            <option value="2">Decline</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Comment </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-firstname" name="comment" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->
    <?php include("footer.php"); ?>
