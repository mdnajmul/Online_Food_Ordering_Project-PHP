<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   //include constant.inc.php file inside this index page
   include('constant.inc.php');

    //check user login or not login
    if(!isset($_SESSION['FOOD_USER_ID'])){
        redirect(SITE_PATH.'shop');
    }

   
    $rate=get_safe_value($con,$_POST['rate']);
    $dish_details_id=get_safe_value($con,$_POST['id']);
    $order_id=get_safe_value($con,$_POST['order_id']);
    $user_id=$_SESSION['FOOD_USER_ID'];
           
    //execute insert query
    mysqli_query($con, "INSERT INTO rating(user_id,order_id,dish_details_id,rating_value) VALUES('$user_id','$order_id','$dish_details_id','$rate')");

?>