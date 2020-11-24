<?php

    include('header.php');

    //check website close or not
    if($website_close==1){
        redirect(SITE_PATH.'shop');
    }
    

    //include this file for send email
    include('smtp/class.phpmailer.php');

    //call 'getUserFullCart()' to fetch add to cart data
    $cartArray=getUserFullCart();

    //check cart is empty or not empty.If empty then user couldn't go to checkout page
    if(count($cartArray)>0){
        
    }else{
        //call 'redirect()' function
        redirect(SITE_PATH.'shop');
    }


    //check user login or not login
    if(isset($_SESSION['FOOD_USER_LOGIN'])){
        $is_show='';
        $box_id='';
        $final_show='show';
        $final_box_id='payment-2';
    }else{
        $is_show='show';
        $box_id='payment-1';
        $final_show='';
        $final_box_id='';
    }

    //hold login user data
    $userDataArr=getUserDetails();
    $is_error='';
    $wallet_error_msg='';
    

    //For Checkout information
    if(isset($_POST['place_order'])){
        
        $payment_type=get_safe_value($con,$_POST['payment_type']);
        
        if($cart_minimum_price!=''){
            if(($totalCartPrice+50)>=$cart_minimum_price){
               $is_error=''; 
            }else{
               $is_error='yes'; 
            }
        }
        
        if(trim($payment_type)=='wallet'){
            if($Wallet_total_balance<($totalCartPrice+50)){
                $wallet_error_msg='yes';
            }
        }
        
        
        if($is_error=='' && $wallet_error_msg==''){

            //hold all checkout information from checkout form
            $checkout_name=get_safe_value($con,$_POST['checkout_name']);
            $checkout_email=get_safe_value($con,$_POST['checkout_email']);
            $checkout_mobile=get_safe_value($con,$_POST['checkout_mobile']);
            $checkout_zip=get_safe_value($con,$_POST['checkout_zip']);
            $checkout_address=get_safe_value($con,$_POST['checkout_address']);
            //$payment_type=get_safe_value($con,$_POST['payment_type']);
            $added_on=date('Y-m-d h:i:s');

            $_SESSION['FOOD_ORDER_ADDRESS_EMAIL']=$checkout_email;

            $shiping=50;
            $totalCartPrice=$totalCartPrice+$shiping;
            
            $payment_status = 'pending';
            $order_status = '1';
            $txnid = "SSLCZ_TEST_".uniqid();
            $pay_id = "";
            $online_payment_status = "INVALID";
            $payment_method='';
            if(trim($payment_type)=='cash'){
                $payment_method="CASH";
                $online_payment_status = "No";
                $txnid='';
            }


            if(isset($_SESSION['COUPON_ID'])){
                $coupon_id=$_SESSION['COUPON_ID'];
                $coupon_code=$_SESSION['COUPON_CODE'];
                $coupon_value=$_SESSION['COUPON_VALUE'];
                $totalCartPrice=$totalCartPrice-$coupon_value;

                unset($_SESSION['COUPON_ID']);
                unset($_SESSION['COUPON_CODE']);
                unset($_SESSION['COUPON_VALUE']);
            }else{
                $coupon_id=0;
                $coupon_code='';
                $coupon_value='';
            }
            
            
            if(trim($payment_type)=='wallet'){
                    $payment_method="Wallet Balance";
                    $payment_status="success";
                    $online_payment_status = "No";
                    $txnid='';   
            }
            
            //write insert query
            $sql="INSERT INTO order_master(user_id,name,email,mobile,address,zip_code,total_price,payment_type,payment_status,order_status,txnid,pay_id,online_payment_status,payment_method,coupon_id,coupon_code,coupon_value,added_on) VALUES('".$_SESSION['FOOD_USER_ID']."','$checkout_name','$checkout_email','$checkout_mobile','$checkout_address','$checkout_zip','$totalCartPrice','$payment_type','$payment_status','$order_status','$txnid','$pay_id','$online_payment_status','$payment_method','$coupon_id','$coupon_code','$coupon_value','$added_on')";

            //execute query
            mysqli_query($con,$sql);
            //hold last insert id
            $insert_id=mysqli_insert_id($con);

            //hold $insert_id/order_id into session for further use
            $_SESSION['ORDER_ID']=$insert_id;

            //write foreach loop to insert cart data to 'order_details' table
            foreach($cartArray as $key=>$val){
                mysqli_query($con,"INSERT INTO order_details(order_id,dish_details_id,unit_price,qty) VALUES('$insert_id','$key','".$val['price']."','".$val['qty']."')");
            }

            //empty cart
            emptyCart();
            


            if(trim($payment_type)=='online'){
                /* PHP */


                $post_data = array();
                $post_data['store_id'] = "oviit5f1d140c9d4c7";
                $post_data['store_passwd'] = "oviit5f1d140c9d4c7@ssl";
                $post_data['total_amount'] = $totalCartPrice;
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = $txnid;
                $post_data['success_url'] = "http://localhost/new_project/Food_Ordering_Project/payment_success.php";
                $post_data['fail_url'] = "http://localhost/new_project/Food_Ordering_Project/payment_fail.php";
                $post_data['cancel_url'] = "http://localhost/new_sslcz_gw/cancel.php";
                # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

                # EMI INFO
                $post_data['emi_option'] = "1";
                $post_data['emi_max_inst_option'] = "9";
                $post_data['emi_selected_inst'] = "9";

                # CUSTOMER INFORMATION
                $post_data['cus_name'] = $checkout_name;
                $post_data['cus_email'] = $checkout_email;
                $post_data['cus_add1'] = $checkout_address;
                $post_data['cus_add2'] = $checkout_address;
                $post_data['cus_city'] = "Dhaka";
                $post_data['cus_state'] = "Dhaka";
                $post_data['cus_postcode'] = $checkout_zip;
                $post_data['cus_country'] = "Bangladesh";
                $post_data['cus_phone'] = $checkout_mobile;
                $post_data['cus_fax'] = "01711111111";

                # SHIPMENT INFORMATION
                $post_data['ship_name'] = "testoviitvujj";
                $post_data['ship_add1 '] = $checkout_address;
                $post_data['ship_add2'] = $checkout_address;
                $post_data['ship_city'] = "Dhaka";
                $post_data['ship_state'] = "Dhaka";
                $post_data['ship_postcode'] = $checkout_zip;
                $post_data['ship_country'] = "Bangladesh";

                # OPTIONAL PARAMETERS
                $post_data['value_a'] = "ref001";
                $post_data['value_b '] = "ref002";
                $post_data['value_c'] = "ref003";
                $post_data['value_d'] = "ref004";

                # CART PARAMETERS
                $post_data['cart'] = json_encode(array(
                    array("product"=>"DHK TO BRS AC A1","amount"=>"200.00"),
                    array("product"=>"DHK TO BRS AC A2","amount"=>"200.00"),
                    array("product"=>"DHK TO BRS AC A3","amount"=>"200.00"),
                    array("product"=>"DHK TO BRS AC A4","amount"=>"200.00")
                ));
                $post_data['product_amount'] = "100";
                $post_data['vat'] = "5";
                $post_data['discount_amount'] = "5";
                $post_data['convenience_fee'] = "3";



                # REQUEST SEND TO SSLCOMMERZ
                $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $direct_api_url );
                curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($handle, CURLOPT_POST, 1 );
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


                $content = curl_exec($handle );

                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                if($code == 200 && !( curl_errno($handle))) {
                    curl_close( $handle);
                    $sslcommerzResponse = $content;
                } else {
                    curl_close( $handle);
                    echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                    exit;
                }

                # PARSE THE JSON RESPONSE
                $sslcz = json_decode($sslcommerzResponse, true );

                if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
                        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                    echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                    # header("Location: ". $sslcz['GatewayPageURL']);
                    exit;
                } else {
                    echo "JSON Data parsing error!";
                }

            }
            if(trim($payment_type)=='wallet'){
                
                $user_id=$_SESSION['FOOD_USER_ID'];

                manageWallet($user_id,$totalCartPrice,'out','Shopping');

                //call 'orderInvoiceSendEmail()' function for html data Invoice which sent to user email when order place 
                $html=orderInvoiceSendEmail($insert_id);

                //call 'send_email()' function for send email
                send_email($checkout_email,$html,'Order Placed Invoice');

                //redirect to success page
                redirect(SITE_PATH.'success');
                
            }else{

                //call 'orderInvoiceSendEmail()' function for html data Invoice which sent to user email when order place 
                $html=orderInvoiceSendEmail($insert_id);

                //call 'send_email()' function for send email
                send_email($checkout_email,$html,'Order Placed Invoice');

                //redirect to success page
                redirect(SITE_PATH.'success');
            }
        }
        
        
    }
