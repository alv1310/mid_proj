<?php
require_once('./db.inc.php'); //引用資料庫連線

//SQL 語法
$sql = "DELETE FROM `activities` WHERE `acid` = ? ";

//加入繫結陣列
$arrParam = [
    (int)$_GET['id']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

header("Refresh: 1; url=./acadmin.php");

if($stmt->rowCount() > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}