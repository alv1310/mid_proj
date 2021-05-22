<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

echo "<pre>";
echo($_GET ['delete']);
$strmIds = [$_GET ['delete']];
print_r($strmIds)  ;
echo "</pre>";
// 測試是否傳送過來




$strmIds = $_GET ['delete'];
$count = 0;

$sqlDelete = "DELETE FROM `member` WHERE `mId` = ? ";
$stmtDelte = $pdo->prepare($sqlDelete);

$stmtDelte->execute([$strmIds]);
$count = $stmtDelte->rowCount();

header("Refresh: 3; url=./admin.php");
if($count > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}
