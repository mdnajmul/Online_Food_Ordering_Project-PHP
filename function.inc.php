<?php

    /** Here we write some common function that we use from different file **/


    //create two basic function name 'pr()' and 'prx()' that return us array value inside <pre> & print_r tag
    function pr($arr){
        echo '<pre>';
        print_r($arr);
    }

    function prx($arr){
        echo '<pre>';
        print_r($arr);
        die();
    }


    //create this function for pass data which comes from input field and 'database connection($con)' through/pass by 'mysqli_real_escape_string()' function
    function get_safe_value($con, $val){
        //validate that data is empty or not
        if($val != ''){
            //remove space from text
            $val = trim($val);
            return strip_tags(mysqli_real_escape_string($con, $val));
        }
    }


    //create redirect function for redirect page through this function
    function redirect($link){
        ?>
            <script>
                window.location.href='<?php echo $link; ?>';
            </script>
        <?php
        die();
    }




    //Email Send
    function send_email($email,$html,$subject){
        $mail = new PHPMailer(); 
        $mail->IsSMTP(); 
        $mail->SMTPDebug = 1; 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; 
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = "neberhossain7@gmail.com";
        $mail->Password = "01823260474";
        $mail->SetFrom("neberhossain7@gmail.com");
        $mail->Subject = $subject;
        $mail->Body =$html;
        $mail->AddAddress($email);
        if($mail->Send()){
            //echo 'yes';
        }else{

        }
    }



    //create random string
    function rand_str(){
        $str=str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz");
        //hold first 15 character
        $str=substr($str,0,15);
        return $str;
    }


    //Formate Date
    function dateFormat($date){
        $str=strtotime($date);
        return date('d-m-Y',$str);
    }



    //Get dish details from user cart
    function getUserCart(){
        global $con;
        $arr=array();
        $user_id=$_SESSION['FOOD_USER_ID'];
        $res=mysqli_query($con,"SELECT * FROM dish_cart WHERE user_id='$user_id'");
        while($row=mysqli_fetch_assoc($res)){
            //all data put inside $arr array variable
            $arr[] = $row;
        }
        return $arr;
    }





    //Manage user cart/dish add to user cart
    function manageUserCart($user_id,$qty,$attr){
        global $con;
        //check these attribut already added inside database table? if already added then update only quantity. If not added the add inside database table
        $res=mysqli_query($con,"SELECT * FROM dish_cart WHERE user_id='$user_id' AND dish_details_id='$attr'");
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
            $cart_id=$row['id'];
            //update dish quantity
            mysqli_query($con,"UPDATE dish_cart SET qty='$qty' WHERE id='$cart_id'");
        }else{
            $added_on=date('Y-m-d h:i:s');
            //insert/add dish
            mysqli_query($con,"INSERT INTO dish_cart(user_id,dish_details_id,qty,added_on) VALUES('$user_id','$attr','$qty','$added_on')");
        }
    }



    //Get Dish Cart Details/Attribute Staus(Active or Deactive)
    function getDishCartStatus(){
        global $con;
        $cartArray=array();
        $dishDetailsID=array();
        
        //For login user
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
            //call 'getUserCart()' for fetch data from 'dish_cart' table
            $geteUserCart=getUserCart();
            
            //format cart data same too session data when show
            foreach($geteUserCart as $list){
                //hold all attribute_id/dish_details_id inside '$dishDetailsID' array variable from whish dish added to the cart
                $dishDetailsID[]=$list['dish_details_id'];
                    
            }
        }
        //For not login user
        else{
            if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
             
               //set attribute price in session cart & hold cart data from session
               foreach($_SESSION['cart'] as $key=>$val){
                   //hold all attribute_id/dish_details_id inside '$dishDetailsID' array variable from whish dish added to the cart
                   $dishDetailsID[]=$key;
                
                }
            }
        }
        
        foreach($dishDetailsID as $id){
            $res=mysqli_query($con,"SELECT dish_details.status,dish.status as dish_status,dish.id FROM dish_details,dish WHERE dish_details.id='$id' AND dish_details.dish_id=dish.id");
            $row=mysqli_fetch_assoc($res);
            //if main dish status is 0, then remove all attribute of that dish
            if($row['dish_status']==0){
                //hold dish id
                $dish_id=$row['id'];
                //write sql query for fetch all attribute by using '$dish_id'
                $res1=mysqli_query($con,"SELECT id FROM dish_details WHERE dish_id='$dish_id'");
                while($row1=mysqli_fetch_assoc($res1)){
                    //remove it's all attribute
                    removeDishFromCartById($row1['id']);
                }
            }
            if($row['status']==0){
                removeDishFromCartById($id);
            }
        }
        
    }



    //Find Cart Total Price
    function getCartTotalPrice(){
        //call 'getUserFullCart()' to fetch add to cart data
       $cartArray=getUserFullCart();

       // Total cart price //
          $totalCartPrice=0;
          foreach($cartArray as $list){
             $totalCartPrice=$totalCartPrice+($list['qty']*$list['price']);
          }
       // ================ //
        return $totalCartPrice;
    }





    //Get full user cart data from database when user login. If user not login then cart data comes from session
    function getUserFullCart($attr_id=''){
        $cartArray=array();
        
        //For login user
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
            //call 'getUserCart()' for fetch data from 'dish_cart' table
            $geteUserCart=getUserCart();
            
            //format cart data same too session data when show
            foreach($geteUserCart as $list){
                    
                    $cartArray[$list['dish_details_id']]['qty']=$list['qty'];
                
                    //hold dish details by calling 'getDishDetailsById()' function
                    $DishDetails=getDishDetailsById($list['dish_details_id']);

                    $cartArray[$list['dish_details_id']]['price']=$DishDetails['price'];
                    $cartArray[$list['dish_details_id']]['name']=$DishDetails['dish_name'];
                    $cartArray[$list['dish_details_id']]['attribute']=$DishDetails['attribute'];
                    $cartArray[$list['dish_details_id']]['image']=$DishDetails['image'];
                
            }
        }
        //For not login user
        else{
            if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
             
               //set attribute price in session cart & hold cart data from session
               foreach($_SESSION['cart'] as $key=>$val){
                   
                        $cartArray[$key]['qty']=$val['qty'];

                        //hold dish details by calling 'getDishDetailsById()' function
                        $DishDetails=getDishDetailsById($key);

                        $cartArray[$key]['price']=$DishDetails['price'];
                        $cartArray[$key]['name']=$DishDetails['dish_name'];
                        $cartArray[$key]['attribute']=$DishDetails['attribute'];
                        $cartArray[$key]['image']=$DishDetails['image'];
                
                }
            }
        }
        //if attr_id found then return attribute quantity. If attr_id not found then return full $cartArray
        if($attr_id!=''){
            return $cartArray[$attr_id]['qty'];
        }else{
            return $cartArray;
        }
    }




    //Get Dish Details by attribute id
    function getDishDetailsById($id){
        global $con;
        //fetch price from 'dish_details' table given by attribute id
        $res=mysqli_query($con,"SELECT dish.dish_name,dish.image,dish_details.price,dish_details.attribute FROM dish,dish_details WHERE dish_details.id='$id' AND dish.id=dish_details.dish_id");
        $row=mysqli_fetch_assoc($res);
        return $row;
    }




    //remove dish from cart when user login or not login
    function removeDishFromCartById($id){
        //check user login or not.If user login then dish delete from database table
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
          global $con;
          $uid=$_SESSION['FOOD_USER_ID'];
          //delete dish from 'dish_cart' table given by attribute id
          mysqli_query($con,"DELETE FROM dish_cart WHERE dish_details_id='$id' AND user_id='$uid'");
        }
        //if user not login then dish add to session
        else{
            unset($_SESSION['cart'][$id]);
        } 
        
    }



    //Get user details
    function getUserDetails(){
        global $con;
        $data['name']='';
        $data['email']='';
        $data['mobile']='';
        $data['referral_code']='';
        
        //check user login or not.If user login then dish add to database table
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
            //hold user id from session
            $user_id=$_SESSION['FOOD_USER_ID'];
            $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id'"));
            $data['name']=$row['name'];
            $data['email']=$row['email'];
            $data['mobile']=$row['mobile'];
            $data['referral_code']=$row['referral_code'];
        }
        return $data;
        
        
    }



    //Empty cart
    function emptyCart(){
        //check user login or not.If user login then dish delete from database table
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
          global $con;
          $uid=$_SESSION['FOOD_USER_ID'];
          //delete dish from 'dish_cart' table given by user id
          mysqli_query($con,"DELETE FROM dish_cart WHERE user_id='$uid'");
        }
        //if user not login then dish delete from session
        else{
            unset($_SESSION['cart']);
        }
    }



    
   //Order Attribute Details By Order Id from 'order_details','dish_details','dish' table
   function geteOrderDetails($order_id){
       global $con;
       $sql="SELECT order_details.unit_price,order_details.qty,order_details.dish_details_id,dish_details.attribute,dish.dish_name,dish.image FROM order_details,dish_details,dish WHERE order_details.order_id='$order_id' AND order_details.dish_details_id=dish_details.id AND dish_details.dish_id=dish.id";
       $res=mysqli_query($con,$sql);
       $data=array();
       while($row=mysqli_fetch_assoc($res)){
           $data[]=$row;
       }
       return $data;
   }




    //Order Details from order_master table
   function OrderDetails($order_id){
       global $con;
       $sql="SELECT * FROM order_master WHERE id='$order_id'";
       $res=mysqli_query($con,$sql);
       $data=array();
       while($row=mysqli_fetch_assoc($res)){
           $data[]=$row;
       }
       return $data;
   }



   //Get details about website settings
   function getWebsiteSetting(){
       global $con;
       $sql="SELECT * FROM setting WHERE id='1'";
       $res=mysqli_query($con,$sql);
       $row=mysqli_fetch_assoc($res);
       return $row;
   }




    //Get dish rating details
    function getRatingList($dish_details_id,$order_id){
        $ratingArr=array('Bad','Below Average','Average','Good','Very Good');
        
        $html='<select onchange=updateRating("'.$dish_details_id.'","'.$order_id.'") id="rate_'.$dish_details_id.'">';
            $html.='<option value="">Select Rating</option>';
            foreach($ratingArr as $key=>$val){
                $id=$key+1;
                $html.="<option value='$id'>$val</option>";
            }
        $html.='</select>';
        return $html;
    }

    
    //Get Rating
    function getRating($dish_details_id,$order_id){
       global $con;
       $sql="SELECT * FROM rating WHERE order_id='$order_id' AND dish_details_id='$dish_details_id'";
       $res=mysqli_query($con,$sql);
       if(mysqli_num_rows($res)>0){
           $row=mysqli_fetch_assoc($res);
           $rating=$row['rating_value'];
           $ratingArr=array('','Bad','Below Average','Average','Good','Very Good');
           echo "<div class='set_rating_style'>".$ratingArr[$rating]."</div>";
       }else{
           echo getRatingList($dish_details_id,$order_id);
       }
    }

    
    //Get Total Rating By Dish Id
    function getRatingByDishId($dish_id){
        global $con;
        $sql="SELECT id FROM dish_details WHERE dish_id='$dish_id'";
        $res=mysqli_query($con,$sql);
        $ratingArr=array();
        $str='';
        while($row=mysqli_fetch_assoc($res)){
            $str.="dish_details_id='".$row['id']."' OR ";
        }
        $str=rtrim($str," OR");
        $ratingArr=array('','Bad','Below Average','Average','Good','Very Good');
        
        $sql_1="SELECT SUM(rating_value) AS rating,count(*) AS total FROM rating WHERE $str";
        $res_1=mysqli_query($con,$sql_1);
        $row_1=mysqli_fetch_assoc($res_1);
        
        if($row_1['total']>0){
            $totalRate=$row_1['rating']/$row_1['total'];
            $html="<span style='color:red;font-weight:bold;font-size:14px;'>Rating: </span><span style='color:green'>( ".$ratingArr[round($totalRate)]." )</span><br/><span style='color:red;font-weight:bold;font-size:14px;'>Rated By: </span><span style='color:green'>( ".$row_1['total']." Users)</span>";
            echo $html;
        }
        
    }




    //Add data into wallet table
    function manageWallet($user_id,$amount,$type,$msg){
        global $con;
        $added_on=date('Y-m-d h:i:s');
        $sql="INSERT INTO wallet(user_id,amount,msg,type,added_on) VALUES('$user_id','$amount','$msg','$type','$added_on')";
        mysqli_query($con,$sql);
    }


    //get wallet details data given by user id
    function getWallet($user_id){
        global $con;
        $sql="SELECT * FROM wallet WHERE user_id='$user_id' ORDER BY id DESC";
        $res=mysqli_query($con,$sql);
        $arr=array();
        while($row=mysqli_fetch_assoc($res)){
            $arr[]=$row;
        }
        return $arr;
    }



    //get wallet total amount given by user id
    function getWalletTotalAmount($user_id){
        global $con;
        $sql="SELECT * FROM wallet WHERE user_id='$user_id'";
        $res=mysqli_query($con,$sql);
        $in=0;
        $out=0;
        $arr=array();
        while($row=mysqli_fetch_assoc($res)){
            if($row['type']=='in'){
                $in=$in+$row['amount'];
            }
            if($row['type']=='out'){
                $out=$out+$row['amount'];
            }
        }
        return $in-$out;
    }




    //Total sale
    function getSale($start_date,$end_date){
        global $con;
        $sql="SELECT SUM(total_price) AS daily_total_sale FROM order_master WHERE added_on BETWEEN '$start_date' AND '$end_date' AND order_status=4";
        $res=mysqli_query($con,$sql);
        while($row=mysqli_fetch_assoc($res)){
            return $row['daily_total_sale'];
        }
        
    }





    //Order Send to Email
    function orderInvoiceSendEmail($order_id){
        
        //hold user details by call 'getUserDetails()' function
        $userDetails=getUserDetails();
        
        $user_name=$userDetails['name'];
        $user_email=$userDetails['email'];
        
        //hold order details from 'order_master' table by calling 'OrderDetails()' function
        $orderDetail=OrderDetails($order_id);
        
        //hold Order Attribute Detail from 'order_details','dish_details','dish' table by call 'geteOrderDetails()' function
        $orderAttributeDetails=geteOrderDetails($order_id);
        
        $order_date=$orderDetail[0]['added_on'];
        $payment_type=$orderDetail[0]['payment_type'];
        $total_price=$orderDetail[0]['total_price'];
        $payment_method=$orderDetail[0]['payment_method'];
        $pay_id=$orderDetail[0]['pay_id'];
        $txnd_id=$orderDetail[0]['txnid'];
        $coupon_value=$orderDetail[0]['coupon_value'];
        
        //prx($orderDetails);
        
        $html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html>
                  <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <meta name="x-apple-disable-message-reformatting" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <title></title>
                    <style type="text/css" rel="stylesheet" media="all">
                    /* Base ------------------------------ */

                    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
                    body {
                      width: 100% !important;
                      height: 100%;
                      margin: 0;
                      -webkit-text-size-adjust: none;
                    }

                    a {
                      color: #3869D4;
                    }

                    a img {
                      border: none;
                    }

                    td {
                      word-break: break-word;
                    }

                    .preheader {
                      display: none !important;
                      visibility: hidden;
                      mso-hide: all;
                      font-size: 1px;
                      line-height: 1px;
                      max-height: 0;
                      max-width: 0;
                      opacity: 0;
                      overflow: hidden;
                    }
                    /* Type ------------------------------ */

                    body,
                    td,
                    th {
                      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
                    }

                    h1 {
                      margin-top: 0;
                      color: #333333;
                      font-size: 22px;
                      font-weight: bold;
                      text-align: left;
                    }

                    h2 {
                      margin-top: 0;
                      color: #333333;
                      font-size: 16px;
                      font-weight: bold;
                      text-align: left;
                    }

                    h3 {
                      margin-top: 0;
                      color: #333333;
                      font-size: 14px;
                      font-weight: bold;
                      text-align: left;
                    }

                    td,
                    th {
                      font-size: 16px;
                    }

                    p,
                    ul,
                    ol,
                    blockquote {
                      margin: .4em 0 1.1875em;
                      font-size: 16px;
                      line-height: 1.625;
                    }

                    p.sub {
                      font-size: 13px;
                    }
                    /* Utilities ------------------------------ */

                    .align-right {
                      text-align: right;
                    }

                    .align-left {
                      text-align: left;
                    }

                    .align-center {
                      text-align: center;
                    }
                    /* Buttons ------------------------------ */

                    .button {
                      background-color: #3869D4;
                      border-top: 10px solid #3869D4;
                      border-right: 18px solid #3869D4;
                      border-bottom: 10px solid #3869D4;
                      border-left: 18px solid #3869D4;
                      display: inline-block;
                      color: #FFF;
                      text-decoration: none;
                      border-radius: 3px;
                      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                      -webkit-text-size-adjust: none;
                      box-sizing: border-box;
                    }

                    .button--green {
                      background-color: #22BC66;
                      border-top: 10px solid #22BC66;
                      border-right: 18px solid #22BC66;
                      border-bottom: 10px solid #22BC66;
                      border-left: 18px solid #22BC66;
                    }

                    .button--red {
                      background-color: #FF6136;
                      border-top: 10px solid #FF6136;
                      border-right: 18px solid #FF6136;
                      border-bottom: 10px solid #FF6136;
                      border-left: 18px solid #FF6136;
                    }

                    @media only screen and (max-width: 500px) {
                      .button {
                        width: 100% !important;
                        text-align: center !important;
                      }
                    }
                    /* Attribute list ------------------------------ */

                    .attributes {
                      margin: 0 0 21px;
                    }

                    .attributes_content {
                      background-color: #F4F4F7;
                      padding: 16px;
                    }

                    .attributes_item {
                      padding: 0;
                    }
                    /* Related Items ------------------------------ */

                    .related {
                      width: 100%;
                      margin: 0;
                      padding: 25px 0 0 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                    }

                    .related_item {
                      padding: 10px 0;
                      color: #CBCCCF;
                      font-size: 15px;
                      line-height: 18px;
                    }

                    .related_item-title {
                      display: block;
                      margin: .5em 0 0;
                    }

                    .related_item-thumb {
                      display: block;
                      padding-bottom: 10px;
                    }

                    .related_heading {
                      border-top: 1px solid #CBCCCF;
                      text-align: center;
                      padding: 25px 0 10px;
                    }
                    /* Discount Code ------------------------------ */

                    .discount {
                      width: 100%;
                      margin: 0;
                      padding: 24px;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      background-color: #F4F4F7;
                      border: 2px dashed #CBCCCF;
                    }

                    .discount_heading {
                      text-align: center;
                    }

                    .discount_body {
                      text-align: center;
                      font-size: 15px;
                    }
                    /* Social Icons ------------------------------ */

                    .social {
                      width: auto;
                    }

                    .social td {
                      padding: 0;
                      width: auto;
                    }

                    .social_icon {
                      height: 20px;
                      margin: 0 8px 10px 8px;
                      padding: 0;
                    }
                    /* Data table ------------------------------ */

                    .purchase {
                      width: 100%;
                      margin: 0;
                      padding: 35px 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                    }

                    .purchase_content {
                      width: 100%;
                      margin: 0;
                      padding: 25px 0 0 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                    }

                    .purchase_item {
                      padding: 10px 0;
                      color: #51545E;
                      font-size: 15px;
                      line-height: 18px;
                    }

                    .purchase_heading {
                      padding-bottom: 8px;
                      border-bottom: 1px solid #EAEAEC;
                    }

                    .purchase_heading p {
                      margin: 0;
                      color: #85878E;
                      font-size: 12px;
                    }

                    .purchase_footer {
                      padding-top: 15px;
                      border-top: 1px solid #EAEAEC;
                    }

                    .purchase_total {
                      margin: 0;
                      text-align: right;
                      font-weight: bold;
                      color: #333333;
                    }

                    .purchase_total--label {
                      padding: 0 15px 0 0;
                    }

                    body {
                      background-color: #F4F4F7;
                      color: #51545E;
                    }

                    p {
                      color: #51545E;
                    }

                    p.sub {
                      color: #6B6E76;
                    }

                    .email-wrapper {
                      width: 100%;
                      margin: 0;
                      padding: 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      background-color: #F4F4F7;
                    }

                    .email-content {
                      width: 100%;
                      margin: 0;
                      padding: 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                    }
                    /* Masthead ----------------------- */

                    .email-masthead {
                      padding: 25px 0;
                      text-align: center;
                    }

                    .email-masthead_logo {
                      width: 94px;
                    }

                    .email-masthead_name {
                      font-size: 16px;
                      font-weight: bold;
                      color: #A8AAAF;
                      text-decoration: none;
                      text-shadow: 0 1px 0 white;
                    }
                    /* Body ------------------------------ */

                    .email-body {
                      width: 100%;
                      margin: 0;
                      padding: 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      background-color: #FFFFFF;
                    }

                    .email-body_inner {
                      width: 570px;
                      margin: 0 auto;
                      padding: 0;
                      -premailer-width: 570px;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      background-color: #FFFFFF;
                    }

                    .email-footer {
                      width: 570px;
                      margin: 0 auto;
                      padding: 0;
                      -premailer-width: 570px;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      text-align: center;
                    }

                    .email-footer p {
                      color: #6B6E76;
                    }

                    .body-action {
                      width: 100%;
                      margin: 30px auto;
                      padding: 0;
                      -premailer-width: 100%;
                      -premailer-cellpadding: 0;
                      -premailer-cellspacing: 0;
                      text-align: center;
                    }

                    .body-sub {
                      margin-top: 25px;
                      padding-top: 25px;
                      border-top: 1px solid #EAEAEC;
                    }

                    .content-cell {
                      padding: 35px;
                    }
                    /*Media Queries ------------------------------ */

                    @media only screen and (max-width: 600px) {
                      .email-body_inner,
                      .email-footer {
                        width: 100% !important;
                      }
                    }

                    @media (prefers-color-scheme: dark) {
                      body,
                      .email-body,
                      .email-body_inner,
                      .email-content,
                      .email-wrapper,
                      .email-masthead,
                      .email-footer {
                        background-color: #333333 !important;
                        color: #FFF !important;
                      }
                      p,
                      ul,
                      ol,
                      blockquote,
                      h1,
                      h2,
                      h3 {
                        color: #FFF !important;
                      }
                      .attributes_content,
                      .discount {
                        background-color: #222 !important;
                      }
                      .email-masthead_name {
                        text-shadow: none !important;
                      }
                    }
                    </style>
                    <!--[if mso]>
                    <style type="text/css">
                      .f-fallback  {
                        font-family: Arial, sans-serif;
                      }
                    </style>
                  <![endif]-->
                  </head>
                  <body>
                    <span class="preheader">This is an invoice for your purchase on '.$order_date.'.</span>
                    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td align="center">
                          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                              <td class="email-masthead">
                                <a href="'.SITE_PATH.'">
                                <img src="https://i.ibb.co/fYrbFh1/food-online-logo-1.png"><br/><br/>
                                <span style="color:#1155CC;font-weight:bold">Food Online Ltd.</span>
                              </a>
                              </td>
                            </tr>
                            <!-- Email Body -->
                            <tr>
                              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                  <!-- Body content -->
                                  <tr>
                                    <td class="content-cell">
                                      <div class="f-fallback">
                                        <h1>Hi <span style="color:green;font-weight:bold">'.$user_name.'</span>,</h1>
                                        <p>Thanks for using Food Online Ltd.This is an invoice for your recent purchase.</p>
                                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td class="attributes_content">
                                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">';
        
    
                                    if($payment_type=='online'){
                                        $html.='<tr>
                                                   <td class="attributes_item">
                                                     <span class="f-fallback">
                                                       <strong>Amount Paid:</strong> &#2547; '.$total_price.'
                                                     </span>
                                                   </td>
                                                 </tr>
                                                 <tr>
                                                   <td class="attributes_item">
                                                     <span class="f-fallback">
                                                       <strong>Payment Method: </strong>'.$payment_method.'
                                                     </span>
                                                   </td>
                                                 </tr>
                                                 <tr>
                                                   <td class="attributes_item">
                                                     <span class="f-fallback">
                                                       <strong>Payment ID: </strong>'.$pay_id.'
                                                     </span>
                                                   </td>
                                                 </tr>
                                                 <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                                                      <strong>Transaction ID: </strong>'.$txnd_id.'
                                                    </span>
                                                  </td>
                                                </tr>';
                                    }
        
                                    if($payment_type=='cash'){
                                       $html.='<tr>
                                           <td class="attributes_item">
                                             <span class="f-fallback">
                                               <strong>Amount Due:</strong> &#2547; '.$total_price.'
                                             </span>
                                           </td>
                                        </tr>
                                        <tr>
                                          <td class="attributes_item">
                                            <span class="f-fallback">
                                              <strong>Payment Method: </strong>'.$payment_method.'
                                            </span>
                                          </td>
                                        </tr>'; 
                                    }
        
                                    if($payment_type=='wallet'){
                                       $html.='<tr>
                                           <td class="attributes_item">
                                             <span class="f-fallback">
                                               <strong>Amount Paid:</strong> &#2547; '.$total_price.'
                                             </span>
                                           </td>
                                        </tr>
                                        <tr>
                                          <td class="attributes_item">
                                            <span class="f-fallback">
                                              <strong>Payment Method: </strong>'.$payment_method.'
                                            </span>
                                          </td>
                                        </tr>'; 
                                    }
        
                                    $html.='</table>
                                                </td>
                                              </tr>
                                            </table>
                                            <!-- Action -->

                                            <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td>
                                                  <h3>Order Id: '.$order_id.'</h3>
                                                </td>
                                                <td>
                                                  <h3 class="align-right">Order Date: '.$order_date.'</h3>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="2">
                                                  <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                      <th class="purchase_heading" style="text-align:left">
                                                        <p class="f-fallback">Description</p>
                                                      </th>
                                                      <th class="purchase_heading" style="text-align:center">
                                                        <p class="f-fallback">Qty</p>
                                                      </th>
                                                      <th class="purchase_heading" style="text-align:center">
                                                        <p class="f-fallback">Unit Price</p>
                                                      </th>
                                                      <th class="purchase_heading" style="text-align:right">
                                                        <p class="f-fallback">Amount</p>
                                                      </th>
                                                    </tr>';
                                              
                                              $total_price=0;
                                              foreach($orderAttributeDetails as $list){
                                                  $item_price=$list['unit_price']*$list['qty'];
                                                  $total_price=$total_price+$item_price;
                                                  $html.='<tr>
                                                          <td width="45%" class="purchase_item" style="text-align:left"><span class="f-fallback">'.$list['dish_name'].'('.$list['attribute'].')</span></td>
                                                          <td width="10%" class="purchase_item" style="text-align:center"><span class="f-fallback">'.$list['qty'].'</span></td>
                                                          <td width="15%" class="purchase_item" style="text-align:center"><span class="f-fallback">&#2547; '.$list['unit_price'].'</span></td>
                                                          <td class="align-right" width="30%" class="purchase_item" style="text-align:right"><span class="f-fallback">&#2547; '.$item_price.'</span></td>
                                                        </tr>';
                                              }
                                    
                
                                              $shiping=50;
                                              $grand_price=$total_price+$shiping;
                                              $final_price=$grand_price-$coupon_value;
                                              $html.='<tr>
                                                      <td width="80%" class="purchase_footer" valign="middle" colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">Total = </p>
                                                      </td>
                                                      <td width="20%" class="purchase_footer" valign="middle">
                                                        <p class="f-fallback purchase_total">&#2547; '.$total_price.'</p>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td width="80%" class="purchase_footer" valign="middle" colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">Shipping(+)</p>
                                                      </td>
                                                      <td width="20%" class="purchase_footer" valign="middle">
                                                        <p class="f-fallback purchase_total">&#2547; '.$shiping.'</p>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td width="80%" class="purchase_footer" valign="middle" colspan="3">
                                                        <p class="f-fallback purchase_total purchase_total--label">Grand Total = </p>
                                                      </td>
                                                      <td width="20%" class="purchase_footer" valign="middle">
                                                        <p class="f-fallback purchase_total">&#2547; '.$grand_price.'</p>
                                                      </td>
                                                    </tr>';
        
        
                                                if($coupon_value!=''){
                                                        $html.='<tr>
                                                                  <td width="80%" class="purchase_footer" valign="middle" colspan="3">
                                                                    <p class="f-fallback purchase_total purchase_total--label">Discount(-)</p>
                                                                  </td>
                                                                  <td width="20%" class="purchase_footer" valign="middle">
                                                                    <p class="f-fallback purchase_total">&#2547; '.$coupon_value.'</p>
                                                                  </td>
                                                                </tr>
                                                                <tr>
                                                                  <td width="80%" class="purchase_footer" valign="middle" colspan="3">
                                                                    <p class="f-fallback purchase_total purchase_total--label">Final Grand Total = </p>
                                                                  </td>
                                                                  <td width="20%" class="purchase_footer" valign="middle">
                                                                    <p class="f-fallback purchase_total">&#2547; '.$final_price.'</p>
                                                                  </td>
                                                                </tr>';
                                                        }
        
        
                                                $html.='</table>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                    <p>If you have any questions about this invoice, simply reply to this email or reach out to our <a href="javascript:void(0)">support team</a> for help.</p>
                                                    <p>Cheers,
                                                      <span style="color:green;"><br>The <span><a href="'.SITE_PATH.'" style="color:#1155CC">Food Online </a><span style="color:green">Support Team</p><span>
                                                    <!-- Sub copy -->

                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>

                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </body>
                            </html>';
        
        return $html;
    }


?>