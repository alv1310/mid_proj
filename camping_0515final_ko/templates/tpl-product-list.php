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
                        <div class="card mb-3 shadow-sm" style="width:100%;height:500px;">
                            <a href="./itemDetail.php?aId=<?php echo $arr[$i]['aId']; ?>">
                                <img class="list-item" src="./images/items/<?php echo $arr[$i]['aImg']; ?>" style="width:100%;height:300px;object-fit:cover">
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

<hr>

<div class="album py-5 bg-light flex-shrink-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 d-flex justify-content-center">
                <h1>露營用品</h1>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <?php
            //SQL 敘述
            $sql = "SELECT `productlist`.`product_id`, `productlist`.`product_name`, `productlist`.`product_img`, `productlist`.`product_price`, 
            `productlist`.`qty`, `productlist`.`cat_id`, `productlist`.`created_at`, `productlist`.`updated_at`,
            `productcategory`.`cat_name`
    FROM `productlist` INNER JOIN `productcategory`
    ON `productlist`.`cat_id` = `productcategory`.`cat_id` ";

            //查詢分頁後的商品資料
            if (isset($_GET['cat_id'])) {
                $sql .= "WHERE FIND_IN_SET(`productcategory`.`cat_id`, ? ) ORDER BY `productlist`.`product_id` ASC ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_GET['cat_id']]);
            } else {
                //沒有指定商品種類編號，則單純顯示全部商品
                $sql .= "ORDER BY `productlist`.`product_id` ASC ";
                $stmt = $pdo->query($sql);
            }

            //若數量大於 0，則列出商品
            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
                for ($i = 0; $i < count($arr); $i++) {
            ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card mb-3 shadow-sm " style="width:100%;height:500px;">
                            <a href="./cart_itemDetail.php?product_id=<?php echo $arr[$i]['product_id'] ?>">
                                <img class="list-item" src="./images/<?php echo $arr[$i]['product_img']; ?>" style="width:100%;height:300px;object-fit:cover">
                            </a>
                            <div class="card-body">
                                <p class="card-text"><b><?php echo $arr[$i]['product_name']; ?></b></p>
                                <small>test content</small>

                                <!-- <p>加入預覽文字 多餘隱藏... class 設.txt-line-clamp3 </p> -->
                                <div class="d-flex">
                                    <a class="btn btn-outline-warning ml-auto mb-3" href="./cart_itemDetail.php?product_id=<?php echo $arr[$i]['product_id'] ?>" role="button">看更多</a>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">

                                    <small class="text-muted">金額 <?php echo $arr[$i]['product_price']; ?></small>

                                    <small class="text-muted">發布日期：<?php echo $arr[$i]['created_at']; ?></small>

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