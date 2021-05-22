<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

$strIds = join(",", $_POST['chk']);

$count = 0;

$sqlGetImg = "SELECT `aImg` FROM `articleList` WHERE FIND_IN_SET(`aId`, ?) ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$stmtGetImg->execute([$strIds]);
if ($stmtGetImg->rowCount() > 0) {
    $arrImg = $stmtGetImg->fetchAll();
    for ($i = 0; $i < count($arrImg); $i++) {
        if ($arrImg[$i]['aImg'] !== NULL) {
            @unlink("../../images/items/" . $arrImg[$i]['aImg']);
        }
    }

    // 進行刪除資料表紀錄
    $sqlDelete = "DELETE FROM `articleList` WHERE FIND_IN_SET(`aId`, ?)";
    $stmtDelete = $pdo->prepare($sqlDelete);
    $stmtDelete->execute([$strIds]);
    $count = $stmtDelete->rowCount();
}

header("Refresh: 2; url=./admin.php");

if ($count > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);

//