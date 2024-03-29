<?php require_once('header.php'); ?>

<?php

if ( (isset($_REQUEST['email'])) && (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
    $statement->execute(array($_REQUEST['email']));
    $c=$statement->rowCount();
    if(!$c){
        $var=0;
        header('location: '.BASE_URL);
        exit;
    }

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['cust_token']) {
            header('location: '.BASE_URL);
            $var=0;
            exit;
        }
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $tkn=md5(time());
        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?, cust_status=? WHERE cust_email=?");
        $statement->execute(array($tkn,1,$_GET['email']));

        $success_message = '<p style="color:green;">Your email is verified successfully. You can login now.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';     
    }else{
        $error_message="Something went wrong!";
    }
}else{
    header('location: '.BASE_URL);
    exit;
}
?>

<div class="page-banner" style="background-color:#444;">
    <div class="inner">
        <h1>Registration Confirmation</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        if ($var==0){echo $error_message;}else{echo $success_message;}

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>