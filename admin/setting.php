<?php 

    include('top.php');

    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        
        $cart_min_price = get_safe_value($con,$_POST['cart_min_price']);
        $cart_min_price_msg = get_safe_value($con,$_POST['cart_min_price_msg']);
        $website_close = get_safe_value($con,$_POST['website_close']);
        $website_close_msg = get_safe_value($con,$_POST['website_close_msg']);
        $wallet_amount = get_safe_value($con,$_POST['wallet_amount']);
        $referral_bonus_amount = get_safe_value($con,$_POST['referral_bonus_amount']);
        
        mysqli_query($con,"UPDATE setting SET cart_min_price='$cart_min_price',cart_min_price_msg='$cart_min_price_msg',website_close='$website_close',wallet_amount='$wallet_amount',website_close_msg='$website_close_msg',referral_bonus_amount='$referral_bonus_amount' WHERE id='1'");
              
    }


    $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM setting WHERE id='1'"));

    $cart_min_price=$row['cart_min_price'];
    $cart_min_price_msg=$row['cart_min_price_msg'];
    $website_close=$row['website_close'];
    $website_close_msg=$row['website_close_msg'];
    $wallet_amount=$row['wallet_amount'];
    $referral_bonus_amount=$row['referral_bonus_amount'];


?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Setting</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="cart_min_price">Cart Minimum Price</label>
                        <input type="text" class="form-control" name="cart_min_price" placeholder="Price" value="<?php echo $cart_min_price;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cart_min_price_msg">Cart Price Message</label>
                        <input type="textbox" class="form-control" name="cart_min_price_msg" placeholder="Write Cart Minimum Price Message" value="<?php echo $cart_min_price_msg;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="website_close">Website Close</label>
                        <select class="form-control" style="color:#000;" name="website_close" required>
                            <option value="">Select Option</option>
                            <?php
                                if($website_close==1){
                                    echo '<option value="1" selected>Yes</option>';
                                    echo '<option value="0">No</option>';
                                }else{
                                    echo '<option value="1">Yes</option>';
                                    echo '<option value="0" selected>No</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="website_close_msg">Website Close Message</label>
                        <input type="textbox" class="form-control" name="website_close_msg" placeholder="Write Website Close Message" value="<?php echo $website_close_msg;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="wallet_amount">Wallet Amount</label>
                        <input type="textbox" class="form-control" name="wallet_amount" placeholder="Price" value="<?php echo $wallet_amount;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="referral_bonus_amount">Referral Bonus Amount</label>
                        <input type="textbox" class="form-control" name="referral_bonus_amount" placeholder="Enter Amount" value="<?php echo $referral_bonus_amount;?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>