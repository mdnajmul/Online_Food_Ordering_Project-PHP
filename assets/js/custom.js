//contact form
function send_message(){
    $(".msg_err").hide();
    $(".msg_corr").hide();
	var name=$("#c_name").val();
	var email=$("#c_email").val();
	var mobile=$("#c_mobile").val();
	var subject=$("#c_subject").val();
	var message=$("#c_message").val();
    var is_error = false;
	
	if(name==""){
        $(".msg_err").show();
        $(".msg_err").html('Please enter name!');
        is_error = true;
	}else if(email==""){
        $(".msg_err").show();
        $(".msg_err").html('Please enter email!');
        is_error = true;
	}else if(mobile==""){
        $(".msg_err").show();
        $(".msg_err").html('Please enter mobile!');
        is_error = true;
	}else if(subject==""){
        $(".msg_err").show();
        $(".msg_err").html('Please enter subject!');
        is_error = true;
	}else if(message==""){
        $(".msg_err").show();
        $(".msg_err").html('Please enter message!');
        is_error = true;
	}else if(is_error == false){
		$.ajax({
			url:SITE_PATH+'send_message',
			type:'post',
			data:'name='+name+'&email='+email+'&mobile='+mobile+'&subject='+subject+'&message='+message,
			success:function(result){
				$(".msg_corr").show();
				$(".msg_corr").html(result);
			},
            complete: function(){
                $("#contact-form").each(function(){
                    this.reset();   //Here form fields will be cleared.
                });
            }
		});
	}
}



//registration form
function user_register(){
    $(".field_error").html("");
    $('.register_msg p').html('Please wait...');
    $('#register_btn').attr('disabled',true);
    
	var name=$("#name").val();
	var email=$("#email").val();
	var mobile=$("#mobile").val();
	var password=$("#password").val();
    var is_error='';
    
	
	if(name==""){
        $("#name_error").html("Please enter your name!");
        $('.register_msg p').html('');
        $('#register_btn').attr('disabled',false);
        is_error='yes';
	}
    if(email==""){
        $("#email_error").html("Please enter your email!");
        $('.register_msg p').html('');
        $('#register_btn').attr('disabled',false);
        is_error='yes';
	}
    if(mobile==""){
        $("#mobile_error").html("Please enter your mobile!");
        $('.register_msg p').html('');
        $('#register_btn').attr('disabled',false);
        is_error='yes';
	}
    if(password==""){
        $("#password_error").html("Please enter your password!");
        $('.register_msg p').html('');
        $('#register_btn').attr('disabled',false);
        is_error='yes';
	}
    if(is_error==''){
		$.ajax({
			url:SITE_PATH+'register_submit',
			type:'post',
			data:'name='+name+'&email='+email+'&mobile='+mobile+'&password='+password,
			success:function(result){
                $('.register_msg p').html('');
                $('#register_btn').attr('disabled',false);
                if($.trim(result).toUpperCase()=='PRESENT'){
                   $("#email_error").html("This email already registered!");
                }
                if($.trim(result)=='insert'){
                   $('.register_msg p').html("Thank you for registration. Please check your email inbox to verify your account.");
                    $("#register_form")[0].reset();
                }
                
			}
            
		});
 }
}



