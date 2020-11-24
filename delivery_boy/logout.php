<?php

    //session start
    session_start();

    //include function.inc.php file inside this login page
    include('../function.inc.php');
    
    //unset session value
    unset($_SESSION['DELIVERY_BOY_USER_LOGIN']);
    unset($_SESSION['DELIVERY_BOY_NAME']);
    unset($_SESSION['DELIVERY_BOY_ID']);

    //call redirect() from function page for redirect to index.php page
    redirect('index.php');
?>