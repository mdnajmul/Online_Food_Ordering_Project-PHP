<?php 

    include('top.php');


    //Delete,Active,Deactive Category
    if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
        $type = get_safe_value($con,$_GET['type']);
        $id = get_safe_value($con,$_GET['id']);
        
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM banner WHERE id='$id'");
            redirect('banner.php');
        }
        
        if($type=='active' || $type=='deactive'){
            $status=1;
            if($type=='deactive'){
                $status=0;
            }
            mysqli_query($con,"UPDATE banner SET status='$status' WHERE id='$id'");
            redirect('banner.php');
        }
        
    }

    //fetch data from 'categories' table
    $sql="SELECT * FROM banner ORDER BY banner_serial_number";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Banner Master</h1>
              <a href="add_banner.php" class="add_link">Add Banner</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.No #</th>
                            <th width="15%">Image</th>
                            <th width="25%">Heading</th>
                            <th width="25%">Sub Heading</th>
                            <th width="25%">Actions</th>
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
                                    <td><a target="_blank" href="<?php echo BANNER_IMAGE_SITE_PATH.$row['image'];?>"><img src="<?php echo BANNER_IMAGE_SITE_PATH.$row['image'];?>"></a></td>
                                    <td><?php echo $row['heading'];?></td>
                                    <td><?php echo $row['sub_heading'];?></td>
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
                                        
                                        <a href="add_banner.php?id=<?php echo $row['id']?>"><span class="badge badge-pill badge-edit edit_clr">Edit</span></a>&nbsp;
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