<?php
require_once('./db.inc.php'); //引用資料庫連線
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";

$sql = "UPDATE `cartOrder`
        SET
        `cartDescription` = ?,
        `nNN` = ?, 
        `nAA` = ?,
        `nCC` = ?,
        `cartStatus` = ? ";
$arrParam = [
    $_POST['cartDescription'],
    $_POST['nNN'],
    $_POST['nAA'],
    $_POST['nCC'],
    $_POST['cartStatus']
];

$sql .= "WHERE `cartOrderId` = ? ";
$arrParam[] = (int)$_POST['cartOrderId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

$page = (int)$_POST['page'];

header("Refresh: 0.5; url=./cart.php?page=$page");

// header("Refresh: 4; location.href=./index.php?page=$_GET[$page]");


if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
