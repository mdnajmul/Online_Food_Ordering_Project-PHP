<?php

   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

    //include constant.inc.php file
   include('constant.inc.php');

   //include this file for send email
   include('smtp/class.phpmailer.php');

   
    $email=get_safe_value($con,$_POST['email']);
    
    $res=mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
    $check_email = mysqli_num_rows($res);
    if($check_email>0){
        
        //fetch all data from user table for '$email' id 
        $row=mysqli_fetch_assoc($res);
        $id=$row['id'];
        
        $rand_password=rand(11111,99999);
        $hash_rand_password=password_hash($rand_password,PASSWORD_BCRYPT);
        mysqli_query($con,"UPDATE users SET password='$hash_rand_password' WHERE id='$id'");
        
        
        $subject="Your New Password";
        $html="Your password is: <strong>".$rand_password."</strong>";
        send_email($email,$html,$subject);
        
        echo "present";
        
    }else{
        echo "not_present";
    }

    

?>