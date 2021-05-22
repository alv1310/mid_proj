<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

header("Refresh: 2; url=./atag.php");

if (isset($_GET['deletetagId'])) {
    $sql = "DELETE FROM `aTagList` WHERE `tagId` = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$_GET['deletetagId']]);
    if ($stmt->rowCount() > 0) {
        $objResponse['success'] = true;
        $objResponse['info'] = "刪除成功";
    }
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
