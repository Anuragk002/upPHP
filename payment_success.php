<?php require_once('header.php'); ?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <p>
                    <!-- <h3 style="margin-top:20px;"><?php #echo LANG_VALUE_121; ?></h3> -->
                    <?php 
                        if($_SESSION['order_number']){
                            ?>
                            <h3 style="margin-top:20px;">Congratulations...</h3>
                            <p>Your order placed successfully with the Order Number : <?php echo $_SESSION['order_number'] ?>. You will also get order confirmation on your email.</p><br/><br/>

                    <?php
                            unset($_SESSION['order_number']);
                        }else{
                    ?>
                            <h3 style="margin-top:20px;">Something went wrong...</h3>
                            <p>If your order is placed, You will get order confirmation on your email.</p><br/><br/>
                    
                    <?php
                        }
                        if(isset($_SESSION['customer'])) {
                            // if($_SESSION['customer']['cust_guest']===1) {
                            // 	?>
                                
                            // 	<?php
                            //     header("refresh:3;url= ".BASE_URL."logout.php");
                            // }
                            echo '<a href="dashboard.php" class="btn btn-success"><?php echo LANG_VALUE_91; ?></a>';
                            }
                        else{
                                
                            echo '<a href="index.php" class="btn btn-success"><?php echo "Go to Home";#LANG_VALUE_91; ?></a>';
                            
                        }                        
					?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>