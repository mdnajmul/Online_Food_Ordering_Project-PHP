<?php

    include('top.php');

    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        //fetch data from 'order_master','order_status' table
        $sql="SELECT order_master.*,order_status.status as order_status_str FROM order_master,order_status WHERE order_master.order_status=order_status.id AND order_master.id='$id' ORDER BY order_master.id DESC";
        //execute this query
        $res=mysqli_query($con,$sql);
        if(mysqli_num_rows($res)>0){
            $orderRow=mysqli_fetch_assoc($res);
            $coupon_value=$orderRow['coupon_value'];
        }else{
            redirect('dashboard.php');
        }
        
    }else{
        redirect('dashboard.php');
    }

?>

    <div class="page-header">
        <h3 class="page-title"> Invoice </h3>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card px-2">
                <div class="card-body">
                    <div class="container-fluid">
                        <h3 class="text-right my-5">Order ID#&nbsp;&nbsp;<?php echo $id?></h3>
                        <hr>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="col-lg-3 pl-0">
                            <p class="mt-5 mb-2"><b>Shop Address</b></p>
                            <p>H/N# 30,Sector# 4,Road# 3,Uttara</p>
                            <p>Dhaka,Bangladesh</p>
                            <p><a href="#">info@foodonline.mail.com</a></p>
                        </div>
                        <div class="col-lg-3 pr-0">
                            <p class="mt-5 mb-2 text-right"><b>Invoice to</b></p>
                            <p class="text-right">
                                <?php  echo $orderRow['name']?><br />
                                <?php  echo $orderRow['address']?><br />
                                Dhaka - 
                                <?php  echo $orderRow['zip_code']?>
                            </p>
                        </div>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="col-lg-3 pl-0">
                            <p class="mb-0 mt-5">Order Date : <?php  echo dateFormat($orderRow['added_on'])?></p>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                        <div class="table-responsive w-100">
                            <table class="table">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>#</th>
                                        <th>Description</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $orderDetails=geteOrderDetails($id);
                                    $total_price=0;
                                    $i=1;
                                    foreach($orderDetails as $list){
                                        $total_price=$total_price+($list['unit_price']*$list['qty']);	
                                ?>

                                        <tr class="text-right">
                                            <td class="text-left"><?php echo $i++;?></td>
                                            <td class="text-left"><?php echo $list['dish_name'].'('.$list['attribute'].')'?></td>
                                            <td><?php echo $list['qty']?></td>
                                            <td>&#2547; <?php echo $list['unit_price']?></td>
                                            <td>&#2547; <?php echo $list['unit_price']*$list['qty']?></td>
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 w-100">
                        <h4 class="text-right mb-5">Total : &#2547; <?php echo $total_price?></h4>
                        <h4 class="text-right mb-5">Shipping : (+) &#2547; <?php echo 50;?></h4>
                        <h4 class="text-right mb-5">Grand Total : &#2547; <?php echo $total_price+50;?></h4>
                        <?php if($coupon_value!=''){?>
                            <h4 class="text-right mb-5">Discount : (-) &#2547; <?php echo $coupon_value;?></h4>
                            <h4 class="text-right mb-5">Grand Final Total : &#2547; <?php echo ($total_price+50)-$coupon_value;?></h4>
                        <?php } ?>    
                        <hr>
                    </div>
                    <div class="container-fluid w-100">
                        <a href="download_invoice.php?id=<?php echo $id?>" class="btn btn-primary float-right mt-4 ml-2"><i class="mdi mdi-printer mr-1"></i>PDF</a>
                    </div>
                    <?php
    
                        $orderStatusRes=mysqli_query($con,"SELECT * FROM order_status ORDER BY id");

                        $orderDeliveryBoyRes=mysqli_query($con,"SELECT * FROM delivery_boy WHERE status=1 ORDER BY name");
                           
                        //=== Hold Delivery Boy Name From 'delivery_boy' based on 'delivery_boy_id' & 'Order Id' ===//
                            $deliveryBoyId=$orderRow['delivery_boy_id'];
                            $sql="SELECT name,mobile FROM delivery_boy WHERE id='$deliveryBoyId'";
                            $deliveryBoyNameRes=mysqli_query($con,$sql);
                            $deliveryBoyNameRow=mysqli_fetch_assoc($deliveryBoyNameRes);
                        //============================================================//
					
					?>
                    <div>
                       <table>
                           <tr>
                            <?php
                                echo "<td ><h4 id='status_order_update' class='status_order_style'>Order Status:- ".$orderRow['order_status_str']."&nbsp;&nbsp;</h4></td>";
                                echo "<td><h4 id='status_payment_update' class='status_payment_style'>Payment Status:- ".$orderRow['payment_status']."&nbsp;&nbsp;</h4></td>";
                                if(mysqli_num_rows($deliveryBoyNameRes)>0){
                                    echo "<td ><h4 id='status_delivery_boy_update' class='delivery_style'>Delivery Boy:- ".$deliveryBoyNameRow['name']."<br/>Mobile:- ".$deliveryBoyNameRow['mobile']."</h4></td>";
                                }else{
                                    echo "<td ><h4 id='status_delivery_boy_update' class='delivery_style'>Delivery Boy:- Not Assigned</h4></td>";
                                }
                            ?>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control wSelect200" style="color:#000;" name="order_status" id="order_status" onchange="updateOrderStatus()">
                                        <option value="">Update Order Status</option>
                                        <?php 
                                        while($orderStatusRow=mysqli_fetch_assoc($orderStatusRes)){
                                            echo "<option value=".$orderStatusRow['id'].">".$orderStatusRow['status']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control wSelect230" style="color:#000;" name="payment_status" id="payment_status" onchange="updatePaymentStatus()">
                                        <option value="">Update Payment Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="success">Success</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control wSelect265" style="color:#000;" name="delivery_boy" id="delivery_boy" onchange="updateDeliveryBoy()">
                                        <option value="">Assign Delivery Boy</option>
                                        <?php 
                                        while($orderDeliveryBoyRow=mysqli_fetch_assoc($orderDeliveryBoyRes)){
                                            echo "<option value=".$orderDeliveryBoyRow['id'].">".$orderDeliveryBoyRow['name']."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>


        <script>
            
            function updateOrderStatus(){
                var order_status=jQuery('#order_status').val();
                if(order_status!=''){
                    var order_id="<?php echo $id?>";
                    jQuery.ajax({
                        url:'update_status.php',
                        type:'post',
                        data:'order_status='+order_status+'&order_id='+order_id+'&type=order',
                        success:function(result){
                            jQuery('#status_order_update').html('Order Status:- '+result+'&nbsp;&nbsp;');
                        }
                    });
                }
            }
            
            
            function updatePaymentStatus(){
                var payment_status=jQuery('#payment_status').val();
                if(payment_status!=''){
                    var order_id="<?php echo $id?>";
                    jQuery.ajax({
                        url:'update_status.php',
                        type:'post',
                        data:'payment_status='+payment_status+'&order_id='+order_id+'&type=payment',
                        success:function(result){
                            jQuery('#status_payment_update').html('Payment Status:- '+result+'&nbsp;&nbsp;');
                        }
                    });
                }
            }
            
            
            
             function updateDeliveryBoy(){
                var delivery_boy_id=jQuery('#delivery_boy').val();
                if(delivery_boy_id!=''){
                    var order_id="<?php echo $id?>";
                    jQuery.ajax({
                        url:'update_status.php',
                        type:'post',
                        data:'delivery_boy_id='+delivery_boy_id+'&order_id='+order_id+'&type=delivery_boy',
                        success:function(result){
                            //decode json result data
                            var data=jQuery.parseJSON(result);
                            jQuery('#status_delivery_boy_update').html('Delivery Boy:- '+data.name+'<br/>Mobile:- '+data.mobile);
                        }
                    });
                }
            }
            
        </script>


<?php include('footer.php'); ?>