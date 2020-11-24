<?php

    include('header.php');

    //check user login or not login
    if(!isset($_SESSION['FOOD_USER_ID'])){
        redirect(SITE_PATH.'shop');
    }

    //hold order id
    if(isset($_GET['id']) && $_GET['id']>0){
        $order_id=get_safe_value($con,$_GET['id']);
        $res=mysqli_query($con,"SELECT * FROM order_master WHERE id='$order_id'");
        if(mysqli_num_rows($res)>0){
            $orderFullDetails=OrderDetails($order_id);
            if($orderFullDetails[0]['user_id']!=$_SESSION['FOOD_USER_ID']){
                redirect(SITE_PATH.'shop');
            }
        }else{
           redirect(SITE_PATH.'shop'); 
        }
    }else{
        redirect(SITE_PATH.'shop');
    }

    //fetch coupon details from database
    $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM order_master WHERE id='$order_id'"));
    //hold coupon value
    $coupon_value=$coupon_details['coupon_value'];

?>
           
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                            <div class="table-content table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th width="15%">Image</th>
                                            <th width="25%">Dish Name</th>
                                            <th width="13%">Unit Price</th>
                                            <th width="20%">Qty</th>
                                            <th width="12%">Sub Total</th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                         $total_price=0;
                                         $orderDetails=geteOrderDetails($order_id);
                                         foreach($orderDetails as $list){ 
                                      ?>
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img src="<?php echo DISH_IMAGE_SITE_PATH.$list['image']?>" alt="">
                                            </td>
                                            <td><?php echo $list['dish_name'].'( '.$list['attribute'].' )'?></td>
                                            <td>&#2547; <?php echo $list['unit_price']?></td>
                                            <td><?php echo $list['qty']?></td>
                                            <td>&#2547; <?php echo $list['unit_price']*$list['qty']?></td>
                                            <td id="rating_<?php echo $list['dish_details_id']?>">
                                                <?php 
                                                    if($orderFullDetails[0]['order_status']==4){
                                                        echo getRating($list['dish_details_id'],$order_id);
                                                    }else{
                                                        echo '<div style="background-color: red;height: 50px;width: 80%;text-align: center;padding-top: 14px;color: #fff;">Rating Closed</div>';
                                                    }
                                                ?>
                                            </td>

                                        </tr>
                                        <?php 
                                            $total_price=$total_price+($list['unit_price']*$list['qty']);
                                         }
                                        
                                        ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td style="color:black;font-weight:bold;font-size:18px;">Total = </td>
                                            <td style="color:blue;">&#2547; <?php echo $total_price;?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td style="color:black;font-weight:bold;font-size:18px;">Shipping = </td>
                                            <td style="color:green;">(+) &#2547; 50</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td style="color:black;font-weight:bold;font-size:18px;">Grand Total = </td>
                                            <td style="color:blue;">&#2547; <?php echo $total_price+50;?></td>
                                        </tr>
                                        <?php
                                          if($coupon_value!=''){
                                        ?>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="color:black;font-weight:bold;font-size:18px;">Discount = </td>
                                                <td style="color:red;">(-) &#2547; <?php echo $coupon_value;?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="color:black;font-weight:bold;font-size:18px;">Final Grand Total = </td>
                                                <td style="color:blue;">&#2547; <?php echo ($total_price+50)-$coupon_value;?></td>
                                            </tr>
                                        <?php } ?>    
                                    </tbody>
                                </table>
                            </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
       
      
<?php include('footer.php'); ?>