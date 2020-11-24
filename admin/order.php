<?php 

    include('top.php');

    //fetch data from 'order_master','order_status' table
    $sql="SELECT order_master.*,order_status.status FROM order_master,order_status WHERE order_master.order_status=order_status.id ORDER BY order_master.id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Order Master</h1>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="7%">S.No</th>
                            <th width="18%">Name/Email/Mobile</th>
                            <th width="15%">Address</th>
                            <th width="10%">Price</th>
                            <th width="10%">Payment Status</th>
                            <th width="8%">Payment Type</th>
                            <th width="15%">Order Status</th>
                            <th width="10%">Order Date</th>
                            <th width="7%"></th>
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