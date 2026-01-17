<?php
header('Content-Type: application/json');
include('../connect.php');

$output = ['error' => true, 'message' => 'Invalid admin_id'];

if (isset($_POST['admin_id']) && !empty($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // 1. Get admin subscription
    $sub_sql = "
        SELECT a.subscription_expiry_date, a.subscription_package_id,
               p.name AS package_name, p.subscription_type, p.price,
               p.web_check, p.max_employees, p.max_departments,
               p.mobile_check, p.future_updates, p.reports
        FROM admin a
        JOIN subscription_packages p ON p.id = a.subscription_package_id
        WHERE a.id = '".$admin_id."'
        LIMIT 1
    ";
    $sub_query = $conn->query($sub_sql);

    if ($sub_query->num_rows == 0) {
        $output = ['error' => true, 'message' => 'No subscription found for this admin'];
    } else {
        $sub = $sub_query->fetch_assoc();

        // Check if subscription is active
        $today = new DateTime();
        $expiry = new DateTime($sub['subscription_expiry_date']);
        $remaining_days = $expiry->diff($today)->format('%r%a'); // can be negative
        $active = ($expiry >= $today) ? 1 : 0;

        $output = [
            'error' => false,
            'admin_id' => $admin_id,
            'package' => [
                'id' => $sub['subscription_package_id'],
                'name' => $sub['package_name'],
                'type' => $sub['subscription_type'],
                'price' => $sub['price'],
                'web_check' => (int)$sub['web_check'],
                'max_employees' => (int)$sub['max_employees'],
                'max_departments' => (int)$sub['max_departments'],
                'mobile_check' => (int)$sub['mobile_check'],
                'future_updates' => (int)$sub['future_updates'],
                'reports' => $sub['reports'],
                'active' => $active,
                'remaining_days' => ($active ? (int)$remaining_days : 0)
            ]
        ];
    }
}

echo json_encode($output);
?>
