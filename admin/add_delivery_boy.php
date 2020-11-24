<?php 

    include('top.php');

    $name='';
    $mobile='';
    $password='';

    $id='';
    
    //create a $msg variable for show message
    $msg = '';


    /**This is for show only that id's data which one user click for Edit inside categories section**/
    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        
        $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM delivery_boy WHERE id='$id'"));
        
        $name=$row['name'];
        $mobile=$row['mobile'];
        $password=$row['password'];
        
    }



    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        //hold categorr name & order number from html form
        $name = get_safe_value($con,$_POST['name']);
        $mobile = get_safe_value($con,$_POST['mobile']);
        $password = get_safe_value($con,$_POST['password']);
        $added_on=date('Y-m-d h:i:s');
        
        if($id==''){
            $sql="SELECT * FROM delivery_boy WHERE mobile='$mobile'";
        } else{
            $sql="SELECT * FROM delivery_boy WHERE mobile='$mobile' AND id!='$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($con,$sql))>0){
            $msg='This Mobile Number Already Exits !';
        }else{
            if($id==''){
                //add/insert data to 'categories' table
                mysqli_query($con,"INSERT INTO delivery_boy(name,mobile,password,status,added_on) VALUES('$name','$mobile','$password',1,'$added_on')");
                redirect('delivery_boy.php');
            } else{
                //update data to 'categories' table
                mysqli_query($con,"UPDATE delivery_boy SET name='$name',mobile='$mobile',password='$password' WHERE id='$id'");
                redirect('delivery_boy.php');
            }
              
        }
              
    }



?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Delivery Boy</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name*" value="<?php echo $name;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number*" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" value="<?php echo $mobile;?>" required>
                        <!--========================= Create a <div> for show error message =====================-->
                             <div class="field_error"> <?php echo $msg; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password*" value="<?php echo $password;?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>