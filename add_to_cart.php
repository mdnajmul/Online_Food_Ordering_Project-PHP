<?php
   //include database.inc.php file
   include('database.inc.php');

   //include function.inc.php file
   include('function.inc.php');

    //include constant.inc.php file
   include('constant.inc.php');
   
    $attr=get_safe_value($con,$_POST['attr']); 
    $type=get_safe_value($con,$_POST['type']);
    
    //add dish to cart
    if($type=='add'){
        $qty=get_safe_value($con,$_POST['qty']);
        //check user login or not.If user login then dish add to database table
        if(isset($_SESSION['FOOD_USER_LOGIN'])){
            //hold user id from session
            $user_id=$_SESSION['FOOD_USER_ID'];
            //call 'manageUserCart()' function for add dish or update dish qty to database 'dish_cart' table
            manageUserCart($user_id,$qty,$attr);
        }
        //if user not login then dish add to session
        else{
            $_SESSION['cart'][$attr]['qty']=$qty;  
        }
        
        // Calculate total price from cart //
            $getUserFullCart=getUserFullCart();
            $totalCartPrice=0;
            foreach($getUserFullCart as $list){
                $totalCartPrice=$totalCartPrice+($list['qty']*$list['price']);
            }
        // ============================== //
        
        // hold/fetch cart dish details by calling 'getDishDetailsById()' function //
            $DishDetails=getDishDetailsById($attr);           
            $dish_price=$DishDetails['price'];
            $dish_name=$DishDetails['dish_name'];
            $dish_attr=$DishDetails['attribute'];
            $dish_image=$DishDetails['image'];
        // ===================================================================== //
        
        //count total dish item number inside session cart
        $totalDishNumber=count($getUserFullCart);
        
        //create json array which return total number of dish & total price present inside cart list
            $arr=array('totalCartDish'=>$totalDishNumber,'totalCartPrice'=>$totalCartPrice,'price'=>$dish_price,'name'=>$dish_name,'attribute'=>$dish_attr,'image'=>$dish_image);
            echo json_encode($arr);
    }



    //delete from dish cart
    if($type=='delete'){
        
        removeDishFromCartById($attr);
        
        // Calculate total price from cart //
            $getUserFullCart=getUserFullCart();
            $totalCartPrice=0;
            foreach($getUserFullCart as $list){
                $totalCartPrice=$totalCartPrice+($list['qty']*$list['price']);
            }
        // ============================== //
        
        //count total dish item number inside session cart
        $totalDishNumber=count($getUserFullCart);
        
        //create json array which return total number of dish & total price present inside cart list
            $arr=array('totalCartDish'=>$totalDishNumber,'totalCartPrice'=>$totalCartPrice);
            echo json_encode($arr);
        
    }

?>