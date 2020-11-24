<?php 

    include('top.php');

    $user_id='';


    /**This is for when click Submit Button.**/
    if(isset($_POST['submit'])){
        //hold categorr name & order number from html form
        $money = get_safe_value($con,$_POST['money']);
        $msg = get_safe_value($con,$_POST['msg']);
        $user_id = get_safe_value($con,$_GET['id']);
        
        manageWallet($user_id,$money,'in',$msg);
        redirect('users.php');
              
    }



?>

<div class="row">
    <h1 class="grid_title ml10 ml15"><strong>Wallet</strong> <small>Form</small></h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="money">Amount</label>
                        <input type="number" class="form-control" name="money" placeholder="Enter Amount" required>
                    </div>
                    <div class="form-group">
                        <label for="msg">Message</label>
                        <input type="textbox" class="form-control" name="msg" placeholder="Enter Message" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                </form>
    
            </div>
        </div>
    </div>

</div>
        



<?php include('footer.php'); ?>