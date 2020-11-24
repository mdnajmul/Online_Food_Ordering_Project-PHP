<?php

    include('header.php');

    //check user login or not login
    if(!isset($_SESSION['FOOD_USER_LOGIN'])){
        redirect(SITE_PATH.'shop');
    }

    //hold login user id from session
    $user_id=$_SESSION['FOOD_USER_ID'];


    if(isset($_GET['cancel_id']) && $_GET['cancel_id']>0){
        $cancel_order_id=get_safe_value($con,$_GET['cancel_id']);
        $cancel_time=date('Y-m-d h:i:s');
        mysqli_query($con,"UPDATE order_master SET order_status='5',cancel_by='User',cancel_time='$cancel_time' WHERE id='$cancel_order_id' AND order_status='1' AND user_id='$user_id'");
    }

    //fetch data from 'order_master','order_status' table
    $sql="SELECT order_master.*,order_status.status FROM order_master,order_status WHERE order_master.order_status=order_status.id AND order_master.user_id='$user_id' ORDER BY order_master.id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);


?>

<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Order History</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th width="5%">Order No</th>
                                    <th width="7%">Total Price</th>
                                    <th width="30%">Address</th>
                                    <th width="10%">Order Status</th>
                                    <th width="10%">Payment Status</th>
                                    <th width="5%">Order Date</th>
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(mysqli_num_rows($res)>0) {
                                       while($row=mysqli_fetch_assoc($res)){  
                                  ?>
                                            <tr>
                                                <td><?php echo $row['id'];?></td>
                                                <td>
                                                    <div style="color: #FF8C00;"><?php echo '&#2547; '.$row['total_price'];?></div>
                                                </td>
                                                <td><?php echo $row['address'].','.$row['zip_code'];?></td>
                                                <!--
                                                <td>
                                                   <table style="border:1px solid #e9e8ef; padding:5px;">
                                                        <tr>
                                                            <th>Dish Name</th>
                                                            <th>Unit Price</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                        <?php
                                                        /*  $orderDetails=geteOrderDetails($row['id']);
                                                            foreach($orderDetails as $list){
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo $list['dish_name'].'('.$list['attribute'].')'?></td>
                                                                        <td><?php echo $list['unit_price']?></td>
                                                                        <td><?php echo $list['qty']?></td>
                                                                    </tr>
                                                                <?php
                                                         } */
                                                        ?>
                                                    </table>
                                                </td>
                                                -->
                                                <td>
                                                    <?php
                                                        $orderStatus=$row['status'];
                                                        $arr=explode(' ',trim($orderStatus));
                                                        $orderStatus=$arr[0];
                                                    ?>
                                                    <div class="order_status_front order_status_front_<?php echo $orderStatus?>">
                                                        <?php 
                                                            echo $row['status'];
                                           
                                                        ?>
                                                    </div>
                                                    <?php
                                                        if($row['status']=='Pending'){
                                                             ?>
                                                    <div class="order_status_front order_status_front_Canceled" style="margin-top:5px;"><a href="?cancel_id=<?php echo $row['id']?>" style="text-decoration:none;color:#fff;">Cancel Order</a></div>
                                                             <?php    
                                                            }
                                                    ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="payment_status_front payment_status_front_<?php echo $row['payment_status']?>"><?php echo ucfirst($row['payment_status']);?></div>
                                                </td>
                                                <td><?php echo $row['added_on'];?></td>
                                                <td>
                                                    <a href="<?php echo SITE_PATH?>order_details?id=<?php echo $row['id']?>" class="details_order_front">Details</a>
                                                </td>
                                                <td>
                                                    <a href="<?php echo SITE_PATH?>download_invoice?id=<?php echo $row['id']?>"><img src="<?php echo SITE_PATH?>assets/img/icon-img/pdf.png" width="20px" title="Download Invoice"></a>
                                                </td>
                                            </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>