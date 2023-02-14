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
        // if(!isset($_SESSION['customer'])){
        //     if (isset($_SESSION['cart_p_id']) && isset($_SESSION['cart_p_pkg_id']) && isset($_SESSION['cart_p_qty'])){
        //         $i=0;
        //         for($i=0;$i<count($arr_u_p_id);$i++){
        //             $j=0;
        //             for($j=0;$j<count($arr_cart_p_id);$j++){
        //                 if(($arr_u_p_id[$i]==$arr_cart_p_id[$j]) && ($arr_u_p_pkg_id[$i]==$arr_cart_p_pkg_id[$j]) ){
        //                     $_SESSION['cart_p_qty'][$j]=$arr_u_p_qty[$i];
        //                     $arr_cart_p_qty[$j]=$arr_u_p_qty[$i];
        //                     break;
        //                 }
        //             }
        //         }
        //         $c_success_msg='All Items Quantity Update is Successful!';
        //     }else{
        //         header('location:index.php');
        //     }
            
        // }else{
        //     $i=0;
        //     for($i=0;$i<count($arr_u_p_id);$i++){
        //         $statement = $pdo->prepare("UPDATE `tbl_cart` SET `quantity` =? WHERE `cust_id`=? AND `product_id`=? AND `package_id`=?");
        //         $statement->execute(array($arr_u_p_qty[$i],$_SESSION['customer']['cust_id'],$arr_u_p_id[$i],$arr_u_p_pkg_id[$i]));
        //     }
        //     $c_success_msg='All Items Quantity Update is Successful!';
        // }
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
                    <?php $csrf->echoInputField(); ?>
                    <div class="cart">
                        <table class="table table-responsive table-hover table-bordered">
                            <tr>
                                <th><?php echo '#' ?></th>
                                <th><?php echo LANG_VALUE_8; ?></th>
                                <th><?php echo LANG_VALUE_47; ?></th>
                                <th><?php echo "Package Name";#LANG_VALUE_157 ?></th>
                                <!-- <th> #LANG_VALUE_158; </th> -->
                                <th><?php echo LANG_VALUE_159; ?></th>
                                <th><?php echo LANG_VALUE_55; ?></th>
                                <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                                <th class="text-center" style="width: 100px;"><?php echo LANG_VALUE_83; ?></th>
                            </tr>

                            <?php 
                                $c=1;
                                for($i=count($arr_cart_p_id)-1;$i>=0;$i--): 
                            ?>
                            <tr>
                                <td><?php echo $c++; ?></td>
                                <td>
                                    <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                                </td>
                                <td><?php echo $arr_cart_p_name[$i]; ?></td>
                                <td><?php echo $arr_cart_pkg_name[$i]; ?></td>
                                <!-- <td><?php  #$arr_cart_color_name[$i];<?>/td> -->
                                <td><?php echo LANG_VALUE_1; ?><?php echo $arr_cart_pkg_price[$i]; ?></td>
                                <td>
                                    <input type="hidden" name="product_id[]" value="<?php echo $arr_cart_p_id[$i]; ?>">
                                    <input type="hidden" name="package_id[]"
                                        value="<?php echo $arr_cart_p_pkg_id[$i]; ?>">
                                    <input type="number" class="input-text qty text" step="1" min="1" max=""
                                        name="quantity[]" value="<?php echo $arr_cart_p_qty[$i]; ?>" title="Qty"
                                        size="4" pattern="[0-9]*" inputmode="numeric" required>
                                </td>
                                <td class="text-right">
                                    <?php
                                        $row_total_price = $arr_cart_pkg_price[$i] * $arr_cart_p_qty[$i];
                                        $table_total_price = $table_total_price + $row_total_price;
                                        ?>
                                    <?php echo LANG_VALUE_1; ?><?php echo $row_total_price; ?>
                                </td>
                                <td class="text-center">
                                    <a onclick="return confirmDelete();"
                                        href="cart-item-delete.php?p_id=<?php echo $arr_cart_p_id[$i]; ?>&pkg_id=<?php echo $arr_cart_p_pkg_id[$i]; ?>"
                                        class="trash"><i class="fa fa-trash" style="color:red;"></i></a>
                                </td>
                            </tr>
                            <?php endfor; ?>
                            <tr>
                                <th colspan="7" class="total-text">Total</th>
                                <th class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $table_total_price; ?>
                                </th>
                                <th></th>
                            </tr>
                        </table>
                    </div>

                    <div class="cart-buttons">
                        <ul>
                            <li><input type="submit" value="<?php echo LANG_VALUE_20; ?>" class="btn btn-primary"
                                    name="form1"></li>
                            <li><a href="index.php" class="btn btn-primary"><?php echo LANG_VALUE_85; ?></a></li>
                            <li><a href="checkout.php" class="btn btn-primary"><?php echo LANG_VALUE_23; ?></a></li>
                        </ul>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>

<?php
// if ($c_err_msg != '') {
//     echo "<script>alert('".$c_err_msg."')</script>";
//     $c_err_msg='';
// }
// if ($c_success_msg != '') {
//     echo "<script>alert('".$c_success_msg."')</script>";
//     $c_success_msg='';
//     // header('location: product.php?id=' . $_REQUEST['id']);
// }
?>