//login form
function user_login(){
    $(".field_error").html("");
    $('#login_btn').html('Please wait...');
    $('#login_btn').attr('disabled',true);
    
	var email=$("#log_email").val();
	var password=$("#log_password").val();
    var is_error='';
    
	
	
    if(email==""){
        $("#log_email_error").html("Please enter your email!");
        $('#login_btn').html('Login');
        $('#login_btn').attr('disabled',false);
        is_error='yes';
	}
    if(password==""){
        $("#log_password_error").html("Please enter your password!");
        $('#login_btn').html('Login');
        $('#login_btn').attr('disabled',false);
        is_error='yes';
	}
    if(is_error==''){
		$.ajax({
			url:SITE_PATH+'login_submit',
			type:'post',
			data:'email='+email+'&password='+password,
			success:function(result){
				$('#login_btn').html('Login');
                $('#login_btn').attr('disabled',false);
                
                if($.trim(result).toUpperCase() == "WRONGEMAIL"){
                   $('.login_msg p').html('Please enter valid email id!');
                }
                
                if($.trim(result).toUpperCase() == "WRONGPASSWORD"){
                   $('.login_msg p').html('Please enter correct password!');
                }
                
                if($.trim(result).toUpperCase() == "NOTVERIFY"){
                   $('.login_msg p').html('Please verify your email id!');
                }
                
                if($.trim(result).toUpperCase() == "DEACTIVATE"){
                   $('.login_msg p').html('Your account has been deactivated!');
                }
                   
                if($.trim(result).toUpperCase() == "VALID"){
                    window.location.href=SITE_PATH+'shop';
                    $("#login_form")[0].reset();
                }
                
			}
            
		});
 }
}




//Checkout login form
function user_login_for_checkout(){
    $(".field_error").html("");
    $('#login_btn').html('Please wait...');
    $('#login_btn').attr('disabled',true);
    
	var email=$("#log_email").val();
	var password=$("#log_password").val();
    var is_error='';
    
	
	
    if(email==""){
        $("#log_email_error").html("Please enter your email!");
        $('#login_btn').html('Login');
        $('#login_btn').attr('disabled',false);
        is_error='yes';
	}
    if(password==""){
        $("#log_password_error").html("Please enter your password!");
        $('#login_btn').html('Login');
        $('#login_btn').attr('disabled',false);
        is_error='yes';
	}
    if(is_error==''){
		$.ajax({
			url:SITE_PATH+'login_submit',
			type:'post',
			data:'email='+email+'&password='+password,
			success:function(result){
				$('#login_btn').html('Login');
                $('#login_btn').attr('disabled',false);
                
                if($.trim(result).toUpperCase() == "WRONGEMAIL"){
                   $('.login_msg p').html('Please enter valid email id!');
                }
                
                if($.trim(result).toUpperCase() == "WRONGPASSWORD"){
                   $('.login_msg p').html('Please enter correct password!');
                }
                
                if($.trim(result).toUpperCase() == "NOTVERIFY"){
                   $('.login_msg p').html('Please verify your email id!');
                }
                
                if($.trim(result).toUpperCase() == "DEACTIVATE"){
                   $('.login_msg p').html('Your account has been deactivated!');
                }
                   
                if($.trim(result).toUpperCase() == "VALID"){
                    window.location.href=SITE_PATH+'checkout';
                    $("#login_form")[0].reset();
                }
                
			}
            
		});
 }
}







//Forgot password
function reset_password() {
    $('.field_error').html('');
    $('.field_correct').html('');
    var email = $('#forgot_password_email').val();
    if (email == '') {
        $('#forgot_password_email_error').html('Please enter your email !');
    } else {
        $('#forgot_btn').html('Please Wait...');
        $('#forgot_btn').attr('disabled', true);
        $.ajax({
            url: SITE_PATH+'forgot_password_submit',
            type: 'post',
            data: 'email=' + email,
            success: function (result) {
                $('#forgot_btn').html('Submit');
                $('#forgot_btn').attr('disabled', false);
                if ($.trim(result) == 'present') {
                    $('.forgot_password_msg p').html('Password send to your email.Please check your email inbox !');
                    $("#forgot_form")[0].reset();
                }
                if ($.trim(result) == 'not_present') {
                    $('#forgot_password_email_error').html('This Email id is not registered !');

                }
            }
        });
    }
}





//Show Category items by clicking checkbox
function set_checkbox(id){
    //hold values from input field of '#frm_catDish' form  
    var cat_dish=jQuery('#cat_dish').val();
    
    //=========== search this 'id'(which is parameter value of 'set_checkbox' function) is present or not present inside 'cat_dish' variable ===========//
    var check = cat_dish.search(":"+id);  //put -1 when no ':id' found inside cat_dish variable
    
        //if already present then unchecked the checkbox & remove values/data. If not present then hold all id with ':' inside 'cat_dish' variable
        if(check!='-1'){
            cat_dish=cat_dish.replace(":"+id,'');
        }else{
            cat_dish=cat_dish+":"+id;
        }
    //put cat_dish values to input feild of '#frm_catDish' form
    jQuery('#cat_dish').val(cat_dish);
    //submit the form
    jQuery('#frm_catDish')[0].submit();
}





