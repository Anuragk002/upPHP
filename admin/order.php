<?php require_once('header.php');
include('../maill.php');
?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['payment_id'])) {
        $valid = 0;
        $error_message .= 'Sorry! Something went wrong, Please reload the page and try again.\n';
    }
    if($valid == 1) {
        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        // $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        // $statement->execute(array($_POST['cust_id']));
        // $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        // foreach ($result as $row) {
        //     $cust_email = $row['cust_email'];
        // }
        // Getting Admin Email Address
        // $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        // $statement->execute();
        // $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        // foreach ($result as $row) {
        //     $admin_email = $row['contact_email'];
        // }
        
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $payment_id=$row['payment_id'];
            $total_amount=$row['paid_amount'];
            $order_date=$row['order_date'];
            $payment_method=$row['payment_method'];
            $payment_status=$row['payment_status'];
            $payment_date=$row['payment_date'];
            $tracking_id=$row['tracking_id'];
            $tracking_link=$row['tracking_link'];
            $shipping_status=$row['shipping_status'];
        	$s_email = $row['s_email'];
            $s_name=$row['s_name'];
            $s_phone=$row['s_phone'];
            $s_address=$row['s_address'];
            $s_city=$row['s_city'];
            $s_state=$row['s_state'];
            $s_zip=$row['s_zip'];

            $statement7 = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
            $statement7->execute(array($row['s_country']));
            $result7 = $statement7->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result7 as $cn7) {
                $s_country= $cn7['country_name']; 
            }

            

        	// if($row['payment_method'] == 'PayPal'):
        	// 	$payment_details = '
            //                     Transaction Id: '.$row['txnid'].'<br>
            //                                     ';
        	// elseif($row['payment_method'] == 'Stripe'):
			// 	$payment_details = '
            //                     Transaction Id: '.$row['txnid'].'<br>
            //                     Card number: '.$row['card_number'].'<br>
            //                     Card CVV: '.$row['card_cvv'].'<br>
            //                     Card Month: '.$row['card_month'].'<br>
            //                     Card Year: '.$row['card_year'].'<br>
            //                                     ';
        	// elseif($row['payment_method'] == 'Bank Deposit'):
			// 	$payment_details = '
            //                     Transaction Details: <br>'.$row['bank_transaction_info'];

            // elseif($row['payment_method'] == 'COD/Pay Later'):
            //     $payment_details = '
            //                     Payment Method: '.$row['payment_method'].'<br>
            //                     Paid Amount: '.$row['paid_amount'].'<br>';
        	// endif;
            
            // $status='
            //         Payment Status: '.$row['payment_status'].'<br>
            //         Shipping Status: '.$row['shipping_status'].'<br>
            //         ';
            // $statement7 = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
            // $statement7->execute(array($row['s_country']));
            // $result7 = $statement7->fetchAll(PDO::FETCH_ASSOC);
            // foreach ($result7 as $cn7) {
            // $cnt= $cn7['country_name']; }
        }

        $shipping_address='
            <u><b>Shipping Address-</b></u>
            <ul style="padding-left:20px;list-style-type:None;color:black">
            <li><b>Name: </b>'.$s_name.'</li>
            <li><b>Phone: </b>'.$s_phone.'</li>
            <li><b>Address: </b>'.$s_address.', '.$s_city.', '.$s_state.', '.$s_country.', '.$s_zip.'</li>
            </ul>';

        $status_details='<ul style="list-style-type:None;color:black">'; 
        $status_details.='
			<li><b>Order ID: </b>'.$payment_id.'</li>
            <li><b>Order Date: </b>'.$order_date.'</li>
            <li><b>Total Amount: </b>$'.$total_amount.'</li>
            <li><b>Payment Status: </b>'.$payment_status.'</li>';
            if(($payment_status=='Completed') && ($tracking_id==-1)){
                $status_details.='
                <li><i>Note*- Order not processed yet, will be processed soon.</i></li>
                ';
            }
        if(($payment_status=='Completed') && ($tracking_id!=-1)){
            $status_details.='
            <li><b>Tracking ID: </b>'.$tracking_id.'</li>
            <li><b><a href="'.$tracking_link.'">CLICK HERE! TO TRACK YOUR ORDER</a></b></li>
            ';
        }
        $status_details.='</ul>'; 
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
        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_details .= '
                <tr>
                <td>'.$i.'</td>
                <td>'.$row['product_name'].'</td>
                <td>'.$row['pkg_name'].'</td>
                <td>$'.$row['pkg_price'].'</td>
                <td>'.$row['quantity'].'</td>
                <td>$'.$row['pkg_price']*$row['quantity'].'</td>
                </tr>
                ';
        }
        $order_details .= '
            <tr>
            <td colspan=5><b>Grand Total</b></td>
            <td><b>$'.$total_amount.'</b></td>
            </tr>
            </table>
            ';

        // sending email
            // $to_customer = $cust_email;
            // $message = '
            //         <html><body>
            //         <p>Hi '.$c_name.',<br></p>
            //         '.$message_text.'<br>
            //         <h3>Order Details: </h3>
            //         '.$order_detail.'<br>
            //         Thanks! for shopping with us. If you have any queries, Please contact to us.<br><br>
            //         <b>Thanks and Regards<b><br>
            //         <p>Unit Pharma Support Team</p><br>
            //         <p>Website:<a href="https://www.unitpharma.com">https://www.unitpharma.com</a><p>
            //         </body></html>
            //         ';
            // $headers = 'From: ' . $admin_email . "\r\n" .
            //            'Reply-To: ' . $admin_email . "\r\n" .
            //            'X-Mailer: PHP/' . phpversion() . "\r\n" . 
            //            "MIME-Version: 1.0\r\n" . 
            //            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // // Sending email to admin                  
        // mail($to_customer, $subject_text, $message, $headers);

        $body ='<body>
			<span style="color:black">Hello '.$s_name.',</span><br/>
			<span style="color:black">'.$message_text.'<br/><br/><b><u>Order Details:</u></b><br/>'.$status_details.'
			'. $order_details .'<br/>'.$shipping_address.'</span>
			<span style="color:black"> Thanks for shopping with us. If you are facing any issue, Please contact us.</span><br/><br/>
			<span style="color:black">
            <b>Thanks and Regards</b><br/>
			Unit Pharma Support Team<br/>
			Website: <a href="https://www.unitpharma.com" style="color:blue">https://www.unitpharma.com</a><br/>
            </span>
			</body>
			';
        $mail->addAddress($s_email, $s_name);//user mail customer
        $mail->Subject = $subject_text;//subject
        $mail->IsHTML(true);
        $mail->Body    = $body;
        if ($mail->send()){
            $statement = $pdo->prepare("INSERT INTO tbl_customer_message (`to_email`,`subject`,`message`,`payment_id`,`status_details`,`order_details`,`shipping_address`) VALUES (?,?,?,?,?,?,?)");
            $statement->execute(array($s_email,$subject_text,$message_text,$_POST['payment_id'],$status_details,$order_details,$shipping_address));
            $success_message = 'Email sent to recipent successfully.';
        }else{
            $error_message="Something went wrong!";
        }
        unset($_POST['payment_id']);
        unset($_POST['subject_text']);
        unset($_POST['message_text']);
    }

}

