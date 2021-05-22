<?php
require_once('./db.inc.php'); //引用資料庫連線

//將所有 id 透過「,」結合在一起，例如「1,2,3」
$strIds = join(",", $_POST['chk']);

//記錄資料表刪除數量
$count = 0;


//在這裡刪除資料表記錄
$sqlDelete = "DELETE FROM `activities` WHERE FIND_IN_SET(`acid`, ?) ";
$stmtDelte = $pdo->prepare($sqlDelete);
$stmtDelte->execute([$strIds]);
$count = $stmtDelte->rowCount();

header("Refresh: 1; url=./acadmin.php");
if ($count > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}
