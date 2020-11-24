<?php

   //include database.inc.php file inside this login page
   include('../database.inc.php');

   //include function.inc.php file inside this login page
   include('../function.inc.php');

   include('../constant.inc.php');

   

   //check login or not_login
   if(!isset($_SESSION['ADMIN_LOGIN'])){
       //call redirect() from function page for redirect to index.php page
       redirect('index.php');
   }



   //*========= SET Page Titile ============*//
        
       //hold full page path
       $page_str=$_SERVER['REQUEST_URI'];
       //explode this path to array
       $page_str_Arr=explode('/',$page_str);
       //hold only page name
       $page_current_path=$page_str_Arr[count($page_str_Arr)-1];

       //write page title
       $page_title='';
       if($page_current_path=='' || $page_current_path=='dashboard.php'){
           $page_title='Dashboard';
       }else if($page_current_path=='category.php'){
           $page_title='Category';
       }else if($page_current_path=='add_category.php'){
           $page_title='Manage Category';
       }else if($page_current_path=='users.php'){
           $page_title='Users Master';
       }else if($page_current_path=='delivery_boy.php'){
           $page_title='Delivery Boy Master';
       }else if($page_current_path=='add_delivery_boy.php'){
           $page_title='Manage Delivery Boy';
       }else if($page_current_path=='coupon_code.php'){
           $page_title='Coupon Master';
       }else if($page_current_path=='add_coupon_code.php'){
           $page_title='Manage Coupon';
       }else if($page_current_path=='dish.php'){
           $page_title='Dish Master';
       }else if($page_current_path=='add_dish.php'){
           $page_title='Manage Dish';
       }else if($page_current_path=='banner.php'){
           $page_title='Banner Master';
       }else if($page_current_path=='add_banner.php'){
           $page_title='Manage Banner';
       }else if($page_current_path=='contact_us.php'){
           $page_title='Contact Us';
       }else if($page_current_path=='order.php'){
           $page_title='Order Master';
       }else if($page_current_path=='setting.php'){
           $page_title='Setting';
       }
    //*=============================================*//

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $page_title;?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="sidebar-light">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
                    <li class="nav-item nav-toggler-item">
                        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </li>

                </ul>
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="index.html"><img src="assets/images/logo.png" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo.png" alt="logo" /></a>
                </div>
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <span class="nav-profile-name"><?php echo $_SESSION['ADMIN_NAME'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                    <li class="nav-item nav-toggler-item-right d-lg-none">
                        <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="mdi mdi-view-quilt menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">
                            <i class="mdi mdi-bell menu-icon"></i>
                            <span class="menu-title">Order</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">
                            <i class="mdi mdi-view-headline menu-icon"></i>
                            <span class="menu-title">Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">
                            <i class="mdi mdi-account-box menu-icon"></i>
                            <span class="menu-title">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="delivery_boy.php">
                            <i class="mdi mdi-bike menu-icon"></i>
                            <span class="menu-title">Delivery Boy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="coupon_code.php">
                            <i class="mdi mdi-cash menu-icon"></i>
                            <span class="menu-title">Coupon Code</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dish.php">
                            <i class="mdi mdi-food menu-icon"></i>
                            <span class="menu-title">Dish</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="banner.php">
                            <i class="mdi mdi-image-area menu-icon"></i>
                            <span class="menu-title">Banner</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">
                            <i class="mdi mdi-message-text-outline menu-icon"></i>
                            <span class="menu-title">Contact Us</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="setting.php">
                            <i class="mdi mdi-settings menu-icon"></i>
                            <span class="menu-title">Settings</span>
                        </a>
                    </li>      

                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">