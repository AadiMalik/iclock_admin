
<?php
//namespace API;
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include('../connect.php');


class EmployeeClass 
{
    function __construct(){}
    
    public function login() {
        
        global $conn;

        if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
            $employee_id = $_REQUEST['employee_id'];
            $sql = "SELECT employees.*, department.department_name FROM employees INNER JOIN department ON employees.department_id = department.id WHERE employees.employee_id ='$employee_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(!empty($row))
            {
              return  json_encode([
                        'success' => true,
                        'data' => $row,
                        'message' => "Employee retrieved successfully."
                ]);    
            }else{
                return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee not found."
            ]);
            }                  
        }
        else{
           return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee ID is required."
            ]);
        }

    }

    public function attendance(){

        global $conn;

        if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){

            if((isset($_REQUEST['timeIn']) && $_REQUEST['timeIn'] != '') || (isset($_REQUEST['timeOut']) && $_REQUEST['timeOut'] != '')){
                
                if(!isset($_REQUEST['location'])){
                    return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Location field is required."
                    ]);
                }

                if(!isset($_REQUEST['lat'])){
                    return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "lat field is required."
                    ]);
                }
                
                if(!isset($_REQUEST['lng'])){
                    return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "lng field is required."
                    ]);
                }                

                $employee = $_REQUEST['employee_id'];
                $date = date('Y-m-d');
                $time_in = '00:00:00';
                $time_out = '00:00:00';
                
                $location = $_REQUEST['location'];
                $lat = $_REQUEST['lat'];
                $lng = $_REQUEST['lng'];
                //$apiUrl = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=AIzaSyCPLNsH-BHqGcizGRSC0GYAbH6Rpt9GDyk"));
                //$address = $apiUrl->results[0]->formatted_address;
                $address = $location;
                if(isset($_REQUEST['timeIn'])){
                    $time_in = $_REQUEST['timeIn'];
//                    $time_in = date('H:i:s', strtotime($time_in));
                }
                elseif(isset($_REQUEST['timeOut'])){
                    $time_out = $_REQUEST['timeOut'];
//                    $time_out = date('H:i:s', strtotime($time_out));
                }
                
                $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";  
                $query = $conn->query($sql); 

                if($query->num_rows < 1){
                    return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Employee not found."
                    ]);
                }
                else{
                    $row = $query->fetch_assoc();
                    $emp = $row['eid'];
                    $department_id = $row['department_id'];
                    $admin_id = $row['admin_id'];
                    
                    
                    if(isset($_REQUEST['timeOut'])){
                        
                        $sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
                       //return $sql;
                    
                        $query = $conn->query($sql);
    
                        if($query->num_rows > 0){
                 
                             $sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date' AND time_out = '00:00:00'" ;
                             //return $sql;
                           
                            $query = $conn->query($sql);
                         
        
                            if($query->num_rows > 0){
                              
                                //  $sql = "UPDATE attendance SET time_out = '$time_out', location = '$address'  WHERE employee_id = '$emp' AND date = '$date'";
                                 $sql = "UPDATE attendance SET time_out = '$time_out', location2 = '$address', lat2 = '$lat', lng2 = '$lng'  WHERE employee_id = '$emp' AND date = '$date'";
                                 
                                 
                                if($conn->query($sql)){
                                    return json_encode([
                                        'success' => true,
                                        'data' =>  [],
                                        'message' => "Attendance marked successfully."
                                    ]);
                                }
                                
                            }
                            else{
                               return json_encode([
                                    'success' => false,
                                    'data' => [],
                                    'message' => "Employee attendance of ".$date." already exist."
                                ]);
                            }
                            
                            
                             
                        }
                        else{
                             return json_encode([
                                'success' => false,
                                'data' => [],
                                'message' => "Employee must be put time in before time out."
                            ]); 
                          
                        }
                        
                    }
                    
                     $sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
                   
                    $query = $conn->query($sql);

                    if($query->num_rows > 0){
                        return json_encode([
                            'success' => false,
                            'data' => [],
                            'message' => "Employee attendance of ".$date." already exist."
                        ]);
                    }
                    else{
                        
                        $sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, daytype, department_id, admin_id, status, location,lat1,lng1) VALUES ('$emp', '$date', '$time_in','$time_out','Regular', $department_id, $admin_id, 0, '$address','$lat','$lng')";
                     
                        if($conn->query($sql)){
                           
                            $id = $conn->insert_id;

                            $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.eid = '$emp'";
                            $query = $conn->query($sql);
                            $srow = $query->fetch_assoc();

                            if($srow['time_in'] > $time_in){
                                $time_in = $srow['time_in'];
                            }

                            if($srow['time_out'] < $time_out){
                                $time_out = $srow['time_out'];
                            }
                            $time_in = date('H:i:s', strtotime($time_in));
                            $time_out = date('H:i:s', strtotime($time_out));
                            $time_in = new DateTime($time_in);
                            $time_out = new DateTime($time_out);
                            $interval = $time_in->diff($time_out);
                            $interval = $time_in->diff($time_out);
                            $hrs = $interval->format('%h');
                            $mins = $interval->format('%i');
                            $mins = $mins/60;
                            $int = $hrs + $mins;
                            
                            if($int < 6.5)
                               $status = 0.5;
                            else
                               $status = 1;
                            
                           $sql = "UPDATE attendance SET status = '$status', num_hr = '$int'  WHERE id = '$id'";
                            
                            $conn->query($sql);
                               
                        }
                        
                        else{
                            return json_encode([
                                'success' => false,
                                'data' => [],
                                'message' => "Something went wrong. Please try again later."
                            ]);
                        }

                        return json_encode([
                                'success' => true,
                                'data' =>  [],
                                'message' => "Attendance marked successfully"
                            ]);
                    }
                }

            }
            else{
                return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Time is required."
            ]);       
            }

            

        }else{
             return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Employee ID is required."
                ]);
        } 


    }
    
    public function leave(){
         global $conn;
        if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != '' ){
            $employee_id = $_REQUEST['employee_id'];
            $sql = "SELECT * FROM employees WHERE employee_id = '".$employee_id."'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if(!empty($row))
            {
        function getDatesFromRange($start, $end, $format = 'Y-m-d') {

                $array = array();
                $interval = new DateInterval('P1D');
                $realEnd = new DateTime($end); 
                $realEnd->add($interval);
                $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
                foreach($period as $date) {
                $array[] = $date->format($format);  
                }
                return $array;
        }
                if(isset($_REQUEST['leave_type']) && $_REQUEST['leave_type'] != ''){
                    if(((isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '') && (isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')) || (isset($_REQUEST['day']) && $_REQUEST['day']==0.5) ){
                        if(!isset($_REQUEST['day']) || $_REQUEST['day'] == ''){
                            return json_encode([
                                'success' => false,
                                'data' => [],
                                'message' => "day field is required."
                            ]);
                        }
                           if($_REQUEST['day']==0.5)
                            {
                                if(isset($_REQUEST['date']) && $_REQUEST['date'] != ""){
                                    //$from_date=$to_date=date('Y-m-d',strtotime($_REQUEST['date']));
                                    $from_date=$to_date=$_REQUEST['date'];
                                    //$leave_type='half_day';
                                    $leave_type=$_REQUEST['leave_type'];
                                }else{
                                    return json_encode([
                                        'success' => false,
                                        'data' => [],
                                        'message' => "date field is required."
                                    ]);
                                }
                            }
                            else
                            {
                                //$from_date=date('Y-m-d',strtotime($_REQUEST['from_date']));
                                //$to_date=date('Y-m-d',strtotime($_REQUEST['to_date']));
                                $from_date=$_REQUEST['from_date'];
                                $to_date=$_REQUEST['to_date'];
                                $leave_type=$_REQUEST['leave_type'];
                            }
                           if($from_date!='' && $to_date!='' && $leave_type!='')
                            {
                                $sql = "SELECT * FROM employees WHERE employee_id = '".$_REQUEST['employee_id']."'";
                                $query = $conn->query($sql);
                                $row1 = $query->fetch_assoc();
                                $eid = $row1['eid'];
                                $department_id = $row1['department_id'];
                                $admin_id = $row1['admin_id'];
                                $allot_leave= $row1['allot_leave'];
                                $avail_leave= $row1['avail_leave'];
                                $leave_diff = $row1['leave_difference'];
                                $employee=$row1['employee_id'];
                                $sick_avail_leave = $row1['sick_avail_leave'];
                                $emp_vacation_leaves = $row1['vacation_leaves'];
                                $emp_maternity_leaves = $row1['maternity_leaves'];
                                $emp_paternity_leaves = $row1['paternity_leaves'];
                                $emp_off_leaves = $row1['off_leaves'];
                                $emp_absence_leaves = $row1['absence_leaves'];
                                $amt = $row1['rate'];
                                $_REQUEST['employee_id'] = $eid;
                               $_REQUEST['reason'] = isset($_REQUEST['reason']) ? $_REQUEST['reason'] : NULL;
                               $_REQUEST['comment'] = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : NULL;
                               $sql2 = "SELECT * FROM leave_type WHERE admin_id='".$admin_id."' AND name='".$leave_type."' AND delete_status=0 ";
                               $query2 = $conn->query($sql2);
//                                            if($query2->num_rows < 1){
//                                                return json_encode([
//                                                    'success' => false,
//                                                    'data' => [],
//                                                    'message' => "This Leave Type is not provided by Admin"
//                                                ]);
//                                            }
                                     $sql = "SELECT * FROM leave_application WHERE employee_id = '".$row['eid']."'";
                                    $query = $conn->query($sql);
                                    $row = $query->fetch_assoc();
                                    if($row && $row['status'] == 0){
                                        return  json_encode([
                                            'success' => true,
                                            'data' => [],
                                            'message' => "You cannot submit another leave, while your previous leave is still pending."
                                        ]);
                                    }
                                $sql_insert_cust = mysqli_query($conn,"INSERT INTO `leave_application`( `employee_id`, `admin_id`, `from_date`, `to_date`, `reason`,`leavetype_status`,`leave_type`, `added_date`,`status`,`department_status`,`comment`) VALUES('".$eid."', '".$admin_id."', '".$from_date."', '".$to_date."', '".$_REQUEST['reason']."', '".$_REQUEST['day']."', '".$leave_type."','".date('Y-m-d')."',0,1,'".$_REQUEST['comment']."')");
                              $last_id = $conn->insert_id;
                              if($_REQUEST['day']==0.5)
                              {
                                  $leave_type='half_day';
                                  if((isset($_REQUEST['time_in']) && $_REQUEST['time_in'] != '') && (isset($_REQUEST['time_out']) && $_REQUEST['time_out'] != '') ){
                                      $sq1 ="INSERT INTO half_attendance(leave_app_id,admin_id,department_id,employee_id,date,status,daytype,time_in,time_out,approve_status) VALUES ('$last_id','".$admin_id."','".$department_id."','".$_REQUEST['employee_id']."','$from_date','".$_REQUEST['day']."','Half Day', '".$_REQUEST['time_in']."', '".$_REQUEST['time_out']."',0)";
                                        $qu1 = mysqli_query($conn,$sq1);
                                  }else{
                                      return  json_encode([
                                            'success' => true,
                                            'data' => [],
                                            'message' => "time_in or time_out field cannot be empty."
                                        ]);
                                  }
                              }
                              $res_date = getDatesFromRange($from_date, $to_date); 
                                $period = new DatePeriod(new DateTime($from_date),new DateInterval('P1D'),new DateTime($to_date));
                                $day=$_REQUEST['day'];
                                if($leave_type!='half_day')
                                {
                                    if($leave_type!='sick_leaves')
                                        {
                                            $sql2 = "SELECT * FROM leave_type WHERE admin_id='".$admin_id."' AND name=".$leave_type." AND delete_status=0 ";
                                            $query2 = $conn->query($sql2);
                                            if($query2){
//                                                if($query2->num_rows < 1){
//                                                    return json_encode([
//                                                        'success' => false,
//                                                        'data' => [],
//                                                        'message' => "This Leave Type is not provided by Admin"
//                                                    ]);
//                                                }
                                                $row2 = $query2->fetch_assoc();
                                            $avail_leave_type = $row2['no_of_days'];
                                            }
                                            $sql3 = "SELECT count(*) as cnt FROM attendance WHERE employee_id='".$_REQUEST['employee_id']."' AND YEAR(date)='".date('Y')."' ";
                                            $query3 = $conn->query($sql3);
                                            $row3 = $query3->fetch_assoc();
                                            $emp_count = $row3['cnt'];
                                            if($emp_count==0)
                                            {
                                                if($avail_leave_type<count($res_date))
                                                {
                                                    $lwp_leave=count($res_date)-$avail_leave_type;
                                                    $lp_leave=$avail_leave_type;
                                                }
                                                else
                                                {
                                                    $lp_leave=$avail_leave_type-count($res_date);
                                                }
                                            }
                                            else
                                            {
                                                if($emp_count<count($res_date))
                                                {
                                                    $lwp_leave=count($res_date)-$emp_count;
                                                    $lp_leave=$avail_leave_type-$emp_count;
                                                }
                                                else
                                                {
                                                    $lp_leave=$emp_count-count($res_date);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if($sick_avail_leave>=count($res_date))
                                            {
                                                $lwp_leave=count($res_date)-$sick_avail_leave;
                                                $lp_leave=$sick_avail_leave;
                                                $s1 = "UPDATE employees SET sick_avail_leave='0' WHERE employee_id = '".$employee."'";
                                                $q1 = mysqli_query($conn,$s1);
                                            }
                                            else
                                            {
                                                $lp_leave=$sick_avail_leave-count($res_date);
                                                $s1 = "UPDATE employees SET sick_avail_leave='".$lp_leave."' WHERE employee_id = '".$employee."'";
                                                    $q1 = mysqli_query($conn,$s1);
                                            }
                                        }
                                        $i=1;
                                        foreach ($res_date as $value) {
                                           $sq1 ="INSERT INTO attendance(admin_id,department_id,employee_id,date,status,daytype) VALUES ('".$admin_id."','$department_id','$eid','$value','".$day."','$leave_type')";
                                             $qu1 = mysqli_query($conn,$sq1);
                                            if($i>$lp_leave)
                                            {
                                                $sd ="INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','".$employee."','$value','$day','$amt')";
                                                $qd = mysqli_query($conn,$sd);
                                            }
                                            $i++;
                                            }
                                }
                                else
                                {
                                    $leave_date=$date=$from_date;  
                                    $sql = "SELECT * FROM emp_leave WHERE employee = '".$employee."'";
                                    $query = $conn->query($sql);
                                    if($query->num_rows < 1)
                                    {
                                    $sq ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','".$employee."','$leave_date','".$day."')";
                                    $qu = mysqli_query($conn,$sq);
                                    $avail_leave = $allot_leave - $day;
                                    $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
                                    $q1 = mysqli_query($conn,$s1);
                                    }
                                    else
                                {
                                    $sql = "SELECT * FROM emp_leave WHERE employee = '".$employee."'";
                                    $query = $conn->query($sql);
                                    if($query->num_rows < 1){
                                    $sq ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','".$employee."','$value','$day')";
                                    $qu = mysqli_query($conn,$sq);
                                    $avail_leave = $allot_leave - $day;
                                    $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
                                    $q1 = mysqli_query($conn,$s1);
                                    }
                                    else
                                    {
                                    $sql1 = "SELECT employee, max(date) as dt FROM emp_leave WHERE employee = '".$employee."'
                                    GROUP BY employee ";
                                    $query1 = mysqli_query($conn,$sql1);
                                    if($query1->num_rows < 1){
                                    echo 'record not found'; exit;
                                    }
                                    else{
                                    $rows = mysqli_fetch_assoc($query1);
                                    $emp = $rows['employee'];
                                    $lastdate= $rows['dt'];
                                    $pickupDate = new DateTime($lastdate);
                                    $returnDate = new DateTime($date);
                                    $interval = $pickupDate->diff($returnDate);
                                    $days = $interval->format('%a');
                                    if($days >= $leave_diff)
                                    {
                                    $s ="INSERT INTO emp_leave(id,employee,date,leavetype) VALUES (' ','$emp','$date','$day')";
                                    $q = mysqli_query($conn,$s);
                                    $avail_leave = $avail_leave - $day;
                                    $s1 = "UPDATE employees SET avail_leave='$avail_leave' WHERE employee_id = '".$employee."'";
                                    $q1 = mysqli_query($conn,$s1);
                                    }
                                    else {
                                    $seq = "SELECT * FROM employees WHERE employee_id = '$emp'";
                                    $qs = $conn->query($seq);
                                    $r = $qs->fetch_assoc();
                                    $e = $r['eid'];
                                    $rate = $r['rate'];
                                    $amt = $rate/2;
                                    $sd ="INSERT INTO deductions(id,empid,date,status,amount) VALUES (' ','".$employee."','$date','$day','$amt')";
                                    $qd = mysqli_query($conn,$sd);
                                    }
                                    }
                                    }
                                }
                                }
                            }
                        return json_encode([
                            'success' => false,
                            'data' => [],
                            'message' => "Your leave has been submitted successfully and waiting for admin approval."
                        ]);
                    }
                    else{
                        return json_encode([
                            'success' => false,
                            'data' => [],
                            'message' => "Leave duration is required."
                        ]);
                    }
                }
                else{
                    return json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => "Leave Type is required."
                    ]);
                }
            }else{
                return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee not found."
            ]);
            }                  
        }
        else{
           return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee ID is required."
            ]);
        }
    }
    
    public function leave_approval_status(){
        
        global $conn;


        if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
            $employee_id = $_REQUEST['employee_id'];
            $sql = "SELECT * FROM employees WHERE employee_id = '".$employee_id."'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        
            if(!empty($row))
            {
                $leaves_data = [];

                $sql = "SELECT * FROM leave_application WHERE employee_id = '".$row['eid']."'";
                $query = $conn->query($sql);

//                $rowD = [];
//                while($row2 = $query->fetch_assoc()){
//                    $rowD[] = $row2;
//                }

                while($row = $query->fetch_assoc()){
                    if($row['status'] == 0){
                        $leaves_data[] = [
                            'from' => $row['from_date'],
                            'to'    =>  $row['to_date'],
                            'reason'    =>  $row['reason'],
                            'leave_type'    =>  $row['leave_type'],
                            'comment'       =>  $row['comment'],
                            'status'        => 'pending'
                        ];
                    }
                    elseif($row['status'] == 1){
                        $leaves_data[] = [
                            'from' => $row['from_date'],
                            'to'    =>  $row['to_date'],
                            'reason'    =>  $row['reason'],
                            'leave_type'    =>  $row['leave_type'],
                            'comment'       =>  $row['comment'],
                            'status'        =>  'accepted'
                        ];
                    }
                    elseif($row['status'] == 2){
                        $leaves_data[] = [
                            'from' => $row['from_date'],
                            'to'    =>  $row['to_date'],
                            'reason'    =>  $row['reason'],
                            'leave_type'    =>  $row['leave_type'],
                            'comment'       =>  $row['comment'],
                            'status'        =>  'declined'
                        ];
                    }
                }
                if(!empty($leaves_data)){
                    return  json_encode([
                            'success' => true,
                            'data' => $leaves_data,
                        ]);
                }
                else{
                    return  json_encode([
                        'success' => true,
                        'data' => [],
                        'message' => "There is no any leave found for this employee"
                    ]);
                }
            }else{
                return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee not found."
            ]);
            }                  
        }
        else{
           return json_encode([
                    'success' => false,
                    'data' => [],
                    'message' => "Employee ID is required."
            ]);
        }
        
    }

    public function add_employee_coordinate($request){
        global $conn;

        if(isset($request['employee_id']) && $request['employee_id'] != ''){
            if(!isset($_REQUEST['latitude'])){
                return json_encode([
                    'success' => false,
                    'message' => "Latitude field is required."
                ]);
            }
            if(!isset($_REQUEST['longitude'])){
                return json_encode([
                    'success' => false,
                    'message' => "Longitude field is required."
                ]);
            }
            $employee = $request['employee_id'];
            $latitude = $request['latitude'];
            $longitude = $request['longitude'];

            $checkIfEmployeeExists = $this->checkIfEmpExist($conn,$employee);
            if(!$checkIfEmployeeExists){
                return json_encode([
                    'success' => false,
                    'message' => "Employee Id Does not exist"
                ]);
            }
            $deleteEmployeeOldLiveLocationIfExist = $this->deleteEmployeeOldLiveLocationIfExist($conn,$employee);
            if($deleteEmployeeOldLiveLocationIfExist){
                $sql = "INSERT INTO employee_locations (employee_id, latitude, longitude) VALUES ('$employee', '$longitude', '$latitude')";
                if($conn->query($sql)) {
                    $user = $this->getUserObject($conn,$conn->insert_id);
                    return json_encode([
                        'success' => true,
                        'data'      => $user,
                        'message' => "Location has been added successfully"
                    ]);
                }
                return json_encode([
                    'success' => false,
                    'data'      => [],
                    'message' => "Could not insert"
                ]);
            }
            return json_encode([
                'success' => false,
                'data'      => [],
                'message' => "SOMETHING WENT WRONG"
            ]);
        }
        return json_encode([
            'success' => false,
            'message' => "Employee ID is required."
        ]);
    }
    private function getUserObject($conn,$id){

        $sql = "SELECT * FROM employee_locations WHERE id = '$id'";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()) {
                return $row;
            }
        }
        return false;
    }
    private function checkIfEmpExist($conn,$empId){
        $sql = "SELECT * FROM employees WHERE eid = '$empId' OR employee_id='$empId'";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
            return true;
        }
        return false;
    }
    private function deleteEmployeeOldLiveLocationIfExist($conn,$employee){
        $sql = "DELETE FROM employee_locations WHERE employee_id = '$employee'";
        $query = $conn->query($sql);
        if($query > 0){
            return true;
        }
        return false;
    }
    
}

                      
?>




































