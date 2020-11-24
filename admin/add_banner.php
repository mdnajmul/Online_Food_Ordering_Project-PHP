<?php 

    include('top.php');

    $image='';
    $heading='';
    $sub_heading='';
    $link='';
    $link_text='';
    $banner_serial_number='';

    $image_required='required';

    $id='';
    
    //create a $msg variable for show message
    $msg = '';

    //show error message for image
    $image_error='';


    /**This is for show only that id's data which one user click for Edit inside banner section**/
    if(isset($_GET['id']) && $_GET['id']>0){
        //hold 'id' value
        $id = get_safe_value($con,$_GET['id']);
        
        $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM banner WHERE id='$id'"));
        
        $image=$row['image'];
        $heading=$row['heading'];
        $sub_heading=$row['sub_heading'];
        $link=$row['link'];
        $link_text=$row['link_text'];
        $banner_serial_number=$row['banner_serial_number'];
        $image_required='';
        
    }



    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        //hold all data from html form
        $heading = get_safe_value($con,$_POST['heading']);
        $sub_heading = get_safe_value($con,$_POST['sub_heading']);
        $link = get_safe_value($con,$_POST['link']);
        $link_text = get_safe_value($con,$_POST['link_text']);
        $banner_serial_number = get_safe_value($con,$_POST['banner_serial_number']);
        $added_on=date('Y-m-d h:i:s');
        
        
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
                move_uploaded_file($_FILES['image']['tmp_name'],BANNER_IMAGE_SERVER_PATH.$image);
                
                //add/insert data to 'banner' table
                mysqli_query($con,"INSERT INTO banner(image,heading,sub_heading,link,link_text,banner_serial_number,status,added_on) VALUES('$image','$heading','$sub_heading','$link','$link_text','$banner_serial_number',1,'$added_on')");
                redirect('banner.php');
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
                        move_uploaded_file($_FILES['image']['tmp_name'],BANNER_IMAGE_SERVER_PATH.$image);
                        $image_condition=", image='$image'";
                        
                        //=== Remove old image from 'media/dish' folder when edit/update new image ===//
                            $oldImageRow=mysqli_fetch_assoc(mysqli_query($con,"SELECT image FROM banner WHERE id='$id'"));
                            $oldImage=$oldImageRow['image'];
                            //remove image
                            unlink(BANNER_IMAGE_SERVER_PATH.$oldImage);
                    }
                }
            
                if($image_error==''){
                    
                    //update data to 'banner' table
                    mysqli_query($con,"UPDATE banner SET heading='$heading',sub_heading='$sub_heading',link='$link',link_text='$link_text',banner_serial_number='$banner_serial_number' $image_condition WHERE id='$id'");
                    
                    redirect('banner.php'); 
                }        
            
        }

    }



?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Banner</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" name="image" <?php echo $image_required;?>>
                        <!--========================= Create a <div> for show image error message =====================-->
                             <div class="field_error"> <?php echo $image_error; ?> </div>
                        <!--===========================================================================================-->
                    </div>
                    <div class="form-group">
                        <label for="heading">Heading</label>
                        <input type="text" class="form-control" name="heading" placeholder="Enter Heading" value="<?php echo $heading;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sub_heading">Sub Heading</label>
                        <input type="text" class="form-control" name="sub_heading" placeholder="Enter Sub Heading" value="<?php echo $sub_heading;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" class="form-control" name="link" placeholder="Enter Link" value="<?php echo $link;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="link_text">Link Text</label>
                        <input type="text" class="form-control" name="link_text" placeholder="Enter Link Text" value="<?php echo $link_text;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="banner_serial_number">Banner Serial Number</label>
                        <input type="text" class="form-control" name="banner_serial_number" placeholder="Enter Serial Number" value="<?php echo $banner_serial_number;?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>