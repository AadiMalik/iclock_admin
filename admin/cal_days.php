<?php
    include('connect.php');
    $results1 = mysqli_query($conn,"SELECT * FROM tbl_task WHERE  status = '0'");

    while($row1 = mysqli_fetch_array($results1))
    {
        if($row1['assign_name'] == $row['task_name'])
        {

            date_default_timezone_set('Asia/Kolkata');
            $from = strtotime($row1['start_date']);
            $to = strtotime($row1['end_date']);;
            $difference = $to - $from;
            $deadline = floor($difference / 86400)+1; 
?>
        <td><?php echo $deadline;?></td>
<?php
        if($row['task_status'] == "Fully Done")
        {
            $days = $row['working_days'];
        }else{
            date_default_timezone_set('Asia/Kolkata');
            $from = strtotime($row1['start_date']);
            $today = time();
            $difference = $today - $from;
            $days = floor($difference / 86400)+1; 
        }

?>
            
        <td><?php echo $days;?></td>
<?php
        }
    }
?>



