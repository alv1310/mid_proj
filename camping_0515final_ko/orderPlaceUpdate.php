<?php
require_once './db.inc.php'; //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";


//SQL 語法
$sql = "UPDATE `orderplaceprice` SET 
        `campingPlaceArea` = ? , 
        `campingPlaceType` = ? , 
        `campingPlaceSize` = ? ,
        `tentQty` = ? ,
        `weekdaysPrice` = ? ,
        `holidayPrice` = ? ,
        `continuousPrice` = ? 
        WHERE `campingAreaId` = ? ";


$arrParam = [
    $_POST['campingPlaceArea'],
    $_POST['campingPlaceType'],
    $_POST['campingPlaceSize'],
    $_POST['tentQty'],
    $_POST['weekdaysPrice'],
    $_POST['holidayPrice'],
    $_POST['continuousPrice'],
    (int)$_POST['campingAreaId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

$page = (int)$_POST['page'];
header("Refresh: 2; url=./orderPlaceIndex.php?page=$page");

if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
