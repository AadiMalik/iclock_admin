<head>
    <style type="text/css">
        
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 30px; /* Location of the box */
  padding-left: 450px;
  padding-right: 350px;
  padding-bottom: 100px;
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding-left: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
    </style>
</head>
<?php    
    include('connect.php');
    include("header.php");
    include("sidebar.php");
?>
<?php 
if(isset($_POST['btn_update']))
{
    $updated = mysqli_query($conn,"UPDATE inv_payment SET 
                amount='".$_POST['receive_amount']."',payment_date='".$_POST['payment_date']."',payment_mode='".$_POST['payment_mode']."',transaction_id = '".$_POST['tran_id']."',note='".$_POST['note']."' WHERE id= '".$_POST['inv_id']."'");
     
    if($updated)
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
                    <h3 class="text-primary">Payment Receipt</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Payment Receipt</li>
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
                            <form method="post">
                            <div class="card-body">
                <?php 
                    $sql_inv_pay = mysqli_query($conn,"SELECT * FROM inv_payment WHERE qut_id='".$_GET['qut_id']."'");
                    $row_inv_pay = mysqli_fetch_array($sql_inv_pay);
                                        
                ?>
                                
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">  
                                            <span><h3><b>Record Payment for <?php echo $row_inv_pay['inv_id'];?></b></h3></span> 

                                            <hr>
                                        </div>
                                    </div>

                                    <input type="hidden" name="inv_id" value="<?php echo $row_inv_pay['id'];?>">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Amount Received</label>
                                            <input type="text" class="form-control" name="receive_amount" value="<?php echo $row_inv_pay['amount'];?>" required>             
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Payment Date</label>
                                            <input type="text" class="form-control" name="payment_date" value="<?php echo $row_inv_pay['payment_date'];?>" required>
                                        </div>

                                        <div class="form-group">    
                                            <label class="col-form-label" for="val-username"><small class="req text-danger">* </small> Payment Mode</label>
                                            <select class="form-control" name="payment_mode" required 
                                            >
                                                <option value="<?php echo $row_inv_pay['payment_mode'];?>"><?php echo $row_inv_pay['payment_mode'];?></option>
                                                <?php 
                                                    if($row_inv_pay['payment_mode'] == "Bank")
                                                    {
                                                ?>
                                                        <option value="Stripe Checkout">Stripe Checkout</option>
                                                <?php  
                                                    }else if($row_inv_pay['payment_mode'] == "Stripe Checkout")
                                                    {
                                                ?>
                                                        <option value="Bank">Bank</option>
                                                <?php 
                                                    }
                                                ?>
                                                
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <div class="form-group">
                                            <label class="col-form-label" for="val-username">Transaction ID</label>
                                            <input type="text" class="form-control" name="tran_id" value="<?php echo $row_inv_pay['transaction_id'];?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label" for="val-username">Leave a note</label>
                                            <textarea class="form-control" rows="10" name="note"><?php echo $row_inv_pay['note'];?></textarea>
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="form-group row" align="right">  
                                    <div class="col-lg-12">
                                        <input type="submit" class="btn btn-primary" name="btn_update" value="Update">

                                    </div>
                                </div>
               
                            </div>
                        </form>
                        </div>
                        
                        </div>

                        <div class="col-7">
                        <div class="card">
                            <div class="card-body">


                <?php 
                    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
                    $row_qut = mysqli_fetch_array($sql_get_qut);
                                          
                ?>

                                <div class="row">                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">    
                                            <span><h3><b>Payment</b></h3></span>&nbsp;&nbsp;
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                        <div class="form-group"  align="right">
                                            
                                            <a href="#add_item" data-toggle="modal" data-target="#sales_item_modal" class="details-popup btn btn-success btn-sm edit btn-flat" id="myBtn"><i class="fa fa-envelope" title="Send Mail"></i></a>            

                                            <a href="convert_inv_pdf.php?qut_id=<?php echo $_GET['qut_id'];?>" class="btn btn-success btn-sm edit btn-flat" title="PDF">PDF</a> 
                                        </div>
                                    </div>

                                     
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <hr>                                
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        
                                        <div class="form-group">
                                            <label class="col-form-label" for="val-address"><?php echo $row_qut['cust_name']."<br>".$row_qut['addr'].",".$row_qut['city']."<br>".$row_qut['state'].",".$row_qut['pin_code'];?>     
                                            </label>           
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                        
                                        <div class="form-group"  align="right">
                                            <label class="col-form-label" for="val-date"><b>To : </b><br><?php echo $row_qut['cust_name'];?></label> 
                                        </div>
                                    </div>

                                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                        <span><h3><u>PAYMENT RECEIPT</u></h3></span>                            
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Payment Date:&nbsp;&nbsp;<?php echo $row_inv_pay['payment_date']; ?></label><br>
                                        
                                            <label class="col-form-label">Payment Mode:&nbsp;&nbsp;<?php echo $row_inv_pay['payment_mode']; ?></label>
                                        </div>
                                    
                                        <div style="background-color: lightblue;margin-left: 20px;padding: 20px;text-align: center;font-size: 1.3em">
                                            <span><b>Total Amount<br><?php echo "$".$row_inv_pay['amount']; ?></b></span>
                                        </div><br>

                                        <div class="form-group"> 
                                            <span><b>Payment For</b></span> 
                                        </div>
                                        <div class="form-group">  
                                            <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <tr>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Amount</th>
                                                    <th>Payment Amount</th>
                                                </tr>
                                               
                                                <tr>
                                                    <td><?php echo $row_inv_pay['inv_id']; ?></td>
                                                    <td><?php echo $row_inv_pay['payment_date']; ?></td>
                                                    <td><?php echo '$'.$row_inv_pay['amount']; ?></td>
                                                    <td><?php echo $row_qut['total'];?>
                                                    </td>
                                                    <td style="display: none;"></td>
                                                </tr>
                                            </table>                                            
                                        </div>
                                    </div>
                                </div>
                          
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div>
                        <span style="font-size: 2em;">Send Payment Receipt To Client</span>
                        <span class="close" style="padding-right: 20px;font-size: 2em;">&times;</span>
                    </div>
                    <span><hr></span>
                    <p>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">                               
                                <div class="form-validation">
                                    <div class="row">
                                        <form action="mail_pay_receipt.php?qut_id=<?php echo $_GET['qut_id']; ?>" method="post">
                                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address">Email To </label>
                                                <input type="text" class="form-control" id="client_email" name="client_email" required="">
                                            </div>

                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address">Preview Email Template </label>
                                                <textarea class="form-control" name="area1" id="area1" style="width: 500px;height: 300px;">Hello <?php echo $row_qut['cust_name'];?><br>Thank you for the payment. Find the payment details below:<br>-------------------------------------------------<br>Amount: <?php echo $row_inv_pay['amount'];?><br>Date: <?php echo $row_inv_pay['payment_date'];?><br>Invoice number: <?php echo $row_inv_pay['inv_id'];?><br>-------------------------------------------------<br>We are looking forward working with you.<br><br>Kind Regards,<br>Upturn IT</textarea>

                                            </div>

                                            <div class="form-group" align="right">
                                                <button type="submit" class="btn btn-primary" name="btn_save" id="btn_save">Send</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>
                </div>
            </div>
            <?php include("footer.php"); ?>

<script type="text/javascript">
    /*$(document).ready(function()
    {
        $('.row_option').on('mouseenter', function()
        {
            $('.edit_del').show();
        });

        $('.row_option').on('mouseleave', function()
        {
            $('.edit_del').hide();
        });
    });  */

// Get the modal
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 


    bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('area1');

    });

    


</script>
    