if(isset($_POST['form2'])){
    $valid = 1;
    if(empty($_POST['tracking_id'])) {
        $valid = 0;
        $error_message .= 'Tracking ID can not be empty\n';
    }
    if(empty($_POST['tracking_link'])) {
        $valid = 0;
        $error_message .= 'Tracking Link can not be empty\n';
    }
    if(empty($_POST['payment_id'])) {
        $valid = 0;
        $error_message .= 'Sorry! Something went wrong, Please reload the page and try again.\n';
    }
    
    if($valid == 1) {

        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {

            $s_name=$row['s_name'];
            $s_email=$row['s_email'];
            $payment_id=$row['payment_id'];
            $order_date=$row['order_date'];
            $payment_status=$row['payment_status'];
        }
        if( $total == 0 ) {
            header('location: logout.php');
            exit;
        }

        $tracking_id = strip_tags($_POST['tracking_id']);
        $tracking_link = strip_tags($_POST['tracking_link']);
        $tracking_date=date('Y-m-d H:i:s');

        $statement = $pdo->prepare("UPDATE tbl_payment SET tracking_id=?, tracking_date=?, tracking_link=? WHERE payment_id=?");
        $statement->execute(array($tracking_id,$tracking_date,$tracking_link,$_POST['payment_id']));

        // Getting Admin Email Address
            // $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            // $statement->execute();
            // $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            // foreach ($result as $row) {
            //     $admin_email = $row['contact_email'];
            // }

            // $message_text='Tracking ID for your order successfully generated. Visit to tracking link to track your order using tracking id.<br>
            // <br><b>Order ID:</b> '.$payment_id.'<br>
            // <b>Tracking ID:</b> '.$tracking_id.'<br>
            // <b>Tracking Link:</b> '.$tracking_link.'<br>
            // ';
            // $message = '
            //             <html><body>
            //             <p>Hi '.$c_name.',<br></p>
            //             '.$message_text.'<br>
            //             Thanks! for shopping with us. If you have any queries, Please contact to us.<br><br>
            //             <b>Thanks and Regards<b><br>
            //             <p>Unit Pharma Support Team</p><br>
            //             <p>Website:<a href="https://www.unitpharma.com">https://www.unitpharma.com</a><p>
            //             </body></html>
            //             ';
            // $headers = 'From: ' . $admin_email . "\r\n" .
            //            'Reply-To: ' . $admin_email . "\r\n" .
            //            'X-Mailer: PHP/' . phpversion() . "\r\n" . 
            //            "MIME-Version: 1.0\r\n" . 
            //            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to admin                  
        // mail($to_customer, $subject_text, $message, $headers);

        $body ='<body>
            <span style="color:black">Hello '.$s_name.',</span><br/>
            <span style="color:black">Your order has been processed successfully. You can track your order by using tracking ID.
			<ul style="padding-left:20px;list-style-type:None;color:black">
			<li><b>Order ID: </b>'.$payment_id.'</li>
			<li><b>Order Date: </b>'.$order_date.'</li>
            <li><b>Payment Status: </b>'.$payment_status.'</li>
			<li><b>Tracking ID: </b>'.$tracking_id.'</li>
			<li><b><a href="'.$tracking_link.'">CLICK HERE! TO TRACK YOUR ORDER</a></b></li>
			</ul>
            </span>
            <span style="color:black">
			Thanks for shopping with us. If you are facing any issue, Please contact us.</span><br/><br/>
			<span style="color:black">
            <b>Thanks and Regards</b><br/>
			Unit Pharma Support Team<br/>
			Website: <a href="https://www.unitpharma.com" style="color:blue">https://www.unitpharma.com</a><br/>
            </span>
			</body>
			';

        $mail->addAddress($s_email, $s_name);//user mail customer
        $mail->Subject = 'Order processed successfully - '.$payment_id;//subject
        $mail->IsHTML(true);
        $mail->Body    = $body;
        if($mail->send()){
            $success_message = 'Tracking ID marked as completed and confirmation email has been send to customer.';
        }else{
            $error_message ="Something went wrong!";
        }
        unset($_POST['tracking_id']);
        unset($_POST['tracking_link']);
        unset($_POST['payment_id']); 
    }

}
?>
<?php
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Orders</h1>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">


            <div class="box box-info">

                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Product Details</th>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>
                                    Payment Information
                                </th>
                                <th>Paid Amount</th>
                                <th>Payment Status</th>
                                <th>Tracking ID</th>
                                <th>Shipping Address</th>
                                <th>Delivery</th>
                                <?php if($_SESSION['user']['role']=='Super Admin' ){?><th>Action</th><?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM `tbl_payment` ORDER by id DESC
                ");
            	// $statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
                            <tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
                                <!-- serial number -->
                                <td><?php echo $i; ?></td>
                                <!-- Customer Details-->
                                <td>
                                    <b>Name:</b><br> <?php echo $row['customer_name']; ?><br>
                                    <?php if($row['customer_id']!=0){ 
                                ?>
                                    <!-- <b>Id:</b> <?php #echo #$row['customer_id']; ?><br> -->
                                    <b>Primary Email:</b><br> <?php echo $row['customer_email']; ?><br>
                                    <?php }?>
                                    <b>Payment Email:</b><br> <?php echo $row['s_email']; ?><br><br>
                                    <a href="#" data-toggle="modal" data-target="#model-<?php echo $i; ?>"
                                        class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Send
                                        Message</a>
                                    <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title" style="font-weight: bold;">Send Message</h4>
                                                </div>
                                                <div class="modal-body" style="font-size: 14px">
                                                    <form action="" method="post">
                                                        <!-- <input type="hidden" name="cust_id" value="<?php #echo $row['customer_id']; ?>"> -->
                                                        <input type="hidden" name="payment_id"
                                                            value="<?php echo $row['payment_id']; ?>">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Subject</td>
                                                                <td>
                                                                    <input type="text" name="subject_text"
                                                                        class="form-control" style="width: 100%;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Message</td>
                                                                <td>
                                                                    <textarea name="message_text" class="form-control"
                                                                        cols="30" rows="10"
                                                                        style="width:100%;height: 200px;"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="submit" value="Send Message"
                                                                        name="form1"></td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- product details -->
                                <td>
                                    <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Product ID:</b> '.$row1['product_id'];
                                echo ',<b>Product:</b> '.$row1['product_name'];
                                echo '<br>(<b>Package:</b> '.$row1['pkg_name'];
                                echo '<br>(<b>Quantity:</b> '.$row1['quantity'];
                                echo ', <b>Package Price:</b> '.$row1['pkg_price'].')';
                                echo '<br><br>';
                           }
                           ?>
                                </td>
                                <!-- order id and date -->
                                <th><?php echo $row['payment_id']; ?></th>
                                <th><?php echo $row['order_date']; ?></th>
                                <!-- payment information (method and Payment completion date) -->
                                <td>
                                    <?php if($row['payment_method'] == 'PayPal'): ?>
                                    <b>Payment Method:</b>
                                    <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                    <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                    <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                    <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                                    <?php elseif($row['payment_method'] == 'Stripe'): ?>
                                    <b>Payment Method:</b>
                                    <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                    <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                    <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                    <b>Transaction Id:</b> <?php echo $row['txnid']; ?><br>
                                    <b>Card Number:</b> <?php echo $row['card_number']; ?><br>
                                    <b>Card CVV:</b> <?php echo $row['card_cvv']; ?><br>
                                    <b>Expire Month:</b> <?php echo $row['card_month']; ?><br>
                                    <b>Expire Year:</b> <?php echo $row['card_year']; ?><br>
                                    <?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                                    <b>Payment Method:</b>
                                    <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                                    <b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
                                    <b>Date:</b> <?php echo $row['payment_date']; ?><br>
                                    <b>Transaction Information:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                                    <?php elseif($row['payment_method'] == 'COD/Pay Later'): ?>
                                    <b>Payment Method:</b>
                                    <?php echo '<span style="color:red;"><b>COD/Pay Later</b></span>'; ?><br>
                                    <b>Date:</b> <?php echo $row['payment_date']; ?><br>

                                    <?php endif; ?>
                                </td>
                                <!-- total amount -->
                                <td>$<?php echo $row['paid_amount']; ?></td>
                                <!-- payment status -->
                                <td>
                                    <?php echo $row['payment_status'] .'<br>';                           
                            ?>
                                    <br>
                                    <?php
                                if($row['payment_status']=='Pending'){
                                    ?>
                                    <a href="payment-change-status.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-success btn-xs" style="width:100%;margin-bottom:4px;">Mark As
                                        Completed</a>
                                    <?php
                                }
                            ?>
                                </td>
                                <!-- Tracking ID -->
                                <td>
                                    <?php 
                                if($row['tracking_id']!=-1){
                                    echo "<b>ID:</b> ".$row['tracking_id'].'<br>';
                                    echo "<b>Link:</b> <a style='color:blue; font-weight:bold' href=".$row['tracking_link'].">click to track</a><br>";
                                    echo "<b>Date:</b> ".$row['tracking_date'];
                                }else{
                                    echo 'Pending <br><br>';
                                }
                            ?>
                                    <br>
                                    <?php
                                if($row['payment_status']=='Completed') {
                                    if($row['tracking_id']==-1){
                                        ?>
                                    <!-- <a href="tracking-change-status.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark Generated</a> -->
                                    <a href="#" data-toggle="modal" data-target="#model-tid-<?php echo $i; ?>"
                                        class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark As
                                        Generated</a>
                                    <div id="model-tid-<?php echo $i; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title" style="font-weight: bold;">Tracking ID
                                                        Confirmation</h4>
                                                </div>
                                                <div class="modal-body" style="font-size: 14px">
                                                    <form action="" method="post">
                                                        <!-- <input type="hidden" name="cust_id" value="<?php #echo $row['customer_id']; ?>"> -->
                                                        <input type="hidden" name="payment_id"
                                                            value="<?php echo $row['payment_id']; ?>">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>Tracking ID</td>
                                                                <td>
                                                                    <input type="text" name="tracking_id" required
                                                                        class="form-control" style="width: 100%;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tracking Link</td>
                                                                <td>
                                                                    <textarea name="tracking_link" class="form-control"
                                                                        cols="10" rows="5"
                                                                        style="width:100%;height: 200px;"
                                                                        required></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td><input type="submit" value="Mark As Generated"
                                                                        name="form2"></td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                }
                            ?>
                                </td>
                                <!-- Address coloumn-->
                                <td>
                                    <b>Name:</b><?php echo $row['s_name']; ?><br>
                                    <b>Phone:</b><?php echo $row['s_phone']; ?><br>
                                    <?php echo $row['s_address']; ?>, <?php echo $row['s_city']; ?>,
                                    <?php echo $row['s_state']; ?>,<br>
                                    <?php
                            $statement1 = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                            $statement1->execute(array($row['s_country']));
                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $cn) {
                            echo $cn['country_name']; }?>,<br>Zip: <?php echo $row['s_zip']; ?>
                                </td>
                                <!-- Shipping status -->
                                <td>
                                    <?php 
                            if($row['shipping_status']=='Completed'){
                                echo "<b>Status:</b> ".$row['shipping_status'].'<br>';
                                echo "<b>Date:</b> ".$row['shipping_date'];
                            }
                            else{
                                echo $row['shipping_status'].'<br>';
                            }
                            ?>
                                    <br><br>
                                    <?php
                            if(($row['payment_status']=='Completed') && ($row['tracking_id']!=-1)) {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark As
                                        Completed</a>
                                    <?php
                                }
                            }
                            ?>
                                </td>
                                <!-- actions -->
                                <?php if($_SESSION['user']['role']=='Super Admin' ){?>
                                <td>
                                    <a href="#" class="btn btn-danger btn-xs"
                                        data-href="order-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal"
                                        data-target="#confirm-delete" style="width:100%;">Delete</a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php
            	}
            	?>
                        </tbody>
                    </table>
                </div>
            </div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>