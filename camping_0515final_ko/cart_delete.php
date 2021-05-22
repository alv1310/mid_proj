<?php
// require_once './checkSession.php';
require_once 'db.inc.php';

//先查詢出特定id (editId)資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `cartOrder`.`cartOrderId`,`cartitem`.`cartOrderId` FROM `cartOrder` INNER JOIN `cartitem` ON `cartOrder`.`cartOrderId`=`cartitem`.`cartOrderId` WHERE `cartOrder`.`cartOrderId` = ?";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入繫結陣列
$arrGetImgParam = [
    (int)$_GET['cartOrderId']
];
//執行sql語法
$stmtGetImg->execute($arrGetImgParam);

//若有找到studentImg的資料

$sqlA = "DELETE FROM `cartOrder` WHERE `cartOrderId` = ?";
$stmtA = $pdo->prepare($sqlA);
$sqlB = "DELETE FROM `cartitem` WHERE `cartOrderId` = ?";
$stmtB = $pdo->prepare($sqlB);

//加入繫結
$arrParam = [
    (int)$_GET['cartOrderId']
];
$stmtA->execute($arrParam);
$stmtB->execute($arrParam);

if ($stmtA->rowCount() > 0) {
    header("Refresh: 0.5;url=./cart.php");
    echo "刪除成功";
} else {
    header("Refresh:0.5; url=./cart.php");
    echo "刪除成功";
}
if ($stmtB->rowCount() > 0) {
    header("Refresh: 0.5;url=./cart.php");
    echo "刪除成功";
} else {
    header("Refresh:0.5; url=./cart.php");
    echo "刪除成功";
}
