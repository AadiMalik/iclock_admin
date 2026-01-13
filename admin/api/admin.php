<?php

require __DIR__ . '/AdminClass.php';

$api = new AdminClass();
if (isset($_REQUEST['action']) && $_REQUEST['action'] != '') {

      if ($_REQUEST['action'] == 'login') {
            print_r($api->login($_REQUEST));
      } elseif ($_REQUEST['action'] == 'department_list') {
            print_r($api->department_list($_REQUEST));
      } elseif ($_REQUEST['action'] == 'department_by_id') {
            print_r($api->department_by_id($_REQUEST));
      } elseif ($_REQUEST['action'] == 'department_save') {
            print_r($api->department_save($_REQUEST));
      } elseif ($_REQUEST['action'] == 'department_status') {
            print_r($api->department_status($_REQUEST));
      } elseif ($_REQUEST['action'] == 'department_delete') {
            print_r($api->department_delete($_REQUEST));
      }
      // Employees
      elseif ($_REQUEST['action'] == 'employee_list') {
            print_r($api->employee_list($_REQUEST));
      }
      elseif ($_REQUEST['action'] == 'employee_by_id') {
            print_r($api->employee_by_id($_REQUEST));
      }
      elseif ($_REQUEST['action'] == 'employee_save') {
            print_r($api->employee_save($_POST));
      }
      elseif ($_REQUEST['action'] == 'employee_update') {
            print_r($api->employee_update($_POST));
      }
      elseif ($_REQUEST['action'] == 'employee_delete') {
            print_r($api->employee_delete($_REQUEST));
      }

      // Attendance
      elseif ($_REQUEST['action'] == 'attendance_list') {
            print_r($api->attendance_list($_REQUEST));
      }
      //leave type
      elseif ($_REQUEST['action'] == 'leave_type_list') {
            print_r($api->leave_type_list($_REQUEST));
      }
      //leave type save
      elseif ($_REQUEST['action'] == 'leave_type_save') {
            print_r($api->leave_type_save($_POST));
      }
      //leave type update
      elseif ($_REQUEST['action'] == 'leave_type_update') {
            print_r($api->leave_type_update($_POST));
      }
      //leave type delete
      elseif ($_REQUEST['action'] == 'leave_type_delete') {
            print_r($api->leave_type_delete($_REQUEST));
      }
      //leave application
      elseif ($_REQUEST['action'] == 'leave_application_list') {
            print_r($api->leave_application_list($_REQUEST));
      }
      //leave application
      elseif ($_REQUEST['action'] == 'leave_application_save') {
            print_r($api->leave_application_save($_POST));
      }
      elseif ($_REQUEST['action'] == 'leave_application_status') {
            print_r($api->leave_application_status($_REQUEST));
      }

      //notification
      elseif ($_REQUEST['action'] == 'notification_send') {
            print_r($api->notification_send($_REQUEST));
      }
} else {
      $resp = json_encode([
            'success' => false,
            'data' => [],
            'message' => "Action is required."
      ]);
      print_r($resp);
}
