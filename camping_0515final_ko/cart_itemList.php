<?php
session_start();
$title = "商品清單";
require_once('./db.inc.php');
require_once './templates/tittle.php';
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="./css/style.css">
<!--  tpl-item-list.php -->
<div class="container-fluid">
    <div class="row">
        <!-- title -->
        <div class="col-md-3 col-sm-4">
            <?php
            $sql = "SELECT `cat_id`, `cat_name` FROM `productcategory` ";
            $stmt = $pdo->query($sql);
            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
            ?>

                <div class="list-group">
                    <?php for ($i = 0; $i < count($arr); $i++) { ?>

                        <a href="./cart_itemList.php?cat_id=<?php echo $arr[$i]['cat_id'] ?>" class="list-group-item list-group-item-action"><?php echo $arr[$i]['cat_name'] ?></a>
                    <?php } ?>
                </div>

            <?php } ?>

        </div>
        <!-- 右側商品項目清單 -->
        <div class="col-md-9 col-sm-9 ">
            <div class="row">
                <?php
                $sql = "SELECT `productlist`.`product_id`, `productlist`.`product_name`, `productlist`.`product_img`, `productlist`.`product_price`, 
        `productlist`.`qty`, `productlist`.`cat_id`, `productlist`.`created_at`, `productlist`.`updated_at`,
        `productcategory`.`cat_name`
FROM `productlist` INNER JOIN `productcategory`
ON `productlist`.`cat_id` = `productcategory`.`cat_id`";

                //若網址有商品種類編號，則整合字串來操作 SQL 語法
                if (isset($_GET['cat_id'])) {
                    $sql .= "WHERE FIND_IN_SET(`productcategory`.`cat_id`, ?)
                            ORDER BY `productlist`.`product_id` ASC ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$_GET['cat_id']]);
                } else {
                    //沒有指定商品種類編號，則單純顯示全部商品
                    $sql .= "ORDER BY `productlist`.`product_id` ASC ";
                    $stmt = $pdo->query($sql);
                }

                //若商品項目個數大於 0，則列出商品
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                    for ($i = 0; $i < count($arr); $i++) {
                ?>
                        <div class="col-md-4 col-sm-6 filter-items" data-price="<?php //echo $arr[$i]['product_name'] 
                                                                                ?>">
                            <div class="card mb-3 shadow-sm">
                                <a href="./cart_itemDetail.php?product_id=<?php echo $arr[$i]['product_id'] ?>">
                                    <img class="list-item" src="./images/<?php echo $arr[$i]['product_img'] ?>">
                                </a>
                                <div class="card-body">
                                    <p class="card-text list-item-card"><b><?php echo $arr[$i]['product_name'] ?></b></p>
                                    <p class="text-muted">價格：<?php echo $arr[$i]['product_price'] ?></p>

                                    <!-- <p>加入預覽文字 多餘隱藏... class 設.txt-line-clamp3 </p> -->
                                    <div class="d-flex">
                                        <a class="btn btn-outline-warning ml-auto mb-3" href="./cart_itemDetail.php?product_id=<?php echo $arr[$i]['product_id'] ?>" role="button">看更多</a>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <small class="text-muted">剩餘數量 <?php echo $arr[$i]['qty'] ?></small>

                                        <small class="text-muted">發布日期：<?php echo $arr[$i]['created_at'] ?></small>

                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>



<!-- 商品開始 -->


<?php
require_once './templates/tpl-footer.php';
?>