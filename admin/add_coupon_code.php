<?php 

    include('top.php');

    $coupon_code='';
    $coupon_type='';
    $coupon_value='';
    $cart_min_value='';
    $expired_on='';

    $id='';
    
    //create a $msg variable for show message
    $msg = '';


    /**This is for show only that id's data which one user click for Edit inside categories section**/
    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        
        $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM coupon_master WHERE id='$id'"));
        
        $coupon_code=$row['coupon_code'];
        $coupon_type=$row['coupon_type'];
        $coupon_value=$row['coupon_value'];
        $cart_min_value=$row['cart_min_value'];
        $expired_on=$row['expired_on'];
        
    }



    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        //hold categorr name & order number from html form
        $coupon_code = get_safe_value($con,$_POST['coupon_code']);
        $coupon_type = get_safe_value($con,$_POST['coupon_type']);
        $coupon_value = get_safe_value($con,$_POST['coupon_value']);
        $cart_min_value = get_safe_value($con,$_POST['cart_min_value']);
        $expired_on = get_safe_value($con,$_POST['expired_on']);
        $added_on=date('Y-m-d h:i:s');
        
        if($id==''){
            $sql="SELECT * FROM coupon_master WHERE coupon_code='$coupon_code'";
        } else{
            $sql="SELECT * FROM coupon_master WHERE coupon_code='$coupon_code' AND id!='$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($con,$sql))>0){
            $msg='This Coupon Code Already Exits !';
        }else{
            if($id==''){
                //add/insert data to 'categories' table
                mysqli_query($con,"INSERT INTO coupon_master(coupon_code,coupon_type,coupon_value,cart_min_value,expired_on,status,added_on) VALUES('$coupon_code','$coupon_type','$coupon_value','$cart_min_value','$expired_on',1,'$added_on')");
                redirect('coupon_code.php');
            } else{
                //update data to 'categories' table
                mysqli_query($con,"UPDATE coupon_master SET coupon_code='$coupon_code',coupon_type='$coupon_type',coupon_value='$coupon_value',cart_min_value='$cart_min_value',expired_on='$expired_on' WHERE id='$id'");
                redirect('coupon_code.php');
            }
              
        }
              
    }



?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Coupon Code</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="coupon_code">Coupon Code</label>
                        <input type="text" class="form-control" name="coupon_code" placeholder="Coupon Code*" value="<?php echo $coupon_code;?>" required>
                        <!--========================= Create a <div> for show error message =====================-->
                             <div class="field_error"> <?php echo $msg; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    <div class="form-group">
                        <label for="coupon_type">Coupon Type</label>
                        <select class="form-control" style="color:#000;" name="coupon_type" required>
                            <option value=''>Select*</option>
                            <?php
                                 if($coupon_type=='P'){
                                    echo "<option value='P' selected>Percentage</option>
                                          <option value='F'>Fixed</option>";
                                 }else if($coupon_type=='F'){
                                    echo "<option value='P'>Percentage</option>
                                          <option value='F' selected>Fixed</option>";
                                 } else{
                                     echo "<option value='P'>Percentage</option>
                                          <option value='F'>Fixed</option>";
                                 }

                           ?>
                        </select>    
                    </div>
                    <div class="form-group">
                        <label for="coupon_value">Coupon Value</label>
                        <input type="text" class="form-control" name="coupon_value" placeholder="Enter Coupon Value*" value="<?php echo $coupon_value;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cart_min_value">Cart Min Value</label>
                        <input type="text" class="form-control" name="cart_min_value" placeholder="Enter Cart Min Value*" value="<?php echo $cart_min_value;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="expired_on">Expired Date</label>
                        <input type="date" class="form-control" name="expired_on" placeholder="Expired Date" value="<?php echo $expired_on;?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>