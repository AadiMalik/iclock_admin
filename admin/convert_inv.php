<?php 
//session_start();
    include("connect.php");   
            
        $sql_update_quot = mysqli_query($conn,"UPDATE quotation SET inv_status='1' WHERE id= '".$_GET['qut_id']."'");

        if($sql_update_quot)
        {
?>
            <script type="text/javascript">    
            	alert("Quotation Convert To Invoice");            
                window.location.href = "quotation.php?qut_id=<?php echo $_GET['qut_id'];?>";
            </script>
<?php
        }
?>