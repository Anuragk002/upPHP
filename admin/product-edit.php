<?php require_once('header.php'); ?>

<?php
if($_SESSION['user']['role']!="Super Admin") {
	header('location: logout.php');
	exit;
}
if (isset($_POST['form1'])) {
	$valid = 1;
	$pkgvalid= 0;
	if (count($_POST['pkg'])) {
		foreach($_POST['pkg'] as $pkg1){
			if((empty($pkg1['name'])))
			{
				$valid = 0;
			$error_message .= "Input Package Name<br>";
			}
			else if((empty($pkg1['price'])))
			{
				$valid = 0;
			$error_message .= "Input Package Price<br>";
			}
			else{
			$pkgvalid= 1;
			}
		}
	}else{
		$valid=0;
		$error_message .= "Package can't be empty<br>";
	}

	if (empty($_POST['tcat_id'])) {
		$valid = 0;
		$error_message .= "You must have to select a top level category<br>";
	}

	if (empty($_POST['p_name'])) {
		$valid = 0;
		$error_message .= "Product name can not be empty<br>";
	}

	if (empty($_POST['p_qty'])) {
		$valid = 0;
		$error_message .= "Quantity can not be empty<br>";
	}

	$path = $_FILES['p_featured_photo']['name'];
	$path_tmp = $_FILES['p_featured_photo']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}


	if ($valid == 1) {

		if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

			$photo = array();
			$photo = $_FILES['photo']["name"];
			$photo = array_values(array_filter($photo));

			$photo_temp = array();
			$photo_temp = $_FILES['photo']["tmp_name"];
			$photo_temp = array_values(array_filter($photo_temp));

			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$next_id1 = $row[10];
			}
			$z = $next_id1;

			$m = 0;
			for ($i = 0; $i < count($photo); $i++) {
				$my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
				if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
					$final_name1[$m] = $z . '.' . $my_ext1;
					move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $final_name1[$m]);
					$m++;
					$z++;
				}
			}

			if (isset($final_name1)) {
				for ($i = 0; $i < count($final_name1); $i++) {
					$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
					$statement->execute(array($final_name1[$i], $_REQUEST['id']));
				}
			}
		}

		if ($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
        							-- p_old_price=?, 
        							-- p_current_price=?, 
        							p_qty=?,
        							p_description=?,
        							p_short_description=?,
        							p_feature=?,
        							p_condition=?,
        							p_return_policy=?,
        							p_is_featured=?,
        							p_is_active=?,
        							tcat_id=?

        							WHERE p_id=?");
			$statement->execute(array(
				$_POST['p_name'],
				// $_POST['p_old_price'],
				// $_POST['p_current_price'],
				$_POST['p_qty'],
				$_POST['p_description'],
				$_POST['p_short_description'],
				$_POST['p_feature'],
				$_POST['p_condition'],
				$_POST['p_return_policy'],
				$_POST['p_is_featured'],
				$_POST['p_is_active'],
				$_POST['tcat_id'],
				$_REQUEST['id']
			));
		} else {

			unlink('../assets/uploads/' . $_POST['current_photo']);

			$final_name = 'product-featured-' . $_REQUEST['id'] . '.' . $ext;
			move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);


			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
        							-- p_old_price=?, 
        							-- p_current_price=?, 
        							p_qty=?,
        							p_featured_photo=?,
        							p_description=?,
        							p_short_description=?,
        							p_feature=?,
        							p_condition=?,
        							p_return_policy=?,
        							p_is_featured=?,
        							p_is_active=?,
        							tcat_id=?

        							WHERE p_id=?");
			$statement->execute(array(
				$_POST['p_name'],
				// $_POST['p_old_price'],
				// $_POST['p_current_price'],
				$_POST['p_qty'],
				$final_name,
				$_POST['p_description'],
				$_POST['p_short_description'],
				$_POST['p_feature'],
				$_POST['p_condition'],
				$_POST['p_return_policy'],
				$_POST['p_is_featured'],
				$_POST['p_is_active'],
				$_POST['tcat_id'],
				$_REQUEST['id']
			));
		}


		// if (isset($_POST['size'])) {

		// 	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
		// 	$statement->execute(array($_REQUEST['id']));

		// 	foreach ($_POST['size'] as $value) {
		// 		$statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
		// 		$statement->execute(array($value, $_REQUEST['id']));
		// 	}
		// } else {
		// 	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
		// 	$statement->execute(array($_REQUEST['id']));
		// }

		// if (isset($_POST['color'])) {

		// 	$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
		// 	$statement->execute(array($_REQUEST['id']));

		// 	foreach ($_POST['color'] as $value) {
		// 		$statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
		// 		$statement->execute(array($value, $_REQUEST['id']));
		// 	}
		// } else {
		// 	$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
		// 	$statement->execute(array($_REQUEST['id']));
		// }

		if($pkgvalid == 1) {
			$statement = $pdo->prepare("DELETE FROM tbl_product_package WHERE p_id=?");
			$statement->execute(array($_REQUEST['id']));

			foreach($_POST['pkg'] as $pkg) {
				// print_r($pkg);
				$statement = $pdo->prepare("INSERT INTO tbl_product_package (p_id,pkg_name,pkg_price) VALUES (?,?,?)");
				$statement->execute(array($_REQUEST['id'],$pkg['name'],$pkg['price']));
			}
		}
		$success_message = 'Product is updated successfully.';
	}
}
?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$total = $statement->rowCount();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($total == 0) {
			header('location: logout.php');
			exit;
		}
	}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Product</h1>
	</div>
	<div class="content-header-right">
		<a href="product.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$p_name = $row['p_name'];
		$p_old_price = $row['p_old_price'];
		$p_current_price = $row['p_current_price'];
		$p_qty = $row['p_qty'];
		$p_featured_photo = $row['p_featured_photo'];
		$p_description = $row['p_description'];
		$p_short_description = $row['p_short_description'];
		$p_feature = $row['p_feature'];
		$p_condition = $row['p_condition'];
		$p_return_policy = $row['p_return_policy'];
		$p_is_featured = $row['p_is_featured'];
		$p_is_active = $row['p_is_active'];
		$tcat_id = $row['tcat_id'];
	}

	$statement = $pdo->prepare("SELECT * 
							FROM tbl_top_category t1
							WHERE t1.tcat_id=?");
	$statement->execute(array($tcat_id));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$tcat_name = $row['tcat_name'];
	}

	$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$size_id[] = $row['size_id'];
	}

	$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$color_id[] = $row['color_id'];
	}
