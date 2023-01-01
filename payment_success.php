<?php require_once('header.php'); ?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <p>
                    <!-- <h3 style="margin-top:20px;"><?php echo LANG_VALUE_121; ?></h3> -->
                    <h3 style="margin-top:20px;">Order Placed Successfully...</h3>
                    <?php
					if(isset($_SESSION['customer'])) {
						if($_SESSION['customer']['cust_guest']===1) {
							?>
							<p>You will get order confirmation on your email.</p>
							<?php
                            header("refresh:3;url= ".BASE_URL."logout.php");
						}
                        else{
                            ?>
                            <a href="dashboard.php" class="btn btn-success"><?php echo LANG_VALUE_91; ?></a>
                        <?php
                        }
					}
					?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>