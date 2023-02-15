<?php require_once('header.php'); ?>
<!-- FETCHING STANDARD DATA -->
<?php
    // Fetching the banner-->
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    foreach ($result as $row) {
        $banner_cart = $row['banner_cart'];
    }

    
    // Fetching the cart data according the user id registered or not registered -->
    $GUEST=true;
    $TOTAL_ITEMES=0;

    $arr_cart_p_id[]=array();
    $arr_cart_p_featured_photo[]=array();
    $arr_cart_p_name[]=array();
    $arr_cart_p_qty[]=array();
    $arr_cart_p_pkg_id[]=array();
    $arr_cart_pkg_name[]=array();
    $arr_cart_pkg_price[]=array();
    $table_total_price = 0;
                    
    if(!isset($_SESSION['customer'])) {
        // guest user--->
        $GUEST=true;
        if(isset($_SESSION['cart_p_id']) && isset($_SESSION['cart_p_pkg_id']) && isset($_SESSION['cart_p_qty'])){
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
            $TOTAL_ITEMES=count($arr_cart_p_id);
        }else {
            $TOTAL_ITEMES=0;
        }   
    }else{
        // registered user -->
        $GUEST=false;
        $arr_cart_id[]=array();
        $arr_cart_cust_id[]=array();

        $statement = $pdo->prepare("SELECT * FROM tbl_cart WHERE cust_id=?");
        $statement->execute(array($_SESSION['customer']['cust_id']));
        $TOTAL_ITEMES = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $i=0;
        foreach($result as $row){
            $arr_cart_id[$i]=$row['id'];
            $arr_cart_cust_id[$i]=$row['cust_id'];
            $arr_cart_p_id[$i]=$row['product_id'];
            $arr_cart_p_pkg_id[$i]=$row['package_id'];
            $arr_cart_p_qty[$i]=$row['quantity'];
            $i++;
        }
    }
    $j=0;              
    for ($j=0;$j<$TOTAL_ITEMES;$j++){
        // Getting product name and featured photo-->
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
        $statement->execute(array($arr_cart_p_id[$j]));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $arr_cart_p_name[$j]=$row['p_name'];
            $arr_cart_p_featured_photo[$j]=$row['p_featured_photo'];
        } 

        // Getting package_name and package_price-->
        $statement = $pdo->prepare("SELECT * FROM tbl_product_package WHERE id=?");
        $statement->execute(array($arr_cart_p_pkg_id[$j]));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
            $arr_cart_pkg_name[$j]=$row['pkg_name'];
            $arr_cart_pkg_price[$j]=$row['pkg_price'];
        }
    }
?>

