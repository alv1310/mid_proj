<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
// 新增類別頁中的 執行新增功能php
// 預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增商品失敗";

// 若未填寫商品種類時的行為
if ($_POST['aCatName'] == '') {
    header("Refresh: 1; url=./category.php");
    $objResponse['info'] = "請填寫商品種類";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

header("Refresh: 2; url=./category.php");

$sql = "INSERT INTO `aCategoryList` (`aCatName`) VALUES (?)";
$stmt = $pdo->prepare($sql);
$arrParam = [$_POST['aCatName']];
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
    //  若新增成功的行為    
    $objResponse['success'] = true;
    $objResponse['info'] = "新增文章類別成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
