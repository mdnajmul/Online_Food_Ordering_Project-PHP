<?php 

    include('top.php');


    $categories_id='';
    $dish_name='';
    $dish_detail='';
    $image='';
    $type='';

    $image_required='required';

    $id='';
    
    //create a $msg variable for show message
    $msg = '';

    //show error message for image
    $image_error='';


    /**This is for show only that id's data which one user click for Edit inside categories section**/
    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        
        $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM dish WHERE id='$id'"));
        
        $categories_id=$row['categories_id'];
        $dish_name=$row['dish_name'];
        $type=$row['type'];
        $dish_detail=$row['dish_detail'];
        $image_required='';
        
    }

    // when get dish_details_id from url then remove data from database & redirect current page //
    if(isset($_GET['dish_details_id']) && $_GET['dish_details_id']>0){
        $dish_details_id=get_safe_value($con,$_GET['dish_details_id']);
        $dish_id=get_safe_value($con,$_GET['id']);
        mysqli_query($con,"DELETE FROM dish_details WHERE id='$dish_details_id'");
        redirect('add_dish.php?id='.$dish_id);
    }



    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        
        //prx($_POST);
        
        //hold categorr name & order number from html form
        $categories_id = get_safe_value($con,$_POST['categories_id']);
        $dish_name = get_safe_value($con,$_POST['dish_name']);
        $dish_type=get_safe_value($con,$_POST['dish_type']);
        $dish_detail = get_safe_value($con,$_POST['dish_detail']);
        $added_on=date('Y-m-d h:i:s');
        
        if($id==''){
            $sql="SELECT * FROM dish WHERE dish_name='$dish_name'";
        } else{
            $sql="SELECT * FROM dish WHERE dish_name='$dish_name' AND id!='$id'";
        }
        
        if(mysqli_num_rows(mysqli_query($con,$sql))>0){
            $msg='This Dish Already Exits !';
        }else{
            //hold image type(jpg,jpeg,png)
            $image_type=$_FILES['image']['type'];
            if($id==''){
                //varification image type when insert image
                if($image_type!='image/png' && $image_type!='image/jpg' && $image_type!='image/jpeg'){
                    $image_error="Please select only png,jpg and jpeg image formate";
                }else{
                    //hold image inside $image variable
                    $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
                    //upload image file inside media/dish folder
                    move_uploaded_file($_FILES['image']['tmp_name'],DISH_IMAGE_SERVER_PATH.$image);

                    //add/insert data to 'dish' table
                    mysqli_query($con,"INSERT INTO dish(categories_id,dish_name,dish_detail,image,type,status,added_on) VALUES('$categories_id','$dish_name','$dish_detail','$image','$dish_type',1,'$added_on')");
                    
                    //hold dish id
                    $dish_id=mysqli_insert_id($con);
                    
                    //hold attribute & price value inside array variable from input form 
                    $attributeArr=$_POST['attribute'];
                    $priceArr=$_POST['price'];
                    $statusArr=$_POST['status'];

                    //write foreach loop to fetch all values from array variables
                    foreach($attributeArr as $key=>$val){
                        $attribute=$val;
                        $price=$priceArr[$key];
                        $status=$statusArr[$key];
                        //write insert query to insert attribute & price inside 'dish_details' table
                        mysqli_query($con,"INSERT INTO dish_details(dish_id,attribute,price,status,added_on) VALUES('$dish_id','$attribute','$price','$status','$added_on')");
                    }
                    
                    redirect('dish.php');
                }
            } else{
                $image_condition='';
                if($_FILES['image']['name']!=''){
                    //varification image type when update image
                    if($image_type!='image/png' && $image_type!='image/jpg' && $image_type!='image/jpeg'){
                        $image_error="Please select only png,jpg and jpeg image formate";
                    }else{
                        //hold image inside $image variable
                        $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
                        //upload image file inside media/dish folder
                        move_uploaded_file($_FILES['image']['tmp_name'],DISH_IMAGE_SERVER_PATH.$image);
                        $image_condition=", image='$image'";
                        
                        //=== Remove old image from 'media/dish' folder when edit/update new image ===//
                            $oldImageRow=mysqli_fetch_assoc(mysqli_query($con,"SELECT image FROM dish WHERE id='$id'"));
                            $oldImage=$oldImageRow['image'];
                            //remove image
                            unlink(DISH_IMAGE_SERVER_PATH.$oldImage);
                    }
                }
                
                if($image_error==''){
                    $sql="UPDATE dish SET categories_id='$categories_id',dish_name='$dish_name',dish_detail='$dish_detail',type='$dish_type' $image_condition WHERE id='$id'";
                    
                    //update data to 'dish' table
                    mysqli_query($con,$sql);
                    
                    //hold attribute & price value inside array variable from input form 
                    $attributeArr=$_POST['attribute'];
                    $priceArr=$_POST['price'];
                    $statusArr=$_POST['status'];
                    $dishDetailsIdArr=$_POST['dish_details_id'];

                    //write foreach loop to fetch all values from array variables
                    foreach($attributeArr as $key=>$val){
                        $attribute=$val;
                        $price=$priceArr[$key];
                        $status=$statusArr[$key];
                        if(isset($dishDetailsIdArr[$key])){
                            $uid=$dishDetailsIdArr[$key];
                            //write insert query to insert attribute & price inside 'dish_details' table
                            mysqli_query($con,"UPDATE dish_details SET attribute='$attribute',price='$price',status='$status' WHERE id='$uid'");
                        } else{
                            //write insert query to insert attribute & price inside 'dish_details' table
                            mysqli_query($con,"INSERT INTO dish_details(dish_id,attribute,price,status,added_on) VALUES('$id','$attribute','$price','$status','$added_on')");
                        }
                        
                    }
                    redirect('dish.php');
                }
            }
              
        }
              
    }