?>
           
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active"> Checkout </li>
            </ul>
        </div>
    </div>
</div>
<!-- checkout-area start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-1">Checkout method</a></h5>
                            </div>
                            <div id="<?php echo $box_id?>" class="panel-collapse collapse <?php echo $is_show?>">
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="login-register-wrapper">
                                                <div class="login-register-tab-list nav">
                                                    <a class="active" data-toggle="tab" href="#lg1">
                                                        <h4> login </h4>
                                                    </a>
                                                    <a data-toggle="tab" href="#lg2">
                                                        <h4> register </h4>
                                                    </a>
                                                </div>
                                                <div class="tab-content">
                                                    <div id="lg1" class="tab-pane active">
                                                        <div class="login-form-container">
                                                            <div class="login-register-form">
                                                                <form id="login_form" method="post">
                                                                    <div style="margin-bottom:15px">
                                                                        <input type="email" name="log_email" id="log_email" placeholder="Email*">
                                                                        <span class="field_error" id="log_email_error"></span>
                                                                    </div>
                                                                    <div style="margin-bottom:15px">
                                                                        <input type="password" name="log_password" id="log_password" placeholder="Password*">
                                                                        <span class="field_error" id="log_password_error"></span>
                                                                    </div>
                                                                    <div class="button-box">
                                                                        <button type="button" onclick="user_login_for_checkout()" id="login_btn">Login</button>
                                                                    </div>
                                                                </form>
                                                                <div class="login_msg">
                                                                    <p class="form-messege field_error"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="lg2" class="tab-pane">
                                                        <div class="login-form-container">
                                                            <div class="login-register-form">
                                                                <form id="register_form" method="post">

                                                                    <div style="margin-bottom:15px">
                                                                        <input type="text" name="name" id="name" placeholder="Name*">
                                                                        <span class="field_error" id="name_error"></span>
                                                                    </div>
                                                                    <div style="margin-bottom:15px">
                                                                        <input type="email" name="email" id="email" placeholder="Email*">
                                                                        <span class="field_error" id="email_error"></span>
                                                                    </div>
                                                                    <div style="margin-bottom:15px">
                                                                        <input type="text" name="mobile" id="mobile" placeholder="Mobile*" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
                                                                        <span class="field_error" id="mobile_error"></span>
                                                                    </div>
                                                                    <div style="margin-bottom:15px">
                                                                        <input type="password" name="password" id="password" placeholder="Password*">
                                                                        <span class="field_error" id="password_error"></span>
                                                                    </div>

                                                                    <div class="button-box" style="margin-bottom:15px">
                                                                        <button type="button" onclick="user_register()" id="register_btn">Register</button>
                                                                    </div>

                                                                </form>
                                                                <div class="register_msg">
                                                                    <p class="form-messege "></p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq" href="#payment-2">Other information</a></h5>
                        </div>
                        <div id="<?php echo $final_box_id?>" class="panel-collapse collapse <?php echo $final_show?>">
                            <div class="panel-body">
                                <form method="post">
                                    <div class="billing-information-wrapper">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Name</label>
                                                    <input type="text" name="checkout_name" value="<?php echo $userDataArr['name']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Email Address</label>
                                                    <input type="email" name="checkout_email" value="<?php echo $userDataArr['email']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Mobile</label>
                                                    <input type="text" name="checkout_mobile" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" value="<?php echo $userDataArr['mobile']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="billing-info">
                                                    <label>Zip/Postal Code</label>
                                                    <input type="text" name="checkout_zip" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Address</label>
                                                    <input type="text" name="checkout_address" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ship-wrapper">
                                            <div class="single-ship">
                                                <input type="radio" name="payment_type" value="cash" checked="checked">
                                                <label>Cash on Delivery(COD)</label>
                                            </div>
                                            <div class="single-ship">
                                                <input type="radio" name="payment_type" value="online">
                                                <label>Online/Digital Payment</label>
                                            </div>
                                            <div class="single-ship">
                                                <input type="radio" name="payment_type" value="wallet">
                                                <label>Payment From Wallet Balance</label>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-btn">
                                                <button type="submit" name="place_order">Place Your Order</button>
                                            </div>
                                        </div>
                                        <?php if($is_error=='yes'){ ?>
                                                 <div class="product-price-wrapper" style="margin-top:10px;">
                                                     <span style="color:red;text-transform: capitalize;"><?php echo $cart_message;?></span>
                                                 </div>   
                                        <?php }if(trim($wallet_error_msg)=='yes'){?>
                                                     <div class="product-price-wrapper" style="margin-top:10px;">
                                                         <span style="color:red;text-transform: capitalize;"><?php echo $wallet_message;?></span> 
                                                     </div>   
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="checkout-progress">
                    <div class="shopping-cart-content-box">
                        <h4 class="checkout_title" style="text-align:center;color:#FF00FF">Cart Details</h4>
                        <ul>
                            <?php foreach($cartArray as $key=>$list){ ?>
                            <li class="single-shopping-cart">
                                <div class="shopping-cart-img">
                                    <a href="#"><img alt="" src="<?php echo DISH_IMAGE_SITE_PATH.$list['image']?>"></a>
                                </div>
                                <div class="shopping-cart-title">
                                    <h4><a href="#"><?php echo $list['name'].' ('.$list['attribute'].')'?></a></h4>
                                    <h6>Qty: <?php echo $list['qty']?></h6>
                                    <h6>Unit Price: <?php echo '&#2547; '.$list['price']?></h6>
                                    <span>Total Price: <?php echo '&#2547; '.($list['qty']*$list['price'])?></span>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="shopping-cart-total">
                            <h4>Order Total : <span class="shop-total"><?php echo '&#2547; '.$totalCartPrice?></span></h4>
                            <h4>Shipping : <span style="color:green">(+) &#2547; 50</span></h4>
                            <h4 id="coupon_box">Discount : <span style="color:red" id="coupon_discount_price"></span></h4>
                            <h4>Grand Total : <span class="shop-total" id="final_price"><?php echo '&#2547; '.($totalCartPrice+50);?></span></h4>
                        </div>
                        <div class="single-contact-form">
                            <label for="discount" class=" form-control-label discount_txt">Coupon Code?</label>
                            <div class="contact-box name">
                                <input type="text" id="coupon_str" name="discount" placeholder="Enter coupon" class="form-control discount_input" required>
                                <button type="button" onclick="set_coupon()" class="discount_btn">APPLY COUPON</button>
                            </div>
                            <span class="field_error" id="coupon_result" style="margin-left:-24px;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
      
      
      <script>
            function set_coupon(){
                var coupon_txt = jQuery('#coupon_str').val();
                if(coupon_txt!=''){
                    jQuery('#coupon_result').html('');
                    jQuery.ajax({
                        url:'set_coupon.php',
                        type:'post',
                        data:'coupon_txt='+coupon_txt,
                        success:function(result){
                            //decode result value from json format
                            var data = jQuery.parseJSON(result);
                            if(data.is_error=='yes'){
                                jQuery('#coupon_box').hide();
                                swal("Error",data.msg,"error");
                                //jQuery('#coupon_result').html(data.msg);
                                jQuery('#final_price').html(data.final_price);
                            }
                            if(data.is_error=='no'){
                                jQuery('#coupon_box').show();
                                //jQuery('#coupon_box').css({"display":"-moz-flex","display":"-ms-flex","display":"-o-flex","display":"flex"});
                                swal("Congratulation!",data.msg,"success");
                                jQuery('#coupon_discount_price').html('(-) &#2547; '+data.discount_value);
                                jQuery('#final_price').html('&#2547; '+data.final_price);
                            }
                        }
                    });
                }else{
                    jQuery('#coupon_result').html('Please enter a discount code !');
                }
            }
          
          
        </script>
       
      
<?php 

    //If we apply coupon code but not submit payment form & we reload the page. That time previous coupon details will be clear but coupon_details inside session is not clear.For this reason we unset coupon details from session after page reload
    if(isset($_SESSION['COUPON_ID'])){
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_VALUE']);
    }

    include('footer.php'); 
?>