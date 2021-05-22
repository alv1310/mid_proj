<?php
session_start();
$title = "情報誌";
require_once './db.inc.php';
require_once './templates/tittle.php';
?>

<!-- tpl-item-detail.php -->
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div class="container-fluid">
    <div class="row">
        <!-- 左側目錄連結 -->
        <div class="col-md-3 col-sm-4">
            <?php
            $sql = "SELECT `aCatId`, `aCatName` FROM `aCategoryList` ";
            $stmt = $pdo->query($sql);
            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
            ?>
                <div class="list-group">
                    <?php for ($i = 0; $i < count($arr); $i++) { ?>

                        <a href="./itemList.php?aCategoryId=<?php echo $arr[$i]['aCatId'] ?>" class="list-group-item list-group-item-action"><?php echo $arr[$i]['aCatName'] ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <!-- 文章列表清單 -->
        <div class="col-md-9 col-sm-8">
            <?php
            if (isset($_GET['aId'])) {
                //SQL 敘述
                $sql = "SELECT `articleList`.`aId`, `articleList`.`aTitle`, `articleList`.`aImg`, `articleList`.`author`, 
                            `articleList`.`aContent`, `articleList`.`aCategoryId`, `articleList`.`aDate`, `articleList`.`created_at`, `articleList`.`updated_at`,
                            `aCategoryList`.`aCatId`, `aCategoryList`.`aCatName`
                        FROM `articleList` INNER JOIN `aCategoryList`
                        ON `articleList`.`aCategoryId` = `aCategoryList`.`aCatId`
                        WHERE `aId` = ? ";

                $arrParam = [
                    (int)$_GET['aId']
                ];

                //查詢
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);

                //若文章數量大於 0 則列出
                if ($stmt->rowCount() > 0) {
                    $arrItem = $stmt->fetchAll()[0];
            ?>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row mb-3 d-flex justify-content-center">
                                    <img class="item-view border" src="./images/items/<?php echo $arrItem["aImg"]; ?>">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <p class="h3 text-primary font-weight-bold"><?php echo $arrItem["aTitle"] ?></p>
                                <p class="text-secondary"><?php echo $arrItem["aDate"] ?></p>
                                <p class="text-secondary"> By <?php echo $arrItem["author"] ?></p>
                                <p><?php echo $arrItem["aContent"] ?></p>

                                <!-- tags標籤顯示名稱 -->
                                <label class="text-primary font-weight-bold">Check These Tags</label><br>

                                <?php
                                $sql = "SELECT `articlelist`.`aId`, `ataglist`.`tagName`,`atagmap`.`tagId`
                                FROM `atagmap` 
                                JOIN `articlelist` ON `articlelist`.`aId` = `atagmap`.`aId`
                                JOIN `ataglist` ON `ataglist`.`tagId` = `atagmap`.`tagId`
                                WHERE `articleList`.`aId` = ? ";

                                $sqlItem = "SELECT `productlist`.`product_name`,`productlist`.`product_img`, `atagmap`.`tagId`,`productlist`.`product_id`
                                FROM `productlist`
                                JOIN `atagmap` ON `productlist`.`product_id` = `atagmap`.`pId`
                                WHERE `atagmap`.`obj` = 2 AND `atagmap`.`tagId` = ?";

                                // 顯示在tagmap中，該文章 aId 有對應的 tagId ，其帶出的 tag 名稱
                                $arrParam = [(int)$_GET['aId']];

                                $stmt = $pdo->prepare($sql);
                                $stmtItem = $pdo->prepare($sqlItem);

                                $stmt->execute($arrParam);

                                if ($stmt->rowCount() > 0) {

                                    $arr = $stmt->fetchAll();

                                    for ($i = 0; $i < count($arr); $i++) {
                                        // ------- Error 可參照商品種類連結--------
                                        // a連結指向此 tagid 在tagmap中，所對應的aId，為列表? 
                                        // 應使用 .//itemList.php.php?aTagId=???
                                ?><a href="./itemDetail.php?aId=<?php echo $arr[$i]['aId'] ?>" class="btn btn-outline-primary">
                                            <?php echo $arr[$i]['tagName'] ?></a><?php
                                                                                    $arrItem = [$arr[$i]['tagId']];
                                                                                    $stmtItem->execute($arrItem);
                                                                                    $arrItem = $stmtItem->fetchAll();
                                                                                    for ($k = 0; $k < count($arrItem); $k++) {
                                                                                        // echo $arrItem[$k]['product_name'];
                                                                                        // echo $arrItem[$k]['product_img'];

                                                                                        $name[] = $arrItem[$k]['product_name'];
                                                                                        $img[] = $arrItem[$k]['product_img'];
                                                                                        $id[] = $arrItem[$k]['product_id'];
                                                                                    }
                                                                                    ?>

                                <?php
                                    }
                                } ?>



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
<div class="container">
    <hr>
    <p class="h4 text-primary font-weight-bold">逛逛相關推薦商品</p>
    <div class="row mt-5">
        <?php
        for ($l = 0; $l < count($name); $l++) {
            //echo $name[$l];
            //echo '"<img src="./images/' . $img[$l] . '">';
        ?>
            <div class="col-md-4 col-sm-6 filter-items" data-price="">
                <div class="card mb-3 shadow-sm">
                    <a href="./cart_itemDetail.php?product_id=<?php echo $id[$l] ?>">
                        <img class="list-item" src="./images/<?php echo  $img[$l] ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text list-item-card"><b><?php echo $name[$l] ?></b></p>

                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>


<!-- tpl-footer -->
<?php
require_once './templates/tpl-footer.php';
?>