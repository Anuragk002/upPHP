<?php require_once('header.php');
include('maill.php');
?>

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

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

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
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_gender'])) {
        $valid = 0;
        $error_message .= "Please select the gender. <br>";
    }

    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }

    if($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_email,
                                        cust_phone,
                                        cust_gender,
                                        cust_s_name,
                                        cust_s_email,
                                        cust_s_phone,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
                                        strip_tags($_POST['cust_name']),
                                        strip_tags($_POST['cust_email']),
                                        strip_tags($_POST['cust_phone']),
                                        strip_tags($_POST['cust_gender']),
                                        strip_tags($_POST['cust_name']),
                                        strip_tags($_POST['cust_email']),
                                        strip_tags($_POST['cust_phone']),
                                        md5($_POST['cust_password']),
                                        $token,
                                        $cust_datetime,
                                        $cust_timestamp,
                                        0
                                    ));

        // Send email for confirmation of the account
        // $to = $_POST['cust_email'];
        
//         $subject = LANG_VALUE_150;
//         $verify_link = BASE_URL.'verify.php?email='.$to.'&token='.$token;
//         $message = '
// '.LANG_VALUE_151.'<br><br>

// <a href="'.$verify_link.'">'.$verify_link.'</a>';

//         $headers = "From: noreply@" . BASE_URL . "\r\n" .
//                    "Reply-To: noreply@" . BASE_URL . "\r\n" .
//                    "X-Mailer: PHP/" . phpversion() . "\r\n" . 
//                    "MIME-Version: 1.0\r\n" . 
//                    "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $to = $_POST['cust_email'];
        $verify_link ='https://www.unitpharma.com/verify.php?email='.$to.'&token='.$token;

        $body ='
            <body>
            <span style="color:black">Hello '.$_POST['cust_name'].',</span><br/>
            <span style="color:black">Congratulations!, your account has been successfully created. To activate your acount, please click on below given link:<br/>
            <a href="'.$verify_link.'" style="color:blue; font-weight:bold">'.$verify_link.'<a>
            </span><br/><br/>
            <span style="color:black">
            <b>Thanks and Regards</b><br/>
            Unit Pharma Support Team<br/>
            Website: <a href="https://www.unitpharma.com">https://www.unitpharma.com</a><br>
            </span>
            </body>
            ';

        $mail->addAddress($_POST['cust_email'], $_POST['cust_name']);//user mail customer
        $mail->Subject = 'Welcome to Unit Pharma';//subject
        $mail->Body    = $body;
        $mail->IsHTML(true);
        $mail->send();
        
        // Sending Email
        // mail($to, $subject, $message, $headers);

        unset($_POST['cust_name']);
        unset($_POST['cust_cname']);
        unset($_POST['cust_email']);
        unset($_POST['cust_phone']);
        unset($_POST['cust_gender']);
        unset($_POST['cust_city']);

        $success_message = LANG_VALUE_152;
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_16; ?></h1>
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

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> *</label>
                                    <input type="text" class="form-control" required name="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo "Gender";#LANG_VALUE_106; ?><sup>*</sup></label>
                                    <select name="cust_gender" class="form-control" required >
                                        <option value="">Select Gender</option>                            
                                        <option value="male">Male</option> 
                                        <option value="female">Female</option>     
                                        <option value="other">Other</option>   
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" required name="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> *</label>
                                    <input type="text" class="form-control" required name="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>">
                                </div>                               
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" required class="form-control" name="cust_password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_98; ?> *</label>
                                    <input type="password" required class="form-control" name="cust_re_password">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-md btn-primary" value="<?php echo LANG_VALUE_15; ?>" name="form1">
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