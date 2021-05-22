<?php
require_once('./db.inc.php'); //引用資料庫連線

//將所有 id 透過「,」結合在一起，例如「1,2,3」
$strIds = join(",", $_POST['chk']);

//記錄資料表刪除數量
$count = 0;

//先查詢出所有 id 資料欄位中的大頭貼檔案名稱


//在這裡刪除資料表記錄
$sqlDelete = "DELETE FROM `cartOrder` WHERE FIND_IN_SET(`cartOrderId`, ?) ";
$stmtDelte = $pdo->prepare($sqlDelete);
$stmtDelte->execute([$strIds]);
$count = $stmtDelte->rowCount();
$sqlDeleteA = "DELETE FROM `cartitem` WHERE FIND_IN_SET(`cartOrderId`, ?)";
$stmtDelteA = $pdo->prepare($sqlDeleteA);
$stmtDelteA->execute([$strIds]);
$count = $stmtDelte->rowCount();


header("Refresh: 0.5; url=./cart.php");
if ($count > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}
