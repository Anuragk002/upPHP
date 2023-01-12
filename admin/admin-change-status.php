<?php require_once('header.php'); ?>

<?php

if($_SESSION['user']['role']!="Super Admin") {
	header('location: index.php');
	exit;
}
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$cust_status = $row['status'];
		}
	}
}
?>

<?php
if($cust_status == 0) {$final = 1;} else {$final = 0;}
$statement = $pdo->prepare("UPDATE tbl_user SET `status`=? WHERE id=?");
$statement->execute(array($final,$_REQUEST['id']));

header('location: admin-view.php');
?>