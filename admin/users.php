<?php 

    include('top.php');


    //Delete,Active,Deactive Category
    if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
        $type = get_safe_value($con,$_GET['type']);
        $id = get_safe_value($con,$_GET['id']);
        
        if($type=='active' || $type=='deactive'){
            $status=1;
            if($type=='deactive'){
                $status=0;
            }
            mysqli_query($con,"UPDATE users SET status='$status' WHERE id='$id'");
            redirect('users.php');
        }
        
    }

    //fetch data from 'categories' table
    $sql="SELECT * FROM users ORDER BY id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">User Master</h1>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.No #</th>
                            <th width="13%">Name</th>
                            <th width="12%">Email</th>
                            <th width="10%">Mobile</th>
                            <th width="10%">Wallet Balance</th>
                            <th width="15%">Registration Date</th>
                            <th width="30%">Actions</th>
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
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['email'];?></td>
                                    <td><?php echo $row['mobile'];?></td>
                                    <td>&#2547; <?php echo getWalletTotalAmount($row['id'])?></td>
                                    <td>
                                        <?php
                                            //convert date into second
                                            $dateScond=strtotime($row['added_on']);
                                            echo date('d-m-Y',$dateScond);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($row['status']==1){
                                        ?>        
                                              <a href="?id=<?php echo $row['id']?>&type=deactive"><span class="badge badge-pill badge-complete active_clr">Active</span></a>&nbsp;
                                              <a href="add_money.php?id=<?php echo $row['id']?>"><span class="badge badge-pill badge-info money_clr">Add Money</span></a>&nbsp;
                                        <?php      
                                            }else{
                                        ?>        
                                                <a href="?id=<?php echo $row['id']?>&type=active"><span class="badge badge-pill badge-complete deactive_clr">Deactive</span></a>&nbsp;
                                                <span class="badge badge-pill badge-info money_clr" style="cursor: no-drop;">Add Money</span>&nbsp;
                                        <?php        
                                            }
                                        ?>
                                        
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