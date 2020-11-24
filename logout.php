<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   
        unset($_SESSION['FOOD_USER_LOGIN']);
        unset($_SESSION['FOOD_USER_ID']);
        unset($_SESSION['FOOD_USER_NAME']);
        unset($_SESSION['FOOD_USER_MOBILE']);

        header('location:shop');
        die();
       





?>