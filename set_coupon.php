<?php


   //include database.inc.php file inside this index page
   include('database.inc.php');

   //include function.inc.php file inside this index page
   include('function.inc.php');

   //include constant.inc.php file inside this index page
   include('constant.inc.php');

   
    //hold coupon code
    $coupon_txt = get_safe_value($con,$_POST['coupon_txt']);

    $res=mysqli_query($con,"SELECT * FROM coupon_master WHERE coupon_code='$coupon_txt' AND status='1'");
    $count=mysqli_num_rows($res);

    //create json array for hold multiple error & their value
    $jsonArr=array();

    if(isset($_SESSION['COUPON_ID'])){ 
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_VALUE']);
    }

    $totalCartPrice=getCartTotalPrice();
    $totalCartPrice=$totalCartPrice+50;

    if($count>0){
        $row=mysqli_fetch_assoc($res);
        
        $coupon_id=$row['id'];
        $coupon_code=$row['coupon_code'];
        $coupon_value=$row['coupon_value'];
        $coupon_type=$row['coupon_type'];
        $cart_min_value=$row['cart_min_value'];
        $expired_date=strtotime($row['expired_on']);
        $current_date=strtotime(date('Y-m-d'));
        
        
        if($cart_min_value>$totalCartPrice){
            $jsonArr=array('is_error'=>'yes','msg'=>'Cart total value must be equal or greater than Tk.'.$cart_min_value,'final_price'=>$totalCartPrice);
        }else{
            
            if($current_date>$expired_date){
                $jsonArr=array('is_error'=>'yes','msg'=>'Coupon Code Already Expired!','final_price'=>$totalCartPrice);
            }else{
                if($coupon_type=='F'){
                   $final_price=$totalCartPrice-$coupon_value;
                }else{
                   $final_price=floor($totalCartPrice-(($totalCartPrice*$coupon_value)/100));
                }
                $discount_value=$totalCartPrice-$final_price;
                //hold coupon apply details into sesssion for update database after paytment submit
                $_SESSION['COUPON_ID']=$coupon_id;
                $_SESSION['FINAL_PRICE']=$final_price;
                $_SESSION['COUPON_VALUE']=$discount_value;
                $_SESSION['COUPON_CODE']=$coupon_txt;

                $jsonArr=array('is_error'=>'no','msg'=>'Coupon Code Applied Successfully!','final_price'=>$final_price,'discount_value'=>$discount_value);
            }
        }
        
    }else{
        $jsonArr=array('is_error'=>'yes','msg'=>'Please enter a valid discount code!','final_price'=>$totalCartPrice);
    }
    
    //encode json array
    echo json_encode($jsonArr);




?>