<!-- Updating Cart -->
<?php

    $c_err_msg = '';
    $c_success_msg = '';

    if(isset($_POST['form1'])) {
        $arr_u_p_id=array();
        $arr_u_p_pkg_id=array();
        $arr_u_p_qty=array();
        $i=0;
        foreach($_POST['product_id'] as $val) {
            $arr_u_p_id[$i] = $val;
            $i++;
        }
        $i=0;
        foreach($_POST['package_id'] as $val) {
            $arr_u_p_pkg_id[$i] = $val;
            $i++;
        }
        $i=0;
        foreach($_POST['quantity'] as $val) {
            $arr_u_p_qty[$i] = $val;
            $i++;
        }


        // Updating cart according user is registered or not--->
        $i=0;
        for($i=0;$i<count($arr_u_p_id);$i++){
            $j=0;
            for($j=0;$j<count($arr_cart_p_id);$j++){
                if(($arr_u_p_id[$i]==$arr_cart_p_id[$j]) && ($arr_u_p_pkg_id[$i]==$arr_cart_p_pkg_id[$j]) ){
                    if(!isset($_SESSION['customer'])){
                        if (isset($_SESSION['cart_p_id']) && isset($_SESSION['cart_p_pkg_id']) && isset($_SESSION['cart_p_qty'])){
                            $_SESSION['cart_p_qty'][$j]=$arr_u_p_qty[$i];
                        }else{
                            header('location:index.php');
                            exit;
                        }   
                    }else{
                        $statement = $pdo->prepare("UPDATE `tbl_cart` SET `quantity` =? WHERE `cust_id`=? AND `product_id`=? AND `package_id`=?");
                        $statement->execute(array($arr_u_p_qty[$i],$_SESSION['customer']['cust_id'],$arr_u_p_id[$i],$arr_u_p_pkg_id[$i]));
                    }
                    $arr_cart_p_qty[$j]=$arr_u_p_qty[$i];
                    break;
                }
            }
        }
        $c_success_msg='All Items Quantity Update is Successful!';
        unset($_POST['quantity']);
        unset($_POST['package_id']);
        unset($_POST['product_id']);
    }  
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_cart; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_18; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    if($c_success_msg != '') {
                        echo '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>'. $c_success_msg .'</strong></div>';
                    $c_success_msg='';
                    }
                    if($c_err_msg != '') {
                        echo '<div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>'. $c_err_msg .'</strong></div>';
                    $c_err_msg='';
                    }

                ?>

                <?php if($TOTAL_ITEMES==0): ?>
                <?php echo '<h2 class="text-center">Cart is Empty!!</h2></br>'; ?>
                <?php echo '<h4 class="text-center">Add products to the cart in order to view it here.</h4>'; ?>
                <?php else: ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 mera-cart ">
                            <h4 class='cart-heading'>My Shopping Cart(<?php echo count($arr_cart_p_id); ?>)</h4>
                            <hr />
                            <?php 
                            $c=1;
                            for($i=count($arr_cart_p_id)-1;$i>=0;$i--){ 
                        ?>
                            <div class="row cart-row thumbnail">
                                <div class="col-xs-6 col-sm-3 cart-img">
                                    <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                                </div>
                                <div class="col-xs-6 col-sm-3 cart-name ">
                                    <h4><?php echo $arr_cart_p_name[$i]; ?></h4>
                                    <small><?php echo $arr_cart_pkg_name[$i]; ?></small>
                                </div>

                                <!-- Add the extra clearfix for only the required viewport -->
                                <div class="clearfix visible-xs-block"></div>

                                <div class="col-xs-6 col-sm-2 cart-qty ">
                                    <input type="hidden" name="product_id[]" value="<?php echo $arr_cart_p_id[$i]; ?>">
                                    <input type="hidden" name="package_id[]"
                                        value="<?php echo $arr_cart_p_pkg_id[$i]; ?>">
                                    <input type="number" class="input-text hidden" step="1" min="1" max=""
                                        name="quantity[]" value="<?php echo $arr_cart_p_qty[$i]; ?>" title="Qty"
                                        size="4" pattern="[0-9]" inputmode="numeric" id="cart_qty<?php echo $i; ?>">
                                    <div class="btn-group qty-btn-parent">
                                        <button type="button" class="btn   qty-btn"
                                            onclick="cartMinus(<?php echo $i; ?>)"><span
                                                class='glyphicon glyphicon-minus'></span></button>
                                        <span class="btn qty-text"
                                            id="cart_text<?php echo $i; ?>"><?php echo $arr_cart_p_qty[$i]; ?></span>
                                        <button type="button" class="btn  qty-btn"
                                            onclick="cartPlus(<?php echo $i; ?>)"><span
                                                class='glyphicon glyphicon-plus'></span></button>
                                    </div>

                                </div>
                                <div class="col-xs-3 col-sm-2 cart-price ">
                                    <?php
                                        $row_total_price = $arr_cart_pkg_price[$i] * $arr_cart_p_qty[$i];
                                        $table_total_price = $table_total_price + $row_total_price;
                                        ?>
                                    <?php echo LANG_VALUE_1; ?><?php echo $row_total_price; ?>
                                </div>
                                <div class="col-xs-3 col-sm-2 cart-btn ">
                                    <a onclick="return confirmDelete();"
                                        href="cart-item-delete.php?p_id=<?php echo $arr_cart_p_id[$i]; ?>&pkg_id=<?php echo $arr_cart_p_pkg_id[$i]; ?>"
                                        class="trash"><i class="fa fa-trash-o fa-2x" style="color:red;"></i>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="cart-buttons">
                                <ul>
                                    <li><input type="submit" value="<?php echo LANG_VALUE_20; ?>"
                                            class="btn btn-lg btn-primary" name="form1"></li>
                                    <li><a href="index.php" class="btn btn-lg btn-info"><?php echo LANG_VALUE_85; ?></a>
                                    </li>
                                    <li><a href="checkout.php"
                                            class="btn btn-lg btn-success"><?php echo LANG_VALUE_23; ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class=" col-md-2"></div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once('footer.php'); ?>
<script src="assets/js/cart_quantity.js"></script>