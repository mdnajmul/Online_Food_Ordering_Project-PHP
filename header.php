<?php
    
    
   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

   //include constant.inc.php file
   include('constant.inc.php');



   //call 'getWebsiteSetting()' function to get information about website setting
   $websiteSetting=getWebsiteSetting();
   //hold all information
   $cart_minimum_price=$websiteSetting['cart_min_price'];
   $cart_message=$websiteSetting['cart_min_price_msg'];
   $website_close=$websiteSetting['website_close'];
   $website_close_msg=$websiteSetting['website_close_msg'];
   $wallet_message=$websiteSetting['wallet_balance_msg'];
       
       
       
       

   //call this function when page reload
   getDishCartStatus();

    //===== when user click 'UPDATE SHOPPING CART' button from cart page =====//
    if(isset($_POST['update_cart'])){
        foreach($_POST['qty'] as $key=>$val){
            //For login user
            if(isset($_SESSION['FOOD_USER_LOGIN'])){
                //check dish quantity is 0 or not.If 0 then delete that dish from database 'dish_cart' table
                if($val[0]==0){
                    //delete/remove dish item from 'dish_cart' table
                    mysqli_query($con,"DELETE FROM dish_cart WHERE dish_details_id='$key' AND user_id='".$_SESSION['FOOD_USER_ID']."'");
                }else{
                    //update dish quantity
                    mysqli_query($con,"UPDATE dish_cart SET qty='".$val[0]."' WHERE dish_details_id='$key' AND user_id='".$_SESSION['FOOD_USER_ID']."'");
                }
            }
            //For not login user
            else{
                //check dish quantity is 0 or not.If 0 then unset that dish from session cart
                if($val[0]==0){
                    unset($_SESSION['cart'][$key]['qty']);
                }else{
                    $_SESSION['cart'][$key]['qty']=$val[0];
                }
            }
        }
    }
    // ======================================================================== //


   //call 'getUserFullCart()' to fetch add to cart data
   $cartArray=getUserFullCart();
   //hold total dish item inside cart
   $totalCartDish=count($cartArray);

   $totalCartPrice=getCartTotalPrice();

   $Wallet_total_balance=0;
   if(isset($_SESSION['FOOD_USER_ID'])){
       //get wallet total balance
       $Wallet_total_balance=getWalletTotalAmount($_SESSION['FOOD_USER_ID']);
   }
?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo FRONT_SITE_NAME;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/slick.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/chosen.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH?>assets/css/responsive.css">
    <script src="<?php echo SITE_PATH?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- header start -->
    <header class="header-area">
        <div class="header-top black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-4 col-12 col-sm-4">
                        <div class="welcome-area">
                            
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 col-sm-4">
                       <?php if(isset($_SESSION['FOOD_USER_LOGIN'])){ ?>
                            <div id="wallet_top_box">
                                <a href="<?php echo SITE_PATH?>wallet"><span style="color:#fff">Wallet Balance: </span><span style="color: #FF8C00;">&nbsp;&#2547;<?php echo ' '.$Wallet_total_balance;?></span></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-2 col-md-8 col-12 col-sm-8">
                        <div class="account-curr-lang-wrap f-right">
                           <?php if(isset($_SESSION['FOOD_USER_LOGIN'])){ ?>
                                <ul>
                                    <li class="top-hover"><a href="#"><?php echo "Welcome! <span id='user_top_name' style='color:green; font-weight:bold; text-transform:capitalize;'> ".$_SESSION['FOOD_USER_NAME']."</span> ";?><i class="ion-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="<?php echo SITE_PATH?>profile">Profile </a></li>
                                            <li><a href="<?php echo SITE_PATH?>order_history">Order History</a></li>
                                            <li><a href="<?php echo SITE_PATH?>logout">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <div class="logo">
                            <a href="<?php echo SITE_PATH?>">
                                <img alt="" src="assets/img/logo/food_online_logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                        <div class="header-middle-right f-right">
                            <div class="header-login">
                                <?php if(!isset($_SESSION['FOOD_USER_LOGIN'])){?>
                                    <a href="<?php echo SITE_PATH?>login_register">
                                        <div class="header-icon-style">
                                            <i class="icon-user icons"></i>
                                        </div>
                                        <div class="login-text-content" style="font-size:18px;">
                                            <p>Register <br> or <span>Sign in</span></p>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="header-wishlist">
                                &nbsp;
                            </div>
                            <div class="header-cart">
                                <a href="#">
                                    <div class="header-icon-style">
                                        <i class="icon-handbag icons"></i>
                                        <span class="count-style" id="totalCartDish"><?php echo $totalCartDish;?></span>
                                    </div>
                                    <div class="cart-text">
                                        <span class="digit">My Cart</span>
                                        <span class="cart-digit-bold" id="totalCartPrice" style="color: #FF8C00;">
                                            <?php 
                                                if($totalCartPrice!=0){
                                                    echo '&#2547; '.$totalCartPrice;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                </a>
                                <?php if($totalCartPrice!=0){ ?>
                                    <div class="shopping-cart-content">
                                            <ul id="cart_ul">
                                                <?php foreach($cartArray as $key=>$list){ ?>
                                                    <li class="single-shopping-cart" id="attr_<?php echo $key?>">
                                                        <div class="shopping-cart-img">
                                                            <a href="javascript:void(0)"><img alt="" src="<?php echo DISH_IMAGE_SITE_PATH.$list['image']?>"></a>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4><a href="javascript:void(0)"><?php echo $list['name'].' ('.$list['attribute'].')'?></a></h4>
                                                            <h6>Qty: <?php echo $list['qty']?></h6>
                                                            <h6>Unit Price: <?php echo '&#2547; '.$list['price']?></h6>
                                                            <span>Total Price: <?php echo '&#2547; '.($list['qty']*$list['price'])?></span>
                                                        </div>
                                                        <div class="shopping-cart-delete">
                                                            <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key?>')"><i class="ion ion-close"></i></a>
                                                        </div>
                                                    </li>
                                                 <?php } ?>    
                                            </ul>
                                            <div class="shopping-cart-total">
                                                <h4>Shipping : <span>&#2547; 50</span></h4>
                                                <h4>Grand Total : <span class="shop-total"><?php echo '&#2547; '.($totalCartPrice+50);?></span></h4>
                                            </div>
                                            <div class="shopping-cart-btn">
                                                <a href="<?php echo SITE_PATH?>cart">view cart</a>
                                                <a href="<?php echo SITE_PATH?>checkout">checkout</a>
                                            </div>
                                        </div>
                                    <?php } ?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom transparent-bar black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="<?php echo SITE_PATH?>shop">Shop</a></li>
                                    <li><a href="<?php echo SITE_PATH?>about_us">About Us</a></li>
                                    <li><a href="<?php echo SITE_PATH?>contact_us">Contact us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow" id="nav">
                                    <li><a href="<?php echo SITE_PATH?>shop">Shop</a></li>
                                    <li><a href="<?php echo SITE_PATH?>about_us">About Us</a></li>
                                    <li><a href="<?php echo SITE_PATH?>contact_us">Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>