<?php

   //include database.inc.php file inside this login page
   include('../database.inc.php');

   //include function.inc.php file inside this login page
   include('../function.inc.php');

   //create a $msg variable for show message
   $msg = '';

   //When click Signin button then username & password information comes here & we hold these information
   if(isset($_POST['submit'])){
       //hold/put mobile by $_POST['mobile']
       $mobile = get_safe_value($con,$_POST['mobile']);
       //hold/put password by $_POST['password']
       $pass = get_safe_value($con,$_POST['password']);
       
       //write select query for fetch all username & password data from 'admin' table from database
       $sql = "SELECT * FROM delivery_boy WHERE mobile='$mobile' AND password='$pass'";
       
       //execute this $sql query through by 'mysqli_query(database_connection, query)' function
       $res = mysqli_query($con,$sql);
       
       //check these $res data store inside database table by 'mysqli_num_rows()' function. If data are found then $count value is greater than 0.
       $count = mysqli_num_rows($res);
       if($count>0){
           $row=mysqli_fetch_assoc($res);
           
           //value transfer/store into session & delivery boy login the site
           $_SESSION['DELIVERY_BOY_USER_LOGIN']='yes';
           $_SESSION['DELIVERY_BOY_NAME']=$row['name'];
           $_SESSION['DELIVERY_BOY_ID']=$row['id'];
           
           //call redirect() from function page for redirect to dashboard.php page
           redirect('dashboard.php');
           
       }else{
           //if data not found then show this message
           $msg = "Please Enter Correct Login Details !";
       }
       
   }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Delivery Boy Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../admin/assets/css/style.css">
</head>

<body class="sidebar-light">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo text-center">
                                <img src="../admin/assets/images/logo.png" alt="logo">
                            </div>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <!--====================== Create Login Form  ==========================-->
                            <form class="pt-3" method="post">
                                <div class="form-group">
                                    <input type="textbox" class="form-control form-control-lg" id="mobile" placeholder="Mobile" name="mobile" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password" required>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" value="SIGN IN">
                                </div>
                            </form>
                            <!--==========================================================================-->

                            <!--========================= Create a <div> for show login error message =====================-->
                            <div class="field_error"> <?php echo $msg; ?> </div>
                            <!--===========================================================================================-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>