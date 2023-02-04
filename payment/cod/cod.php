<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
include("../../admin/inc/CSRF_Protect.php");
include("../../maill.php");
$csrf = new CSRF_Protect();
// header('location: ../../payment_success.php');
?>


<?php
    $c_err_msg = '';
    $c_success_msg = '';
    $order_number = time();
    $order_date = date('Y-m-d H:i:s');
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
            $cust_name='GUEST';
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
    $statement = $pdo->prepare("INSERT INTO tbl_payment (customer_id, customer_name, customer_email, payment_date,order_date, txnid, paid_amount, card_number, card_cvv, card_month, card_year, bank_transaction_info, payment_method, payment_status, tracking_id, tracking_link, tracking_date, shipping_status, payment_id, s_name, s_phone, s_email, s_address, s_city, s_state, s_country, s_zip) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $statement->execute(array($cust_id, $cust_name, $cust_email, '',$order_date,'', $table_total_price,'','','','','','COD/Pay Later','Pending',-1,'','','Pending',$order_number,$s_name,$s_phone,$s_email,$s_address,$s_city,$s_state,$s_country,$s_zip));

    // Inserting the Order Details->
    for($i=0;$i<count($arr_cart_p_name);$i++) {
    	$statement = $pdo->prepare("INSERT INTO tbl_order (product_id,product_name,pkg_name,quantity, pkg_price, payment_id) VALUES (?,?,?,?,?,?)");
		$statement->execute(array($arr_cart_p_id[$i],$arr_cart_p_name[$i],$arr_cart_pkg_name[$i],$arr_cart_p_qty[$i],$arr_cart_pkg_price[$i],$order_number));
    }

    // storing order number--->
    $_SESSION['order_number']=$order_number;

    ?>
    <div style="text-align: center; border:2px solid black; margin-top:50px">
      <h4>Your Order is Being Placed..</h4>
      <h5>Note: Wait for sometime, Don't press anything.</h5>
    </div>
    
    <?php
    // Reducing cart----->
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

    // sending mail ====>
    $statement_cn = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
    $statement_cn->execute(array($s_country));
    $result_cn = $statement_cn->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_cn as $cn) {
        $s_country_name= $cn['country_name']; 
    }
    $shipping_address='
            <u><b>Shipping Address-</b></u>
            <ul style="padding-left:20px;list-style-type:None;color:black">
            <li><b>Name: </b>'.$s_name.'</li>
            <li><b>Phone: </b>'.$s_phone.'</li>
            <li><b>Address: </b>'.$s_address.', '.$s_city.', '.$s_state.', '.$s_country_name.', '.$s_zip.'</li>
            </ul>'; 
    $status_details='
        <ul style="list-style-type:None;color:black">
        <li><b>Order ID: </b>'.$order_number.'</li>
        <li><b>Order Date: </b>'.$order_date.'</li>
        <li><b>Total Amount: </b>$'.$table_total_price.'</li>
        <li><b>Payment Status: </b>Pending</li>
        </ul>';

    $order_details='';
    $order_details .= '
        <table border=1 >
        <caption>Order Details</caption>
        <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>Package</th>
        <th>Price</th>
        <th>Quanity</th>
        <th>Total</th>
        </tr>
        ';
    $ct=0;
    for($i=0;$i<count($arr_cart_p_name);$i++) {
        $ct++;
            $order_details .= '
                <tr>
                <td>'.$ct.'</td>
                <td>'.$arr_cart_p_name[$i].'</td>
                <td>'.$arr_cart_pkg_name[$i].'</td>
                <td>$'.$arr_cart_pkg_price[$i].'</td>
                <td>'.$arr_cart_p_qty[$i].'</td>
                <td>$'.$arr_cart_pkg_price[$i]*$arr_cart_p_qty[$i].'</td>
                </tr>
                ';
    }
    $order_details .= '
        <tr>
        <td colspan=5><b>Grand Total</b></td>
        <td><b>$'.$table_total_price.'</b></td>
        </tr>
        </table>
        ';
    $body ='<body>
        <span style="color:black">Hello '.$s_name.',</span><br/>
        <span style="color:black">Your order has been placed successfully with Order ID: '.$order_number.'. Your payment status for this order is pending. We will contact you soon to complete the payment process.<br/>'.$status_details.'
        '. $order_details .'<br/>'.$shipping_address.'</span>
        <span style="color:black"> Thanks for shopping with us. If you are facing any issue, Please contact us.</span><br/><br/>
        <span style="color:black">
        <b>Thanks and Regards</b><br/>
        Unit Pharma Support Team<br/>
        Website: <a href="https://www.unitpharma.com" style="color:blue">https://www.unitpharma.com</a><br/>
        </span>
        </body>
        ';
    $mail->addAddress("pankaj143giri@gmail.com", $s_name);//user mail customer
    $mail->Subject = 'Order confirmation - '.$order_number;//subject
    $mail->IsHTML(true);
    $mail->Body    = $body;
    $mail->send();
    // redirecting to successfull page
    header('location: ../../order_success.php');
    // echo '<script>window.location="../../payment_success.php";</script>';


?>