//Show veg/non-veg/both item by clicking checkbox
function setDishType(type){
    //put dish type values to input feild of '#frm_catDish' form
    jQuery('#dish_type').val(type);
    //submit the form
    jQuery('#frm_catDish')[0].submit();
}


//Show search item by clicking search box
function setSearchType(){
    //put search values to input feild of '#frm_catDish' form
    jQuery('#search_str').val(jQuery('#search').val());
    //submit the form
    jQuery('#frm_catDish')[0].submit();
}




//add to cart
function add_to_cart(id,type){
    //hold quantity which selected by user
    var qty = jQuery('#qty'+id).val();
    //hold attribute which is selected by user
    var attr = jQuery('input[name="radio_'+id+'"]:checked').val();
    
    //checked qty & attr is selected or not
    var is_attr_checked='';
    if(typeof attr==='undefined'){
        is_attr_checked='no';
    }
    if(qty>0 && is_attr_checked!='no'){
        jQuery.ajax({
            url:SITE_PATH+'add_to_cart',
            type:'post',
            data:'qty='+qty+'&attr='+attr+'&type='+type,
            success:function(result){
                //decode json result data
                var data=jQuery.parseJSON(result);
                
                swal("Congratulation!", "Dish added successfully", "success");
                jQuery('#shop_added_msg_'+attr).html('[Added (Qty: '+qty+')]');
                
                // update total dish number inside header cart logo without page reload //  
                    jQuery('#totalCartDish').html(data.totalCartDish);
                // ================================================================== //
                
                // update total price inside header cart logo without page reload //  
                    jQuery('#totalCartPrice').html('&#2547; '+data.totalCartPrice);
                // ================================================================== //
                
                // This section for header cart option. When user add to cart any dish then heder cart section also updated without page reload //
                    if(data.totalCartDish==1){
                        var totalPrice=qty*data.price;
                        var shipping=50;
                        var grandTotal=totalPrice+shipping;
                        
                        html='<div class="shopping-cart-content"><ul id="cart_ul"><li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="" src="'+DISH_IMAGE_SITE_PATH+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+' ('+data.attribute+')</a></h4><h6>Qty: '+qty+'</h6><h6>Unit Price: &#2547; '+data.price+'</h6><span>Total Price: &#2547; '+totalPrice+'</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick=delete_cart("'+attr+'")><i class="ion ion-close"></i></a></div></li></ul><div class="shopping-cart-total"><h4>Shipping : <span>&#2547; '+shipping+'</span></h4><h4>Grand Total : <span class="shop-total">&#2547; '+grandTotal+'</span></h4></div><div class="shopping-cart-btn"><a href="cart">view cart</a><a href="checkout">checkout</a></div></div>';

                        jQuery('.header-cart').append(html);
                        
                    }else{
                        var totalPrice=qty*data.price;
                        var shipping=50;
                        var grandTotal=data.totalCartPrice+shipping;
                        
                        //remove old dish & add updated dish
                        jQuery('#attr_'+attr).remove();
                        
                        html='<li class="single-shopping-cart" id="attr_'+attr+'"><div class="shopping-cart-img"><a href="javascript:void(0)"><img alt="" src="'+DISH_IMAGE_SITE_PATH+data.image+'"></a></div><div class="shopping-cart-title"><h4><a href="javascript:void(0)">'+data.name+' ('+data.attribute+')</a></h4><h6>Qty: '+qty+'</h6><h6>Unit Price: &#2547; '+data.price+'</h6><span>Total Price: &#2547; '+totalPrice+'</span></div><div class="shopping-cart-delete"><a href="javascript:void(0)" onclick=delete_cart("'+attr+'")><i class="ion ion-close"></i></a></div></li>';
                        
                        jQuery('#cart_ul').append(html);
                        jQuery('.shop-total').html('&#2547; '+grandTotal);
                    }
                // ========================================================================================================================== //
            }
        });
    }else{
        swal("Error", "Please select dish item & quantity", "error");
    }

}





