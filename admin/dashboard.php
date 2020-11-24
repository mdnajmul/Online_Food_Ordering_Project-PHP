<?php include('top.php'); ?>


<div class="row">
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $start_date=date('Y-m-d'). ' 00-00-00';
                        $end_date=date('Y-m-d'). ' 23-59-59';
                        $total_day_sale=getSale($start_date,$end_date);
                        if($total_day_sale==''){
                            $total_day_sale=0;
                        }
                        echo '&#2547; '.$total_day_sale;
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Total Sale</h4>
                      <p class="text-muted mb-0 font-weight-light">Today</p> 
                   </div>
                   <i class="mdi mdi-shopping icon-lg text-primary ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $start_date_sec=strtotime(date('Y-m-d'));
                        $start_date_sec=strtotime("-7 day",$start_date_sec);
                        $start_date=date('Y-m-d',$start_date_sec);
                        $end_date=date('Y-m-d'). ' 23-59-59';
                        $total_week_sale=getSale($start_date,$end_date);
                        if($total_week_sale==''){
                            $total_week_sale=0;
                        }
                        echo '&#2547; '.$total_week_sale;
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Total Sale</h4>
                      <p class="text-muted mb-0 font-weight-light">Last 7 Days</p> 
                   </div>
                   <i class="mdi mdi-shopping icon-lg text-danger ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $start_date_sec=strtotime(date('Y-m-d'));
                        $start_date_sec=strtotime("-30 day",$start_date_sec);
                        $start_date=date('Y-m-d',$start_date_sec);
                        $end_date=date('Y-m-d'). ' 23-59-59';
                        $total_month_sale=getSale($start_date,$end_date);
                        if($total_month_sale==''){
                            $total_month_sale=0;
                        }
                        echo '&#2547; '.$total_month_sale;
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Total Sale</h4>
                      <p class="text-muted mb-0 font-weight-light">Last 30 Days</p> 
                   </div>
                   <i class="mdi mdi-shopping icon-lg text-info ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-3 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $start_date_sec=strtotime(date('Y-m-d'));
                        $start_date_sec=strtotime("-365 day",$start_date_sec);
                        $start_date=date('Y-m-d',$start_date_sec);
                        $end_date=date('Y-m-d'). ' 23-59-59';
                        $total_year_sale=getSale($start_date,$end_date);
                        if($total_year_sale==''){
                            $total_year_sale=0;
                        }
                        echo '&#2547; '.$total_year_sale;
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Total Sale</h4>
                      <p class="text-muted mb-0 font-weight-light">Last 365 Days</p>
                   </div>
                   <i class="mdi mdi-shopping icon-lg text-success ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $sql="SELECT COUNT(order_master.user_id) AS total,users.name,users.email,users.mobile FROM order_master,users WHERE order_master.user_id=users.id GROUP BY order_master.user_id ORDER BY order_master.user_id DESC LIMIT 1";
                        $res=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($res);
                        echo "<p>Name: ".$row['name']."</p>";
                        echo "<p>Mobile: ".$row['mobile']."</p>";
                        echo "<p>Email: ".$row['email']."</p>";
                        echo "<p>Total Order: ".$row['total']."</p>";
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Most Active User</h4>
                   </div>
                   <i class="mdi mdi-account icon-lg text-success ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $sql="SELECT COUNT(dish_details.dish_id) AS total,dish_details.dish_id,dish.dish_name FROM dish_details,dish WHERE dish.id=dish_details.dish_id GROUP BY dish_details.dish_id ORDER BY COUNT(dish_details.dish_id) DESC LIMIT 1";
                        $res=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($res);
                        echo $row['dish_name'].' ( '.$row['total'].' Times)';
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Most Favourite Dish</h4>
                   </div>
                   <i class="mdi mdi-food icon-lg text-primary ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
       <div class="card">
           <div class="card-body">
               <h1 class="font-weight-light mb-4">
                   <?php
                        $sql="SELECT * FROM users";
                        $res=mysqli_query($con,$sql);
                        $count=mysqli_num_rows($res);
                        echo $count.' User';
                   ?>
               </h1>
               <div class="d-flex flex-wrap align-items-center">
                   <div>
                      <h4 class="font-weight-normal">Total Registered</h4>
                   </div>
                   <i class="mdi mdi-account-multiple icon-lg text-success ml-auto"></i>
               </div>
           </div>
       </div> 
    </div>
</div>

<?php
    //fetch data from 'order_master','order_status' table
    $sql="SELECT order_master.*,order_status.status FROM order_master,order_status WHERE order_master.order_status=order_status.id ORDER BY order_master.id DESC LIMIT 5";
    //execute this query
    $res=mysqli_query($con,$sql);
?>

<div class="row">
    <div class="col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Latest 5 Orders</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="3%">S.No</th>
                                <th width="13%">Name/Email/Mobile</th>
                                <th width="13%">Address</th>
                                <th width="18%">Price</th>
                                <th width="10%">Payment Status</th>
                                <th width="8%">Payment Type</th>
                                <th width="10%">Order Status</th>
                                <th width="20%">Order Date</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                            if(mysqli_num_rows($res)>0) { 
                               $i=1;
                               while($row=mysqli_fetch_assoc($res)){  
                          ?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td>
                                        <p><?php echo $row['name'];?></p>
                                        <p><?php echo $row['email'];?></p>
                                        <p><?php echo $row['mobile'];?></p>
                                    </td>
                                    <td><?php echo $row['address'].','.$row['zip_code'];?></td>
                                    <td><?php echo '&#2547; '.$row['total_price'];?></td>
                                    <td>
                                        <div class="payment_status payment_status_<?php echo $row['payment_status']?>"><?php echo ucfirst($row['payment_status']);?></div>
                                    </td>
                                    <td><?php echo ucfirst($row['payment_type'])?></td>
                                    <td>
                                        <?php
                                            $orderStatus=$row['status'];
                                            $arr=explode(' ',trim($orderStatus));
                                            $orderStatus=$arr[0];
                                        ?>
                                        <div class="order_status order_status_<?php echo $orderStatus?>"><?php echo $row['status'];?></div>
                                    </td>
                                    <td>
                                        <?php
                                            //convert date into second
                                            $dateScond=strtotime($row['added_on']);
                                            echo date('d-m-Y h:i',$dateScond);
                                        ?>
                                    </td>
                                    <td>
                                        <a href="order_details.php?id=<?php echo $row['id'];?>" class="details_order">Details</a>
                                    </td>
                                </tr>
                          <?php } } else { ?>  
                                <td colspan="8" style="text-align:center;">No Data Found !</td>
                          <?php } ?>    
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





<?php include('footer.php'); ?>