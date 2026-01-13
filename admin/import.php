<?php     
  include("header.php");
  include("sidebar.php");
  include("connect.php");
?>
<?php 
if(isset($_POST['upload']))
{
  //echo "<pre>"; print_r($_FILES); exit;
  $filename=$_FILES["csv_file"]["tmp_name"];          
  $flag=0;   
  $_SESSION['reply']='danger';   
  
$tmp = explode('.', $_FILES["csv_file"]["name"]);
$extension = end($tmp);
if($extension != 'csv')
{
echo 'Please upload Only CSV file';
}

        function createSalt()
           {
            return '2123293dsj2hu2nikhiljdsd';
           }

if($_FILES["csv_file"]["size"] > 0)
{
  $file = fopen($filename, "r");
  for ($lines = 0; $data = fgetcsv($file,1000,",",'"'); $lines++) {
    if ($lines == 0) continue;
     $letters = '';
        $numbers = '';
        foreach (range('A', 'Z') as $char) {
            $letters .= $char;
        }
        for($i = 0; $i < 10; $i++){
            $numbers .= $i;
        }
        $employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0,5);
        $pin='1234';
        $passw = hash('sha256', $pin);
          $salt = createSalt();
          $pass = hash('sha256', $salt . $passw);
          $leave = $data[7];
        $leavediff = number_format(365 / $leave);
        $dresult = mysqli_query($conn,"SELECT * FROM department WHERE id='".$data[3]."' and delete_status=0 and admin_id='".$_SESSION['id']."'");
        $department= mysqli_fetch_array($dresult);

        $presult = mysqli_query($conn,"SELECT * FROM position WHERE id='".$data[4]."' and admin_id='".$_SESSION['id']."'");
        $position= mysqli_fetch_array($presult);

        $sresult = mysqli_query($conn,"SELECT * FROM schedules WHERE id='".$data[6]."' and admin_id='".$_SESSION['id']."'");
        $schedules= mysqli_fetch_array($sresult);
        if(!empty($department) && !empty($position) && !empty($schedules))
        {
           $sql="INSERT INTO `employees`(`admin_id`, `department_id`, `employee_id`, `pin`, `password`, `firstname`, `lastname`, `gender`, `position_id`, `rate`, `schedule_id`, `allot_leave`, `avail_leave`, `leave_difference`, `sick_allot_leave`, `sick_avail_leave`, `created_on`, `expiry_date`) VALUES ('".$_SESSION['id']."','".$data[3]."','".$employee_id."','".$pin."','".$pass."','".$data[0]."','".$data[1]."','".$data[2]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[7]."','".$leavediff."','".$data[8]."','".$data[8]."','".date('Y-m-d')."','".$_SESSION["expiry_date"]."')"; 
          $sql_insert_cust = mysqli_query($conn,$sql);
           
          if($sql_insert_cust)
          {
            $_SESSION['reply']='success';
            $flag=1;
          }
        }
       

    }
  }
 if($flag==1){
  ?>
  <script type="text/javascript">
      window.location.href = "employeelist.php";
  </script>
<?php
}
}

?>

<!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Import CSV</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Import CSV</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                              <div class="form-validation">
                                <form method="POST" enctype="multipart/form-data"> 
                                <div class="row">
                                <div class="col-md-2">
                                <div class="form-group">
                                  <label>
                                Demo CSV<span class="danger">*</span> : 
                                </label>
                                <a href="demo.csv" class="btn btn-primary"><i class="fa fa-download"></i></a>
                                </div>
                                </div>


                                <div class="col-md-4">
                                <div class="form-group">
                                <input type="file" name="csv_file" class="form-control" accept=".csv" id="image">
                                </div>
                                <p style="color: red">(Please add proper ID for Position , Schedule and Department.)</p>
                                </div>

                                <div class="col-md-2">
                                <div class="form-group">
                                <input type="submit" name="upload" class="btn btn-success" value="Upload">
                                </div>
                                </div>

                                </div> 
                                </form>
                              </div>    
                            </div>
                          </div>
                          <div class="card">
                            <div class="card-body row">
                              <div class="col-md-4">
                                <div class="table-responsive m-t-40">
                                    <table class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th colspan="2" ><center> Department</center></th>
                                          </tr>
                                            <tr>
                                              <th>ID</th>
                                              <th style="text-align: left;">Department Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
                                            $sql = "SELECT * FROM `department` WHERE delete_status=0 and admin_id='".$_SESSION['id']."'";
                                          
                                          $result = $conn->query($sql);
                                          while($row=mysqli_fetch_array($result)){ ?>
                                            <tr>
                                              <td style="color: #000;"><?php echo $row['id']; ?></td>
                                              <td style="text-align: left;"><?php echo $row['department_name']; ?></td>
                                            </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="table-responsive m-t-40">
                                    <table class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th colspan="2" ><center> Position</center></th>
                                          </tr>
                                            <tr>
                                              <th>ID</th>
                                              <th style="text-align: left;">Position Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
                                            $sql = "SELECT * FROM `position` WHERE admin_id='".$_SESSION['id']."'";
                                          
                                          $result = $conn->query($sql);
                                          while($row=mysqli_fetch_array($result)){ ?>
                                            <tr>
                                              <td style="color: #000;"><?php echo $row['id']; ?></td>
                                              <td style="text-align: left;"><?php echo $row['description']; ?></td>
                                            </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="table-responsive m-t-40">
                                    <table class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th colspan="2" ><center> Schedules</center></th>
                                          </tr>
                                            <tr>
                                              <th>ID</th>
                                              <th style="text-align: left;">Schedules</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php 
                                            $sql = "SELECT * FROM `schedules` WHERE admin_id='".$_SESSION['id']."'";
                                          
                                          $result = $conn->query($sql);
                                          while($row=mysqli_fetch_array($result)){ ?>
                                            <tr>
                                              <td style="color: #000;"><?php echo $row['id']; ?></td>
                                              <td style="text-align: left;"><?php echo date('h:i a',strtotime($row['time_in'])).' - '.date('h:i a',strtotime($row['time_out'])); ?></td>
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
                </div>
                <!-- End PAge Content -->
            </div>
        </div>
<?php include("footer.php"); ?>

