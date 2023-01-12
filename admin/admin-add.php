<?php require_once('header.php'); ?>

<?php
if($_SESSION['user']['role']!="Super Admin") {
	header('location: index.php');
	exit;
}
if(isset($_POST['addAdmin'])) {
	$valid = 1;

    if(empty($_POST['name'])) {
        $valid = 0;
        $error_message .= "Name can not be empty<br>";
        
    }
    else if(empty($_POST['email'])) {
        $valid = 0;
        $error_message .= "Email can not be empty<br>";
    }
    else if(empty($_POST['password'])) {
        $valid = 0;
        $error_message .= "Password can not be empty<br>";
    }
    else if(empty($_POST['confirmPassword'])) {
        $valid = 0;
        $error_message .= "Confirm Password can not be empty<br>";
    }
    else {
            // Checking the password and re_password are same or not
        if($_POST['password'] != $_POST['confirmPassword']){
            $valid = 0;
            $error_message .= "Possword and Confirm Password should be same<br>";
        }
        else{
    	    // Duplicate Category checking
            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=?");
            $statement->execute(array($_POST['email']));
            $total = $statement->rowCount();
            if($total){
                $valid = 0;
                $error_message .= "Email already exist<br>";
            }
        }
    }

    if($valid == 1) {
		// Saving data into the main table tbl_color
		$statement = $pdo->prepare("INSERT INTO tbl_user (`full_name`, `email`,`password`,`role`,`status`) VALUES (?,?,?,?,?)");
		$statement->execute(array($_POST['name'],$_POST['email'],md5($_POST['password']),'Admin',1));
    	$success_message = 'Admin added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Admin</h1>
	</div>
	<div class="content-header-right">
		<a href="admin-view.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Name </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="name" required>
										</div>
									</div>
                                    <div class="form-group">
										<label for="" class="col-sm-2 control-label">Email </label>
										<div class="col-sm-4">
											<input type="email" class="form-control" name="email" required>
										</div>
									</div>
                                    <div class="form-group">
										<label for="" class="col-sm-2 control-label">Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password" required>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Confirm Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="confirmPassword" required>
										</div>
									</div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="addAdmin">Add Admin</button>
										</div>
									</div>
								</div>
							</div>
							</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>