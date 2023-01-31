<?php require_once('header.php'); ?>

<?php
if( !isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    foreach ($result as $row) {
        $to_customer = $row['s_email'];
        $c_name = $row['s_name'];
		$payment_id=$row['payment_id'];
		$tracking_id=$row['tracking_id'];
	}
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	$shipping_date=date('Y-m-d H:i:s');
	$statement = $pdo->prepare("UPDATE tbl_payment SET shipping_date=?,shipping_status=? WHERE id=?");
	$statement->execute(array($shipping_date,'Completed',$_REQUEST['id']));

	// Getting Admin Email Address
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
	foreach ($result as $row) {
		$admin_email = $row['contact_email'];
	}

	// $message_text='Your order deliverded successfully. If you have not received yet, Please contact us asap.<br>
	// <br><b>Order ID:</b> '.$payment_id.'<br>
	// <b>Tracking ID :</b> '.$tracking_id.'<br>
	// <b>Shipping Status :</b>  Completed <br>
	// <b>Deliverdrd On :</b> '.$shipping_date.'<br>';
	// $message = '
    //             <html><body>
    //             <p>Hi '.$c_name.',<br></p>
    //             '.$message_text.'<br>
	// 			Thanks! for shopping with us. If you have any queries, Please contact to us.<br><br>
    //             <b>Thanks and Regards<b><br>
    //             <p>Unit Pharma Support Team</p><br>
    //             <p>Website:<a href="https://www.unitpharma.com">https://www.unitpharma.com</a><p>
    //             </body></html>
    //             ';
	// $headers = 'From: ' . $admin_email . "\r\n" .
	// 			'Reply-To: ' . $admin_email . "\r\n" .
	// 			'X-Mailer: PHP/' . phpversion() . "\r\n" . 
	// 			"MIME-Version: 1.0\r\n" . 
	// 			"Content-Type: text/html; charset=ISO-8859-1\r\n";

	// Sending email to admin  ====>                
	// mail($to_customer, $subject_text, $message, $headers);

	header('location: order.php');
?>