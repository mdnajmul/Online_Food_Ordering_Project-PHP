<?php

   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

   //include constant.inc.php file
   include('constant.inc.php');
   
   include('vendor/autoload.php');



   //check user login or not login.If user not login then die this page & not generate pdf.
    if(!isset($_SESSION['FOOD_USER_ID'])){
        die();
    }

    ## If User login then execute all this code & generate pdf file ##

    //hold order id
    if(isset($_GET['id']) && $_GET['id']>0){
        $order_id=get_safe_value($con,$_GET['id']);
        $user_id=$_SESSION['FOOD_USER_ID'];
        
        $check=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM order_master WHERE id='$order_id'"));

        if($check['user_id']!=$user_id){
           redirect(SITE_PATH.'shop');
        }
    }

    //fetch coupon details from database
    $coupon_details=mysqli_fetch_assoc(mysqli_query($con,"SELECT coupon_value FROM order_master WHERE id='$order_id'"));
    //hold coupon value
    $coupon_value=$coupon_details['coupon_value'];
    //if user login then execute this query
    $order_res=mysqli_fetch_assoc(mysqli_query($con,"SELECT address,zip_code,payment_status,payment_method,added_on FROM order_master WHERE user_id='$user_id' AND id='$order_id'"));


    $css=file_get_contents('assets/css/bootstrap.min.css');
    $css.=file_get_contents('assets/css/custom.css');


    $html='
    <!doctype html>
    <html class="no-js" lang="en">

    <head>
    </head>

    <body>
        <div class="wishlist-table table-responsive">
            <table>
                <caption style="caption-side: left; margin-bottom:20px;">
                    <a href="'.SITE_PATH.'"><img src="https://i.ibb.co/fYrbFh1/food-online-logo-1.png"></a><br/><br/>
                    <span style="color:green; font-size:18px; font-weight:bold;">Food Online Ltd.</span><br/><span style="color:blue; font-size:14px; font-weight:normal;"><strong>Address:</strong> H/N# 30,Sector# 4,Road# 3,Uttara,Dhaka,Bangladesh</span><br/>
                    <span style="color:blue; font-size:14px; font-weight:normal;"><strong>Phone:</strong> 09612344502</span><br/>
                    <span style="color:blue; font-size:14px; font-weight:normal;"><strong>Email:</strong> info@foodonline.mail.com</span><br/><br/>
                    <hr/><span style="color:black; font-size:18px; font-weight:normal;"><strong>ORDER DETAILS:</strong></span><br/>
                    <span style="color:black; font-size:14px; font-weight:normal;"><strong>Order Address: </strong>'.$order_res['address'].',Dhaka-'.$order_res['zip_code'].'</span><br/>
                    <span style="color:black; font-size:14px; font-weight:normal;"><strong>Order Date: </strong>'.$order_res['added_on'].'</span><br/>
                    <span style="color:black; font-size:14px; font-weight:normal;"><strong>Payement Method: </strong>'.$order_res['payment_method'].'</span><br/>
                    <span style="color:black; font-size:14px; font-weight:normal;"><strong>Payement Status: </strong>'.ucfirst($order_res['payment_status']).'</span>
                </caption>
                <thead>
                    <tr>
                        <th class="product-name" width="5%">Sl.</th>
                        <th class="product-name" width="40%">Dish Name</th>
                        <th class="product-name" width="10%"><span class="nobr"> Qty </span></th>
                        <th class="product-price" width="25%"><span class="nobr">Unit Price</span></th>
                        <th class="product-price" width="20%"><span class="nobr">Total</span></th>
                    </tr>
                </thead>
                <tbody>';


            //hold order details from 'order_master' table by calling 'OrderDetails()' function
            $orderDetail=OrderDetails($order_id);

            //hold Order Attribute Detail from 'order_details','dish_details','dish' table by call 'geteOrderDetails()' function
            $orderAttributeDetails=geteOrderDetails($order_id);

            //hold coupon value
            $coupon_value=$orderDetail[0]['coupon_value'];


                

               $total_price=0;
               $i=0;
               foreach($orderAttributeDetails as $list){
                    $item_price=$list['unit_price']*$list['qty'];
                    $total_price=$total_price+$item_price;
                    $i++;

                    $html.='<tr>
                            <td class="product-name">'.$i.'</td>
                            <td class="product-name">'.$list['dish_name'].'('.$list['attribute'].')</td>
                            <td class="product-name">'.$list['qty'].'</td>
                            <td class="product-price">Tk.'.$list['unit_price'].'</td>
                            <td class="product-price">Tk.'.$item_price.'</td>
                        </tr>';
                 }

               $shiping=50;
               $grand_price=$total_price+$shiping;
               $final_price=$grand_price-$coupon_value;
               $html.='<tr>
                         <td colspan="3"></td>
                         <td class="product-price">Sub Total: </td>
                         <td class="product-price">Tk.'.$total_price.'</td>
                       </tr>
                       <tr>
                         <td colspan="3"></td>
                         <td class="product-price">Shipping: </td>
                         <td class="product-price">Tk. (+) '.$shiping.'</td>
                       </tr>
                       <tr>
                         <td colspan="3"></td>
                         <td class="product-price">Grand Total: </td>
                         <td class="product-price">Tk.'.$grand_price.'</td>
                      </tr>';

               if($coupon_value!=''){
                   $html.='<tr>
                            <td colspan="3"></td>
                            <td class="product-price">Discount: </td>
                            <td class="product-price">Tk. (-) '.$coupon_value.'</td>
                          </tr>  
                          <tr>
                            <td colspan="3"></td>
                            <td class="product-price">Final Grand Total: </td>
                            <td class="product-price">Tk.'.$final_price.'</td>
                          </tr>';
                    }

               $html.='</tbody>
                        </table>
                    </div>
                </body>

                </html>
                ';

    $mpdf=new \Mpdf\Mpdf();
    $mpdf->WriteHTML($css,1);
    $mpdf->WriteHTML($html,2);
    $file=time().'.pdf';
    $mpdf->Output($file,'D');
?>