<?php 

    include('top.php');


    //Delete data
    if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']>0){
        $type = get_safe_value($con,$_GET['type']);
        $id = get_safe_value($con,$_GET['id']);
        
        if($type=='delete'){
            mysqli_query($con,"DELETE FROM contact_us WHERE id='$id'");
            redirect('contact_us.php');
        }
        
    }

    //fetch data from 'contact_us' table
    $sql="SELECT * FROM contact_us ORDER BY id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>


<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Contact Us</h1>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.No #</th>
                            <th width="15%">Name</th>
                            <th width="15%">Email</th>
                            <th width="10%">Mobile</th>
                            <th width="10%">Subject</th>
                            <th width="20%">Message</th>
                            <th width="15%">Date/Time</th>
                            <th width="5%">Action</th>
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
                                    <td><?php echo $row['subject'];?></td>
                                    <td><?php echo $row['message'];?></td>
                                    <td><?php echo $row['added_on'];?></td>
                                    <td>
                                        <a href="?id=<?php echo $row['id']?>&type=delete"><span class="badge badge-pill badge-danger delete_red">Delete</span></a>
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