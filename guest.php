<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;
    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();   
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $cust_status = $row['cust_status'];
            }

            if($total) {
                $valid = 0;
                $_SESSION['customer'] = $row;
                header("location: ".BASE_URL."cart.php");
                // $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                        cust_name,
                        cust_cname,
                        cust_email,
                        cust_phone,
                        cust_country,
                        cust_address,
                        cust_city,
                        cust_state,
                        cust_zip,
                        cust_b_name,
                        cust_b_cname,
                        cust_b_phone,
                        cust_b_country,
                        cust_b_address,
                        cust_b_city,
                        cust_b_state,
                        cust_b_zip,
                        cust_s_name,
                        cust_s_cname,
                        cust_s_phone,
                        cust_s_country,
                        cust_s_address,
                        cust_s_city,
                        cust_s_state,
                        cust_s_zip,
                        cust_password,
                        cust_token,
                        cust_datetime,
                        cust_timestamp,
                        cust_status,
                        cust_guest
                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $statement->execute(array(
                        '',
                        '',
                        strip_tags($_POST['cust_email']),
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        md5('guest_pass'),
                        $token,
                        $cust_datetime,
                        $cust_timestamp,
                        1,
                        1
                    ));

            //login after guest register
            $last_id = $pdo->lastInsertId();
            $gett = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
            $gett->execute(array($last_id));
            $total = $gett->rowCount();   
            $result = $gett->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $cust_status = $row['cust_status'];
            }

            if($total) {
                $valid = 0;
                $_SESSION['customer'] = $row;
                header("location: ".BASE_URL."cart.php");
                // $error_message .= LANG_VALUE_147."<br>";
            }
            // header("Refresh:0");
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="inner">
        <h1>Guest Checkout</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">

                    

                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>">
                                </div>
                        
                                <div class="col-md-6 form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-danger" value="Next" name="form1">
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>