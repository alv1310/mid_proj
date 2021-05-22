<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";
// 若無填寫商品種類名稱的行為
if ($_POST['aCatName'] == '') {
    // 跳轉回原始商品更新頁 用嵌入的 $_POST["editaCatId"] 帶回原本該項商品頁 來自editCategory.php 的 hidden input value 值
    header("Refresh: 1; url=./editCategory.php?editaCatId={$_POST["editaCatId"]}");
    $objResponse['success'] = false;
    $objResponse['info'] = "請填寫文章類別";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

header("Refresh: 3; url=./editCategory.php?editaCatId={$_POST["editaCatId"]}");

// 更新商品種類名稱
$sql = "UPDATE `aCategoryList` SET `aCatName` = ? WHERE `aCatId` = ? ";
$stmt = $pdo->prepare($sql);
$arrParam = [
    $_POST['aCatName'],
    (int)$_POST["editaCatId"]
];

$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
