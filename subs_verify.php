<?php require_once('header.php'); ?>

<?php

if ( (isset($_REQUEST['email'])) && (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=? AND subs_active=0");
    $statement->execute(array($_REQUEST['email']));
    $c=$statement->rowCount();
    if(!$c){
        $var=0;
        header('location: '.BASE_URL);
        exit;
    }

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['subs_hash']) {
            header('location: '.BASE_URL);
            $var=0;
            exit;
        }
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $key = md5(uniqid(rand(), true));
        $statement = $pdo->prepare("UPDATE tbl_subscriber SET subs_hash=?, subs_active=? WHERE subs_email=?");
        $statement->execute(array($key,1,$_GET['email']));

        $success_message = '<p style="color:green;">Congratulations!, Your subscription confirmed.</p><p><a href="'.BASE_URL.'index.php" style="color:#167ac6;font-weight:bold;">Click here to go to Home</a></p>';     
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
        <h1>Subscription Confirmation</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php 
                        if ($var==0){echo '<p style="color:red">'.$error_message.'</p>';}else{echo $success_message;}
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>