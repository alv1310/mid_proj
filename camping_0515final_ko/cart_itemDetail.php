<?php
session_start();
require_once('./db.inc.php');
$title = "商品細節";
require_once './templates/tittle.php';
?>
<!-- tpl-item-detail.php -->

<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<div class="container-fluid">
    <div class="row">
        <!-- 左側樹狀商品種類連結 -->
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
        <!-- 商品列表   -->

        <div class="col-md-9 col-sm-8">
            <?php
            if (isset($_GET['product_id'])) {
                //SQL 敘述
                $sql = "SELECT `productlist`.`product_id`, `productlist`.`product_name`, `productlist`.`product_img`, `productlist`.`product_price`, 
                            `productlist`.`qty`, `productlist`.`cat_id`, `productlist`.`created_at`, `productlist`.`updated_at`,
                            `productcategory`.`cat_id`, `productcategory`.`cat_name`
                        FROM `productlist` INNER JOIN `productcategory`
                        ON `productlist`.`cat_id` = `productcategory`.`cat_id`
                        WHERE `product_id` = ? ";

                $arrParam = [
                    (int)$_GET['product_id']
                ];

                //查詢
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);

                //若商品項目個數大於 0，則列出商品
                if ($stmt->rowCount() > 0) {
                    $arrItem = $stmt->fetchAll()[0];
            ?>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-3 d-flex justify-content-center">
                                    <img class="item-view border" src="./images/<?php echo $arrItem["product_img"]; ?>">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <p class="h3 text-warning font-weight-bold"><?php echo $arrItem["product_name"] ?></p>
                                <p class="text-secondary">價格:<?php echo $arrItem["product_price"] ?></p>
                                <p class="text-secondary"> 商品數量: <?php echo $arrItem["qty"] ?></p>

                                <form name="cartForm" id="cartForm" method="POST" action="./cart_addCart.php">
                                    <label>數量：</label>

                                    <!-- 設定數量 -->
                                    <input type="number" name="cartQty" value="1" maxlength="5" min="1" max="<?php echo $arrItem["qty"] ?>">

                                    <!-- 隱藏元素，配合加入購物車使用 -->
                                    <input type="hidden" name="product_id" value="<?php echo (int)$_GET['product_id'] ?>">

                                    <input type="submit" class="btn btn-warning btn-lg" name="smb" value="加入購物車">




                                </form>
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


<!-- tpl-footer -->
<?php
require_once './templates/tpl-footer.php';
?>