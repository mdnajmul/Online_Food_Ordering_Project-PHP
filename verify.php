<?php

    include('header.php');

    $msg="";

    if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_value($con,$_GET['id']);
        $user_res=mysqli_fetch_assoc(mysqli_query($con,"SELECT email_verify,email FROM users WHERE rand_str='$id'"));
        $registered_user_email=$user_res['email'];
        
        if($user_res['email_verify']==0){
            mysqli_query($con,"UPDATE users SET email_verify=1 WHERE rand_str='$id'");
            $msg="Congrasulation! Your email id verified.Now you can login.";
            
            
        }else{
            $msg="Your email id already verified!";
        }
    }else{
        //redirect(SITE_PATH);
    }


?>
           

           <div class="breadcrumb-area gray-bg">
               <div class="container">
                   <div class="breadcrumb-content">
                       <ul>
                           <li><a href="<?php echo SITE_PATH?>shop">Home</a></li>
                           <li class="active"> Email Verify </li>
                       </ul>
                   </div>
               </div>
           </div>
           <div class="contact-area pt-100 pb-100">
               <div class="container">
                   <div class="row">
                       <div class="col-12">
                           <div class="contact-message-wrapper">
                               <h4 class="contact-title" style="color:green;font-weight:bold;font-size:18px;">
                                   <?php
                                      echo $msg;
                                   ?>
                               </h4>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       
      
<?php include('footer.php'); ?>