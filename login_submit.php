<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   //include constant.inc.php file inside this index page
   include('constant.inc.php');

   
    $email=get_safe_value($con,$_POST['email']);
    //hold user passord which given by user and this password is not hash/encrypt
    $password=get_safe_value($con,$_POST['password']);

    $res = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' LIMIT 1");
    $check_data = mysqli_num_rows($res);
    if($check_data>0){
        $row = mysqli_fetch_assoc($res);
        $status=$row['status'];
        $email_verify=$row['email_verify'];
        //hold user hash/encrypt password from database
        $hash_pass=$row['password'];
        if($email_verify==1){
            if($status==1){
                //check password correct or not
                if(password_verify($password,$hash_pass)){
                    $_SESSION['FOOD_USER_LOGIN']='yes';
                    $_SESSION['FOOD_USER_ID']=$row['id'];
                    $_SESSION['FOOD_USER_NAME']=$row['name'];
                    echo "valid";
                    
                    //check any dish is presesent inside cart session? if present then call 'manageUserCart()' to add cart data inside database table after user successfully login
                    if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
                        foreach($_SESSION['cart'] as $key=>$val){
                            $user_id=$_SESSION['FOOD_USER_ID'];
                            $qty=$val['qty'];
                            $attr=$key;
                            //call 'manageUserCart()' function to add/update dish inside database table from SESSION after user login
                            manageUserCart($user_id,$qty,$attr);
                        }
                    }
                }else{
                    echo "wrongpassword";
                }
            }else{
                echo "deactivate";
            }
        }else{
            echo "notverify";
        }
        
    }else{
        echo "wrongemail";
        
    }






?>