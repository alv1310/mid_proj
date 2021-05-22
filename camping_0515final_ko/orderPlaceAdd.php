<?php
session_start();
require_once './db.inc.php';

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增露營場地失敗";

$sql = "INSERT INTO `ordercampingplace`";

if ($_POST['campingPlaceName'] == '') {
    header("Refresh: 2; url=./orderPlaceIndex.php");
    $objResponse['info'] = "請填露營場地";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

$arrParam[] = $_POST['campingPlaceName'];

if ($_FILES["campingPlaceImg"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "campingPlace_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["campingPlaceImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $strDatetime . "." . $extension;

    //移動暫存檔案到實際存放位置
    $isSuccess = move_uploaded_file($_FILES["campingPlaceImg"]["tmp_name"], "./images/" . $imgFileName);

    //若上傳失敗，則不會繼續往下執行，回到管理頁面
    if (!$isSuccess) {
        header("Refresh: 2; url=./orderPlaceIndex.php");
        $objResponse['info'] = "圖片上傳失敗";
        exit();
    }

    $arrParam[] = $imgFileName;
}
header("Refresh: 2; url=./orderPlaceIndex.php");

// $sql .= "(`campingPlaceName`,"

if ($_FILES["campingPlaceImg"]["error"] === 0) {
    $sql .= "(`campingPlaceName`,`campingPlaceImg`) VALUES (?, ?)";
} else {
    $sql .= "(`campingPlaceName`) VALUES (?)";
}

// $sql = "INSERT INTO `ordercampingplace` (`campingPlaceName`,`campingPlaceImg`) VALUES (?, ?)";

$stmt = $pdo->prepare($sql);
// $arrParam = [$_POST['campingPlaceName'], $imgFileName];
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {

    $objResponse['success'] = true;
    $objResponse['info'] = "新增露營場地成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
