<?php

    include('header.php');

    if(!isset($_SESSION['FOOD_USER_ID'])){
        redirect(SITE_PATH.'shop');
    }
    
    //hold user details
    $userDetails=getUserDetails();

?>
           

           <div class="breadcrumb-area gray-bg">
               <div class="container">
                   <div class="breadcrumb-content">
                       <ul>
                           <li><a href="index.php">Home</a></li>
                           <li class="active">My Account </li>
                       </ul>
                   </div>
               </div>
           </div>
           <!-- my account start -->
           <div class="myaccount-area pb-80 pt-100">
               <div class="container">
                   <div class="row">
                       <div class="ml-auto mr-auto col-lg-9">
                           <div class="checkout-wrapper">
                               <div id="faq" class="panel-group">
                                  
                                   <div class="panel panel-default">
                                       <div class="panel-heading">
                                           <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                                       </div>
                                       <div id="my-account-1" class="panel-collapse collapse show">
                                           <div class="panel-body">
                                               <form method="post" id="profilefrm">
                                                   <div class="billing-information-wrapper">
                                                       <div class="row">
                                                           <div class="col-lg-6 col-md-6">
                                                               <div class="billing-info">
                                                                   <label>Name</label>
                                                                   <input type="text" name="name" id="uname" value="<?php echo $userDetails['name']?>" required>
                                                               </div>
                                                           </div>
                                                           <div class="col-lg-6 col-md-6">
                                                               <div class="billing-info">
                                                                   <label>Mobile Number</label>
                                                                   <input type="text" name="mobile" value="<?php echo $userDetails['mobile']?>" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
                                                               </div>
                                                           </div>
                                                           <div class="col-lg-12 col-md-12">
                                                               <div class="billing-info">
                                                                   <label>Email Address</label>
                                                                   <input type="email" readonly="readonly" name="email" value="<?php echo $userDetails['email']?>" required>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="billing-back-btn">
                                                           <div class="billing-back">
                                                               <a href="javascript:void(0)"><i class="ion-arrow-up-c"></i> back</a>
                                                           </div>
                                                           <div class="billing-btn">
                                                               <button type="submit" id="profile_submit">Save</button>
                                                           </div>
                                                       </div>
                                                       <div id="form_msg" style="color:green"></div>
                                                   </div>
                                                   <input type="hidden" name="type" value="profile">
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                                   
                                   <div class="panel panel-default">
                                       <div class="panel-heading">
                                           <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                                       </div>
                                       <div id="my-account-2" class="panel-collapse collapse">
                                           <div class="panel-body">
                                               <form method="post" id="profilepasswordupdate">
                                                   <div class="billing-information-wrapper">
                                                       <div class="row">
                                                           <div class="col-lg-12 col-md-12">
                                                               <div class="billing-info">
                                                                   <label>Old Password</label>
                                                                   <input type="password" name="old_password" required>
                                                               </div>
                                                           </div>
                                                           <div class="col-lg-12 col-md-12">
                                                               <div class="billing-info">
                                                                   <label>New Password</label>
                                                                   <input type="password" name="new_password" required>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="billing-back-btn">
                                                           <div class="billing-back">
                                                               <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                           </div>
                                                           <div class="billing-btn">
                                                               <button type="submit" id="profile_password_update">Update Password</button>
                                                           </div>
                                                       </div>
                                                       <div id="password_form_msg" style="color:green"></div>
                                                   </div>
                                                   <input type="hidden" name="type" value="password">
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                                   
                                   <div class="panel panel-default">
                                       <div class="panel-heading">
                                           <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Refferal System</a></h5>
                                       </div>
                                       <div id="my-account-3" class="panel-collapse collapse">
                                           <div class="panel-body">
                                               <div class="billing-information-wrapper">
                                                   <div class="row">
                                                       <div class="col-lg-12 col-md-12">
                                                           <div class="billing-info">
                                                               <label>Your Refferal Code</label>
                                                               <input type="textbox" style="color:green;" value="<?php echo $userDetails['referral_code']?>" readonly>
                                                           </div>
                                                       </div>
                                                       <div class="col-lg-12 col-md-12">
                                                           <div class="billing-info">
                                                               <label>Your Refferal Link</label>
                                                               <input type="textbox" style="color:green;" value="<?php echo SITE_PATH?>login_register?referral_code=<?php echo $userDetails['referral_code']?>" readonly>
                                                           </div>
                                                       </div>
                                                       <div class="col-lg-12 col-md-12">
                                                           <div class="billing-info">
                                                               <?php
                                                                  $referral_code=$userDetails['referral_code'];
                                                                  $row=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) AS total_referral FROM users WHERE from_referral_code='$referral_code'"));
                                                                  $total_referral_user=$row['total_referral'];
                                                               ?>
                                                               <label>Your Total Refferal User</label>
                                                               <input type="textbox" style="color:green;" value="<?php echo $total_referral_user?>" readonly>
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
                   </div>
               </div>
           </div>
        
       
      
<?php include('footer.php'); ?>