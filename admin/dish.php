<?php 

    include('top.php');


    //Delete,Active,Deactive Category
    if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
        $type = get_safe_value($con,$_GET['type']);
        $id = get_safe_value($con,$_GET['id']);
        
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM dish WHERE id='$id'");
            redirect('dish.php');
        }
        
        if($type=='active' || $type=='deactive'){
            $status=1;
            if($type=='deactive'){
                $status=0;
            }
            mysqli_query($con,"UPDATE dish SET status='$status' WHERE id='$id'");
            redirect('dish.php');
        }
        
    }

    //fetch data from 'categories' table
    $sql="SELECT dish.*,categories.category FROM dish,categories WHERE dish.categories_id=categories.id ORDER BY dish.id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Dish Master</h1>
              <a href="add_dish.php" class="add_link">Add Dish</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.No #</th>
                            <th width="10%">Category</th>
                            <th width="25%">Dish</th>
                            <th width="15%">Image</th>
                            <th width="15%">Added Date</th>
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
                                    <td><?php echo $row['category'];?></td>
                                    <td><?php echo $row['dish_name'];?> (<?php echo strtoupper($row['type'])?>)</td>
                                    <td><a target="_blank" href="<?php echo DISH_IMAGE_SITE_PATH.$row['image'];?>"><img src="<?php echo DISH_IMAGE_SITE_PATH.$row['image'];?>"></a></td>
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
                                        <?php      
                                            }else{
                                        ?>        
                                                <a href="?id=<?php echo $row['id']?>&type=active"><span class="badge badge-pill badge-complete deactive_clr">Deactive</span></a>&nbsp;
                                        <?php        
                                            }
                                        ?>
                                        <a href="add_dish.php?id=<?php echo $row['id']?>"><span class="badge badge-pill badge-edit edit_clr">Edit</span></a>&nbsp;
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