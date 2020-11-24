<?php

    include('header.php');

    //This section is execute when get cat_dish value found from url
    $cat_dish='';
    $cat_dish_arr=array();
    if(isset($_GET['cat_dish'])){
        $cat_dish=get_safe_value($con,$_GET['cat_dish']);
        $cat_dish_arr=array_filter(explode(':',$cat_dish));
        $cat_dish_str=implode(', ',$cat_dish_arr);
    }


    //This section is execute when get dish type value found from url
    $dish_type='';
    if(isset($_GET['dish_type'])){
        $dish_type=get_safe_value($con,$_GET['dish_type']);
    }

    $search_str='';
    if(isset($_GET['search_str'])){
        $search_str=get_safe_value($con,$_GET['search_str']);
    }

    //create dish type array
    $dishTypeArray=array("veg","non-veg","both");

?>
           

           <div class="breadcrumb-area gray-bg">
               <div class="container">
                   <div class="breadcrumb-content">
                       <ul>
                           <li><a href="<?php echo SITE_PATH?>shop">Shop</a></li>
                       </ul>
                   </div>
               </div>
           </div>
           
           <?php if($website_close==1){ ?>
                    <div style="margin-top:10px;text-align:center">
                        <h3><span style="color:red;text-transform: capitalize;"><?php echo $website_close_msg;?></span></h3>
                    </div>
           <?php } ?>
           
           <div class="shop-page-area pt-100 pb-100">
               <div class="container">
                   <div class="row flex-row-reverse">
                       <div class="col-lg-9">
                           <div class="shop-topbar-wrapper">
                              <div class="product-sorting-wrapper">
                                 <div class="product-show shorting-style ">
                                    <?php
                                        // This loop show all type which is set in $dishTypeArray variable //
                                        foreach($dishTypeArray as $list){
                                            // this is for show which type is selected //
                                            $type_radio_selected='';
                                            if($list==$dish_type){
                                                $type_radio_selected="checked='checked'";
                                            }
                                            //  =====================================  //
                                            ?>
                                                <?php echo strtoupper($list)?> <input type="radio" style="margin-top:15px;" class="dish_radio" name="type" value="<?php echo $list?>" onclick="setDishType('<?php echo $list?>')" <?php echo $type_radio_selected?>>&nbsp;
                                            <?php
                                        }
                                        //  =================================================================  //
                                     ?>
                                 </div> 
                              </div>
                              <div class="product-sorting-wrapper">
                                  <div class="product-show shorting-style ">
                                    <input class="search_box search_box_main" type="textbox" id="search" placeholder="Search" value="<?php echo $search_str?>">
                                    <input type="button" class="search_box search_box_btn" value="Search" onclick="setSearchType()">
                                 </div> 
                              </div> 
                           </div> 
                           <?php
                              //write $cat_id=0 for use this to show which category is selected
                              $cat_id=0;
                              //write sql query to fetch all data from dish table
                              $dish_sql="SELECT * FROM dish WHERE status=1";
                              //write if condition when cat_dish id found from url & merge sql query using IN for show those dishes which category is selected
                              if($cat_dish!=''){
                                  $dish_sql.=" AND categories_id IN ($cat_dish_str) ";
                              }
                              //write if condition when dish type found from url & merge sql query for show those type dishes which type is selected
                              if($dish_type!='' && $dish_type!='both'){
                                  $dish_sql.=" AND type='$dish_type' ";
                              }
                              //write if condition when search_str found from url & merge sql query for show those dishes which name is written in search box
                              if($search_str!=''){
                                  $dish_sql.=" AND (dish_name LIKE '%$search_str%' OR dish_detail LIKE '%$search_str%') ";
                              }
                              $dish_sql.=" ORDER BY dish_name DESC";
                              //execute sql query
                              $dish_res=mysqli_query($con,$dish_sql);
                              //if any data found from this sql query,then put total row number inside $dis_count variable
                              $dish_count=mysqli_num_rows($dish_res);
                           ?>
                           <div class="grid-list-product-wrapper">
                               <div class="product-grid product-view pb-20">
                                   <!-- if data found from dish table, then execute those statement which are write inside if condition. If data not found, then execute else condition -->
                                   <?php if($dish_count>0){?>
                                       <div class="row">
                                          <?php while($dish_row=mysqli_fetch_assoc($dish_res)){?>
                                               <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                   <div class="product-wrapper">
                                                       <div class="product-img">
                                                           <a href="product-details.html">
                                                               <img src="<?php echo DISH_IMAGE_SITE_PATH.$dish_row['image'];?>" alt="">
                                                           </a>
                                                       </div>
                                                       <div class="product-content" id="dish_detail">
                                                           <h4>
                                                              <?php
                                                                  // This is set veg & non-veg icon beside dish name //
                                                                  if($dish_row['type']=='veg'){
                                                                      echo "<img src='assets/img/icon-img/veg.png'/>";
                                                                  }else{
                                                                       echo "<img src='assets/img/icon-img/non_veg.png'/>";
                                                                  }
                                                                  //  ==============================================  //
                                                               ?>
                                                               <a href="javascript:void(0)"><?php echo $dish_row['dish_name'];?> </a>
                                                           </h4>
                                                           <?php
                                                              $dish_attr_res=mysqli_query($con,"SELECT * FROM dish_details WHERE dish_id='".$dish_row['id']."' ORDER BY price ASC");
                                                           ?>
                                                           <div class="product-price-wrapper">
                                                               <?php
                                                                  while($dish_attr_row=mysqli_fetch_assoc($dish_attr_res)){
                                                                      
                                                                      $attr_status='';
                                                                      $availability='';
                                                                      if($dish_attr_row['status']==0){
                                                                          $attr_status="disabled='disabled'";
                                                                          $availability='<span style="color:red;font-size:10px;margin-left: 5px;">[Out of Stock]</span>';
                                                                      }
                                                                      if($website_close==0){
                                                                        echo "<input $attr_status type='radio' class='dish_radio' name='radio_".$dish_row['id']."' id='radio_".$dish_row['id']."' value='".$dish_attr_row['id']."'>";
                                                                      }
                                                                      echo $dish_attr_row['attribute'];
                                                                      echo "&nbsp;";
                                                                      echo " ( &#2547;<span>".$dish_attr_row['price']." )</span>";
                                                                      echo $availability;
                                                                      $added_msg="";
                                                                      if(array_key_exists($dish_attr_row['id'],$cartArray)){
                                                                          //hold added quanity
                                                                          $added_qty=getUserFullCart($dish_attr_row['id']);
                                                                          $added_msg="[Added (Qty: $added_qty)]";
                                                                      }
                                                                      echo "<span class='cart_already_added' id='shop_added_msg_".$dish_attr_row['id']."'>".$added_msg."</span>";
                                                                      echo "&nbsp;&nbsp;&nbsp;<br/>";
                                                                      
                                                                  }
                                                               ?>
                                                           </div>
                                                           
                                                           <?php if($website_close==0){?>
                                                               <div class="product-price-wrapper">
                                                                   <select class="select" id="qty<?php echo $dish_row['id']?>">
                                                                       <option value="0">Qty</option>
                                                                       <?php
                                                                          for($i=1;$i<=20;$i++){
                                                                              echo "<option>$i</option>";
                                                                          }
                                                                       ?>
                                                                   </select>
                                                                   <i class="fa fa-cart-plus cart_icon" aria-hidden="true" onclick="add_to_cart('<?php echo $dish_row['id']?>','add')"></i>
                                                               </div>
                                                               <div style="margin-top:10px">
                                                                   <?php echo getRatingByDishId($dish_row['id'])?>
                                                               </div>
                                                           <?php }else{?>
                                                               <div class="product-price-wrapper">
                                                                   <span style="color:red;text-transform: capitalize;margin-top:5px;"><?php echo $website_close_msg;?></span>
                                                               </div>
                                                           <?php } ?>
                                                           
                                                       </div>
                                                   </div>
                                               </div>
                                           <?php } ?>
                                       </div>
                                   <?php 
                                      } else{
                                                echo 'No Dish Found !';
                                            } 
                                   ?>
                               </div>

                           </div>
                       </div>
                       
                       <?php
                          //write sql query for fetch all data from categories table which one status is 1
                          $cat_res=mysqli_query($con,"SELECT * FROM categories WHERE status=1 ORDER BY order_number DESC");
                       ?>
                       <div class="col-lg-3">
                           <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                               <div class="shop-widget">
                                   <h4 class="shop-sidebar-title">Shop By Categories</h4>
                                   <div class="shop-catigory">
                                       <ul id="faq" class="category_list">
                                           <li><a href="<?php echo SITE_PATH?>shop"><u>Clear</u></a></li>
                                           <?php 
                                                while($cat_row=mysqli_fetch_assoc($cat_res)){
                                                    //
                                                    $is_checked='';
                                                    if(in_array($cat_row['id'],$cat_dish_arr)){
                                                       $is_checked="checked='checked'"; 
                                                    }
                                                    
                                                    echo "<li> <input $is_checked type='checkbox' onclick=set_checkbox('".$cat_row['id']."') class='cat_checkbox' name='cat_arr[]' value='".$cat_row['id']."'>".$cat_row['category']." </li>";
                                                 }
                                            ?>
                                           
                                       </ul>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           
           <!--===  Hidden input field which help sort dish by categories & Dish Type   ===-->
           <form method="get" id="frm_catDish">
               <!-- Hiddin input field for sort by categories -->
               <input type="hidden" name="cat_dish" id="cat_dish" value="<?php echo $cat_dish;?>">
               
               <!-- Hiddin input field for sort by Dish Type(like: veg,non-veg,both) -->
               <input type="hidden" name="dish_type" id="dish_type" value="<?php echo $dish_type;?>">
               
               <!-- Hiddin input field for search box -->
               <input type="hidden" name="search_str" id="search_str" value="<?php echo $search_str;?>">
           </form>
        
       
      
<?php include('footer.php'); ?>