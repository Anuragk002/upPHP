<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Customers</h1>
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
                                <th width="180">Country, City, State</th>
                                <th>Status</th>
                                <th width="100">Change Status</th>
                                <?php if($_SESSION['user']['role']=='Super Admin') {?><th width="100">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							$i=0;
							$statement = $pdo->prepare("SELECT * 
														FROM tbl_customer
													");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								?>
                            <tr class="<?php if($row['cust_status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['cust_name']; ?></td>
                                <td><?php echo $row['cust_email']; ?></td>
                                <td>
                                    <!-- ,,,,,, -->
                                    <?php if($row['cust_country']){ ?>
                                    <?php
										$statement9 = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
										$statement9->execute(array($row['cust_country']));
										$result9 = $statement9->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result9 as $cn) {
										echo $cn['country_name']; }?>
                                    <!-- .... -->
                                    <?php echo $row['cust_country']; ?><br>
                                    <?php echo $row['cust_city']; ?><br>
                                    <?php echo $row['cust_state']; ?>
                                    <?php }else{
                                    echo "NA";
                                    }
									?>

                                </td>
                                <td><?php if($row['cust_status']==1) {echo 'Active';} else {echo 'Inactive';} ?></td>
                                <td>
                                    <a href="customer-change-status.php?id=<?php echo $row['cust_id']; ?>"
                                        class="btn btn-success btn-xs">Change Status</a>
                                </td>
                                <?php if($_SESSION['user']['role']=='Super Admin') {?>
                                <td>
                                    <a href="#" class="btn btn-danger btn-xs"
                                        data-href="customer-delete.php?id=<?php echo $row['cust_id']; ?>"
                                        data-toggle="modal" data-target="#confirm-delete">Delete</a>
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>