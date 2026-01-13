<?php     
  include("header.php");
  include("sidebar.php");
?>
<?php 
//session_start();
    include("connect.php");
       
    if(isset($_POST['btn_update']))
    {
       $updated_cust = mysqli_query($conn,"UPDATE customer SET 
                comp_name='".$_POST['comp_name']."',VAT_no='".$_POST['VAT_no']."',phone_no = '".$_POST['phone_no']."',email_id = '".$_POST['email_id']."', grp = '".$_POST['grp']."',currency = '".$_POST['currency']."',addr = '".$_POST['addr']."',city = '".$_POST['city']."',state = '".$_POST['state']."', zip_code = '".$_POST['zip_code']."', country = '".$_POST['country']."' WHERE id= '".$_GET['cust_id']."'");
     
        if($updated_cust)
        {
?>
            <script type="text/javascript">
                window.location.href = "mng_cust.php";
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
                    <h3 class="text-primary">Edit Customer</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Customer</li>
                    </ol>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="form-validation">
                                    <?php                                       
                                        include('connect.php');
                                        $result = mysqli_query($conn,"SELECT * FROM customer WHERE id='".$_GET['cust_id']."'");
                                        //print_r($result);
                                        $row= mysqli_fetch_array($result);
                                        
                                    ?>  
                                    <form class="form-valide" action="" method="post">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-username"><span style="color: red;">*</span>Company</label>
                                                    <input type="text" class="form-control" id="comp_name" name="comp_name" value="<?php echo $row['comp_name'];?>" required >
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-address">VAT Number </label>
                                                    <input type="text" class="form-control" id="VAT_no" name="VAT_no" value="<?php echo $row['VAT_no'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-address">Phone  </label>
                                                    <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo $row['phone_no'];?>" maxlength="13">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Email ID</label>
                                                    <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $row['email_id'];?>">
                                                </div>  

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Currency</label>
                                                    <input type="text" class="form-control" name="currency" value="<?php echo $row['currency'];?>">
                                                </div> 
                                                
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Address</label>
                                                    <textarea id="addr" name="addr" class="form-control" rows="3"><?php echo $row['addr'];?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">City</label>
                                                    <input type="text" name="city" id="city" class="form-control" value="<?php echo $row['city'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">State</label>
                                                    <input type="text" name="state" id="state" class="form-control" value="<?php echo $row['state'];?>">
                                                </div>   

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Zip Code</label>
                                                    <input type="number" class="form-control" id="zip_code" name="zip_code" value="<?php echo $row['zip_code'];?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="val-date">Country</label>       
                                                    <select class="form-control" name="country" id="sel_country">
                                                        <option value="<?php echo $row['country'];?>"><?php echo $row['country'];?></option>
                                                        <?php 
                                                            if($row['country'] != 'India')
                                                            {
                                                        ?>
                                                                <option value="India">India</option>
                                                        <?php 
                                                            }
                                                            if($row['country'] != 'Australia')
                                                            {
                                                        ?>
                                                                <option value="Australia">Australia</option>
                                                        <?php 
                                                            }
                                                            if($row['country'] != 'Bangladesh')
                                                            {
                                                        ?>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                        <?php 
                                                            }
                                                            if($row['country'] != 'Canada')
                                                            {
                                                        ?>
                                                                <option value="Canada">Canada</option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
   
                                        <!--  -->
                                        <br>
                                        <div class="form-group row">
                                            <div class="col-lg-2 ml-auto">
                                                <input type="submit" class="btn btn-primary" name="btn_update" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
</div>
<?php include("footer.php"); ?>



