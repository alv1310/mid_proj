<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增標籤失敗";

if ($_POST['tagName'] == '') {
    header("Refresh: 1; url=./atag.php");
    $objResponse['info'] = "請填寫標籤名稱";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

header("Refresh: 2; url=./atag.php");

$sql = "INSERT INTO `aTagList` (`tagName`) VALUES (?)";
$stmt = $pdo->prepare($sql);
$arrParam = [$_POST['tagName']];
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "新增標籤成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
