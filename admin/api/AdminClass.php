
<?php
//namespace API;
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include('../connect.php');


class AdminClass
{
      function __construct() {}

      // Admin login
      public function login()
      {

            global $conn;

            if (isset($_REQUEST['username']) && isset($_REQUEST['password']) && $_REQUEST['username'] != '' && $_REQUEST['password'] != '') {
                  $username = $_REQUEST['username'];
                  $passw = hash('sha256', $_REQUEST['password']);
                  $salt = $this->createSalt();
                  $password = hash('sha256', $salt . $passw);
                  $sql = "SELECT * FROM  `admin` WHERE username='$username' AND password='$password' AND delete_status=0 AND status=0 limit 1";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  if (!empty($row)) {
                        if ($row['expiry_date'] >= date('Y-m-d')) {
                              return  json_encode([
                                    'success' => true,
                                    'data' => $row,
                                    'message' => "Admin retrieved successfully."
                              ]);
                        } else {
                              return json_encode([
                                    'success' => false,
                                    'data' => [],
                                    'message' => "Admin not active."
                              ]);
                        }
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => "Admin not found."
                        ]);
                  }
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Username and password is required."
                  ]);
            }
      }
      // Department List
      public function department_list()
      {
            global $conn;

            if (isset($_REQUEST['admin_id']) && $_REQUEST['admin_id'] != '') {
                  $admin_id = $_REQUEST['admin_id'];
                  $sql = "SELECT * FROM department WHERE admin_id = '$admin_id' AND delete_status=0 AND status=0";
                  $result = $conn->query($sql);
                  $departments = [];
                  if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { // Fetch all rows
                              $departments[] = $row;
                        }
                        return  json_encode([
                              'success' => true,
                              'data' => $departments,
                              'message' => "Departments retrieved successfully."
                        ]);
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => $departments,
                              'message' => "Department not found."
                        ]);
                  }
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin ID is required."
                  ]);
            }
      }
      // Get Department By ID
      public function department_by_id()
      {
            global $conn;

            if (isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id'] != '') {
                  $department_id = $_REQUEST['department_id'];
                  $admin_id = $_REQUEST['admin_id'];
                  $sql = "SELECT * FROM department WHERE id = '$department_id' AND admin_id = '$admin_id' AND delete_status=0 AND status=0 limit 1";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  if (!empty($row)) {
                        return  json_encode([
                              'success' => true,
                              'data' => $row,
                              'message' => "Department retrieved successfully."
                        ]);
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => "Department not found."
                        ]);
                  }
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Department id and admin id is required."
                  ]);
            }
      }
      // Save Department
      public function department_save()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required.",
                  'username' => "Username is required.",
                  'department_name' => "Department Name is required.",
                  'password' => "Password is required.",
                  'email' => "Email is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            if (!isset($_REQUEST['department_id']) || $_REQUEST['department_id'] == '') {
                  $department_id = $_REQUEST['department_id'];
                  $admin_id = $_REQUEST['admin_id'];
                  $username = $_REQUEST['username'];
                  $department_name = $_REQUEST['department_name'];
                  $valid_pass = $_REQUEST['password'];
                  $email = $_REQUEST['email'];
                  $firstname = $_REQUEST['firstname'];
                  $lastname = $_REQUEST['lastname'];
                  $departmentimage = 'default.png';

                  $passw = hash('sha256', $_REQUEST['password']);

                  $salt = $this->createSalt();
                  $password = hash('sha256', $salt . $passw);

                  $sql2 = "SELECT * FROM admin WHERE id='" . $_REQUEST['admin_id'] . "' ";
                  $result2 = mysqli_query($conn, $sql2);
                  $rows = mysqli_fetch_assoc($result2);

                  $sql = "INSERT INTO `department`(`username`, `password`, `firstname`, `lastname`, `image`, `created_on`, `expiry_date`, `status`,`admin_id`,`department_name`,`valid_pass`,`email`) 
                  VALUES ('" . $username . "','" . $password . "','" . $firstname . "','" . $lastname . "','" . $departmentimage . "','" . date('Y-m-d') . "','" . $rows['expiry_date'] . "','" . $rows['status'] . "','" . $admin_id . "','" . $department_name . "','" . $valid_pass . "','" . $email . "')";
                  if (mysqli_query($conn, $sql)) {
                        $last_id = mysqli_insert_id($conn);
                        $sql_get = "SELECT * FROM `department` WHERE id='$last_id' LIMIT 1";
                        $result = $conn->query($sql_get);
                        $row = $result->fetch_assoc();
                        return  json_encode([
                              'success' => true,
                              'data' => $row,
                              'message' => "Department save successfully."
                        ]);
                  } else {
                        return  json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $conn->error
                        ]);
                  }
            } else {
                  if (!isset($_REQUEST['department_id']) || $_REQUEST['department_id'] == '') {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => "Department Id is required."
                        ]);
                  }
                  $department_id = $_REQUEST['department_id'];
                  $admin_id = $_REQUEST['admin_id'];
                  $email = $_REQUEST['email'];
                  $username = $_REQUEST['username'];
                  $firstname = $_REQUEST['firstname'];
                  $lastname = $_REQUEST['lastname'];
                  $valid_pass = $_REQUEST['password'];
                  $department_name = $_REQUEST['department_name'];
                  $departmentimage = 'default.png';

                  $passw = hash('sha256', $_REQUEST['password']);


                  $salt = $this->createSalt();
                  $password = hash('sha256', $salt . $passw);

                  $sql = "UPDATE `department` SET `username`='$username',`department_name`='$department_name',`password`='$password',`email`='$email',`valid_pass`='$valid_pass',`firstname`='$firstname',`lastname`='$lastname',`image`='$departmentimage' WHERE admin_id='$admin_id' AND id='$department_id'";
                  if (mysqli_query($conn, $sql)) {
                        $sql_get = "SELECT * FROM `department` WHERE id='$department_id' LIMIT 1";
                        $result = $conn->query($sql_get);
                        $row = $result->fetch_assoc();
                        return  json_encode([
                              'success' => true,
                              'data' => $row,
                              'message' => "Department updated successfully."
                        ]);
                  } else {
                        return  json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $conn->error
                        ]);
                  }
            }
      }

      // Status Department
      public function department_status()
      {
            global $conn;

            if (!isset($_REQUEST['department_id']) || $_REQUEST['department_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Department id is required."
                  ]);
            }
            if (!isset($_REQUEST['admin_id']) || $_REQUEST['admin_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin id is required."
                  ]);
            }
            if (!isset($_REQUEST['status']) || $_REQUEST['status'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Status is required."
                  ]);
            }
            $department_id = $_REQUEST['department_id'];
            $admin_id = $_REQUEST['admin_id'];
            $status = $_REQUEST['status'];

            $sql = "UPDATE `department` SET `status`='$status' WHERE admin_id='$admin_id' AND id='$department_id'";
            if (mysqli_query($conn, $sql)) {
                  $sql_get = "SELECT * FROM `department` WHERE id='$department_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Department status updated successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      // Delete Department
      public function department_delete()
      {
            global $conn;

            if (!isset($_REQUEST['department_id']) || $_REQUEST['department_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Department id is required."
                  ]);
            }
            if (!isset($_REQUEST['admin_id']) || $_REQUEST['admin_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin id is required."
                  ]);
            }
            // if (!isset($_REQUEST['delete_status']) || $_REQUEST['delete_status'] == '') {
            //       return json_encode([
            //             'success' => false,
            //             'data' => [],
            //             'message' => "Delete Status is required."
            //       ]);
            // }
            $department_id = $_REQUEST['department_id'];
            $admin_id = $_REQUEST['admin_id'];
            // $delete_status = $_REQUEST['delete_status'];

            $sql = "UPDATE `department` SET `delete_status`=1 WHERE admin_id='$admin_id' AND id='$department_id'";
            if (mysqli_query($conn, $sql)) {
                  $sql_get = "SELECT * FROM `department` WHERE id='$department_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Department deleted successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      /////////////////////////// Employees ////////////////////////

      //employee list
      public function employee_list()
      {
            global $conn;
            if (!isset($_REQUEST['admin_id']) || $_REQUEST['admin_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin id is required."
                  ]);
            }
            if (isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '') {
                  $department_id = $_REQUEST['department_id'];
                  $department = " AND department_id='$department_id'";
            } else {
                  $department = "";
            }
            $admin_id = $_REQUEST['admin_id'];
            $sql = "SELECT * FROM employees WHERE admin_id = '$admin_id' AND isActive=0 AND status=0 $department";
            $result = $conn->query($sql);
            $employees = [];
            if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { // Fetch all rows
                        $employees[] = $row;
                  }
                  return  json_encode([
                        'success' => true,
                        'data' => $employees,
                        'message' => "Employees retrieved successfully."
                  ]);
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => $employees,
                        'message' => "Data not found."
                  ]);
            }
      }

      //employee by id
      public function employee_by_id()
      {
            global $conn;

            if (isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != '' && isset($_REQUEST['admin_id']) && $_REQUEST['admin_id'] != '') {
                  $employee_id = $_REQUEST['employee_id'];
                  $admin_id = $_REQUEST['admin_id'];
                  $sql = "SELECT * FROM employees WHERE eid = '$employee_id' AND admin_id = '$admin_id' AND isActive=0 AND status=0 limit 1";
                  $result = $conn->query($sql);
                  $row = $result->fetch_assoc();
                  if (!empty($row)) {
                        return  json_encode([
                              'success' => true,
                              'data' => $row,
                              'message' => "Employee retrieved successfully."
                        ]);
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => "Data not found."
                        ]);
                  }
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Employee id and admin id is required."
                  ]);
            }
      }
      //employee save
      public function employee_save()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required.",
                  'department_id' => "Department ID is required.",
                  'firstname' => "First name is required.",
                  'lastname' => "Last name is required.",
                  'email' => "Email is required.",
                  'address' => "Address is required.",
                  'gender' => "Gender is required.",
                  'position_id' => "Position ID is required.",
                  'rate' => "Rate is required.",
                  'schedule_id' => "Schedule ID is required.",
                  'allot_leave' => "Allotted leave is required.",
                  'sick_allot_leave' => "Sick allotted leave is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_POST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            if (!isset($_FILES['image']) || $_FILES['image'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Image is required!'
                  ]);
            }
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $birthdate = isset($_POST['date']) ? $_POST['date'] : null;
            $contact = isset($_POST['phone']) ? $_POST['phone'] : null;;
            $gender = $_POST['gender'];
            $position = $_POST['position_id'];
            $rate = $_POST['rate'];
            $schedule = $_POST['schedule_id'];
            $admin_id = $_POST['admin_id'];
            $department_id = $_POST['department_id'];
            $leave = $_POST['allot_leave'];
            $leavediff = number_format(365 / $leave);
            $sick_allot_leave = $_POST['sick_allot_leave'];
            $imgFile = $_FILES['image']['name'];
            $tmp_dir = $_FILES['image']['tmp_name'];
            $imgSize = $_FILES['image']['size'];
            if (empty($imgFile)) {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Please Select Image File.'
                  ]);
            } else {
                  $upload_dir = '../uploaded/employee/';
                  $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
                  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                  $image = rand(1000, 1000000) . "." . $imgExt;
                  if (in_array($imgExt, $valid_extensions)) {
                        if ($imgSize < 5000000) {

                              move_uploaded_file($tmp_dir, $upload_dir . $image);
                        } else {
                              return json_encode([
                                    'success' => false,
                                    'data' => [],
                                    'message' => 'Sorry, Your File Is Too Large To Upload. It Should Be Less Than 5MB.'
                              ]);
                        }
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => 'Sorry, only JPG, JPEG, PNG & GIF Extension Files Are Allowed.'
                        ]);
                  }
            }
            $letters = '';
            $numbers = '';
            foreach (range('A', 'Z') as $char) {
                  $letters .= $char;
            }
            for ($i = 0; $i < 10; $i++) {
                  $numbers .= $i;
            }
            $employee_id = substr(str_shuffle($letters), 0, 3) . substr(str_shuffle($numbers), 0, 5);
            $pin = '1234';
            $passw = hash('sha256', $pin);
            $salt = $this->createSalt();
            $pass = hash('sha256', $salt . $passw);

            $admin_sql = "SELECT * FROM  `admin` WHERE id='$admin_id' AND delete_status=0 AND status=0 limit 1";
            $admin_result = $conn->query($admin_sql);
            $admin_data = $admin_result->fetch_assoc();

            $sql = "INSERT INTO employees (admin_id, employee_id,password, firstname, lastname,email, address, birthdate, contact_info, gender, position_id, rate, schedule_id, allot_leave, avail_leave, leave_difference,sick_allot_leave,sick_avail_leave, image, created_on,expiry_date,department_id,pin) 
                  VALUES ('$admin_id','$employee_id','$pass', '$firstname', '$lastname', '$email', '$address', '$birthdate', '$contact', '$gender', '$position', '$rate', '$schedule', '$leave','$leave' ,'$leavediff','$sick_allot_leave','$sick_allot_leave', '$image', NOW(),'" . $admin_data["expiry_date"] . "','$department_id','$pin')";

            if (mysqli_query($conn, $sql)) {
                  $last_id = mysqli_insert_id($conn);
                  $sql_get = "SELECT * FROM `employees` WHERE eid='$last_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Employee save successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      //employee update
      public function employee_update()
      {
            global $conn;
            $required_fields = [
                  'employee_id' => "Admin ID is required.",
                  'admin_id' => "Admin ID is required.",
                  'department_id' => "Department ID is required.",
                  'firstname' => "First name is required.",
                  'lastname' => "Last name is required.",
                  'email' => "Email is required.",
                  'address' => "Address is required.",
                  'gender' => "Gender is required.",
                  'position_id' => "Position ID is required.",
                  'rate' => "Rate is required.",
                  'schedule_id' => "Schedule ID is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_POST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            if (!isset($_FILES['image']) || $_FILES['image'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Image is required!'
                  ]);
            }
            $employee_id = $_POST['employee_id'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $birthdate = isset($_POST['date']) ? $_POST['date'] : null;
            $contact = isset($_POST['phone']) ? $_POST['phone'] : null;;
            $gender = $_POST['gender'];
            $position = $_POST['position_id'];
            $rate = $_POST['rate'];
            $schedule = $_POST['schedule_id'];
            $admin_id = $_POST['admin_id'];
            $department_id = $_POST['department_id'];
            $is_active = $_POST['is_active'];
            $imgFile = $_FILES['image']['name'];
            $tmp_dir = $_FILES['image']['tmp_name'];
            $imgSize = $_FILES['image']['size'];
            if (empty($imgFile)) {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Please Select Image File.'
                  ]);
            } else {
                  $upload_dir = '../uploaded/employee/';
                  $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
                  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                  $image = rand(1000, 1000000) . "." . $imgExt;
                  if (in_array($imgExt, $valid_extensions)) {
                        if ($imgSize < 5000000) {

                              move_uploaded_file($tmp_dir, $upload_dir . $image);
                        } else {
                              return json_encode([
                                    'success' => false,
                                    'data' => [],
                                    'message' => 'Sorry, Your File Is Too Large To Upload. It Should Be Less Than 5MB.'
                              ]);
                        }
                  } else {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => 'Sorry, only JPG, JPEG, PNG & GIF Extension Files Are Allowed.'
                        ]);
                  }
            }


            $admin_sql = "SELECT * FROM  `admin` WHERE id='$admin_id' AND delete_status=0 AND status=0 limit 1";
            $admin_result = $conn->query($admin_sql);
            $admin_data = $admin_result->fetch_assoc();

            if ($_POST['password'] != '') {
                  $passw1 = $_POST['password'];
                  $passw = hash('sha256', $passw1);
                  $salt = $this->createSalt();
                  $pass = hash('sha256', $salt . $passw);
                  $pin = $_POST['password'];
                  $updated = "UPDATE employees SET isActive='$is_active',
                firstname='$firstname',lastname='$lastname',address='$address',birthdate='$birthdate',contact_info='$contact',gender='$gender',position_id='$position',rate='$rate',schedule_id='$schedule',image='$image',department_id='$department_id',password='$pass',pin='$pin',expiry_date='" . $admin_data["expiry_date"] . "',email='$email' WHERE eid='$employee_id'";
            } else {
                  $updated = "UPDATE employees SET isActive='$is_active',
                firstname='$firstname',lastname='$lastname',address='$address',birthdate='$birthdate',contact_info='$contact',gender='$gender',position_id='$position',rate='$rate',schedule_id='$schedule',image='$image',department_id='$department_id',expiry_date='" . $admin_data["expiry_date"] . "',email='$email' WHERE eid='$employee_id'";
            }

            if (mysqli_query($conn, $updated)) {
                  $sql_get = "SELECT * FROM `employees` WHERE eid='$employee_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Employee updated successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      // employee delete
      public function employee_delete()
      {
            global $conn;

            if (!isset($_REQUEST['employee_id']) || $_REQUEST['employee_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Employee id is required."
                  ]);
            }
            if (!isset($_REQUEST['admin_id']) || $_REQUEST['admin_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin id is required."
                  ]);
            }
            $employee_id = $_REQUEST['employee_id'];
            $admin_id = $_REQUEST['admin_id'];

            $sql = "UPDATE `employees` SET `isActive`=1 WHERE admin_id='$admin_id' AND eid='$employee_id'";
            if (mysqli_query($conn, $sql)) {
                  $sql_get = "SELECT * FROM `employees` WHERE eid='$employee_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Employee deleted successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      ////////////////////////// Attendance ////////////////////////////////

      // attendance list
      public function attendance_list()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $department = "";
            $employee = "";
            if (isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '') {
                  $department_id = $_REQUEST['department_id'];
                  $department = " AND attendance.department_id='$department_id'";
            }
            if (isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != '') {
                  $employee_id = $_REQUEST['employee_id'];
                  $employee = " AND attendance.employee_id='$employee_id'";
            }
            $admin_id = $_REQUEST['admin_id'];
            $sql = "SELECT attendance.*,department.department_name,employees.employee_id AS employee FROM attendance
            JOIN department ON attendance.department_id = department.id
            JOIN employees ON attendance.employee_id = employees.eid
             WHERE attendance.admin_id = '$admin_id' $department $employee";
            $result = $conn->query($sql);
            $attendance = [];
            if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { // Fetch all rows
                        $attendance[] = $row;
                  }
                  return  json_encode([
                        'success' => true,
                        'data' => $attendance,
                        'message' => "Attendance retrieved successfully."
                  ]);
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => $attendance,
                        'message' => "Data not found."
                  ]);
            }
      }

      ////////////////////////// Leave Type ////////////////////////

    // leave type list
      public function leave_type_list()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $admin_id = $_REQUEST['admin_id'];
            $sql = "SELECT * FROM leave_type
             WHERE admin_id = '$admin_id' AND delete_status = 0";
            $result = $conn->query($sql);
            $leave_application = [];
            if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { // Fetch all rows
                        $leave_application[] = $row;
                  }
                  return  json_encode([
                        'success' => true,
                        'data' => $leave_application,
                        'message' => "Leave Type retrieved successfully."
                  ]);
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => $leave_application,
                        'message' => "Data not found."
                  ]);
            }
      }
      //leave type save
      public function leave_type_save()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required.",
                  'name' => "Leave Type Name is required.",
                  'no_of_days' => "No. of Days is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_POST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $admin_id = $_POST['admin_id'];
            $name = $_POST['name'];
            $no_of_days = $_POST['no_of_days'];
            

            $sql = "INSERT INTO leave_type (admin_id, name,no_of_days, delete_status) 
                  VALUES ('$admin_id','$name','$no_of_days',0 )";

            if (mysqli_query($conn, $sql)) {
                  $last_id = mysqli_insert_id($conn);
                  $sql_get = "SELECT * FROM `leave_type` WHERE id='$last_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Leave type save successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }
      //leave type update
      public function leave_type_update()
      {
          
            global $conn;
            $required_fields = [
                  'leave_type_id' => "Leave Type ID is required.",
                  'admin_id' => "Admin ID is required.",
                  'name' => "Leave Type Name is required.",
                  'no_of_days' => "No. of Days is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_POST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $leave_type_id = $_POST['leave_type_id'];
            $admin_id = $_POST['admin_id'];
            $name = $_POST['name'];
            $no_of_days = $_POST['no_of_days'];
            
            $updated = "UPDATE leave_type SET name='$name',admin_id='$admin_id',
                no_of_days='$no_of_days' WHERE id='$leave_type_id'";
            
            if (mysqli_query($conn, $updated)) {
                  $sql_get = "SELECT * FROM `leave_type` WHERE id='$leave_type_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Leave type updated successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }
      
      // leave type delete
      public function leave_type_delete()
      {
            global $conn;

            if (!isset($_REQUEST['leave_type_id']) || $_REQUEST['leave_type_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Leave type id is required."
                  ]);
            }
            if (!isset($_REQUEST['admin_id']) || $_REQUEST['admin_id'] == '') {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Admin id is required."
                  ]);
            }
            $leave_type_id = $_REQUEST['leave_type_id'];
            $admin_id = $_REQUEST['admin_id'];

            $sql = "UPDATE `leave_type` SET `delete_status`=1 WHERE admin_id='$admin_id' AND id='$leave_type_id'";
            if (mysqli_query($conn, $sql)) {
                  $sql_get = "SELECT * FROM `leave_type` WHERE id='$leave_type_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Leave type deleted successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }
      
      ////////////////////////// Leave Application ////////////////////////
      // leave application list
      public function leave_application_list()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required.",
                  'start_date' => "Start Date is required.",
                  'end_date' => "End Date is required.",
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $start_date = date('Y-m-d', strtotime($_REQUEST['start_date'] ?? date('Y-m-d')));
            $end_date = date('Y-m-d', strtotime($_REQUEST['end_date']) ?? date('Y-m-d'));
            $employee = "";
            if (isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != '') {
                  $employee_id = $_REQUEST['employee_id'];
                  $employee = " AND leave_application.employee_id='$employee_id'";
            }
            $admin_id = $_REQUEST['admin_id'];
            $sql = "SELECT leave_application.*,employees.employee_id AS employee FROM leave_application
            JOIN employees ON leave_application.employee_id = employees.eid
             WHERE  leave_application.added_date BETWEEN '$start_date' AND '$end_date' 
             AND leave_application.admin_id = '$admin_id' $employee";
            $result = $conn->query($sql);
            $leave_application = [];
            if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { // Fetch all rows
                        $leave_application[] = $row;
                  }
                  return  json_encode([
                        'success' => true,
                        'data' => $leave_application,
                        'message' => "Leave application retrieved successfully."
                  ]);
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => $leave_application,
                        'message' => "Data not found."
                  ]);
            }
      }
      
      //leave type save
      public function leave_application_save()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin ID is required.",
                  'employee_id' => "Employee ID is required.",
                  'day_type' => "Day Type is required.",
                  'leave_type' => "Employee ID is required.",
                  'reason' => "Reason is required.",
                  'comment' => "Comment is required.",
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_POST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $admin_id = $_POST['admin_id'];
            $employee_id = $_POST['employee_id'];
            $day_type = $_POST['day_type'];
            $leave_type = $_POST['leave_type'];
            $reason = $_POST['reason'];
            $comment = $_POST['comment'];
            $added_date = date('Y-m-d');
            
            if($day_type=='0.5' || $day_type==0.5){
                $from_date=$_POST['date'];
                $to_date=$_POST['date'];
            }else{
                $from_date=$_POST['from_date'];
                $to_date=$_POST['to_date'];
            }
            

            $sql = "INSERT INTO leave_application (employee_id, admin_id, from_date, to_date, reason, status, department_status, leavetype_status, leave_type, comment, added_date) 
                  VALUES ('$employee_id', '$admin_id', '$from_date', '$to_date', '$reason', 1, 1, '$day_type', '$leave_type', '$comment', '$added_date')";

            if (mysqli_query($conn, $sql)) {
                  $last_id = mysqli_insert_id($conn);
                  $sql_get = "SELECT * FROM `leave_application` WHERE id='$last_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Leave application save successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      // leave application status
      public function leave_application_status()
      {
            global $conn;

            $required_fields = [
                  'leave_application_id' => "Leave Application is required.",
                  'admin_id' => "Admin ID is required.",
                  'status' => "Status is required.",
                  'comment' => "Comment is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $leave_application_id = $_REQUEST['leave_application_id'];
            $admin_id = $_REQUEST['admin_id'];
            $status = $_REQUEST['status'];
            $comment = $_REQUEST['comment'];

            $sql = "UPDATE `leave_application` SET `status`='$status',`comment`='$comment' WHERE admin_id='$admin_id' AND id='$leave_application_id'";
            if (mysqli_query($conn, $sql)) {
                  $sql_get = "SELECT * FROM `leave_application` WHERE id='$leave_application_id' LIMIT 1";
                  $result = $conn->query($sql_get);
                  $row = $result->fetch_assoc();
                  return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Leave Application status updated successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => $conn->error
                  ]);
            }
      }

      /////////////////////////// Send Notification ///////////////////////
      
      public function notification_send()
      {
            global $conn;
            $required_fields = [
                  'admin_id' => "Admin Id is required",
                  'title' => "Title is required.",
                  'message' => "Message is required."
            ];

            foreach ($required_fields as $field => $message) {
                  if (empty($_REQUEST[$field])) {
                        return json_encode([
                              'success' => false,
                              'data' => [],
                              'message' => $message
                        ]);
                  }
            }
            $admin_id = $_REQUEST['admin_id'];
            if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id']!=''){
                  $employee_ids = $_REQUEST['employee_id'];
                  $sql = "SELECT * FROM employees WHERE eid IN $employee_ids AND admin_id = '$admin_id' AND status=0 AND isActive=0 AND device_id IS NOT NULL";
            }else{
                  $sql = "SELECT * FROM employees WHERE admin_id = '$admin_id' AND status=0 AND isActive=0 AND device_id IS NOT NULL";
            }
            $result = $conn->query($sql);
            $device_ids = [];
            if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) { // Fetch all rows
                        $device_ids[] = $row['device_id'];
                  }
            } else {
                  return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Employee not found!'
                  ]);
            }

            $deviceTokens = $device_ids;
            $title = $_REQUEST["title"];
            $message = $_REQUEST["message"];
            $data = [];

            $response = $this->sendPushNotification($deviceTokens, $title, $message, $data);

            $responseData = json_decode($response, true);

            if ($responseData && isset($responseData['success']) && $responseData['success'] > 0) {
                  return  json_encode([
                        'success' => true,
                        'data' => $responseData,
                        'message' => "Notification sent successfully."
                  ]);
            } else {
                  return  json_encode([
                        'success' => false,
                        'data' => $responseData,
                        'message' => "Failed to send notification"
                  ]);
            }
      }
      /////////////////////////// Push Notification ///////////////////////

      function base64UrlEncode($text)
      {
            return str_replace(
                  ['+', '/', '='],
                  ['-', '_', ''],
                  base64_encode($text)
            );
      }

      public function getOAuth2AccessToken($private_key, $client_email)
      {
            $private_key = str_replace('\n', "\n", $private_key);

            $secret = openssl_get_privatekey($private_key);

            if (!$secret) {
                  die('Failed to load private key: ' . openssl_error_string());
            }

            // Create the token header
            $header = json_encode([
                  'typ' => 'JWT',
                  'alg' => 'RS256'
            ]);

            $time = time();
            $start = $time - 60;
            $end = $start + 3600;

            // Create payload
            $payload = json_encode([
                  "iss"   => $client_email,
                  "scope" => "https://www.googleapis.com/auth/firebase.messaging",
                  "aud"   => "https://oauth2.googleapis.com/token",
                  "exp"   => $end,
                  "iat"   => $start
            ]);

            // Encode Header
            $base64UrlHeader = base64_encode($header);

            // Encode Payload
            $base64UrlPayload = base64_encode($payload);

            // Create Signature Hash
            $result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);

            // Encode Signature to Base64Url String
            $base64UrlSignature = $this->base64UrlEncode($signature);

            // Create JWT
            $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

            // ================================
            $headerArray = array('Content-Type: application/json');
            $data = json_encode(array(
                  'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                  'assertion'  => $jwt
            ));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://oauth2.googleapis.com/token");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            $response = curl_exec($curl);

            $decoded_response = json_decode($response, true);

            if (isset($decoded_response['access_token']))
                  return $decoded_response['access_token'];
            else
                  false;
      }


      ////////////////////////// Helper function //////////////////////////
      function createSalt()
      {
            return '2123293dsj2hu2nikhiljdsd';
      }

      //notication send
      function sendPushNotification($device_id, $title, $message, $image)
      {
            $private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC898FFk7/OOENs\nbETHYi1bYPTRZb1v/ZWL+l98YcqIXlLtIL9RP1DAmP39ylNuCaPEzP+dno4zNj9Y\nkYiJnaARRVQq9jaid8BEJcQbQE91pFDGPcooSlQ8dyFJtV+lJJh6vcGbkeP7vUZF\nxv1/+yjUXBKc8zKk4cGsxMmYbk0euljE2I/WRY61AS17Yf9YC43ICpzhsFDIXIc5\nKnc4Xbcbw7dD2nklCuyeWJSE7WeGb3l08Gd9LP3xy5IVOk88Acjyew39uQUGRnUO\nJMPTXuDKvU81ZAMNVDAQQuXiX9msrnQnMjBtlsjUzP2yGE/qgwPGTutQXYeLUWX5\nQ+iZ1nWLAgMBAAECggEALgsOKCZaf2RdJU9yKMTGuXOz40uvb1ix9hPw7S0kvLqC\n6S1oAGN1iSAeDxcb4f1uTncGt4CZNGg84hc/1gw2os6qNfedE1QrYE91a5BtbAQ3\n/D21AsEtqjf6v+t2HRaAIrQWtxHCo6WYOEtGnEb1yVyP2nc1eVBasP6YAlCp8Nja\nW6jQgEgg2mMACU84FlZdWGCvFYDUfl/siCx45Xv7y8SgYzUqOWOQLL/8d48DPsYO\nvQDJvOPyzMSy5Cc8EiJh+zqyIZ18ZeIYTK2qf9i3fM8OjXPS/9faTenoFoC1XU7i\nwFS4+5XH9OXumeU4RHb0LD6yNc0oXlLPExWuomw24QKBgQDukD/5347V7h+O2YcU\nFmv1J+Whb0ulTVimW3GjIyf+k2g4gDSn0O5Q2ivrJAbLNOwOWX1zZbsXQb4d4rQB\nDQ6+Rw6wGKIPn92E3XGeSI62VPAcN9QihM4XOenjNSY5xQZvpl5uwKtnTMBPWg0I\nEtbr3lsCpbYkOGW6PAnBxsfoawKBgQDKx4XFKsg9+56XyjHJoyLcFR5IGUh+kqWh\nXQ+Em2l3WjAQLFU+gKzFcX9CwoBVF/aUt1brHnrT4RO8V33MDJ5YVzsQXojvTVg9\nComGnwR4s6ib/z9PrWw+ZypZvtrlcQjnRCXr2X2xPtnoucJh7EDS8XACiJjQBKjg\ngj4wJzNvYQKBgQC04cTQVfR8OofNDRxBW9rRUEXpSHTHykSMJkucUTyy5tuf8315\nPI5l2XZxXKiWDPNq0emvxJO9x4g6KrknDtp95Wy6koLWa/VPF4RdalBi6TYBf0cm\nQSHuNGglcRght0TxBOkW+pk7wtMRl4rH81joEHlbIYBgKC7hrUIMngbXLwKBgG1B\nqZq9XVzAKQgh4keBRXQNUN6J+NxxyRozWPwa/G1ZQ5JDQL7Hd89+QpJG1/yBR9OD\nISrXplho6khNX7NEjUCN533/YYqGQufIuKa3ISKjslIy6frVNwA8d74ZLjn3eFOb\nDU+RRL7uXVyeUdSPBbJicfZ7gNJ74D3vDvDE/lqhAoGAZubBTGexBne1GNFJS7+q\nPPnGKIBCY8GO4+bcbATOsMDbYbFhtdaM0A0IVMs121yG8NfrFlWX6WHDlc0e5+wf\nw6OEjY1Ko0qWbt5NAyWt7bQyxcwYe5YMxNboBJHVpjjDMq2DS8K0CZw9Zyt24pNi\nF5EDQLL5io/oBdG4EKfGYGM=\n-----END PRIVATE KEY-----\n";
            $client_email = "firebase-adminsdk-fbsvc@iclock-9b5f0.iam.gserviceaccount.com";
            $project_id = "iclock-9b5f0";

            $access_token = $this->getOAuth2AccessToken($private_key, $client_email);

            if ($access_token) {
                  $data = [
                        "message" => [
                              "token" => $device_id,                         // token is device id
                              "notification" => [
                                    "title" => $title,
                                    "body" => $message,
                                    "sound" => "Enabled",
                                    "image" => $image
                              ]
                        ]
                  ];

                  $data_string = json_encode($data);

                  $fcm_url = "https://fcm.googleapis.com/v1/projects/" . $project_id . "/messages:send";
                  $headers = array(
                        'Authorization: Bearer ' . $access_token,
                        'Content-Type: application/json'
                  );

                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $fcm_url);
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

                  $result = curl_exec($ch);
                  curl_close($ch);
                  $result = json_decode($result);

                  if (!$result)
                        return false;

                  return $result;
            }
      }
}


?>