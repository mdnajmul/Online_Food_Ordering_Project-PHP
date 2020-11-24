<?php

    include('header.php');

?>
           

           <div class="login-register-area pt-95 pb-100">
               <div class="container">
                   <div class="row">
                       <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                           <div class="login-register-wrapper">
                               <div class="login-register-tab-list nav">
                                   <h4>Forgot Password</h4>
                               </div>
                               <div class="tab-content">
                                   <div id="lg1" class="tab-pane active">
                                       <div class="login-form-container">
                                           <div class="login-register-form">
                                               <form id="forgot_form" method="post">
                                                   <div style="margin-bottom:15px">
                                                       <input type="email" name="forgot_password_email" id="forgot_password_email" placeholder="Email*">
                                                       <span class="field_error" id="forgot_password_email_error"></span>
                                                   </div>
                                                   <div class="button-box">
                                                       <div class="login-toggle-btn">
                                                           <a href="<?php echo SITE_PATH?>login_register">Login</a>
                                                       </div>
                                                       <button type="button" onclick="reset_password()" id="forgot_btn">Submit</button>
                                                   </div>
                                               </form>
                                               <div class="forgot_password_msg">
                                                    <p class="form-messege field_correct"></p>
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