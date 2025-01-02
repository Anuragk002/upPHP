<?php require_once('header.php');
if($_SESSION['user']['role']!="Super Admin") {
	header('location: index.php');
	exit;
}?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Delete from tbl_color
	$statement = $pdo->prepare("DELETE FROM tbl_color WHERE color_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: color.php');
?>