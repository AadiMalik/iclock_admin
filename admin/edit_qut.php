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
  include("header.php");
  include("sidebar.php");
?>
<?php 
//session_start();
    include("connect.php");    

    if(isset($_POST['btn_update']))
    {
       
        $c=0;
        
        if(!empty($_POST['description']))
        {
            mysqli_query($conn,"DELETE FROM item WHERE item_id = '".$_POST['item_id']."'");

            foreach($_POST['description'] as $module)
            {
                $c++;
            }
            $i = 1;
            while($i < $c)
            {
                mysqli_query($conn,"INSERT INTO item(item_id, item_name, long_desc, qty,rate,tax,amount,status) VALUES ('".$_POST['item_id']."','".$_POST['description'][$i]."', '".$_POST['long_description'][$i]."','".$_POST['quantity'][$i]."','".$_POST['rate'][$i]."','".$_POST['taxname'][$i]."','".$_POST['amount'][$i]."', '0')");
                $i++;
            } 
        }               
    
            
        $sql_update_quot = mysqli_query($conn,"UPDATE quotation SET cust_name='".$_POST['sel_cust']."',addr='".$_POST['addr']."',city='".$_POST['city']."',state='".$_POST['state']."',pin_code='".$_POST['pin_code']."',quot_no='".$_POST['quot_no']."',quot_date='".$_POST['quot_date']."',expiry_date='".$_POST['exp_date']."',currency='".$_POST['currency']."',quot_status='".$_POST['quot_status']."',reference='".$_POST['reference']."',sale_agent='".$_POST['sale_agent']."',discount_type='".$_POST['discount_type']."',admin_note='".$_POST['admin_note']."',client_note='".$_POST['client_note']."',Terms_Conditions='".$_POST['terms_cond']."',sub_total='".$_POST['txt_sub_total']."',discount='".$_POST['txt_dis']."',adjust='".$_POST['txt_adj']."',total='".$_POST['txt_total']."' WHERE id= '".$_GET['qut_id']."'");

        if($sql_update_quot)
        {
?>
            <script type="text/javascript">                
                window.location.href = "mng_quotation.php";
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
                    <h3 class="text-primary">Add Quotation</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add Quotation</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php 
                    $sql_get_qut = mysqli_query($conn,"SELECT * FROM quotation WHERE id='".$_GET['qut_id']."'");
                    while($row_qut = mysqli_fetch_array($sql_get_qut))
                    {                        
                ?>
                <form method="post">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <input type="hidden" name="item_id" value="<?php echo $row_qut['item_id'];?>">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-username"><span style="color: red;">*</span>Customer</label>
                                                    <select class="form-control sel_cust" id="sel_cust" name="sel_cust">
                                                        <option value="<?php echo $row_qut['cust_name'];?>"><?php echo $row_qut['cust_name'];?></option>
                                                        <?php 
                                                            $sql_get_cust = mysqli_query($conn,"SELECT * FROM customer");
                                                            while($row = mysqli_fetch_array($sql_get_cust))
                                                            {
                                                                extract($row);
                                                        ?>
                                                            <option value="<?php echo $row['comp_name'];?>"><?php echo $row['comp_name'];?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">Address </label>
                                                    <textarea class="form-control" name="addr" id="addr"><?php echo $row_qut['addr'];?></textarea>
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">City </label>
                                                    <input type="text" class="form-control" id="city" name="city"value="<?php echo $row_qut['city'];?>">
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">State </label>
                                                    <input type="text" class="form-control" id="state" name="state" value="<?php echo $row_qut['state'];?>">
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">Pin Code </label>
                                                    <input type="text" class="form-control" id="pin_code" name="pin_code" value="<?php echo $row_qut['pin_code'];?>">
                                                </div>

                                                <div class="form-group">    
                                                    <label class="col-form-label" for="val-address">Quotation Number </label>
                                                    <input type="text" class="form-control" id="quot_no" name="quot_no" value="<?php echo $row_qut['quot_no'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Currency</label>
                                                    <input type="text" class="form-control" name="currency" id="currency" value="<?php echo $row_qut['currency'];?>">
                                                </div> 
                                                
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-address">Quotation Date </label>
                                                    <input type="date" class="form-control" id="quot_date" name="quot_date" value="<?php echo $row_qut['quot_date'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Expiry Date</label>
                                                    <input type="date" class="form-control" id="exp_date" name="exp_date" value="<?php echo $row_qut['expiry_date'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Status</label>
                                                    <input type="text" name="quot_status" id="quot_status" class="form-control" value="<?php echo $row_qut['quot_status'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Reference #</label>
                                                    <input type="text" name="reference" id="reference" class="form-control" value="<?php echo $row_qut['reference'];?>">
                                                </div>   

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Sale Agent</label>
                                                    <select class="form-control" id="sale_agent" name="sale_agent">
                                                        <option value="<?php echo $row_qut['sale_agent'];?>"><?php echo $row_qut['sale_agent'];?></option>
                                                        <option value="kanchan">Kanchan</option>
                                                        <option value="Dhanashree">Dhanashree</option>
                                                        <option value="Priyanka">Priyanka</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Discount Type</label>       
                                                    <select class="form-control" name="discount_type" id="discount_type">
                                                        <option value="<?php echo $row_qut['discount_type'];?>"><?php echo $row_qut['discount_type'];?></option>
                                                        <option value="Before Tax">Before Tax</option>
                                                        <option value="After Tax">After Tax</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Admin Note</label>
                                                    <textarea name="admin_note" id="admin_note" class="form-control"><?php echo $row_qut['admin_note'];?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!--  -->
<!-- 
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-lg-2 ml-auto">
                                                <input type="submit" class="btn btn-primary" name="btn_submit" value="Submit">
                                            </div>
                                        </div>  -->
                                    
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    

                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                        <option value="Add Item">Add Item</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div>
                                                <div><!-- 
                                                    <button style="color: black;">+Add Item</button> -->

                                                    <div class="input-group-addon" style="opacity: 1;">
                                                       <a href="#add_item" data-toggle="modal" data-target="#sales_item_modal" class="details-popup"><div class="project-item-overlay"><button style="color: black;"id="myBtn">
                                                        
                                                        <i class="fa fa-plus"></i> Add Item</button></div>
                                                      </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                            </div>
                                        </div>

                                        <!-- Add Item -->
                                        <div id="myModal" class="modal">
                                            <div class="modal-content">
                                                    <div>
                                                        <span style="font-size: 2em;">Add New Item</span>
                                                        <span class="close" style="padding-right: 20px;font-size: 2em;">&times;</span>
                                                    </div>
                                                    <span><hr></span>
                                                    <p>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">                               
                                <div class="form-validation">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address"><small class="req text-danger">* </small>Description </label>
                                                <input type="text" class="form-control" id="modal_desc" name="modal_desc">
                                            </div>

                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address">Long Description </label>
                                                <input type="text" class="form-control" id="modal_Ldesc" name="modal_Ldesc">
                                            </div>

                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address">Quntity </label>
                                                <input type="text" class="form-control" id="modal_qty" name="modal_qty">
                                            </div>

                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address"><small class="req text-danger">* </small> Rate - USD (Base Currency) </label>
                                                <input type="text" class="form-control" id="modal_rate" name="modal_rate">
                                            </div>

                                            <div class="form-group">   
                                                <label class="col-form-label" for="val-address">Tax </label>
                                                <select data-width="100%" name="modal_taxname" id="modal_taxname" class="form-control">
                                                    <option value="No Tax">No Tax</option>
                                                    <option value="5.00%" data-taxrate="5.00" data-taxname="TAX3" data-subtext="TAX3">5.00%</option><option value="10.00%" data-taxrate="10.00" data-taxname="TAX2" data-subtext="TAX2">10.00%</option><option value="18.00%" data-taxrate="18.00" data-taxname="TAX1" data-subtext="TAX1">18.00%</option>
                                                </select>
                                            </div>

                                            <div class="form-group" align="right">
                                                <button type="button" class="btn btn-primary" name="btn_save" id="btn_save">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                                    </p>
                                            </div>
                                        </div>

                                        <table class="table estimate-items-table items table-main-estimate-edit has-calculations no-mtop" id="tbl_item">
                                            <thead style="background-color: lightblue">
                                                <tr>
                                                    <th></th>
                                                    <th width="20%" align="left"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="New lines are not supported for item description. Use the item long description instead."></i> Item</th>
                                                    <th width="25%" align="left">Description</th>
                                                    <th width="10%" class="qty" align="right">Qty</th>
                                                    <th width="15%" align="right">Rate</th>
                                                    <th width="20%" align="right">Tax</th>
                                                    <th width="10%" align="right">Amount</th>
                                                    <th align="center"><i class="fa fa-cog"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody class="ui-sortable">
                                                <tr class="main">
                                                    <td></td>
                                                    <td>
                                                        <textarea id="description" rows="4" class="form-control" placeholder="Description"  name="description[]"></textarea>
                                                    </td>
                                                    <td>
                                                       <textarea id="long_description" rows="4" class="form-control" placeholder="Long description" name="long_description[]"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="quantity" min="0" value="1" class="form-control" placeholder="Quantity" name="quantity[]" >
                                                        <input type="text" placeholder="Unit" name="unit[]" class="form-control input-transparent text-right">
                                                    </td>
                                                    <td>
                                                      <input type="number" id="rate" class="form-control" placeholder="Rate" name="rate[]" >
                                                    </td>
                                                    <td>
                                                        <div style="width: 100%;"><select  data-width="100%" class="form-control" id="taxname" name="taxname[]">
                                                        <option value="0" selected="">No Tax</option>
                                                        <option value="5.00%" data-taxrate="5.00" data-taxname="TAX3" data-subtext="TAX3">5.00%</option><option value="10.00%" data-taxrate="10.00" data-taxname="TAX2" data-subtext="TAX2">10.00%</option><option value="18.00%" data-taxrate="18.00" data-taxname="TAX1" data-subtext="TAX1">18.00%</option></select><!-- <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="button" title="No Tax"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">No Tax</div> --></div> </div><span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open" role="combobox"><div class="inner open" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner "></ul></div></div></div>
                                                    </td>
                                                    <td><input type="hidden" name="amount[]"></td>
                                                    <td>
                                                        <button type="button" name="btn_add_item" id="btn_add_item" class="btn pull-right btn-info"><i class="fa fa-check"></i></button>
                                                    </td>
                                                </tr>

                                                <?php 
                                                    $sql_get_item = mysqli_query($conn,"SELECT * FROM item WHERE item_id='".$row_qut['item_id']."'");
                                                    $old_amt = 0;
                                                    while($row_item = mysqli_fetch_array($sql_get_item))
                                                    {
                                                        
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <textarea id="description" rows="4" class="form-control" placeholder="Description"  name="description[]"><?php echo $row_item['item_name'];?></textarea>
                                                        </td>
                                                        <td>
                                                           <textarea id="long_description" rows="4" class="form-control" placeholder="Long description" name="long_description[]"><?php echo $row_item['long_desc'];?></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" id="quantity" min="0" value="1" class="form-control" placeholder="Quantity" name="quantity[]" value="<?php echo $row_item['qty'];?>">
                                                            <!-- <input type="text" placeholder="Unit" name="unit[]" class="form-control input-transparent text-right"> -->
                                                        </td>
                                                        <td>
                                                          <input type="number" id="rate" class="form-control" placeholder="Rate" name="rate[]" value="<?php echo $row_item['rate'];?>">
                                                        </td>
                                                        <td>
                                                            <div style="width: 100%;"><select  data-width="100%" class="form-control" id="taxname" name="taxname[]">
                                                            <option value="<?php echo $row_item['tax'];?>" selected=""><?php echo $row_item['tax'];?></option>
                                                            <option value="5.00%" data-taxrate="5.00" data-taxname="TAX3" data-subtext="TAX3">5.00%</option><option value="10.00%" data-taxrate="10.00" data-taxname="TAX2" data-subtext="TAX2">10.00%</option><option value="18.00%" data-taxrate="18.00" data-taxname="TAX1" data-subtext="TAX1">18.00%</option></select><!-- <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="button" title="No Tax"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">No Tax</div> --></div> </div><span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open" role="combobox"><div class="inner open" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner "></ul></div></div></div>
                                                        </td>
                                                        <td><?php echo $row_item['amount'];
                                                            $old_amt=$old_amt+$row_item['amount'];
                                                        ?><input type="hidden" name="amount[]" value="<?php echo $row_item['amount'];?>"></td>

                                                        <td>
                                                            <button class="btn btn-danger btn-sm delete btn-flat deletebtn" id="btn_delete" name="btn_delete"><i class="fa fa-trash"></i> Delete</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>

                                            </tbody>
                                        </table>

                                        <br><br>
                                        <div class="form-group row">
                                            <div class="col-lg-5">
                                            </div>
                                            <div class="col-lg-7">
                                                <table class="table text-right" id="tbl_cal">
                                                    <tr>
                                                        <td align="right"  style="color: black">Sub Total :</td>
                                                        <td align="center" width="40%;" style="color: black" id="td_sub_total"><?php echo '$'.number_format($old_amt,2,'.','');?></td>
                                                        
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"  style="color: black">Discount &nbsp;&nbsp;&nbsp;
                                                            <input type="number" name="txt_discount" id="txt_discount">
                                                        </td>
                                                        <td align="center"  style="color: black" id="dis_discount"><?php echo $row_qut['discount'];?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"  style="color: black">Adjustment &nbsp;&nbsp;&nbsp;
                                                            <input type="number" name="txt_adjust" id="txt_adjust" >
                                                        </td>
                                                        <td align="center"  style="color: black" id="dis_adjust"><?php echo $row_qut['adjust'];?></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php 
                                                        $sql_get_item = mysqli_query($conn,"SELECT * FROM item WHERE item_id='".$row_qut['item_id']."'");
                                                        $old_tot_tax = 0;
                                                        while($row_item = mysqli_fetch_array($sql_get_item))
                                                        {
                                                            
                                                    ?>
                                                    <tr>
                                                        <td align="right"  style="color: black"><?php echo $row_item['item_name'];?> Tax</td>
                                                        <td align="center"  style="color: black" id="dis_adjust">
                                                            <?php $dis_tax= number_format((str_replace("%","",$row_item['tax'])/100) * $row_item['amount'],2,'.','');
                                                                 echo '$'.$dis_tax;

                                                                $old_tot_tax = $old_tot_tax + $dis_tax;
                                                            ?>
                                                                
                                                        </td>
                                                        <td></td>

                                                    </tr>
                                                    <?php 
                                                        }
                                                    ?>
                                                    <tfoot>
                                                        <tr>
                                                            <td align="right"  style="color: black">Total :
                                                            </td>
                                                            <td align="center"  style="color: black" id="total"><?php echo '$'.number_format(($old_amt + str_replace("$","",$row_qut['adjust']) + $old_tot_tax)+str_replace("$","",$row_qut['discount']),2,'.','');?></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>

                                                </table>

                                            </div>
                                        </div>
                                        <!--  -->

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                        <div class="col-lg-4 form-group row">
                                            <label class="col-form-label">Client Note </label>
                                        </div>
                                        <div class="col-lg-12 form-group row">
                                            <textarea class="form-control" id="client_note" name="client_note" rows="5"><?php echo $row_qut['client_note'];?></textarea>
                                        </div>

                                        <div class="col-lg-4 form-group row">
                                            <label class="col-form-label">Terms & Conditions </label>
                                        </div>
                                        <div class="col-lg-12 form-group row">
                                            <textarea class="form-control" id="terms_cond" name="terms_cond" rows="5"><?php echo $row_qut['Terms_Conditions'];?></textarea>
                                        </div>
                                        
                                             <input type="hidden" name="old_amt" id="old_amt" value="<?php echo $old_amt;?>">
                                            <input type="hidden" name="old_txt_total" id="old_txt_total" value="<?php echo $row_qut['total'];?>">
                                            <input type="hidden" name="old_sub_total" id="old_sub_total" value="<?php echo $row_qut['sub_total'];?>">
                                            <input type="hidden" name="old_total_tax" id="old_total_tax" value="<?php echo $old_tot_tax;?>">

                                            <input type="hidden" name="txt_sub_total" id="txt_sub_total" value="$0.00">
                                            <input type="hidden" name="txt_total" id="txt_total" value="<?php echo $row_qut['total'];?>">
                                            <input type="hidden" name="txt_dis" id="txt_dis" value="<?php echo $row_qut['discount'];?>">
                                            <input type="hidden" name="txt_adj" id="txt_adj" value="<?php echo $row_qut['adjust'];?>">
                                        <!--  -->

                                        <br>
                                        <div class="form-group row">
                                            <div class="col-lg-2 ml-auto">
                                                <input type="submit" class="btn btn-primary" name="btn_update" value="Update" id="btn_update">
                                            </div>
                                        </div> 
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                </form>
                <?php 
                    }
                ?>
                <!-- End PAge Content -->
            </div>
        </div>

<?php include("footer.php"); ?>

<script type="text/javascript">

    $(document).ready(function()
    {
        $('#sel_cust').on('change', function()
        {
            var cust = $('#sel_cust').val();
            $.ajax({

                type: "POST",
                url: 'myphpdoc.php',
                dataType: 'json',
                data: { 'cust' : cust },
                success: function(data)
                {
                    $('#currency').val(data.currency);
                }
            });
        });
    });   


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

var amt = $('#old_amt').val().replace('$', '');
var total_tax=$('#old_total_tax').val();

var old_new_total = $('#old_txt_total').val().replace('$', '');
$(document).ready(function()
{    
    //old_new_total=old_new_total+parseFloat($('#old_txt_total').val().replace('$', ''));
    $('#btn_add_item').on('click', function()
    {           
        var cal_amt = $('#quantity').val() * $('#rate').val();
        $('#tbl_item tbody').append('<tr><td></td><td><textarea rows="4" class="form-control" name="description[]">'+$('#description').val()+'</textarea></td><td><textarea rows="4" class="form-control" name="long_description[]">'+$('#long_description').val()+'</textarea></td><td><input type="number" min="0" value="'+$('#quantity').val()+'" class="form-control"  name="quantity[]" ></td><td><input type="number" class="form-control" placeholder="Rate" value="'+$('#rate').val()+'" name="rate[]" ></td><td><select  data-width="100%" name="taxname[]" class="form-control"><option value="'+$('#taxname').val()+'" Selected>'+$('#taxname').val()+'</option><option value="5.00%" data-taxrate="5.00" data-taxname="TAX3" data-subtext="TAX3">5.00%</option><option value="10.00%" data-taxrate="10.00" data-taxname="TAX2" data-subtext="TAX2">10.00%</option><option value="18.00%" data-taxrate="18.00" data-taxname="TAX1" data-subtext="TAX1">18.00%</option></select></td><td>'+cal_amt.toFixed(2)+'<input type="hidden" name="amount[]" value="'+cal_amt.toFixed(2)+'"></td><td><button class="btn btn-danger btn-sm delete btn-flat deletebtn" id="btn_delete" name="btn_delete"><i class="fa fa-trash"></i> Delete</button></td></tr>');
        
        //old_new_total = $('#total').html() - old_new_total; 

        amt = parseFloat(amt) + parseFloat(cal_amt);
        
        $('#td_sub_total').html('$'+parseFloat(amt).toFixed(2));
        $('#txt_sub_total').val($('#td_sub_total').html());

        var tax = $('#taxname').val().replace('%', '');
        var final_tax = (parseInt(tax)/100) * parseFloat(cal_amt);
        total_tax = parseFloat(total_tax) + parseFloat(final_tax);
        
        $('#tbl_cal').append('<tr><td style="color:black;">'+$('#description').val()+' Tax :</td><td style="color:black;" align="center">$'+final_tax.toFixed(2)+'</td><td></td></tr>');
        cal();
        /*var adjust = $('#dis_adjust').html().replace('$', '');
        var total = parseInt(amt) - parseInt(total_dis) + parseInt(adjust);
        
        $('#total').html('$'+total.toFixed(2));*/

        $('#description').val('');
        $('#long_description').val('');
        $('#quantity').val('');
        $('#rate').val('');
        $('#taxname').val('0');
    });

    $(document).on('click', 'button.deletebtn', function () 
    {
        $(this).closest('tr').remove();
        return false;
    });
/*
    $("#btn_delete").on('click', function(event) {
        
    });*/
});


$(document).ready(function()
{
    $('#btn_save').on('click', function()
    {           
        var cal_amt = $('#modal_qty').val() * $('#modal_rate').val();
        $('#tbl_item tbody').append('<tr><td></td><td><textarea rows="4" class="form-control" name="description[]">'+$('#modal_desc').val()+'</textarea></td><td><textarea rows="4" class="form-control" name="long_description[]">'+$('#modal_Ldesc').val()+'</textarea></td><td><input type="number" min="0" value="'+$('#modal_qty').val()+'" class="form-control"  name="quantity[]" ></td><td><input type="number" class="form-control" placeholder="Rate" value="'+$('#modal_rate').val()+'" name="rate[]" ></td><td><select  data-width="100%" name="taxname[]" class="form-control" id="modal_taxname"><option value="'+$('#modal_taxname').val()+'">'+$('#modal_taxname').val()+'</option><option value="5.00%" data-taxrate="5.00" data-taxname="TAX3" data-subtext="TAX3">5.00%</option><option value="10.00%" data-taxrate="10.00" data-taxname="TAX2" data-subtext="TAX2">10.00%</option><option value="18.00%" data-taxrate="18.00" data-taxname="TAX1" data-subtext="TAX1">18.00%</option></select></td><td>'+cal_amt.toFixed(2)+'<input type="hidden" name="amount[]" value="'+cal_amt.toFixed(2)+'"></td><td><button class="btn btn-danger btn-sm delete btn-flat deletebtn" id="btn_delete" name="btn_delete"><i class="fa fa-trash"></i> Delete</button></td></tr>');

        amt = parseFloat(amt) + parseFloat(cal_amt);
        $('#td_sub_total').html('$'+parseFloat(amt).toFixed(2));
        $('#txt_sub_total').val($('#td_sub_total').html());

        var tax = $('#modal_taxname').val().replace('%', '');
        var final_tax = (parseInt(tax)/100) * parseFloat(cal_amt);
        total_tax = total_tax + final_tax;

        $('#tbl_cal').append('<tr><td style="color:black;">'+$('#modal_desc').val()+' Tax :</td><td style="color:black;" align="center">$'+final_tax.toFixed(2)+'</td><td></td></tr>');
        cal();

        $('#modal_desc').val('');
        $('#modal_Ldesc').val('');
        $('#modal_qty').val('');
        $('#modal_rate').val('');
        $('#modal_taxname').val('0');
    });

    
});

$(document).ready(function()
{
    $('#txt_discount').on('input', function()
    {
        var dis = parseFloat($('#txt_discount').val()).toFixed(2);
        if(dis == "NaN")
            $('#dis_discount').html('-$0.00');
        else
            $('#dis_discount').html('-$'+dis);

        $('#txt_dis').val($('#dis_discount').html());

        /*var total = parseFloat($('#total').html().replace('$', '')-dis).toFixed(2);
        if(total == "NaN")
            $('#total').html();
        else
            $('#total').html('$'+total);*/
        cal();

             
    });
}); 

$(document).ready(function()
{
    $('#txt_adjust').on('input', function()
    {
        var adjust = parseFloat($('#txt_adjust').val()).toFixed(2);
        if(adjust == "NaN")
            $('#dis_adjust').html('$0.00');
        else
            $('#dis_adjust').html('$'+adjust);

        $('#txt_adj').val($('#dis_adjust').html());
        /*var total_adjust = (parseFloat($('#total').html().replace('$',''))+parseFloat(adjust)).toFixed(2);
        
        if(total_adjust == "NaN")
            $('#total').html('$'+parseFloat(amt - total_dis).toFixed(2));
        else
            $('#total').html('$'+total_adjust);*/
        cal();
             
    });
}); 

function cal()
{
    var adjust = $('#dis_adjust').html().replace('$', '');
    var discount = $('#dis_discount').html().replace('$', '');

    //var total = (parseFloat($('#td_sub_total').html().replace('$', '')) + parseFloat(adjust)) - (parseFloat(total_dis)-parseFloat(discount));

    var total = (parseFloat(amt) + parseFloat(adjust) + (parseFloat(total_tax))+parseFloat(discount));
    
    //var old_total = $('#old_txt_total').val().replace('$', '');
    //total = total + parseFloat(old_total);
        
    $('#total').html('$'+total.toFixed(2));    

    $('#txt_total').val($('#total').html());
}


</script>