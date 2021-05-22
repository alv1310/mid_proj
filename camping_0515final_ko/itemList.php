<?php
session_start();
require_once './db.inc.php';
require_once './templates/tittle.php';
?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css">
<!--  tpl-item-list.php -->
<div class="container-fluid">
    <div class="row">
        <!-- 列出左側樹狀商品種類連結 -->
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

        <!-- 右側商品項目清單 -->
        <div class="col-md-9 col-sm-9">
            <div class="row">
                <?php
                $sql = "SELECT `articleList`.`aId`, `articleList`.`aTitle`, `articleList`.`aImg`, `articleList`.`author`, 
                `articleList`.`aContent`, `articleList`.`aCategoryId`, `articleList`.`aDate`,`articleList`.`created_at`, `articleList`.`updated_at`,
                `aCategoryList`.`aCatName`
        FROM `articleList` INNER JOIN `aCategoryList`
        ON `articleList`.`aCategoryId` = `aCategoryList`.`aCatId`";

                //若網址有商品種類編號，則整合字串來操作 SQL 語法
                if (isset($_GET['aCategoryId'])) {
                    $sql .= "WHERE FIND_IN_SET(`articleList`.`aCategoryId`, ?)
                            ORDER BY `articleList`.`aId` ASC ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([(int)$_GET['aCategoryId']]);
                } else {
                    //沒有指定商品種類編號，則單純顯示全部商品
                    $sql .= "ORDER BY `articleList`.`aId` ASC ";
                    $stmt = $pdo->query($sql);
                }

                //若商品項目個數大於 0，則列出商品
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                    for ($i = 0; $i < count($arr); $i++) {
                ?>
                        <div class="col-md-4 col-sm-6 filter-items" data-price="<?php echo $arr[$i]['author'] ?>">
                            <div class="card mb-3 shadow-sm">
                                <a href="./itemDetail.php?aId=<?php echo $arr[$i]['aId'] ?>">
                                    <img class="list-item" src="./images/items/<?php echo $arr[$i]['aImg'] ?>">
                                </a>
                                <div class="card-body">
                                    <p class="card-text list-item-card"><b><?php echo $arr[$i]['aTitle'] ?></b></p>
                                    <small>test content</small>

                                    <!-- <p>加入預覽文字 多餘隱藏... class 設.txt-line-clamp3 </p> -->
                                    <div class="d-flex">
                                        <a class="btn btn-outline-warning ml-auto mb-3" href="./itemDetail.php?aId=<?php echo $arr[$i]['aId']; ?>" role="button">看更多</a>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <small class="text-muted">By <?php echo $arr[$i]['author'] ?></small>

                                        <small class="text-muted">發布日期：<?php echo $arr[$i]['aDate'] ?></small>

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

<!--  -->

<?php
require_once './templates/tpl-footer.php';
?>