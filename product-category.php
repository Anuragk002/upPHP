<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if(($_REQUEST['type'] != 'top-category')) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $tcat_id= $row['tcat_id'];
            $tcat_name = $row['tcat_name'];
        }
        
    }   
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_product_category; ?>)">
    <div class="inner">
        <h1><?php echo LANG_VALUE_50; ?> <?php echo $tcat_name; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <!-- <h3><?php //echo LANG_VALUE_51; ?> "<?php //echo $tcat_name; ?>"</h3> -->
        <div class="product product-cat">
            <?php
            //Columns must be a factor of 12 (1,2,3,4,6,12)
            $numOfCols = 4;
            $rownumber = 0;
            $bootstrapColWidth = 12 / $numOfCols;
            ?>
            <div class="row">
                <?php
                $prod_count = 0;
                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE tcat_id=? AND p_is_active=?");
                $statement->execute(array($tcat_id,1));
                $prod_count=$statement->rowCount();
                if($prod_count==0) {
                    echo '<div class="pl_15">'.LANG_VALUE_153.'</div>';
                } else {
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        ?>
                <div class="col-md-<?php echo $bootstrapColWidth; ?> ">
                    <div class="item item-product-cat">

                        <div class="inner">
                            <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                <div class="thumb">
                                    <div class="photo"
                                        style="background-image:url(assets/uploads/<?php echo $row['p_featured_photo']; ?>);">
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                                <div class="text">
                                    <h5><a href="product.php?id=<?php echo $row['p_id']; ?>">
                                            <?php #echo $row['p_name']; ?>
                                            <?php 
                                                    if(strlen($row['p_name'])>=30){
                                                        echo substr($row['p_name'],0,30) .'...';
                                                    }else{
                                                        echo $row['p_name'];
                                                    }
                                                
                                                ?>
                                        </a>
                                    </h5>

                                    <h4>
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
                                                unset($pkg_price);
                                                ?>
                                    </h4>

                                    <div class="rating">
                                        <?php
                                                        $t_rating = 0;
                                                        $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                        $statement1->execute(array($row['p_id']));
                                                        $tot_rating = $statement1->rowCount();
                                                        if($tot_rating == 0) {
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
                                                        if($avg_rating == 0) {
                                                            echo '';
                                                        }
                                                        elseif($avg_rating == 1.5) {
                                                            echo '
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star-half-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                ';
                                                        } 
                                                        elseif($avg_rating == 2.5) {
                                                            echo '
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star-half-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                ';
                                                        }
                                                        elseif($avg_rating == 3.5) {
                                                            echo '
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star-half-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                ';
                                                        }
                                                        elseif($avg_rating == 4.5) {
                                                            echo '
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star-half-o"></i>
                                                                ';
                                                                }
                                                        else {
                                                            for($i=1;$i<=5;$i++) {
                                                                if($i>$avg_rating): ?>
                                        <i class="fa fa-star-o"></i>
                                        <?php else: ?>
                                        <i class="fa fa-star"></i>
                                        <?php endif; ?>
                                        <?php
                                                            }
                                                        }
                                                    ?>
                                    </div>
                                    <?php if($row['p_qty'] == 0): ?>
                                    <div class="out-of-stock">
                                        <div class="inner">
                                            Out Of Stock
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><i
                                                class="fa fa-shopping-cart"></i> <?php echo LANG_VALUE_154; ?></a></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                            $rownumber++;
                            if($rownumber % $numOfCols == 0) echo '</div><br/><div class="row">';
                    }
                }
                ?>
            </div>

        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>