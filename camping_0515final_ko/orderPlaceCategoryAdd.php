<?php
session_start();
require_once './db.inc.php';

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增失敗";


$sql = "INSERT INTO `orderplaceprice` (`campingPlaceArea`, `campingPlaceType`, `campingPlaceSize`, `tentQty`, `weekdaysPrice`, `holidayPrice`, `continuousPrice`,`orderPlaceId`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$arrParam = [
    $_POST['campingPlaceArea'],
    $_POST['campingPlaceType'],
    $_POST['campingPlaceSize'],
    $_POST['tentQty'],
    $_POST['weekdaysPrice'],
    $_POST['holidayPrice'],
    $_POST['continuousPrice'],
    $_POST['campingPlaceId']
];

$stmt = $pdo->prepare($sql);

$stmt->execute($arrParam);

header("Refresh: 2; url=./orderPlaceIndex.php");

if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "新增成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
