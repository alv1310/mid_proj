<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";
// 若無填寫標籤名稱
if ($_POST['tagName'] == '') {
    // 跳轉回原始標籤更新頁 用嵌入的 $_POST["edittagId"] 帶回原本該項商品頁
    header("Refresh:1; url=./editATag.php?edittagId={$_POST["edittagId"]}");
    $objResponse['success'] = false;
    $objResponse['info'] = "請填寫標籤類別";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

header("Refresh: 3; url=./editATag.php?edittagId={$_POST["edittagId"]}");

// 更新標籤名稱
$sql = "UPDATE `aTagList` SET `tagName` = ? WHERE `tagId` = ? ";
$arrParam = [$_POST['tagName'], (int)$_POST["edittagId"]];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