?>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message) : ?>
				<div class="callout callout-danger">

					<p>
						<?php echo $error_message; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Top Level Category Name <span>*</span></label>
							<div class="col-sm-4">
								<select name="tcat_id" class="form-control select2 top-cat">
									<option value="">Select Top Level Category</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['tcat_id']; ?>" <?php if ($row['tcat_id'] == $tcat_id) {
																							echo 'selected';
																						} ?>><?php echo $row['tcat_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Add Packages</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<table id="ProductPkgTable" style="width:100%;">
									<tbody>
										<?php
											$statement = $pdo->prepare("SELECT * FROM tbl_product_package WHERE p_id=?");
											$statement->execute(array($_REQUEST['id']));
											$result = $statement->fetchAll(PDO::FETCH_ASSOC);
											foreach ($result as $key=>$row) { ?>
												<tr>
													<td>
														<div class="col-sm-4">
															<input type="text" placeholder="Package name" value="<?php echo $row['pkg_name'] ?>" required class="form-control" name="pkg[<?php echo $key?>][name]" style="margin-bottom:5px; width:200px">
														</div>
													</td>
													<td>
														<div class="col-sm-4">
															<input type="text" placeholder="price" value="<?php echo $row['pkg_price'] ?>" required class="form-control" name="pkg[<?php echo $key?>][price]" style="margin-bottom:5px; width:50px;">
														</div>
													</td>
													<td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
												</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<div class="col-sm-2">
								<input type="button" id="btnAddNewPkg" value="Add Package" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<img src="../assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
								<input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Change Featured Photo </label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="p_featured_photo">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Other Photos</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<table id="ProductTable" style="width:100%;">
									<tbody>
										<?php
										$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
										$statement->execute(array($_REQUEST['id']));
										$result = $statement->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result as $row) {
										?>
											<tr>
												<td>
													<img src="../assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin-bottom:5px;">
												</td>
												<td style="width:28px;">
													<a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
												</td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
							<div class="col-sm-2">
								<input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Short Description</label>
							<div class="col-sm-8">
								<textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_short_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Features</label>
							<div class="col-sm-8">
								<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Conditions</label>
							<div class="col-sm-8">
								<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"><?php echo $p_condition; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Return Policy</label>
							<div class="col-sm-8">
								<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"><?php echo $p_return_policy; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Featured?</label>
							<div class="col-sm-8">
								<select name="p_is_featured" class="form-control" style="width:auto;">
									<option value="0" <?php if ($p_is_featured == '0') {
															echo 'selected';
														} ?>>No</option>
									<option value="1" <?php if ($p_is_featured == '1') {
															echo 'selected';
														} ?>>Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-8">
								<select name="p_is_active" class="form-control" style="width:auto;">
									<option value="0" <?php if ($p_is_active == '0') {
															echo 'selected';
														} ?>>No</option>
									<option value="1" <?php if ($p_is_active == '1') {
															echo 'selected';
														} ?>>Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>