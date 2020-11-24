<?php

    include('header.php');

    if(!isset($_SESSION['FOOD_USER_ID'])){
        redirect(SITE_PATH.'shop');
    }

    $err_msg='';
    if(isset($_POST['add_wallet_money'])){
        $amount=get_safe_value($con,$_POST['wallet_balance']);
        
        if($amount>=10){
                
                $txnid = "SSLCZ_TEST_".uniqid();
                $userDetails=getUserDetails();
                $name=$userDetails['name'];
                $email=$userDetails['email'];
                $mobile=$userDetails['mobile'];
            
                $post_data = array();
                $post_data['store_id'] = "oviit5f1d140c9d4c7";
                $post_data['store_passwd'] = "oviit5f1d140c9d4c7@ssl";
                $post_data['total_amount'] = $amount;
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = $txnid;
                $post_data['success_url'] = "http://localhost/new_project/Food_Ordering_Project/wallet_payment_success.php";
                $post_data['fail_url'] = "http://localhost/new_project/Food_Ordering_Project/wallet_payment_fail.php";
                $post_data['cancel_url'] = "http://localhost/new_sslcz_gw/cancel.php";
                # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

                # EMI INFO
                $post_data['emi_option'] = "1";
                $post_data['emi_max_inst_option'] = "9";
                $post_data['emi_selected_inst'] = "9";

                # CUSTOMER INFORMATION
                $post_data['cus_name'] = $name;
                $post_data['cus_email'] = $email;
                $post_data['cus_add1'] = "Dhaka";
                $post_data['cus_add2'] = "Dhaka";
                $post_data['cus_city'] = "Dhaka";
                $post_data['cus_state'] = "Dhaka";
                $post_data['cus_postcode'] = "1230";
                $post_data['cus_country'] = "Bangladesh";
                $post_data['cus_phone'] = $mobile;
                $post_data['cus_fax'] = "01711111111";

                # SHIPMENT INFORMATION
                $post_data['ship_name'] = "testoviitvujj";
                $post_data['ship_add1 '] = "Dhaka";
                $post_data['ship_add2'] = "Dhaka";
                $post_data['ship_city'] = "Dhaka";
                $post_data['ship_state'] = "Dhaka";
                $post_data['ship_postcode'] = "1230";
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
            
        }else{
            $err_msg="Please enter valid amount(Minimum Tk.10)!";
        }
    }


?>
           
<div class="cart-main-area pt-50 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post" id="add_wallet_balance">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                           <div class="billing-info">
                               <label for="wallet_balance">Add Wallet Balance</label>
                               <input type="number" name="wallet_balance" placeholder="Enter Amount" required>
                           </div>
                        </div>
                        <div class="billing-back-btn">
                           <div class="billing-btn">
                               <button type="submit" name="add_wallet_money">ADD</button>
                           </div>
                        </div>
                     </div>
                     <span class="field_error"><?php echo $err_msg;?></span>  
                  </form>
                   <div class="register_msg">
                        <p class="form-messege "></p>
                   </div>
                    <?php
                        $wallet_details=getWallet($_SESSION['FOOD_USER_ID']);
                    ?>
                    <div class="table-content table-responsive">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Amount</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    foreach($wallet_details as $list){
                                ?>
                                <tr class="wallet_loop">
                                    <td><?php echo $i?></td>
                                    <?php if($list['type']=='in'){?>
                                    <td style="color:green;font-weight:bold;">(+) &#2547; <?php echo $list['amount']?></td>
                                    <?php } ?>
                                    <?php if($list['type']=='out'){?>
                                    <td style="color:red;font-weight:bold;">(-) &#2547; <?php echo $list['amount']?></td>
                                    <?php } ?>
                                    <td>
                                        <span class="<?php echo $list['type']?>"><?php echo $list['msg']?></span>
                                    </td>
                                    <td><?php echo $list['added_on']?></td>
                                </tr>
                                <?php
                                    $i++;
                                      } 
                                ?>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
       
      
<?php include('footer.php'); ?>