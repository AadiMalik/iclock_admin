<?php
$output = array('error' => true, 'message' => 'Unknown error');

if (isset($_POST['emp_id'])) {
	include 'connect.php';
	include 'timezone.php';

	$emp_id = $_POST['emp_id'];

	if ($emp_id != '') {
		// 1. Get employee info
		$sql = "SELECT * FROM employees WHERE employee_id = '" . $emp_id . "' AND expiry_date >= '" . date('Y-m-d') . "'";
		$query = $conn->query($sql);

		if ($query->num_rows == 0) {
			$output['error'] = true;
			$output['message'] = 'Employee ID is not valid or subscription expired';
		} else {
			$row = $query->fetch_assoc();
			$admin_id = $row['admin_id'];

			// 2. Check admin's subscription package
			$sub_sql = "
                SELECT p.web_check, a.subscription_expiry_date, p.name AS package_name
                FROM admin a
                JOIN subscription_packages p ON p.id = a.subscription_package_id
                WHERE a.id = '" . $admin_id . "' 
                  AND a.subscription_expiry_date >= CURDATE()
                LIMIT 1
            ";
			$sub_query = $conn->query($sub_sql);

			if ($sub_query->num_rows == 0) {
				$output['error'] = true;
				$output['message'] = 'Your subscription package is not active. You cannot login or check-in.';
			} else {
				$sub = $sub_query->fetch_assoc();

				if ($sub['web_check'] != 1) {
					$output['error'] = true;
					$output['message'] = 'Your subscription package does not allow Web Check. You cannot login or check-in.';
				} else {
					// 3. All good
					$output['error'] = false;
					$output['admin_id'] = $admin_id;
					$output['package_name'] = $sub['package_name'];
				}
			}
		}
	} else {
		$output['error'] = true;
		$output['message'] = 'Employee ID cannot be empty';
	}
}

echo json_encode($output);