//hold all active category name from categories table
$res_category=mysqli_query($con,"SELECT * FROM categories WHERE status='1' ORDER BY category ASC");

$dishType=array("veg","non-veg");

?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Dish</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="categories_id">Category</label>
                        <select class="form-control" name="categories_id" style="color:#000;" required>
                            <option value="">Select Category*</option>
                            <?php
                                while($row_category=mysqli_fetch_assoc($res_category)){
                                    if($row_category['id']==$categories_id){
                                        echo "<option value='".$row_category['id']."' selected>".$row_category['category']."</option>";
                                    } else{
                                        echo "<option value='".$row_category['id']."'>".$row_category['category']."</option>";
                                    }
                                    
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dish_name">Dish Name</label>
                        <input type="text" class="form-control" name="dish_name" placeholder="Enter Dish Name*" value="<?php echo $dish_name;?>" required>
                        <!--========================= Create a <div> for show error message =====================-->
                             <div class="field_error"> <?php echo $msg; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    <div class="form-group">
                        <label for="dish_type">Type</label>
                        <select class="form-control" name="dish_type" style="color:#000;" required>
                            <option value="">Select Type*</option>
                            <?php
                                foreach($dishType as $list){
                                    if($list==$type){
                                       echo "<option value='$list' selected>".strtoupper($list)."</option>";
                                    }else{
                                       echo "<option value='$list'>".strtoupper($list)."</option>"; 
                                    }
                                    
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dish_detail">Dish Details</label>
                        <textarea class="form-control" name="dish_detail" placeholder="Dish Details"><?php echo $dish_detail;?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Dish Image</label>
                        <input type="file" class="form-control" name="image" <?php echo $image_required;?>>
                        <!--========================= Create a <div> for show image error message =====================-->
                             <div class="field_error"> <?php echo $image_error; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    
                    <div class="form-group" id="dish_details_box1">
                        <label for="attribute">Dish Attributes</label>
                    <?php if($id==''){ ?>
                           
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="attribute[]" placeholder="Enter Attribute*" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="price[]" placeholder="Enter Price*" required>
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="status[]" style="color:#000;" required>
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                    
                    <?php } else if($id>0){ 
                        $dish_details_res=mysqli_query($con,"SELECT * FROM dish_details WHERE dish_id='$id'");
                        $n=1;
                        while($dish_details_row=mysqli_fetch_assoc($dish_details_res)){
                    ?>
                            <div class="row mt8">
                                <div class="col-4">
                                    <input type="hidden" name="dish_details_id[]" value="<?php echo $dish_details_row['id']?>">
                                    <input type="text" class="form-control" name="attribute[]" placeholder="Enter Attribute*" value="<?php echo $dish_details_row['attribute']?>" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="price[]" placeholder="Enter Price*" value="<?php echo $dish_details_row['price']?>" required>
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="status[]" style="color:#000;" required>
                                        <option value="">Select Status</option>
                                        <?php
                                            if($dish_details_row['status']==1){
                                               echo "<option value='1' selected>Active</option>";
                                                echo "<option value='0'>Deactive</option>";
                                            }
                                            if($dish_details_row['status']==0){
                                               echo "<option value='1'>Active</option>";
                                               echo "<option value='0' selected>Deactive</option>"; 
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <!-- Write condition for 'Remove' button which not comes for first row; After first row,'Remove' button comes for every row -->
                                <?php if($n!=1){?>
                                    <div class="col-2">
                                        <button type="button" class="btn badge-danger mr-2" onclick="remove_from_database('<?php echo $dish_details_row['id']?>')">Remove</button>
                                    </div>
                                <?php } ?>
                                
                            </div>
                        
                    <?php 
                        $n++;    
                    } } ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                    <button type="button" class="btn badge-danger mr-2" onclick="add_more()">Add More</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
<input type="hidden" id="add_more" value="1">       
       
       <script>
           function add_more(){
               
               //hold #add_more input value which use for create div input row id
               var add_more = jQuery('#add_more').val();
               add_more++;
               jQuery('#add_more').val(add_more);
               
               //hold html div row section
               var html='<div class="row mt8" id="box'+add_more+'"><div class="col-4"><input type="text" class="form-control" name="attribute[]" placeholder="Enter Attribute*" required></div><div class="col-3"><input type="text" class="form-control" name="price[]" placeholder="Enter Price*" required></div><div class="col-3"><select class="form-control" name="status[]" style="color:#000;" required><option value="">Select Status</option><option value="1">Active</option><option value="0">Deactive</option></select></div><div class="col-2"><button type="button" class="btn badge-danger mr-2" onclick=remove_more("'+add_more+'")>Remove</button></div></div>';
               //when click 'Add More' button then create a input row
               jQuery('#dish_details_box1').append(html);
           }
           
           //Remove row
           function remove_more(id){
               jQuery('#box'+id).remove();
           }
           
           
           //Remove row data from database
           function remove_from_database(id){
               //show pop-up message
               var result=confirm('Are you sure?');
               if(result==true){
                   var cur_path=window.location.href;
                   window.location.href=cur_path+"&dish_details_id="+id;
               }
           }
           
           
       </script>



<?php include('footer.php'); ?>