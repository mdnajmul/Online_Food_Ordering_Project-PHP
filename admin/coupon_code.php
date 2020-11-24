<?php 

    include('top.php');


    //Delete,Active,Deactive Category
    if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
        $type = get_safe_value($con,$_GET['type']);
        $id = get_safe_value($con,$_GET['id']);
        
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM coupon_master WHERE id='$id'");
            redirect('coupon_code.php');
        }
        
        if($type=='active' || $type=='deactive'){
            $status=1;
            if($type=='deactive'){
                $status=0;
            }
            mysqli_query($con,"UPDATE coupon_master SET status='$status' WHERE id='$id'");
            redirect('coupon_code.php');
        }
        
    }

    //fetch data from 'categories' table
    $sql="SELECT * FROM coupon_master ORDER BY id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Coupon Code Master</h1>
              <a href="add_coupon_code.php" class="add_link">Add Coupon</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.No #</th>
                            <th width="9%">Coupon</th>
                            <th width="5%">Type</th>
                            <th width="9%">Value</th>
                            <th width="15%">Cart Min Value</th>
                            <th width="14%">Expired Date</th>
                            <th width="16%">Registration Date</th>
                            <th width="22%">Actions</th>
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
                                    <td><?php echo $row['coupon_code'];?></td>
                                    <td><?php echo $row['coupon_type'];?></td>
                                    <td><?php echo $row['coupon_value'];?></td>
                                    <td><?php echo $row['cart_min_value'];?></td>
                                    <td>
                                        <?php
                                            if($row['expired_on']==''){
                                                echo 'N/A';
                                            } else{
                                                //convert date into second
                                                $ExdateScond=strtotime($row['expired_on']);
                                                echo date('d-m-Y',$ExdateScond);
                                            }
                                            
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            //convert date into second
                                            $RgdateScond=strtotime($row['added_on']);
                                            echo date('d-m-Y',$RgdateScond);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($row['status']==1){
                                        ?>        
                                              <a href="?id=<?php echo $row['id']?>&type=deactive"><span class="badge badge-pill badge-complete active_clr">Active</span></a>&nbsp;
                                        <?php      
                                            }else{
                                        ?>        
                                                <a href="?id=<?php echo $row['id']?>&type=active"><span class="badge badge-pill badge-complete deactive_clr">Deactive</span></a>&nbsp;
                                        <?php        
                                            }
                                        ?>
                                        <a href="add_coupon_code.php?id=<?php echo $row['id']?>"><span class="badge badge-pill badge-edit edit_clr">Edit</span></a>&nbsp;
                                        <a href="?id=<?php echo $row['id']?>&type=delete"><span class="badge badge-pill badge-danger delete_red">Delete</span></a>
                                    </td>
                                </tr>
                      <?php } } else { ?>  
                            <td colspan="5" style="text-align:center;">No Data Found !</td>
                      <?php } ?>    
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>
        


<?php include('footer.php'); ?>