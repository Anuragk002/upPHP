<?php require_once('header.php'); 
include('maill.php');
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
}
?>

<?php
if(isset($_POST['form1'])) {

    $valid = 1;
        
    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."\\n";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."\\n";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                        
            if(!$total) {
                $valid = 0;
                $error_message .= LANG_VALUE_135."\\n";
            }else{
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                foreach ($result as $row) {
                    $c_name = $row['cust_name'];
                    $c_email = $row['cust_email'];
                }
            }

        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $forget_password_message = $row['forget_password_message'];
        }

        $token = md5(rand());
        $now = time();

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?,cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array($token,$now,strip_tags($_POST['cust_email'])));
        
        // $message = '<p>'.LANG_VALUE_142.'<br> <a href="'.BASE_URL.'reset-password.php?email='.$_POST['cust_email'].'&token='.$token.'">Click here</a>';
        
        // $to      = $_POST['cust_email'];
        // $subject = LANG_VALUE_143;
        // $headers = "From: noreply@" . BASE_URL . "\r\n" .
        //            "Reply-To: noreply@" . BASE_URL . "\r\n" .
        //            "X-Mailer: PHP/" . phpversion() . "\r\n" . 
        //            "MIME-Version: 1.0\r\n" . 
        //            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // mail($to, $subject, $message, $headers);
        $to = $_POST['cust_email'];
        $verify_link ='https://www.unitpharma.com/reset-password.php?email='.$to.'&token='.$token;

        $body ='
            <body>
            <span style="color:black">Dear '.$c_name.',</span><br/>
            <span style="color:black">Your password reset request has been initiated. Please click on below given link to reset your password:<br/>
            <a href="'.$verify_link.'" style="color:blue; font-weight:bold">'.$verify_link.'<a>
            </span><br/><br/>
            <span style="color:black">
            <b>Thanks and Regards</b><br/>
            Unit Pharma Support Team<br/>
            Website: <a href="https://www.unitpharma.com">https://www.unitpharma.com</a><br>
            </span>
            </body>
            ';

        $mail->addAddress($c_email, $c_name);//user mail customer
        $mail->Subject = LANG_VALUE_143;//subject
        $mail->Body    = $body;
        $mail->IsHTML(true);
        $mail->send();

        $success_message = $forget_password_message;
    }
}
?>

<div class="page-banner"
    style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_forget_password; ?>);">
    <div class="inner">
        <h1><?php echo "Forgot Password"; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php
                        if($success_message != '') {
                            echo '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>'. $success_message .'</strong></div>';
                            $success_message='';
                        }
                        if($error_message != '') {
                            echo '<div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>'. $error_message .'</strong></div>';
                            $error_message='';
                        }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_4; ?>"
                                        name="form1">
                                </div>
                                <a href="login.php" style="color:#e4144d;"><?php echo LANG_VALUE_12; ?></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>