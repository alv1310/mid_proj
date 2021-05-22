<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMO用新增項目</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php require_once('./db.inc.php'); ?>
    <!-- 請先requireonce必要設定檔案(如db.inc.php) -->
    <!-- $_session['cart'] -->
    <!-- cartQty -->
    <?php
    session_start();
    $sqlList = "SELECT 
`productcategory`.`cat_name`,
`productlist`.`product_id`,
`productlist`.`product_name`,
`productlist`.`product_img`,
`productlist`.`qty`
FROM `productlist` INNER JOIN `productcategory` ON `productcategory`.`cat_id` = `productlist` .`cat_id`";

    $stmtList = $pdo->query($sqlList);
    $dataList = $stmtList->fetchall();

    ?>

    <table>
        <thead>
            <tr>
                <th>類別</th>
                <th>產品名稱</th>
                <th>縮圖</th>
                <th>選擇數量</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <form name="order" action="cart_addcartsql.php" method="POST">
                <?php
                for ($i = 0; $i < count($dataList); $i++) { ?>
                    <tr>
                        <td><?php echo $dataList[$i]['cat_name'] ?></td>
                        <td><?php echo $dataList[$i]['product_name'] ?></td>
                        <td><img src="./images/<?php echo $dataList[$i]['product_img'] ?>" style="width:100px;"></td>
                        <td>
                            <input type="hidden" name="itemid[]" value="<?php echo $dataList[$i]['product_id']; ?> ">
                            <input type="number" name="qty[]" placeholder="0" min="0" max="<?php echo $dataList[$i]['qty'] ?>">
                        </td>
                        <td></td>
                    </tr>

                <?php
                } ?>
                <tr>
                    <td> <input type="submit" value="送出訂單">
                    </td>
                </tr>
        </tbody>
        </form>

    </table>








</body>

</html>