//delete cart item by atrribute id
function delete_cart(id, is_load) {
    jQuery.ajax({
        url: SITE_PATH + 'add_to_cart',
        type: 'post',
        data: 'attr=' + id + '&type=delete',
        success: function (result) {

            if (is_load == 'load') {
                window.location.href = window.location.href;
            } else {
                //decode json result data
                var data = jQuery.parseJSON(result);

                swal("Congratulation!", "Dish remove successfully", "success");
                //jQuery('#shop_added_msg_'+attr).html('[Added (Qty: '+qty+')]');

                // update total dish number inside header cart logo without page reload //  
                jQuery('#totalCartDish').html(data.totalCartDish);
                // ================================================================== //

                //remove '[Added (Qty: '+qty+')]' item from shop page
                jQuery('#shop_added_msg_' + id).html('');



                if (data.totalCartDish == 0) {
                    //remove cart dropdown box when no dish item add inside cart
                    jQuery('.shopping-cart-content').remove();

                    // update total price inside header cart logo without page reload //  
                    jQuery('#totalCartPrice').html('');
                    // ============================================================== //

                } else {
                    var shipping = 50;
                    var grandTotal = data.totalCartPrice + shipping;
                    jQuery('.shop-total').html('&#2547; ' + grandTotal);
                    //remove <li></li> by li id 
                    jQuery('#attr_' + id).remove();

                    // update total price inside header cart logo without page reload //  
                    jQuery('#totalCartPrice').html('&#2547; ' + data.totalCartPrice);
                    // ============================================================= //
                }
            }


        }
    });
}





//Profile Update
jQuery('#profilefrm').on('submit',function(e){
    jQuery('#profile_submit').attr('disabled',true);
    jQuery('#form_msg').html('Please wait...');
    jQuery.ajax({
        url:SITE_PATH+'update_profile',
        type:'post',
        data:jQuery('#profilefrm').serialize(),
        success:function(result){
            jQuery('#profile_submit').attr('disabled',false);
            jQuery('#form_msg').html('');
            var data=jQuery.parseJSON(result);
            if(data.status=='success'){
                //update top-right user name without page load
                jQuery('#user_top_name').html(jQuery('#uname').val());
                
                swal("Congratulation!", data.msg, "success");
            }
        }
    });
    e.preventDefault();
});



//Password Update
jQuery('#profilepasswordupdate').on('submit',function(e){
    jQuery('#profile_password_update').attr('disabled',true);
    jQuery('#password_form_msg').html('Please wait...');
    jQuery.ajax({
        url:SITE_PATH+'update_profile',
        type:'post',
        data:jQuery('#profilepasswordupdate').serialize(),
        success:function(result){
            jQuery('#profile_password_update').attr('disabled',false);
            jQuery('#password_form_msg').html('');
            var data=jQuery.parseJSON(result);
            if(data.status=='success'){
                swal("Congratulation!", data.msg, "success");
                $("#profilepasswordupdate")[0].reset();
            }
            if(data.status=='error'){
                swal("Error!", data.msg, "error");
            }
        }
    });
    e.preventDefault();
});




//Update Dish Rating
function updateRating(dish_details_id,order_id){
    var rate=jQuery('#rate_'+dish_details_id).val();
    var rate_text=jQuery('#rate_'+dish_details_id+' option:selected').text();
    
    if(rate==''){
        
    }else{
        jQuery.ajax({
            url:SITE_PATH+'updaterating',
            type:'post',
            data:'id='+dish_details_id+'&rate='+rate+'&order_id='+order_id,
            success:function(result){
                jQuery('#rating_'+dish_details_id).html("<div class='set_rating_style'>"+rate_text+"</div>");
            }
        });
    }
}