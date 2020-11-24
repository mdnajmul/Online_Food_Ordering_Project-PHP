<?php

    include('header.php');

    if(isset($_GET['referral_code']) && $_GET['referral_code']!=''){
        $_SESSION['FROM_REFERRAL_CODE']=get_safe_value($con,$_GET['referral_code']);
    }

?>
           

           <div class="login-register-area pt-95 pb-100">
               <div class="container">
                   <div class="row">
                       <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                           <div class="login-register-wrapper">
                               <div class="login-register-tab-list nav">
                                   <a class="active" data-toggle="tab" href="#lg1">
                                       <h4> login </h4>
                                   </a>
                                   <a data-toggle="tab" href="#lg2">
                                       <h4> register </h4>
                                   </a>
                               </div>
                               <div class="tab-content">
                                   <div id="lg1" class="tab-pane active">
                                       <div class="login-form-container">
                                           <div class="login-register-form">
                                               <form id="login_form" method="post">
                                                   <div style="margin-bottom:15px">
                                                       <input type="email" name="log_email" id="log_email" placeholder="Email*">
                                                       <span class="field_error" id="log_email_error"></span>
                                                   </div>
                                                   <div style="margin-bottom:15px">
                                                       <input type="password" name="log_password" id="log_password" placeholder="Password*">
                                                       <span class="field_error" id="log_password_error"></span>
                                                   </div>
                                                   <div class="button-box">
                                                       <div class="login-toggle-btn">
                                                           <a href="<?php echo SITE_PATH?>forgot_password">Forgot Password?</a>
                                                       </div>
                                                       <button type="button" onclick="user_login()" id="login_btn">Login</button>
                                                   </div>
                                               </form>
                                               <div class="login_msg">
                                                    <p class="form-messege field_error"></p>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div id="lg2" class="tab-pane">
                                       <div class="login-form-container">
                                           <div class="login-register-form">
                                               <form id="register_form" method="post">
                                                  
                                                   <div style="margin-bottom:15px">
                                                       <input type="text" name="name" id="name" placeholder="Name*">
                                                       <span class="field_error" id="name_error"></span>
                                                   </div>
                                                   <div style="margin-bottom:15px">
                                                       <input type="email" name="email" id="email" placeholder="Email*">
                                                       <span class="field_error" id="email_error"></span>
                                                   </div>
                                                   <div style="margin-bottom:15px">
                                                       <input type="text" name="mobile" id="mobile" placeholder="Mobile*" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
                                                       <span class="field_error" id="mobile_error"></span>
                                                   </div>
                                                   <div style="margin-bottom:15px">
                                                       <input type="password" name="password" id="password" placeholder="Password*">
                                                       <span class="field_error" id="password_error"></span>
                                                   </div>
                                                   
                                                   <div class="button-box" style="margin-bottom:15px">
                                                       <button type="button" onclick="user_register()" id="register_btn">Register</button>
                                                   </div>
                                                   
                                               </form>
                                               <div class="register_msg">
                                                    <p class="form-messege "></p>
                                               </div>
                                               
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       
      
<?php include('footer.php'); ?>