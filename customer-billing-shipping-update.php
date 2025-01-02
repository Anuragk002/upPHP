<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_s_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_s_gender'])) {
        $valid = 0;
        $error_message .= "Please select the gender. <br>";
    }

    if(empty($_POST['cust_s_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_s_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_s_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_s_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_s_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_s_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129."<br>";
    }

    if(empty($_POST['cust_s_gender'])) {
        $valid = 0;
        $error_message .= "Please select the gender. <br>";
    }

    // update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET 
                            cust_s_name=?,
                            cust_s_gender=?, 
                            cust_s_email=?, 
                            cust_s_phone=?, 
                            cust_s_country=?, 
                            cust_s_address=?, 
                            cust_s_city=?, 
                            cust_s_state=?, 
                            cust_s_zip=? 

                            WHERE cust_id=?");
    $statement->execute(array(
                            strip_tags($_POST['cust_s_name']),
                            strip_tags($_POST['cust_s_gender']),
                            strip_tags($_POST['cust_s_email']),
                            strip_tags($_POST['cust_s_phone']),
                            strip_tags($_POST['cust_s_country']),
                            strip_tags($_POST['cust_s_address']),
                            strip_tags($_POST['cust_s_city']),
                            strip_tags($_POST['cust_s_state']),
                            strip_tags($_POST['cust_s_zip']),
                            $_SESSION['customer']['cust_id']
                        ));  
   
    $success_message = LANG_VALUE_122;

    $_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
    $_SESSION['customer']['cust_s_gender'] = strip_tags($_POST['cust_s_gender']);
    $_SESSION['customer']['cust_s_email'] = strip_tags($_POST['cust_s_email']);
    $_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
    $_SESSION['customer']['cust_s_country'] = strip_tags($_POST['cust_s_country']);
    $_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
    $_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);
    $_SESSION['customer']['cust_s_state'] = strip_tags($_POST['cust_s_state']);
    $_SESSION['customer']['cust_s_zip'] = strip_tags($_POST['cust_s_zip']);

}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">

                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">

                            <div class="col-md-2"></div>
                            <div class="col-md-8">

                                <h3><?php echo LANG_VALUE_87; ?></h3>
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
                                    <label for=""><?php echo LANG_VALUE_102; ?></label>
                                    <input type="text" required class="form-control" name="cust_s_name"
                                        value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo "Gender";#LANG_VALUE_106; ?><sup>*</sup></label>
                                    <select name="cust_s_gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            <?php if($_SESSION['customer']['cust_s_gender'] =='male') {echo 'selected';} ?>>
                                            Male</option>
                                        <option value="female"
                                            <?php if($_SESSION['customer']['cust_s_gender'] =='female') {echo 'selected';} ?>>
                                            Female</option>
                                        <option value="other"
                                            <?php if($_SESSION['customer']['cust_s_gender'] =='other') {echo 'selected';} ?>>
                                            Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" required class="form-control" name="cust_s_email"
                                        value="<?php echo $_SESSION['customer']['cust_s_email']; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?></label>
                                    <input type="text" required class="form-control" name="cust_s_phone"
                                        value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?></label>
                                    <textarea name="cust_s_address" required class="form-control" cols="30" rows="10"
                                        style="height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_106; ?></label>
                                    <select name="cust_s_country" required class="form-control">
                                        <option value="">Select Country</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            ?>
                                        <option value="<?php echo $row['country_id']; ?>"
                                            <?php if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {echo 'selected';} ?>>
                                            <?php echo $row['country_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_107; ?></label>
                                    <input type="text" class="form-control" required name="cust_s_city"
                                        value="<?php echo $_SESSION['customer']['cust_s_city']; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_108; ?></label>
                                    <input type="text" class="form-control" required name="cust_s_state"
                                        value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_109; ?></label>
                                    <input type="text" class="form-control" required name="cust_s_zip"
                                        value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="submit" class="btn btn-lg btn-primary"
                                        value="<?php echo LANG_VALUE_5; ?>" name="form1">
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