<?php require_once('header.php');
include('../maill.php');
?>
<?php
if( !isset($_REQUEST['id']) ) {
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
		$order_date=$row['order_date'];
		$total_amount=$row['paid_amount'];
	}
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	$payment_date=date('Y-m-d H:i:s');
	$statement = $pdo->prepare("UPDATE tbl_payment SET payment_date=?,payment_status=? WHERE id=?");
	$statement->execute(array($payment_date,'Completed',$_REQUEST['id']));

	// Getting Admin Email Address
	// $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	// $statement->execute();
	// $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
	// foreach ($result as $row) {
	// 	$admin_email = $row['contact_email'];
	// }

	// $message_text='Payment status for your order successfully updated. We are initiating the shipping process, you will receive tracking id through email for your order soon.<br><br>
	// <ul>
	// 	<li>
	// </ul>
	// <br><b>Order ID:</b> '.$payment_id.'<br>
	// <b>Payment Status :</b> Completed <br>
	// <b>Payment Date :</b> '.$payment_date.'<br>';
	// $body = '
    //             <html><body>
    //             <p>Hello '.$c_name.',<br></p>
    //             '.$message_text.'<br><br>
	// 			Thanks! for shopping with us. If you have any queries, Please contact to us.<br><br>
    //             <b>Thanks and Regards</b><br>
    //             <p>Unit Pharma Support Team</p><br>
    //             <p>Website:<a href="https://www.unitpharma.com">https://www.unitpharma.com</a><p>
    //             </body></html>
    //             ';

	// $headers = 'From: ' . $admin_email . "\r\n" .
	// 			'Reply-To: ' . $admin_email . "\r\n" .
	// 			'X-Mailer: PHP/' . phpversion() . "\r\n" . 
	// 			"MIME-Version: 1.0\r\n" . 
	// 			"Content-Type: text/html; charset=ISO-8859-1\r\n";

	// Sending email to admin--->                
	// mail($to_customer, $subject_text, $message, $headers);

	$body ='<body>
	<span style="color:black">Hello '.$s_name.',</span><br/>
	<span style="color:black">Payment status for your Order ID - '.$payment_id.'  successfully updated. We are initiating the shipping process, you will receive tracking ID through Email for your order soon.
			<ul style="padding-left:20px;list-style-type:None;color:black">
			<li><b>Order ID: </b>'.$payment_id.'</li>
			<li><b>Order date: </b>'.$order_date.'</li>
			<li><b>Total Amount: $</b>'.$total_amount.'</li>
			<li><b>Payment Status: </b>Completed</li>
			<li><b>Payment Date: </b>'.$payment_date.'</li>
			</ul>
			</span>
			<span style="color:black">
			Thanks for shopping with us. If you are facing any issue, Please contact us.</span><br/><br/>
			<span style="color:black">
			<b>Thanks and Regards</b><br/>
			Unit Pharma Support Team<br/>
			Website: <a href="https://www.unitpharma.com">https://www.unitpharma.com</a><br>
			</span>
			</body>
			';

	$mail->addAddress($s_email, $s_name);//user mail customer
    $mail->Subject = 'Payment updated successfully - '.$payment_id;//subject
    $mail->Body    = $body;
	$mail->IsHTML(true);
    $mail->send();

	header('location: order.php');
?>