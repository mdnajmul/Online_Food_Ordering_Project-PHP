<?php

    include('header.php');

?>
           

           <div class="breadcrumb-area gray-bg">
               <div class="container">
                   <div class="breadcrumb-content">
                       <ul>
                           <li><a href="<?php echo SITE_PATH?>shop">Home</a></li>
                           <li class="active"> Contact Us </li>
                       </ul>
                   </div>
               </div>
           </div>
           <div class="contact-area pt-100 pb-100">
               <div class="container">
                   <div class="row">
                       <div class="col-lg-4 col-md-6 col-12">
                           <div class="contact-info-wrapper text-center mb-30">
                               <div class="contact-info-icon">
                                   <i class="ion-ios-location-outline"></i>
                               </div>
                               <div class="contact-info-content">
                                   <h4>Our Location</h4>
                                   <p>H/N# 30, Sector# 4, Road# 3, Uttara</p>
                                   <p>Dhaka,Bangladesh</p>
                                   <p><a href="#">info@foodonline.mail.com</a></p>
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-4 col-md-6 col-12">
                           <div class="contact-info-wrapper text-center mb-30">
                               <div class="contact-info-icon">
                                   <i class="ion-ios-telephone-outline"></i>
                               </div>
                               <div class="contact-info-content">
                                   <h4>Contact us Anytime</h4>
                                   <p>Mobile: +880 1712345678</p>
                                   <p>Phone: 09612344502</p>
                               </div>
                           </div>
                       </div>
                       <div class="col-lg-4 col-md-6 col-12">
                           <div class="contact-info-wrapper text-center mb-30">
                               <div class="contact-info-icon">
                                   <i class="ion-ios-email-outline"></i>
                               </div>
                               <div class="contact-info-content">
                                   <h4>Write Some Words</h4>
                                   <p><a href="#">Support24/7@foodonline.com </a></p>
                                   <p><a href="#">info@foodonline.mail.com</a></p>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-12">
                           <div class="contact-message-wrapper">
                               <h4 class="contact-title">GET IN TOUCH</h4>
                                   <!--=== Show Error & Success Message ===-->
                                       <div class="msg_err"></div>
                                       <div class="msg_corr"></div>
                                    <!--=== Show Error & Success Message ===-->
                                
                               <div class="contact-message">
                                   <form id="contact-form" action="#" method="post">
                                       <div class="row">
                                           <div class="col-lg-4">
                                               <div class="contact-form-style mb-20">
                                                   <input type="text" name="c_name" id="c_name" placeholder="Full Name*">
                                               </div>
                                           </div>
                                           <div class="col-lg-4">
                                               <div class="contact-form-style mb-20">
                                                   <input type="email" name="c_email" id="c_email" placeholder="Email Address*">
                                               </div>
                                           </div>
                                           <div class="col-lg-4">
                                               <div class="contact-form-style mb-20">
                                                   <input type="text" name="c_mobile" id="c_mobile" placeholder="Mobile*" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}">
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="contact-form-style mb-20">
                                                   <input type="text" name="c_subject" id="c_subject" placeholder="Subject*">
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="contact-form-style">
                                                   <textarea name="c_message" id="c_message" placeholder="Message*"></textarea>
                                                   <button type="button" onclick="send_message()" class="submit btn-style" >SEND MESSAGE</button>
                                               </div>
                                           </div>
                                       </div>
                                   </form>
                                   <p class="form-messege"></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       
      
<?php include('footer.php'); ?>