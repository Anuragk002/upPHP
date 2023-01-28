<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['p_id']) || !isset($_REQUEST['pkg_id'])) {
    header('location: cart.php');
    exit;
}

// Checking is the user is registered or not-->
if(!isset($_SESSION['customer'])) {
    $arr_p_id=array();
    $arr_p_pkg_id=array();
    $arr_p_qty=array();
    if ($_SESSION['cart_p_id']){
        $i=0;
        foreach($_SESSION['cart_p_id'] as $key => $value) 
        {
            $arr_p_id[$i]= $value;
            $i++;
        }
                    
        $i=0;
        foreach($_SESSION['cart_p_pkg_id'] as $key => $value) 
        {
            $arr_p_pkg_id[$i] = $value;
            $i++;
        }
                        
        $i=0;
        foreach($_SESSION['cart_p_qty'] as $key => $value) 
        {
            $arr_p_qty[$i] = $value;
            $i++;
        }

        unset($_SESSION['cart_p_id']);
        unset($_SESSION['cart_p_pkg_id']);
        unset($_SESSION['cart_p_qty']);
        // checking----->
        $k=0;
        $i=0;
        for($i=0;$i<count($arr_p_id);$i++) {
            if( ($arr_p_id[$i] == $_REQUEST['p_id']) && ($arr_p_pkg_id[$i] == $_REQUEST['pkg_id'])) {
                
                continue;
                
            } else {
                $_SESSION['cart_p_id'][$k]=strip_tags($arr_p_id[$i]);
                $_SESSION['cart_p_pkg_id'][$k]=strip_tags($arr_p_pkg_id[$i]);
                $_SESSION['cart_p_qty'][$k]=strip_tags($arr_p_qty[$i]);
                $k++;
            }
        }
    }
}else{
    $statement = $pdo->prepare("DELETE FROM `tbl_cart` WHERE `cust_id`=? AND `product_id`=? AND `package_id`=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],$_REQUEST['p_id'],$_REQUEST['pkg_id']));                 
}
echo '<script>window.location="cart.php";</script>';
?>