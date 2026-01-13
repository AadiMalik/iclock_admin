<?php 	 
	include('connect.php');
	include("header.php");
    include("sidebar.php");
?>

<?php 
if(isset($_POST['btn_submit']))
{    
    $sql_last_inv_id = mysqli_query($conn,"SELECT id FROM inv_payment ORDER BY id DESC LIMIT 1");
    $row_last_inv_id = mysqli_fetch_array($sql_last_inv_id);
    $next_qut_id = "INV-".($row_last_inv_id['id']+1);

    if($_POST['qut_amount'] == $_POST['receive_amount'])
    {
        $inv_status = "PAID";
    }else{
        $inv_status = "UNPAID";
    }


    $results = mysqli_query($conn,"INSERT INTO inv_payment(inv_id,qut_id, amount, payment_date, payment_mode, transaction_id, note,inv_status, status) VALUES ('$next_qut_id','".$_GET['qut_id']."','".$_POST['receive_amount']."','".$_POST['payment_date']."', '".$_POST['payment_mode']."', '".$_POST['tran_id']."','".$_POST['note']."','$inv_status','0')");
    if($results)
    {
?>
        <script type="text/javascript">
            window.location.href = "inv_payment_receipt.php?qut_id=<?php echo $_GET['qut_id'];?>";
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
                    <h3 class="text-primary">Invoice Payment</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Invoice Payment</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                
								<a href="add_quotation.php?task=deadline_Task" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
								
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											    <th>ID</th>
                                                <th>Amount</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 
										include('connect.php');
										
										$results = mysqli_query($conn,"SELECT * FROM quotation WHERE status = '0' && inv_status = '0'");

										while($row = mysqli_fetch_array($results))
                                        {
										      extract($row);
										
									    ?>
										
                                            <tr>
                                                <td><a href="quotation.php?qut_id=<?=$row['id'];?>"><?php echo $row['id']; ?></a></td>
                                                <td><?php echo $row['total']; ?></td>
												<td><?php echo $row['cust_name'];?></td>
                                                <td><?php echo $row['quot_date'];?></td>
										   </tr>
                                        <?php } ?>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						</div>

                        <div class="col-7">
                        <div class="card">
                            <form method="post">
                            <div class="card-body">
                                   

                <?php 
                    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
                    while($row_qut = mysqli_fetch_array($sql_get_qut))
                    {                        
                ?>
                                
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">  
                                            <span><h3><b>Record Payment for <?php echo $row_qut['qut_id'];?></b></h3></span> 

                                            <hr>
                                        </div>
                                    </div>

                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Amount Received</label>
                                            <input type="text" class="form-control" name="receive_amount" value="<?php echo str_replace("$","",$row_qut['total']);?>" required>   
                                            <input type="hidden" name="qut_amount" value="<?php echo str_replace("$","",$row_qut['total']);?>">          
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Payment Date</label>
                                            <input type="text" class="form-control" name="payment_date" value="<?php date_default_timezone_set("Asia/Kolkata"); echo date('Y-m-d');?>" required>
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Payment Mode</label>
                                            <select class="form-control" name="payment_mode" required 
                                            >
                                                <option value="0">Nothing Selected</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Stripe Checkout">Stripe Checkout</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <div class="form-group">
                                            <label class="col-form-label" for="val-username">Transaction ID</label>
                                            <input type="text" class="form-control" name="tran_id">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label" for="val-username">Leave a note</label>
                                            <textarea class="form-control" rows="10" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="form-group row" align="right">  
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" name="btn_submit" value="Submit">

                                        <a href="quotation.php?qut_id=<?php echo $_GET['qut_id'];?>" class="btn btn-info btn-sm btn-flat" style="height:35px;font-size: 1em;"> Cancel</a>
                                    </div>
                                </div>
                <?php 
                    }
                ?>

                            </div>
                            </form>
                        </div>
                        
                    </div>
				</div>
			</div>
			<?php include("footer.php"); ?>

<!-- <script type="text/javascript">
    $(document).ready(function()
    {
        $('.row_option').on('mouseenter', function()
        {
            $('.edit_del').show();
        });

        $('.row_option').on('mouseleave', function()
        {
            $('.edit_del').hide();
        });
    });   
</script>
	 -->