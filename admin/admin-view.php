<?php require_once('header.php'); 
if($_SESSION['user']['role']!="Super Admin") {
	header('location: index.php');
	exit;
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Admins</h1>
	</div>
    <div class="content-header-right">
		<a href="admin-add.php" class="btn btn-primary btn-sm">Add Admin</a>
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
								<th width="10">#</th>
								<th width="180">Name</th>
								<th width="150">Email Address</th>
								<th>Status</th>
								<th width="100">Change Status</th>
								<?php if($_SESSION['user']['role']=='Super Admin') {?><th width="100">Action</th> <?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM `tbl_user` WHERE `role`='Admin'");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								?>
								<tr class="<?php if($row['status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>">
									<td><?php echo $i; ?></td>
									<td><?php echo $row['full_name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php if($row['status']==1) {echo 'Active';} else {echo 'Inactive';} ?></td>
									<td>
										<a href="admin-change-status.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Change Status</a>
									</td>
									<?php if($_SESSION['user']['role']=='Super Admin') {?>
									<td>
										<a href="#" class="btn btn-danger btn-xs" data-href="admin-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
		</div>
	</div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>