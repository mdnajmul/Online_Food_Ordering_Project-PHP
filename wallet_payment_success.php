<?php

   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

   //include constant.inc.php file
   include('constant.inc.php');

   //include this file for send email
   include('smtp/class.phpmailer.php');

    $user_id=$_SESSION['FOOD_USER_ID'];
    $userDetails=getUserDetails();
    $email=$userDetails['email'];

    $val_id=urlencode($_POST['val_id']);
    $store_id=urlencode("oviit5f1d140c9d4c7");
    $store_passwd=urlencode("oviit5f1d140c9d4c7@ssl");
    $requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $requested_url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

    $result = curl_exec($handle);

    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if($code == 200 && !( curl_errno($handle)))
    {

        # TO CONVERT AS ARRAY
        # $result = json_decode($result, true);
        # $status = $result['status'];

        # TO CONVERT AS OBJECT
        $result = json_decode($result);

        # TRANSACTION INFO
        $status = $result->status;
        $tran_date = $result->tran_date;
        $tran_id = $result->tran_id;
        $val_id = $result->val_id;
        $amount = $result->amount;
        $store_amount = $result->store_amount;
        $bank_tran_id = $result->bank_tran_id;
        $card_type = $result->card_type;

        # EMI INFO
        $emi_instalment = $result->emi_instalment;
        $emi_amount = $result->emi_amount;
        $emi_description = $result->emi_description;
        $emi_issuer = $result->emi_issuer;

        # ISSUER INFO
        $card_no = $result->card_no;
        $card_issuer = $result->card_issuer;
        $card_brand = $result->card_brand;
        $card_issuer_country = $result->card_issuer_country;
        $card_issuer_country_code = $result->card_issuer_country_code;

        # API AUTHENTICATION
        $APIConnect = $result->APIConnect;
        $validated_on = $result->validated_on;
        $gw_version = $result->gw_version;
        
        manageWallet($user_id,$amount,'in','Credit Added');
        
        $html='<p>Total Amount Credited: &#2547; '.$amount.'</p>';
        $html.='<p>Transaction ID: '.$tran_id.'</p>';
        $html.='<p>Payment Method: '.$card_type.'</p>';
        $html.='<p>Payment Status: '.$status.'</p>';

        //call 'send_email()' function for send email
        send_email($email,$html,'Wallet Credit Added');
        
        //redirect to success page
        redirect(SITE_PATH.'wallet_success');
        

    } else {
       
        //redirect to payment_fail page
        redirect(SITE_PATH.'wallet_payment_fail');
        
        
    }


?>