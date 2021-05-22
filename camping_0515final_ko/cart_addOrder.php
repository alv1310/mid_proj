<?php
session_start();

require_once('./db.inc.php');

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = '訂單新增失敗';

//新增商品明細成功的數量
$count = 0;


//用戶明細
$sqlitem = "INSERT INTO `cartitem`
                    (`cartOrderId`, `product_id`, `cartName`,
                    `cartBuyQty`,`cartBuyP`)
                    VALUES (?,?,?,?,?)";
$stmtitem = $pdo->prepare($sqlitem);
for ($i = 0; $i < count($_POST['product_id']); $i++) {
    $arrParamItemList = [
        date('YmdHis'),
        (int)$_POST['product_id'][$i],
        $_POST['product_name'][$i],
        (int)$_POST['cartQty'][$i],
        (int)$_POST['product_price'][$i]
    ];
    $stmtitem->execute($arrParamItemList);
    $count += $stmtitem->rowCount();
}



$sql = "INSERT INTO `cartorder`
                    (`nNN`, `nAA`, `nCC`,
                    `cartPayId`,`cartLogisticsId`,`cartOrderId`,`mid`,`cartTotal`,`cartDescription`,`cartStatus`)
                    VALUES (?,?,?,?,?,?,?,?,?,?)";

//繫結用陣列
$arr = [
    $_POST['nNN'],
    $_POST['nAA'],
    $_POST['nCC'],
    $_POST['cartPayId'],
    $_POST['cartLogisticsId'],
    date('YmdHis'),
    '1',
    $_POST['total'],
    $_POST['cartDescription'],
    $_POST['cartStatus']

];
$stmt = $pdo->prepare($sql);
$stmt->execute($arr);
header("Refresh: 0.5; url=./cart.php");
if ($count > 0) {
    unset($_SESSION["cart"]);
    $objResponse['success'] = true;
    $objResponse['info'] = "訂單新增成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
