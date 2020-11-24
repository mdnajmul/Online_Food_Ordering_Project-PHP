<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   //include constant.inc.php file inside this index page
   include('constant.inc.php');


    //hold type(profile or password)
    $type=get_safe_value($con,$_POST['type']);
    //hold user id from session
    $uid=$_SESSION['FOOD_USER_ID'];

    if($type=='profile'){
        $name=get_safe_value($con,$_POST['name']);
        $mobile=get_safe_value($con,$_POST['mobile']);
        
        //update session user name
        $_SESSION['FOOD_USER_NAME']=$name;
        
        mysqli_query($con,"UPDATE users SET name='$name',mobile='$mobile' WHERE id='$uid'");
        
        $arr=array('status'=>'success','msg'=>'Profile has been updated succesfully.');
        echo json_encode($arr);
        
    }

    if($type=='password'){
        $old_pass=get_safe_value($con,$_POST['old_password']);
        $new_pass=get_safe_value($con,$_POST['new_password']);
        
        
        
        $check=mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE password='$old_pass'"));
        
        $res=mysqli_query($con,"SELECT password FROM users WHERE id='$uid'");
        $row=mysqli_fetch_assoc($res);
        //hold user hash/encrypt password from database
        $hash_pass=$row['password'];
        
        if(password_verify($old_pass,$hash_pass)){
            
            //generate new password to hash/encrypt password
            $new_pass=password_hash($new_pass,PASSWORD_BCRYPT);
            //update query for update password into database
            mysqli_query($con,"UPDATE users SET password='$new_pass' WHERE id='$uid'");
            $arr=array('status'=>'success','msg'=>'Password has been updated succesfully.');
            
        }else{
            $arr=array('status'=>'error','msg'=>'Please enter correct password');
        }
        
        echo json_encode($arr);
        
    }






?>