<?php

    include('header.php');

    if(!isset($_SESSION['ORDER_ID'])){
        //call 'redirect()' function
        redirect(SITE_PATH.'shop');
    }

    if(isset($_SESSION['COUPON_ID'])){
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_VALUE']);
    }

?>
           

           <div class="breadcrumb-area gray-bg">
               <div class="container">
                   <div class="breadcrumb-content">
                       <ul>
                           <li><a href="<?php echo SITE_PATH?>shop">Home</a></li>
                           <li class="active">Order Placed </li>
                       </ul>
                   </div>
               </div>
           </div>
           <div class="about-us-area pt-50 pb-100">
               <div class="container">
                   <div class="row">
                       <div class="col-lg-12 col-md-7 d-flex align-items-center">
                           <div class="overview-content-2">
                              
                               <h2><span style="color:green;">Your order has been successfully placed!</span></h2><br/><br/>
                               <h2><span>Your order Id: </span><?php echo $_SESSION['ORDER_ID']?></h2>
                               
                               <div class="overview-btn mt-45">
                                   <a class="btn-style-2" href="<?php echo SITE_PATH?>shop">Shop Now</a>
                               </div>
                               
                           </div>
                       </div>

                   </div>
               </div>
           </div>
       
      
<?php 
    unset($_SESSION['ORDER_ID']);
    unset($_SESSION['FOOD_ORDER_ADDRESS_EMAIL']);                              
    include('footer.php'); 
?>