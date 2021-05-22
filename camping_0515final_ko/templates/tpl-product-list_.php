<!-- tpl-product-list.php -->
<div class="album py-5 bg-light flex-shrink-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 d-flex justify-content-center">
                <h1>情報誌</h1>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <?php
            //SQL 敘述
            $sql = "SELECT `articleList`.`aId`, `articleList`.`aTitle`, `articleList`.`aImg`, `articleList`.`author`, 
                            `articleList`.`aContent`, `articleList`.`aCategoryId`, `articleList`.`aDate`, `articleList`.`created_at`, `articleList`.`updated_at`,
                            `aCategoryList`.`aCatName`
                    FROM `articleList` INNER JOIN `aCategoryList`
                    ON `articleList`.`aCategoryId` = `aCategoryList`.`aCatId`
                    ORDER BY `articleList`.`updated_at` DESC ";

            //查詢分頁後的商品資料
            $stmt = $pdo->prepare($sql);
            $stmt->execute(); //$arrParam

            //若數量大於 0，則列出商品
            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
                for ($i = 0; $i < count($arr); $i++) {
            ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card mb-3 shadow-sm">
                            <a href="./itemDetail.php?aId=<?php echo $arr[$i]['aId']; ?>">
                                <img class="list-item" src="./images/items/<?php echo $arr[$i]['aImg']; ?>">
                            </a>
                            <div class="card-body">
                                <p class="card-text"><b><?php echo $arr[$i]['aTitle']; ?></b></p>
                                <small>test content</small>

                                <!-- <p>加入預覽文字 多餘隱藏... class 設.txt-line-clamp3 </p> -->
                                <div class="d-flex">
                                    <a class="btn btn-outline-warning ml-auto mb-3" href="./itemDetail.php?aId=<?php echo $arr[$i]['aId']; ?>" role="button">看更多</a>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">

                                    <small class="text-muted">By <?php echo $arr[$i]['author']; ?></small>

                                    <small class="text-muted">發布日期：<?php echo $arr[$i]['aDate']; ?></small>

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