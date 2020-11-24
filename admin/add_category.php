<?php 

    include('top.php');

    $category='';
    $order_number='';
    $id='';
    
    //create a $msg variable for show message
    $msg = '';


    /**This is for show only that id's data which one user click for Edit inside categories section**/
    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        
        $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM categories WHERE id='$id'"));
        
        $category=$row['category'];
        $order_number=$row['order_number'];
        
    }



    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        //hold categorr name & order number from html form
        $category = get_safe_value($con,$_POST['category']);
        $order_number = get_safe_value($con,$_POST['order_number']);
        $added_on=date('Y-m-d h:i:s');
        
        if($id==''){
            $sql="SELECT * FROM categories WHERE category='$category'";
        } else{
            $sql="SELECT * FROM categories WHERE category='$category' AND id!='$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($con,$sql))>0){
            $msg='This Category Already Exits !';
        }else{
            if($id==''){
                //add/insert data to 'categories' table
                mysqli_query($con,"INSERT INTO categories(category,order_number,status,added_on) VALUES('$category','$order_number',1,'$added_on')");
                redirect('category.php');
            } else{
                //update data to 'categories' table
                mysqli_query($con,"UPDATE categories SET category='$category',order_number='$order_number' WHERE id='$id'");
                redirect('category.php');
            }
              
        }
              
    }



?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Category</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="category">Category Name</label>
                        <input type="text" class="form-control" name="category" placeholder="Category" value="<?php echo $category;?>" required>
                        <!--========================= Create a <div> for show error message =====================-->
                             <div class="field_error"> <?php echo $msg; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    <div class="form-group">
                        <label for="order_number">Order Number</label>
                        <input type="textbox" class="form-control" name="order_number" placeholder="Order Number" value="<?php echo $order_number;?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>