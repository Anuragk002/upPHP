<?php require_once('header.php'); 
include('../maill.php');
?>

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
        $s_email = $row['s_email'];
        $s_name = $row['s_name'];
		$payment_id=$row['payment_id'];
		$tracking_id=$row['tracking_id'];
		$tracking_link=$row['tracking_link'];

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
			$contact_email = $row['contact_email'];
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

	$body ='<body>
			<span style="color:black">Hello '.$s_name.',</span>
			<span style="color:black">Your order deliverded successfully. If you have not received yet, Please contact us asap.
			<ul style="padding-left:20px;list-style-type:None;color:black">
			<li><b>Order ID: </b>'.$payment_id.'</li>
			<li><b>Tracking ID: </b>'.$tracking_id.'</li>
			<li><b>Tracking Link: </b><a style="color:blue; font-weight:bold" href="'.$row['tracking_link'].'">click to track</a></li>
			<li><b>Delivery Status: </b>Completed</li>
			<li><b>Delivery Date: </b>'.$shipping_date.'</li>
			</ul>
			</span>
			<span style="color:black">
			Thanks for shopping with us. If you are facing any issue, Please contact us at '.$contact_email.'.</span><br/><br/>
			<span style="color:black">
			<b>Thanks and Regards</b><br/>
			Unit Pharma Support Team<br/>
			Website: <a href="https://www.unitpharma.com">https://www.unitpharma.com</a><br>
			</span>
			</body>
			';

	$mail->addAddress($s_email, $s_name);//user mail customer
    $mail->Subject = 'Order deliverded successfully - '.$payment_id;//subject
    $mail->Body    = $body;
	$mail->IsHTML(true);
    if ($mail->send()){
		echo "<script type='text/javascript'>
		location='order.php';
		alert('Delivery status Change successfully.');
		</script>";
	}else{
		echo "<script type='text/javascript'>
		location='order.php';
		alert('Something went wrong!');
		</script>";
	}
	// header('location: order.php');
?>