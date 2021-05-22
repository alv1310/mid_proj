<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

header("Refresh: 2; url=./category.php");

if (isset($_GET['deleteaCatId'])) {
    $sql = "DELETE FROM `aCategoryList` WHERE `aCatId` = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$_GET['deleteaCatId']]);
    if ($stmt->rowCount() > 0) {
        $objResponse['success'] = true;
        $objResponse['info'] = "刪除成功";
    }
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
