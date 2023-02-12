<?php require_once('header.php'); ?>

<?php

    $p_err_msg="";
    $p_success_msg="";
    // Checking if product id in valid or not-->
    if (!isset($_REQUEST['id'])) {
        header('location: index.php');
        exit;
    } else {
        // Check the id is valid or not---->
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active =? AND p_id=? ");
        $statement->execute(array(1,$_REQUEST['id']));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($total == 0) {
            header('location: index.php');
            exit;
        }
    }

    // Getting product details start--->
    foreach ($result as $row) {
        $p_name = $row['p_name'];
        $p_qty = $row['p_qty'];
        $p_featured_photo = $row['p_featured_photo'];
        $p_description = $row['p_description'];
        $p_short_description = $row['p_short_description'];
        $p_feature = $row['p_feature'];
        $p_condition = $row['p_condition'];
        $p_return_policy = $row['p_return_policy'];
        $p_total_view = $row['p_total_view'];
        $p_is_featured = $row['p_is_featured'];
        $p_is_active = $row['p_is_active'];
        $tcat_id = $row['tcat_id'];
    }

    // Getting category name for product-->
    $statement = $pdo->prepare("SELECT
                            t3.tcat_id,
                            t3.tcat_name
                            FROM tbl_top_category t3
                            WHERE t3.tcat_id=?");
    $statement->execute(array($tcat_id));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $tcat_name = $row['tcat_name'];
        $tcat_id = $row['tcat_id'];
    }
    // Updating the revies of the product--------->
    $p_total_view = $p_total_view + 1;
    $statement = $pdo->prepare("UPDATE tbl_product SET p_total_view=? WHERE p_id=?");
    $statement->execute(array($p_total_view, $_REQUEST['id']));

    //  Getting package for the prodcut-------->
    $statement = $pdo->prepare("SELECT * FROM tbl_product_package WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $resultpkg = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultpkg as $row) {
        $pkg_name[] = $row['pkg_name'];
        $pkg_price[] = $row['pkg_price'];
    }

    // Submiting the review for the product ------>
    if (isset($_POST['form_review'])) {

        $statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=? AND cust_id=?");
        $statement->execute(array($_REQUEST['id'], $_SESSION['customer']['cust_id']));
        $total = $statement->rowCount();

        if ($total) {
            $error_message = LANG_VALUE_68;
        } else {
            $statement = $pdo->prepare("INSERT INTO tbl_rating (p_id,cust_id,comment,rating) VALUES (?,?,?,?)");
            $statement->execute(array($_REQUEST['id'], $_SESSION['customer']['cust_id'], $_POST['comment'], $_POST['rating']));
            $success_message = LANG_VALUE_163;
        }
    }

    // Getting the average rating for this product ---->
    $t_rating = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $tot_rating = $statement->rowCount();
    if ($tot_rating == 0) {
        $avg_rating = 0;
    } else {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $t_rating = $t_rating + $row['rating'];
        }
        $avg_rating = $t_rating / $tot_rating;
    }

    // Adding product to the cart ------------>
    if (isset($_POST['form_add_to_cart'])) {
        // Checking the input validity---->
        if(!isset($_POST['p_pkg_id'])){
            $p_err_msg='Please select one package';
            
        }else if(!isset($_POST['p_qty'])){
            $p_err_msg='Quantity should not be empty';
        
        }else {
            $quantity=$_POST['p_qty'];
            $pkg_id=$_POST['p_pkg_id'];
            // Checking if the user is registered or the guest----->
            if(!isset($_SESSION['customer'])) {
                if (isset($_SESSION['cart_p_id']) && isset($_SESSION['cart_p_pkg_id']) && isset($_SESSION['cart_p_qty'])) {
                    $arr_cart_p_id = array();
                    $arr_cart_p_pkg_id = array();
                    $arr_cart_p_qty = array();
                    
                    $i = 0;
                    foreach ($_SESSION['cart_p_id'] as $key => $value) {
                        $arr_cart_p_id[$i] = $value;
                        $i++;                     
                    }
                    
                    $i = 0;
                    foreach ($_SESSION['cart_p_pkg_id'] as $key => $value) {
                        $arr_cart_p_pkg_id[$i] = $value;
                        $i++;                      
                    }

                    $i = 0;
                    foreach ($_SESSION['cart_p_qty'] as $key => $value) {
                        $arr_cart_p_qty[$i] = $value;
                        $i++;                      
                    }
                    
                    // Checking if item is present in local cart with same package --->
                    $added = 0;
                    for ($i = 0; $i <count($arr_cart_p_id); $i++) {
                        if (($arr_cart_p_id[$i] == $_REQUEST['id']) && ($arr_cart_p_pkg_id[$i] == $pkg_id)) {
                            $added = 1;
                                break;
                        }
                    }
                    if ($added == 1) {
                        $p_err_msg = 'This product already exist in the shopping cart.';
                                        
                    } else {
                    
                        $k = 0;
                        foreach ($_SESSION['cart_p_id'] as $key => $res) {
                            $k++;
                        }   
                        $new_key = $k;
                        $_SESSION['cart_p_id'][$new_key] = $_REQUEST['id'];
                        $_SESSION['cart_p_pkg_id'][$new_key] = $pkg_id;
                        $_SESSION['cart_p_qty'][$new_key] = $quantity;
                        $p_success_msg = 'Product added to the cart.';  
                        echo '<script type="text/JavaScript"> 
                        change_text();
                                    function change_text(){
                                        var name = document.getElementById("cart-count").innerHTML;
                                        document.getElementById("cart-count").innerHTML = 1+Number(name);
                                    }
                                </script>'
                        ;                
                    }
                } else {
                    $_SESSION['cart_p_id'][0] = $_REQUEST['id'];
                    $_SESSION['cart_p_pkg_id'][0] = $pkg_id;
                    $_SESSION['cart_p_qty'][0] = $quantity;
                    $p_success_msg = 'Product added to the cart.';       
                    echo '<script type="text/JavaScript"> 
                        change_text();
                                    function change_text(){
                                        var name = document.getElementById("cart-count").innerHTML;
                                        document.getElementById("cart-count").innerHTML = 1+Number(name);
                                    }
                                </script>'
                        ;            
                }
     
            }else{
                // Checking if the Item is present in cart with same package --->
                $statement = $pdo->prepare("SELECT * FROM tbl_cart WHERE cust_id=? AND (product_id=? AND package_id=?)");
                $statement->execute(array($_SESSION['customer']['cust_id'],$_REQUEST['id'],$pkg_id,));
                $cart_count=$statement->rowCount();
                if ($cart_count) {
                    $p_err_msg= "Product already exist in cart.";
                }else{
                    $statement = $pdo->prepare("INSERT INTO tbl_cart (cust_id,product_id,package_id,quantity) VALUES (?,?,?,?)");
                    $statement->execute(array($_SESSION['customer']['cust_id'],$_REQUEST['id'],$pkg_id, $quantity));
                    $p_success_msg = "Product added to cart.";
                    echo '<script type="text/JavaScript"> 
                        change_text();
                                    function change_text(){
                                        var name = document.getElementById("cart-count").innerHTML;
                                        document.getElementById("cart-count").innerHTML = 1+Number(name);
                                    }
                                </script>'
                        ; 
                }

            }
            
            unset($_POST['p_qty']);
            unset($_POST['p_pkg_id']);
        }
        
    }
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb mb_30">
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                        <li>-></li>
                        <li><a
                                href="<?php echo BASE_URL . 'product-category.php?id=' . $tcat_id . '&type=top-category' ?>"><?php echo $tcat_name; ?></a>
                        </li>
                        <li>-></li>
                        <li><?php echo $p_name; ?></li>
                    </ul>
                </div>
                <?php
                    if($p_success_msg != '') {
                        echo '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>'. $p_success_msg .'</strong></div>';
                    $p_success_msg='';
                    }
                    if($p_err_msg != '') {
                        echo '<div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>'. $p_err_msg .'</strong></div>';
                    $p_err_msg='';
                    }

                ?>
                <div class="product">
                    <div class="row">
                        <div class="col-md-5 p_photos">
                            <ul class="prod-slider">

                                <li style="background-image: url(assets/uploads/<?php echo $p_featured_photo; ?>);">
                                    <a class="popup" href="assets/uploads/<?php echo $p_featured_photo; ?>"></a>
                                </li>
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                $statement->execute(array($_REQUEST['id']));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                ?>
                                <li
                                    style="background-image: url(assets/uploads/product_photos/<?php echo $row['photo']; ?>);">
                                    <a class="popup"
                                        href="assets/uploads/product_photos/<?php echo $row['photo']; ?>"></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                            <div id="prod-pager">
                                <a data-slide-index="0" href="">
                                    <div class="prod-pager-thumb"
                                        style="background-image: url(assets/uploads/<?php echo $p_featured_photo; ?>">
                                    </div>
                                </a>
                                <?php
                                $i = 1;
                                $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                $statement->execute(array($_REQUEST['id']));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                ?>
                                <a data-slide-index="<?php echo $i; ?>" href="">
                                    <div class="prod-pager-thumb"
                                        style="background-image: url(assets/uploads/product_photos/<?php echo $row['photo']; ?>">
                                    </div>
                                </a>
                                <?php
                                    $i++;
                                }
                                ?>
                            </div>
                            <br clear=all />
                        </div>
                        <div class="col-md-7 p_srt_details">

                            <div class="p-title">
                                <h2><?php echo $p_name; ?></h2>
                            </div>
                            <div class="p-review">
                                <div class="rating">
                                    <?php
                                    if ($avg_rating == 0) {
                                        echo '';
                                    } elseif ($avg_rating == 1.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 2.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 3.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 4.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        ';
                                    } else {
                                        for ($i = 1; $i <= 5; $i++) {
                                    ?>
                                    <?php if ($i > $avg_rating) : ?>
                                    <i class="fa fa-star-o"></i>
                                    <?php else : ?>
                                    <i class="fa fa-star"></i>
                                    <?php endif; ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="p-short-des">
                                <p>
                                    <?php echo $p_short_description; ?>
                                </p>
                            </div>
                            <form action="" method="post">
                                <div class="p-select-package">
                                    <div class="row">
                                        <div class="col-md-12">
                                            Select Package<sup>*</sup> <br>
                                            <?php
                                                foreach ($resultpkg as $row) {
                                                ?>
                                            <div class="radio">
                                                <label><input type="radio" name="p_pkg_id"
                                                        value="<?php echo $row['id']; ?>" required>
                                                    <?php echo $row['pkg_name']; ?> -
                                                    $<?php echo $row['pkg_price']; ?></label>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

                                <div class="p-quantity">
                                    <?php echo LANG_VALUE_55; ?><sup>*</sup><br>
                                    <input type="number" class="input-text qty" step="1" min="1" max="" name="p_qty"
                                        value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" required>
                                </div>
                                <div class="btn-cart btn-cart1">
                                    <input type="submit" value="<?php echo LANG_VALUE_154; ?>" name="form_add_to_cart">
                                </div>
                            </form>
                            <div class="share">
                                <?php echo LANG_VALUE_58; ?> <br>
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#description"
                                        aria-controls="description" role="tab"
                                        data-toggle="tab"><?php echo LANG_VALUE_59; ?></a></li>
                                <li role="presentation"><a href="#feature" aria-controls="feature" role="tab"
                                        data-toggle="tab"><?php echo LANG_VALUE_60; ?></a></li>
                                <li role="presentation"><a href="#condition" aria-controls="condition" role="tab"
                                        data-toggle="tab"><?php echo LANG_VALUE_61; ?></a></li>
                                <li role="presentation"><a href="#return_policy" aria-controls="return_policy"
                                        role="tab" data-toggle="tab"><?php echo LANG_VALUE_62; ?></a></li>
                                <!-- <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab"><?php echo LANG_VALUE_63; ?></a></li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="description"
                                    style="margin-top: -30px;">
                                    <p>
                                        <?php
                                        if ($p_description == '') {
                                            echo LANG_VALUE_70;
                                        } else {
                                            echo $p_description;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="feature" style="margin-top: -30px;">
                                    <p>
                                        <?php
                                        if ($p_feature == '') {
                                            echo LANG_VALUE_71;
                                        } else {
                                            echo $p_feature;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="condition" style="margin-top: -30px;">
                                    <p>
                                        <?php
                                        if ($p_condition == '') {
                                            echo LANG_VALUE_72;
                                        } else {
                                            echo $p_condition;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="return_policy" style="margin-top: -30px;">
                                    <p>
                                        <?php
                                        if ($p_return_policy == '') {
                                            echo LANG_VALUE_73;
                                        } else {
                                            echo $p_return_policy;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="review" style="margin-top: -30px;">

                                    <div class="review-form">
                                        <?php
                                        $statement = $pdo->prepare("SELECT * 
                                                            FROM tbl_rating t1 
                                                            JOIN tbl_customer t2 
                                                            ON t1.cust_id = t2.cust_id 
                                                            WHERE t1.p_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $total = $statement->rowCount();
                                        ?>
                                        <h2><?php echo LANG_VALUE_63; ?> (<?php echo $total; ?>)</h2>
                                        <?php
                                        if ($total) {
                                            $j = 0;
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                $j++;
                                        ?>
                                        <div class="mb_10"><b><u><?php echo LANG_VALUE_64; ?> <?php echo $j; ?></u></b>
                                        </div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width:170px;"><?php echo LANG_VALUE_75; ?></th>
                                                <td><?php echo $row['cust_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo LANG_VALUE_76; ?></th>
                                                <td><?php echo $row['comment']; ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo LANG_VALUE_78; ?></th>
                                                <td>
                                                    <div class="rating">
                                                        <?php
                                                                for ($i = 1; $i <= 5; $i++) {
                                                                ?>
                                                        <?php if ($i > $row['rating']) : ?>
                                                        <i class="fa fa-star-o"></i>
                                                        <?php else : ?>
                                                        <i class="fa fa-star"></i>
                                                        <?php endif; ?>
                                                        <?php
                                                                }
                                                                ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                            }
                                        } else {
                                            echo LANG_VALUE_74;
                                        }
                                        ?>

                                        <h2><?php echo LANG_VALUE_65; ?></h2>
                                        <?php
                                        // if ($error_message != '') {
                                        //     echo "<script>alert('" . $error_message . "')</script>";
                                        // }
                                        // if ($success_message != '') {
                                        //     echo "<script>alert('" . $success_message . "')</script>";
                                        // }
                                        ?>
                                        <?php if (isset($_SESSION['customer'])) : ?>

                                        <?php
                                            $statement = $pdo->prepare("SELECT * 
                                                                FROM tbl_rating
                                                                WHERE p_id=? AND cust_id=?");
                                            $statement->execute(array($_REQUEST['id'], $_SESSION['customer']['cust_id']));
                                            $total = $statement->rowCount();
                                            ?>
                                        <?php if ($total == 0) : ?>
                                        <form action="" method="post">
                                            <div class="rating-section">
                                                <input type="radio" name="rating" class="rating" value="1" checked>
                                                <input type="radio" name="rating" class="rating" value="2" checked>
                                                <input type="radio" name="rating" class="rating" value="3" checked>
                                                <input type="radio" name="rating" class="rating" value="4" checked>
                                                <input type="radio" name="rating" class="rating" value="5" checked>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control" cols="30" rows="10"
                                                    placeholder="Write your comment (optional)"
                                                    style="height:100px;"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-default" name="form_review"
                                                value="<?php echo LANG_VALUE_67; ?>">
                                        </form>
                                        <?php else : ?>
                                        <span style="color:red;"><?php echo LANG_VALUE_68; ?></span>
                                        <?php endif; ?>


                                        <?php else : ?>
                                        <p class="error">
                                            <?php echo LANG_VALUE_69; ?> <br>
                                            <a href="login.php"
                                                style="color:red;text-decoration: underline;"><?php echo LANG_VALUE_9; ?></a>
                                        </p>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="product bg-gray pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="headline">
                    <h2><?php echo LANG_VALUE_155; ?></h2>
                    <h3><?php echo LANG_VALUE_156; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="product-carousel">

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE tcat_id=? AND p_id!=?");
                    $statement->execute(array($tcat_id, $_REQUEST['id']));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    ?>
                    <div class="item">
                        <div class="thumb">
                            <div class="photo"
                                style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);">
                            </div>
                            <div class="overlay"></div>
                        </div>
                        <div class="text">
                            <h5><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a>
                            </h5>
                            <h4>
                                <?php #echo LANG_VALUE_1; ?><?php #echo $row['p_current_price']; ?>
                                <?php #if ($row['p_old_price'] != '') : ?>
                                <del>
                                    <?php #echo LANG_VALUE_1; ?><?php #echo $row['p_old_price']; ?>
                                </del>
                                <?php #endif; ?>
                                <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_package WHERE p_id=?");
                                    $statement->execute(array($row['p_id']));
                                    $count_pkg=$statement->rowCount();
                                    $resultpkg = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($resultpkg as $pkg) {
                                        $pkg_price[] = $pkg['pkg_price'];
                                    } 
                                    if ($count_pkg==1){
                                        echo "$".max($pkg_price);   
                                    }else{
                                        echo "$".min($pkg_price)." - $".max($pkg_price);
                                    }
                                ?>
                            </h4>
                            <div class="rating">
                                <?php
                                    $t_rating = 0;
                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                    $statement1->execute(array($row['p_id']));
                                    $tot_rating = $statement1->rowCount();
                                    if ($tot_rating == 0) {
                                        $avg_rating = 0;
                                    } else {
                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1) {
                                            $t_rating = $t_rating + $row1['rating'];
                                        }
                                        $avg_rating = $t_rating / $tot_rating;
                                    }
                                    ?>
                                <?php
                                    if ($avg_rating == 0) {
                                        echo '';
                                    } elseif ($avg_rating == 1.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 2.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 3.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } elseif ($avg_rating == 4.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        ';
                                    } else {
                                        for ($i = 1; $i <= 5; $i++) {
                                    ?>
                                <?php if ($i > $avg_rating) : ?>
                                <i class="fa fa-star-o"></i>
                                <?php else : ?>
                                <i class="fa fa-star"></i>
                                <?php endif; ?>
                                <?php
                                        }
                                    }
                                    ?>
                            </div>
                            <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo LANG_VALUE_154; ?></a>
                            </p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

<?php
// if ($p_err_msg != '') {
//     echo "<script>alert('".$p_err_msg."')</script>";
//     $p_err_msg='';
// }
// if ($p_success_msg != '') {
//     echo "<script>alert('".$p_success_msg."')</script>";
//     $p_success_msg='';
//     // header('location: product.php?id=' . $_REQUEST['id']);
// }
?>