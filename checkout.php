<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
// Checking that the user is registered or guest--->
    $err_msg='';
    $name='';
    $phone='';
    $email='';
    $address='';
    $city='';
    $state='';
    $country='';
    $zip='';

    $arr_cart_p_id[]=array();
    $arr_cart_p_name[]=array();
    $arr_cart_p_qty[]=array();
    $arr_cart_p_pkg_id[]=array();
    $arr_cart_pkg_name[]=array();
    $arr_cart_pkg_price[]=array();
    $table_total_price = 0;

    if(isset($_SESSION['customer'])){
        $statement = $pdo->prepare("SELECT * FROM tbl_cart WHERE cust_id=?");
        $statement->execute(array($_SESSION['customer']['cust_id']));
        $c=$statement->rowCount();
        if($c){
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $i=0;
            foreach($result as $row){
                $arr_cart_p_id[$i]=$row['product_id'];
                $arr_cart_p_pkg_id[$i]=$row['package_id'];
                $arr_cart_p_qty[$i]=$row['quantity'];
                $i++;
            }
        // Setting Address -->
        $name=$_SESSION['customer']['cust_s_name'];
        $phone=$_SESSION['customer']['cust_s_phone'];
        $email=$_SESSION['customer']['cust_s_email'];
        $address=$_SESSION['customer']['cust_s_address'];
        $city=$_SESSION['customer']['cust_s_city'];
        $state=$_SESSION['customer']['cust_s_state'];
        $country=$_SESSION['customer']['cust_s_country'];
        $zip=$_SESSION['customer']['cust_s_zip'];

        }else{
            header('location: cart.php');
            exit; 
        }
    }else{
        if(!isset($_SESSION['cart_p_id'])) {
            header('location: cart.php');
            exit;
        }else{
            $i=0;
            foreach($_SESSION['cart_p_id'] as $key => $value) 
            {
                $arr_cart_p_id[$i] = $value;
                $i++;
            }                    
            $i=0;
            foreach($_SESSION['cart_p_pkg_id'] as $key => $value) 
            {
                $arr_cart_p_pkg_id[$i] = $value;
                $i++;
            }        
            $i=0;
            foreach($_SESSION['cart_p_qty'] as $key => $value) 
            {
                $arr_cart_p_qty[$i] = $value;
                $i++;
            }
            if(isset($_SESSION['s_address'])){
                $name=$_SESSION['s_address']['name'];
                $email=$_SESSION['s_address']['email'];
                $phone=$_SESSION['s_address']['phone'];
                $address=$_SESSION['s_address']['address'];
                $city=$_SESSION['s_address']['city'];
                $state=$_SESSION['s_address']['state'];
                $country=$_SESSION['s_address']['country'];
                $zip=$_SESSION['s_address']['zip'];
            }
        }
    }
    // Fetching product name-->
    $i=0;
    for($i=0;$i<count($arr_cart_p_id);$i++){
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
        $statement->execute(array($arr_cart_p_id[$i]));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $arr_cart_p_name[$i]=$row['p_name'];
        } 
    }
    // // Feching the package name and price->
    $i=0;
    for($i=0;$i<count($arr_cart_p_pkg_id);$i++){
        $statement = $pdo->prepare("SELECT * FROM tbl_product_package WHERE id=?");
        $statement->execute(array($arr_cart_p_pkg_id[$i]));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $arr_cart_pkg_name[$i]=$row['pkg_name'];;
            $arr_cart_pkg_price[$i]=$row['pkg_price'];;
        } 
    }
    // total price--->$
    $i=0;
    for($i=0;$i<count($arr_cart_p_qty);$i++){
        $table_total_price=$table_total_price +($arr_cart_p_qty[$i]*$arr_cart_pkg_price[$i]);
    }

    // Processing form data---->$
    if(isset($_POST['form1'])){
        $valid=1;
        // validating the form data
        if(empty($_POST['name'])){
            $valid=0;
            $err_msg .="Name should not be empty.</br>";
        }
        if(empty($_POST['phone'])){
            $valid=0;
            $err_msg .="Phone should not be empty.</br>";
        }
        if(empty($_POST['email'])){
            $valid=0;
            $err_msg .="Email should not be empty.</br>";
        }
        if(empty($_POST['address'])){
            $valid=0;
            $err_msg .="Address should not be empty.</br>";
        }
        if(empty($_POST['city'])){
            $valid=0;
            $err_msg .="City should not be empty.</br>";
        }
        if(empty($_POST['state'])){
            $valid=0;
            $err_msg .="State should not be empty.</br>";
        }
        if(empty($_POST['country'])){
            $valid=0;
            $err_msg .="Country should not be empty.</br>";
        }
        if(empty($_POST['zip'])){
            $valid=0;
            $err_msg .="Zip should not be empty.</br>";
        }
        if(empty($_POST['payment_method'])){
            $valid=0;
            $err_msg .="Payment method should be selected.</br>";
        }

        if($valid==1){
            if(isset($_SESSION['customer'])){
                $statement = $pdo->prepare("SELECT * FROM tbl_cart WHERE cust_id=?");
                $statement->execute(array($_SESSION['customer']['cust_id']));
                $c=$statement->rowCount();
                if($c){
                    if(!empty($_POST['set_address'])){
                        if($_POST['set_address']==1){
                            $statement = $pdo->prepare("UPDATE `tbl_customer` SET cust_s_name=?,`cust_s_phone`=?,`cust_s_email`=?, `cust_s_address`=?,`cust_s_city`=?,`cust_s_state`=?,`cust_s_country`=?,`cust_s_zip`=? WHERE `cust_id` =? ");
                            $statement->execute(array(strip_tags($_POST['name']),strip_tags($_POST['phone']),strip_tags($_POST['email']),strip_tags($_POST['address']),strip_tags($_POST['city']),strip_tags($_POST['state']),strip_tags($_POST['country']),strip_tags($_POST['zip']),$_SESSION['customer']['cust_id']));
                            
                            // Setting Address -->
                            $_SESSION['customer']['cust_s_name']=strip_tags($_POST['name']);
                            $_SESSION['customer']['cust_s_phone']=strip_tags($_POST['phone']);
                            $_SESSION['customer']['cust_s_email']=strip_tags($_POST['email']);
                            $_SESSION['customer']['cust_s_address']=strip_tags($_POST['address']);
                            $_SESSION['customer']['cust_s_city']=strip_tags($_POST['city']);
                            $_SESSION['customer']['cust_s_state']=strip_tags($_POST['state']);
                            $_SESSION['customer']['cust_s_country']=strip_tags($_POST['country']);
                            $_SESSION['customer']['cust_s_zip']=strip_tags($_POST['zip']);
                        }
                    }

                }else{
                    header('location: cart.php');
                    exit; 
                }
            }else{
                if(!isset($_SESSION['cart_p_id'])){
                    header('location: cart.php');
                    exit; 
                }
      
            }

            $_SESSION['s_address']['name']=strip_tags($_POST['name']);
            $_SESSION['s_address']['phone']=strip_tags($_POST['phone']);
            $_SESSION['s_address']['email']=strip_tags($_POST['email']);
            $_SESSION['s_address']['address']=strip_tags($_POST['address']);
            $_SESSION['s_address']['city']=strip_tags($_POST['city']);
            $_SESSION['s_address']['state']=strip_tags($_POST['state']);
            $_SESSION['s_address']['country']=strip_tags($_POST['country']);
            $_SESSION['s_address']['zip']=strip_tags($_POST['zip']);
            $_SESSION['s_payment_method']=strip_tags($_POST['payment_method']);
            $_SESSION['s_comment']=trim(strip_tags($_POST['comment']));

            unset($_POST['name']);
            unset($_POST['phone']);
            unset($_POST['email']);
            unset($_POST['address']);
            unset($_POST['city']);
            unset($_POST['state']);
            unset($_POST['coutnry']);
            unset($_POST['zip']);
            unset($_POST['payment_method']);
            unset($_POST['comment']);

            header("location:payment/cod/cod.php");
            exit;
        }
    }
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <form action="" method="post">
                <?php $csrf->echoInputField(); ?>
                <div class="col-md-8 mb-4">
                    <div class="col-md-12">
                        <div class="user-content">
                            <div class="row">
                                <h3><?php echo LANG_VALUE_87; ?></h3>

                                <?php
                                    if($err_msg != '') {
                                        echo '<div class="alert alert-danger alert-dismissible">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Warning!</strong> '. $err_msg .'
                                    </div>';
                                    $err_msg='';
                                    }
                                ?>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_102; ?><sup>*</sup></label>
                                        <input type="text" required class="form-control" name="name"
                                            value="<?php echo $name; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_105; ?><sup>*</sup></label>
                                        <textarea name="address" required class="form-control" cols="30" rows="5"
                                            style="height:110px;"><?php echo $address; ?></textarea>
                                    </div>

                                    <!-- Select Payment Method -->
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_34; ?> *</label>
                                        <select name="payment_method" class="form-control" required>
                                            <option value=""><?php echo LANG_VALUE_35; ?></option>
                                            <option value="Zelle"><?php echo "Zelle"; ?></option>
                                            <option value="Cash App"><?php echo "Cash App"; ?></option>
                                            <option value="Venmo"><?php echo "Venmo"; ?></option>
                                            <option value="PayPal"><?php echo "PayPal"; ?></option>
                                            <option value="Western Union"><?php echo "Western Union"; ?></option>
                                            <option value="Other"><?php echo "Other"; ?></option>
                                        </select>
                                        <br>
                                        <p>You will receive a payment link over
                                            email to
                                            complete the payment. Please complete your payment through the link.</p>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo "Order Note (Optional)"; ?></label>
                                        <textarea name="comment"
                                            placeholder="Comment about your order, e.g. special notes for delivery or payment method."
                                            class="form-control" cols="30" rows="5" style="height:110px;"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><?php echo "Email"; ?><sup>*</sup></label>
                                        <input type="email" required class="form-control" name="email"
                                            value="<?php echo $email; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_104; ?><sup>*</sup></label>
                                        <input type="text" required class="form-control" name="phone"
                                            value="<?php echo $phone; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_107; ?><sup>*</sup></label>
                                        <input type="text" required class="form-control" name="city"
                                            value="<?php echo $city; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_108; ?><sup>*</sup></label>
                                        <input type="text" required class="form-control" name="state"
                                            value="<?php echo $state; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_106; ?><sup>*</sup></label>
                                        <select name="country" class="form-control" required>
                                            <option value="">Select Country</option>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                ?>
                                            <option value="<?php echo $row['country_id']; ?>"
                                                <?php if($row['country_id'] == $country) {echo 'selected';} ?>>
                                                <?php echo $row['country_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo LANG_VALUE_109; ?><sup>*</sup></label>
                                        <input type="text" class="form-control" required name="zip"
                                            value="<?php echo $zip; ?>">
                                    </div>
                                    <div class="form-group checkbox" style="color:blue">
                                        <?php
                                            if(isset($_SESSION['customer'])){ ?>
                                        <label>
                                            <input type="checkbox" name="set_address" value=1> <b>Set as default
                                                shipping address</b>
                                        </label>
                                        <?php }else{?>
                                        <!-- <label>
                                            <input type="checkbox" name="set_profile" value=1> <b >Check to create account</b>
                                            </label> -->
                                        <?php }?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>Summary</h4>
                        </div>
                        <ul class="panel-body list-group">
                            <?php for($i=0;$i<count($arr_cart_p_name);$i++){ ?>
                            <li class="list-group-item " style="border:0px">
                                <div><b style="float:left"><?php echo $arr_cart_p_name[$i]; ?></b><span
                                        style="float:right"><?php echo "".$arr_cart_p_qty[$i] ."X $". $arr_cart_pkg_price[$i]; ?></span>
                                </div>
                                <br class="clear" />
                            </li>
                            <?php } ?>
                            <li class="list-group-item" style="font-weight:bold">
                                <h4>
                                    <p style="float:left">Total Price </p><span
                                        style="float:right"><?php echo "$".$table_total_price;?></span>
                                </h4><br class="clear" />
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block"
                            value="<?php echo"PLACE ORDER";#echo LANG_VALUE_46; ?>" name="form1">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>