<?php

   //include database.inc.php file inside this login page
   include('../database.inc.php');

   //include function.inc.php file inside this login page
   include('../function.inc.php');

   //create a $msg variable for show message
   $msg = '';

   //When click Signin button then username & password information comes here & we hold these information
   if(isset($_POST['submit'])){
       //hold/put username by $_POST['username']
       $userName = get_safe_value($con,$_POST['username']);
       //hold/put password by $_POST['password']
       $pass = get_safe_value($con,$_POST['password']);
       
       //write select query for fetch all username & password data from 'admin' table from database
       $sql = "SELECT * FROM admin WHERE username='$userName' AND password='$pass'";
       
       //execute this $sql query through by 'mysqli_query(database_connection, query)' function
       $res = mysqli_query($con,$sql);
       
       //check these $res data store inside database table by 'mysqli_num_rows()' function. If data are found then $count value is greater than 0.
       $count = mysqli_num_rows($res);
       if($count>0){
           $row=mysqli_fetch_assoc($res);
           
           //value transfer/store into session & admin login the site
           $_SESSION['ADMIN_LOGIN']='yes';
           $_SESSION['ADMIN_NAME']=$row['name'];
           
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
  <title>Food Ordering Admin Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="sidebar-light">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo text-center">
                <img src="assets/images/logo.png" alt="logo">
              </div>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <!--====================== Create Login Form  ==========================-->
              <form class="pt-3" method="post">
                <div class="form-group">
                  <input type="textbox" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password" required>
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
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- plugins:js -->
  <script src="assets/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/js/Chart.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>
</html>