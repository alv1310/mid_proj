<?php
session_start();
require_once './db.inc.php';
require_once './templates/tittle_admin.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/product.css">
</head>
<div style="text-align:center;">
    <a href="./productlist.php?page=1">
        <h2>產品管理</h2>

    </a>

</div>
<div class="inline">

    <br>

    <a href="#" onclick="window.open(' ./productcategory.php ', '新增訂單', config='height=700,width=700');">
        商品分類編輯</a> |
    <a href="#" onclick="window.open(' ./padditem.php ', '新增商品', config='height=700,width=700');">
        新增商品</a>


</div>
<?php
// 設定頁面
$total =  $pdo->query("SELECT count(1) AS `page` FROM `productlist`")->fetchAll()[0]['page'];

//每頁幾筆
$numPerPage = 5;

// 總頁數，ceil()為無條件進位
$totalPages = ceil($total / $numPerPage);

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;

$sqlALL = "SELECT `productcategory`.`cat_name`,`productlist`.`product_id`,`productlist`.`cat_id`,`productlist`.`product_img`,`productlist`.`product_name`,`productlist`.`product_desc`,`productlist`.`product_price`,`ataglist`.`tagName`,`productlist`.`updated_at` FROM `productlist` INNER JOIN `productcategory` ON `productcategory`.`cat_id` = `productlist` .`cat_id` INNER JOIN `ataglist` ON `productlist`.`tag_id` = `ataglist`.`tagId` LIMIT ?, ? ";

$arrPage = [($page - 1) * $numPerPage, $numPerPage];

$stmtALL = $pdo->prepare($sqlALL);
$stmtALL->execute($arrPage);
$arrALL = $stmtALL->fetchAll();
?>



<table>
    <thead>
        <tr>
            <th>多選刪除</th>
            <th>產品類別</th> <!-- cat_id -->
            <th>產品編號</th> <!-- product_id -->
            <th>縮圖</th> <!-- product_img -->
            <th>產品名稱</th> <!-- product_name -->
            <th>產品TAG</th> <!-- product_tag -->
            <th>產品簡介</th> <!-- product_desc -->
            <th>產品租金</th> <!-- product_price -->
            <th>最後更新</th><!-- updated_at -->
            <th>編輯</th>
        </tr>
    </thead>
    <tbody>
        <form name="group" method="POST" action="pdelitemgroup.php">
            <?php for ($i = 0; $i < count($arrALL); $i++) {
            ?>
                <tr>
                    <td><input type="checkbox" class="ck" name="chk[]" value="<?php echo str_pad($arrALL[$i]['product_id'], 5, "0", STR_PAD_LEFT); ?>" /></td>
                    <td style="width:100px;"><?php echo $arrALL[$i]['cat_id'] . '-' . $arrALL[$i]['cat_name'] ?></td>
                    <td style="width:100px;"><?php echo $arrALL[$i]['product_id'] ?></td>
                    <td>
                        <a href="#" onclick="window.open(' ./images/<?php echo $arrALL[$i]['product_img'] ?> ', '預覽圖片', config='height=600,width=800');">
                            <img src="./images/<?php echo $arrALL[$i]['product_img'] ?>" style="max-width:200px;"></a>
                    </td>
                    <td><?php echo $arrALL[$i]['product_name'] ?></td>
                    <td><?php echo $arrALL[$i]['tagName'] ?></td>
                    <td style="width:300px;"><?php echo $arrALL[$i]['product_desc'] ?></td>
                    <td><?php echo $arrALL[$i]['product_price'] ?></td>
                    <td><?php echo date("Y-m-d", (strtotime($arrALL[$i]['updated_at']))) ?></td>
                    <td><a href="#" onclick="window.open(' ./pedititem.php?Pid=<?php echo $arrALL[$i]['product_id'] ?> ', '編輯', config='height=600,width=800');"> 編輯</a>
                        <a href="#" onclick="window.open(' ./pdelitem.php?Pid=<?php echo $arrALL[$i]['product_id'] ?> ', '刪除單筆資料', config='height=200,width=200');"> 刪除單筆</a>
                    </td>
                </tr>
            <?php }
            ?>
            <tr>
                <td>
                    <input type="submit" value="刪除多筆資料">
                </td>
            </tr>
        </form>
    </tbody>
    <tfoot>
        <tr>
            <td class="border" colspan="9">
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                <?php } ?>
            </td>
        </tr>
    </tfoot>
</table>