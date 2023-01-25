<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
include("../../admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
// header('location: ../../payment_success.php');
?>


<?php
    $c_err_msg = '';
    $c_success_msg = '';
    $item_number = time();
    if(!isset($_SESSION['s_address'])){
        header('location: ../../cart.php');
        exit;
    }

    $arr_cart_p_id[]=array();
    $arr_cart_p_name[]=array();
    $arr_cart_p_qty[]=array();
    $arr_cart_p_pkg_id[]=array();
    $arr_cart_pkg_name[]=array();
    $arr_cart_pkg_price[]=array();
    $table_total_price = 0;
    $cust_id=0;
    $cust_name='';
    $cust_email='';
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
        }else{
            header('location: ../../cart.php');
            exit; 
        }
        $cust_id=$_SESSION['customer']['cust_id'];
        $cust_name=$_SESSION['customer']['cust_name'];
        $cust_email=$_SESSION['customer']['cust_email'];
    }else{
        if(!isset($_SESSION['cart_p_id'])) {
            header('location: ../../cart.php');
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
            $cust_id=0;
            $cust_name=$_SESSION['s_address']['name'];
            $cust_email=$_SESSION['s_address']['email'];
        }
    }

    // fetching shiping address--->
    $s_name=$_SESSION['s_address']['name'];
    $s_email=$_SESSION['s_address']['email'];
    $s_phone=$_SESSION['s_address']['phone'];
    $s_address=$_SESSION['s_address']['address'];
    $s_city=$_SESSION['s_address']['city'];
    $s_state=$_SESSION['s_address']['state'];
    $s_country=$_SESSION['s_address']['country'];
    $s_zip=$_SESSION['s_address']['zip'];

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
    
    // Feching the package name and price->
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
    // Inserting payment details->
    $statement = $pdo->prepare("INSERT INTO tbl_payment (customer_id, customer_name, customer_email, payment_date, txnid, paid_amount, card_number, card_cvv, card_month, card_year, bank_transaction_info, payment_method, payment_status, shipping_status, payment_id, s_name, s_phone, s_email, s_address, s_city, s_state, s_country, s_zip) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $statement->execute(array($cust_id, $cust_name, $cust_email, '','', $table_total_price,'','','','','','COD/Pay Later','Pending','Pending',$item_number,$s_name,$s_phone,$s_email,$s_address,$s_city,$s_state,$s_country,$s_zip));

    // Inserting the Order Details->
    for($i=0;$i<count($arr_cart_p_name);$i++) {
    	$statement = $pdo->prepare("INSERT INTO tbl_order (product_id,product_name,pkg_name,quantity, pkg_price, payment_id) VALUES (?,?,?,?,?,?)");
		$statement->execute(array($arr_cart_p_id[$i],$arr_cart_p_name[$i],$arr_cart_pkg_name[$i],$arr_cart_p_qty[$i],$arr_cart_pkg_price[$i],$item_number));
    }
    // Reducing cart----->

    ?>
    <div>
        <?php 
        echo "Address:->";
        echo "". $cust_id .",". $cust_name.",".$cust_email.",".$item_number.",".$s_name.",".$s_phone.",".$s_email.",".$s_address.",".$s_city.",".$s_state.",".$s_country.",".$s_zip;
        echo "<br/>";
        echo "items:->";
        for($i=0;$i<count($arr_cart_p_qty);$i++){
            echo "qt: ".$arr_cart_p_qty[$i] ."id: ".$arr_cart_p_id[$i] ."qt: ".$arr_cart_p_name[$i]."pkg: ".$arr_cart_pkg_name[$i] ."price:".$arr_cart_pkg_price[$i];
        }

?>
    </div>
    
    <?php
    if(isset($_SESSION['customer'])){
        $statement = $pdo->prepare("DELETE FROM `tbl_cart` WHERE cust_id=?");
        $statement->execute(array($_SESSION['customer']['cust_id']));
        
    }else{
        if(isset($_SESSION['cart_p_id'])) {
            unset($_SESSION['cart_p_id']);
            unset($_SESSION['cart_p_pkg_id']);
            unset($_SESSION['cart_p_qty']);
        }
    }
    // redirecting to successfull page
    // header('location: ../../payment_success.php');
    // echo '<script>window.location="../../payment_success.php";</script>';


?>