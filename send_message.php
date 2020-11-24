<?php
   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

    //include constant.inc.php file
   include('constant.inc.php');
   
    $name=get_safe_value($con,$_POST['name']);
    $email=get_safe_value($con,$_POST['email']);
    $mobile=get_safe_value($con,$_POST['mobile']);
    $subject=get_safe_value($con,$_POST['subject']);
    $message=get_safe_value($con,$_POST['message']);
    $added_on=date('Y-m-d h:i:s');
           
    //execute insert query
    mysqli_query($con, "INSERT INTO contact_us(name,email,mobile,subject,message,added_on) VALUES('$name','$email','$mobile','$subject','$message','$added_on')");
    echo "Thank you for connecting with us, we will get back to you shortly!";
?>