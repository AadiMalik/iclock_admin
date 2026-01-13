<?php

require __DIR__.'/EmployeeClass.php';

$api = new EmployeeClass();
if(isset($_REQUEST['action']) && $_REQUEST['action'] != ''){

    if($_REQUEST['action'] == 'login'){
       print_r($api->login($_REQUEST)) ;
    }
    elseif($_REQUEST['action'] == 'attendance'){
       print_r($api->attendance($_REQUEST)) ;
    }
    elseif($_REQUEST['action'] == 'leave'){
       print_r($api->leave($_REQUEST)) ;
    }
    elseif($_REQUEST['action'] == 'leave_approval_status'){
       print_r($api->leave_approval_status($_REQUEST)) ;
    }
    else if($_REQUEST['action'] == 'employee_coordinates'){
        print_r($api->add_employee_coordinate($_REQUEST)) ;
    }


}
else{
        $resp = json_encode([
                'success' => false,
                'data' => [],
                'message' => "Action is required."
        ]);
        print_r($resp);
}