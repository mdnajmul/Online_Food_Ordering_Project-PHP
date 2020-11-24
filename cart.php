<?php

    include('header.php');

    //check website close or not
    if($website_close==1){
        redirect(SITE_PATH.'shop');
    }


?>
           
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                    <?php 
                        //call 'getUserFullCart()' to fetch add to cart data
                        $cartArray=getUserFullCart();
                        if(count($cartArray)>0){
                    ?>
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($cartArray as $key=>$list){
                                        ?>
                                                <tr>
                                                    <td class="product-thumbnail">
                                                        <a href="javascript:void(0)"><img src="<?php echo DISH_IMAGE_SITE_PATH.$list['image']?>" alt=""></a>
                                                    </td>
                                                    <td class="product-name"><a href="javascript:void(0)"><?php echo $list['name'].' ('.$list['attribute'].')'?></a></td>
                                                    <td class="product-price-cart"><span class="amount"><?php echo '&#2547; '.$list['price']?></span></td>
                                                    <td class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <input class="cart-plus-minus-box" type="text" name="qty[<?php echo $key?>][]" value="<?php echo $list['qty']?>">
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal"><?php echo '&#2547; '.($list['qty']*$list['price'])?></td>
                                                    <td class="product-remove">
                                                        <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key?>','load')"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <div class="cart-shiping-update">
                                            <a href="<?php echo SITE_PATH?>shop">Continue Shopping</a>
                                        </div>
                                        <div class="cart-update">
                                            <button name="update_cart">Update Shopping Cart</button>
                                            <a href="<?php echo SITE_PATH?>checkout">checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }else{
                            echo '<span style="color:red; font-size:18px;">Empty Cart !</span>';
                        }?>
                </form>
            </div>
        </div>
    </div>
</div>
       
      
<?php include('footer.php'); ?>