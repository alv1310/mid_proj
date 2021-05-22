<?php
session_start();
require_once './db.inc.php'; //引用資料庫連線

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

header("Refresh: 2; url=./orderPlaceIndex.php");

$strIds = $_GET['deleteCampingPlaceId'];

$sql = "SELECT `orderPlaceId` FROM `orderplaceprice` WHERE `orderPlaceId` = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([(int)$_GET['deleteCampingPlaceId']]);
if ($stmt->rowCount() > 0) {
    $objResponse['info'] = "營區區域還有資料，不可刪除";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

$sqlGetImg = "SELECT `campingPlaceImg` FROM `ordercampingplace` WHERE FIND_IN_SET(`campingPlaceId`, ?) ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$stmtGetImg->execute([$strIds]);
if ($stmtGetImg->rowCount() > 0) {
    //取得所有大頭貼檔案名稱
    $arrImg = $stmtGetImg->fetchAll();

    //各別刪除大頭貼實際檔案
    for ($i = 0; $i < count($arrImg); $i++) {
        //若是 itemImg 裡面不為空值，代表過去有上傳過
        if ($arrImg[$i]['campingPlaceImg'] !== NULL) {
            //刪除實體檔案
            @unlink("./images/" . $arrImg[$i]['campingPlaceImg']);
        }
    }
}

if (isset($_GET['deleteCampingPlaceId'])) {
    $sql = "DELETE FROM `ordercampingplace` WHERE `campingPlaceId` = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$_GET['deleteCampingPlaceId']]);
    if ($stmt->rowCount() > 0) {
        $objResponse['success'] = true;
        $objResponse['info'] = "刪除成功";
    }
}



echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
