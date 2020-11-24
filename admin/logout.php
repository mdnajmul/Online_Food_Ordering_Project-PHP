<?php

    //session start
    session_start();

    //include function.inc.php file inside this login page
    include('../function.inc.php');
    
    //unset session value
    unset($_SESSION['ADMIN_LOGIN']);
    unset($_SESSION['ADMIN_USERNAME']);

    //call redirect() from function page for redirect to index.php page
    redirect('index.php');
?>