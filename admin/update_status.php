<?php

   //include database.inc.php file inside this index page
   include('../database.inc.php');

   //include function.inc.php file inside this index page
   include('../function.inc.php');

   //include constant.inc.php file inside this index page
   include('../constant.inc.php');

    
   $type=get_safe_value($con,$_POST['type']);

   if($type=='order'){
       
      $order_status=get_safe_value($con,$_POST['order_status']);
      $order_id=get_safe_value($con,$_POST['order_id']);
      
      if($order_status==5){
          $cancel_time=date('Y-m-d h:i:s');
          $sql="UPDATE order_master SET order_status='$order_status',cancel_by='Admin',cancel_time='$cancel_time' WHERE id='$order_id'";
      }else{
          $sql="UPDATE order_master SET order_status='$order_status' WHERE id='$order_id'";
      }
      
      mysqli_query($con,$sql); 
       
       
       
      //** This section write for send referral bonus to user account after new user registered by using referral code & delivered his 1st order **//
          $referral_row=getWebsiteSetting();
          $referral_bonus_amount=$referral_row['referral_bonus_amount'];
          if($referral_bonus_amount>0){
              if($order_status==4){
                  //call 'OrderDetails()' for order details
                  $Order_details=OrderDetails($order_id);
                  $user_id=$Order_details['0']['user_id'];
                  //hold email which order status is updated
                  $row_email=mysqli_fetch_assoc(mysqli_query($con,"SELECT email FROM users WHERE id='$user_id'"));
                  $user_email=$row_email['email'];

                  //write sql query to find total order number which are Delivered for this user
                  $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS total_order FROM order_master WHERE user_id='$user_id' AND order_status=4"));
                  //hold total order for that user
                  $total_order=$row['total_order'];

                  //if $total_order=0, then referral bonus added to that user which referral code use this user when he registration in this site
                  if($total_order==1){

                        $res=mysqli_query($con,"SELECT from_referral_code FROM users WHERE id='$user_id'");
                        if(mysqli_num_rows($res)>0){
                            $row=mysqli_fetch_assoc($res);
                            $from_referral_code=$row['from_referral_code'];

                            //find user id by using 'from_referral_code' for send referral bonus to his wallet balance//
                            $row_1=mysqli_fetch_assoc(mysqli_query($con,"SELECT id FROM users WHERE referral_code='$from_referral_code'"));
                            $uid_where_sent_bonus=$row_1['id'];

                            $message='Referral Bonus From '.$user_email;

                            //call 'manageWallet()' function to add referral bonus to his accoun wallet balance
                            manageWallet($uid_where_sent_bonus,$referral_bonus_amount,'in',$message);
                        }

                  }
               }
            }
       //**==================================================================================================================================**// 
       
       
      //hold order status
      $orderStatusRow=mysqli_fetch_assoc(mysqli_query($con,"SELECT status FROM order_status WHERE id='$order_status'"));
      $orderStatus=$orderStatusRow['status'];
      echo $orderStatus;
   }






   if($type=='payment'){
      $payment_status=get_safe_value($con,$_POST['payment_status']);
      $order_id=get_safe_value($con,$_POST['order_id']);
       
      mysqli_query($con,"UPDATE order_master SET payment_status='$payment_status' WHERE id='$order_id'");
       
      echo $payment_status;
   }







   if($type=='delivery_boy'){
      $delivery_boy_id=get_safe_value($con,$_POST['delivery_boy_id']);
      $order_id=get_safe_value($con,$_POST['order_id']);
       
      mysqli_query($con,"UPDATE order_master SET delivery_boy_id='$delivery_boy_id' WHERE id='$order_id'");
       
      //hold Delivery boy name
      $deliveryBoyRow=mysqli_fetch_assoc(mysqli_query($con,"SELECT name,mobile FROM delivery_boy WHERE id='$delivery_boy_id'"));
      $delivery_boy_name=$deliveryBoyRow['name'];
      $delivery_boy_mobile=$deliveryBoyRow['mobile'];
      $arr=array('name'=>$delivery_boy_name,'mobile'=>$delivery_boy_mobile);
      echo json_encode($arr);
   }


?>