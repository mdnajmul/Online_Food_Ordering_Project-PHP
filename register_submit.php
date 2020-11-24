<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   //include constant.inc.php file inside this index page
   include('constant.inc.php');

   //include this file for send email
   include('smtp/class.phpmailer.php');



    $name=get_safe_value($con,$_POST['name']);
    $email=get_safe_value($con,$_POST['email']);
    $mobile=get_safe_value($con,$_POST['mobile']);
    $password=get_safe_value($con,$_POST['password']);

    
    $check_email = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email = '$email'"));
    if($check_email>0){
        echo "present";
        
    }else{
        //generate hash/encrypt password
        $hash_pass=password_hash($password,PASSWORD_BCRYPT);
        $rand_str=rand_str();
        $referral_code=rand_str();
        $added_on=date('Y-m-d h:i:s');
        if(isset($_SESSION['FROM_REFERRAL_CODE']) && $_SESSION['FROM_REFERRAL_CODE']!=''){
            $from_referral_code=get_safe_value($con,$_SESSION['FROM_REFERRAL_CODE']);
            //check refferal code is valid or not valid
            $res=mysqli_query($con,"SELECT * FROM users WHERE referral_code='$from_referral_code'");
            if(mysqli_num_rows($res)<1){
                $from_referral_code='';
            }
        }else{
            $from_referral_code='';
        }
        
        mysqli_query($con,"insert into users(name,email,mobile,password,status,email_verify,rand_str,referral_code,from_referral_code,added_on) values('$name','$email','$mobile','$hash_pass',1,0,'$rand_str','$referral_code','$from_referral_code','$added_on')");
        echo "insert";
        
        $id=mysqli_insert_id($con);
        unset($_SESSION['FROM_REFERRAL_CODE']);

        $webSetting=getWebsiteSetting();
        $wallet_amount=$webSetting['wallet_amount'];

        manageWallet($id,$wallet_amount,'in','Registration Bonus');
        
        //=== Send verify link to email ===//
            $html="<html><body>";
            $html.="<p style='color:#333; font-size:14px; font-family:san-serif,Arial;'>please click on given link to activate your account</p>";
            $html.="<a href='".SITE_PATH."verify?id=".$rand_str."'>Click Verify Email</a>";
            $html.="</body></html>"; 
            //$html=SITE_PATH."verify/".$rand_str;
            
            send_email($email,$html,'Verify your email id');
        
        //=================================//
        
        
    }






?>