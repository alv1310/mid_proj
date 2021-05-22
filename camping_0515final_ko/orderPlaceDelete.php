<?php
session_start();
require_once './db.inc.php'; //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

//將所有 id 透過「,」結合在一起，例如「1,2,3」
$strIds = join(",", $_POST['chk']);

//記錄資料表刪除數量
$count = 0;

//在這裡刪除資料表記錄
$sqlDelete = "DELETE FROM `orderplaceprice` 
    WHERE FIND_IN_SET(`campingAreaId`, ?) ";
$stmtDelte = $pdo->prepare($sqlDelete);
$stmtDelte->execute([$strIds]);
$count = $stmtDelte->rowCount();


header("Refresh: 2; url=./orderPlaceIndex.php");

//累計每次刪除的次數大於0，代表刪除成功
if ($count > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
