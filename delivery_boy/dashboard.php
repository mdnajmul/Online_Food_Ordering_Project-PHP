<?php

   //include database.inc.php file inside this login page
   include('../database.inc.php');

   //include function.inc.php file inside this login page
   include('../function.inc.php');


   if(!isset($_SESSION['DELIVERY_BOY_USER_LOGIN'])){
       redirect('index.php');
   }


   if(isset($_GET['set_order_id']) && $_GET['set_order_id']>0){
       $order_id=get_safe_value($con,$_GET['set_order_id']);
       $delivery_date=date('Y-m-d h:i:s');
       
       mysqli_query($con,"UPDATE order_master SET order_status=4,delivery_date='$delivery_date' WHERE id='$order_id' AND delivery_boy_id='".$_SESSION['DELIVERY_BOY_ID']."'");
   }

    //fetch data from 'order_master','order_status' table
    $sql="SELECT order_master.*,order_status.status FROM order_master,order_status WHERE order_master.order_status=order_status.id AND order_master.delivery_boy_id='".$_SESSION['DELIVERY_BOY_ID']."' AND order_master.order_status!=4 ORDER BY order_master.id DESC";
    //execute this query
    $res=mysqli_query($con,$sql);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../admin/assets/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../admin/assets/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../admin/assets/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">
</head>

<body class="sidebar-light">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
               <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">

                </ul>
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="index.html"><img src="../admin/assets/images/logo.png" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../admin/assets/images/logo.png" alt="logo" /></a>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                   
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" id="profileDropdown">
                            <span class="nav-profile-name"><?php echo $_SESSION['DELIVERY_BOY_NAME'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    
                    <li class="nav-item nav-toggler-item-right d-lg-none">
                        <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel" style="width:100%">
                <div class="content-wrapper">

                    <div class="card">
                        <div class="card-body">
                            <h1 class="grid_title" style="text-align:center">Order Delivery Details</h1>
                            <div class="row grid_box">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Order ID</th>
                                                    <th width="15%">Name/Mobile</th>
                                                    <th width="15%">Address</th>
                                                    <th width="10%">Price</th>
                                                    <th width="15%">Payment Status</th>
                                                    <th width="10%">Payment Type</th>
                                                    <th width="15%">Order Status</th>
                                                    <th width="10%">Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php 
                                                    if(mysqli_num_rows($res)>0) { 
                                                       while($row=mysqli_fetch_assoc($res)){  
                                                ?>
                                                            <tr>
                                                                <td><?php echo $row['id'];?></td>
                                                                <td>
                                                                    <p><?php echo $row['name'];?></p>
                                                                    <p><?php echo $row['mobile'];?></p>
                                                                </td>
                                                                <td><?php echo $row['address'].','.$row['zip_code'];?></td>
                                                                <td><?php echo '&#2547; '.$row['total_price'];?></td>
                                                                <td>
                                                                    <div class="payment_status payment_status_<?php echo $row['payment_status']?>"><?php echo ucfirst($row['payment_status']);?></div>
                                                                </td>
                                                                <td><?php echo $row['payment_type'];?></td>
                                                                <td>
                                                                    <a href="?set_order_id=<?php echo $row['id']?>" style="text-decoration:none;color:#fff;" class="order_status order_status_Delivered">Update Delivered</a>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        //convert date into second
                                                                        $dateScond=strtotime($row['added_on']);
                                                                        echo date('d-m-Y h:i',$dateScond);
                                                                    ?> 
                                                                </td>
                                                            </tr>
                                                <?php } } else { ?>  
                                                    <td colspan="8" style="text-align:center;">No Data Found !</td>
                                                <?php } ?>            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 Online-Food Ltd . All rights reserved.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../admin/assets/js/vendor.bundle.base.js"></script>
    <script src="../admin/assets/js/jquery.dataTables.js"></script>
    <script src="../admin/assets/js/dataTables.bootstrap4.js"></script>
    <script src="../admin/assets/js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>

</html>