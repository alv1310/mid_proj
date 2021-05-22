<?php
session_start();
require_once './db.inc.php'; //引用資料庫連線

//預設訊息
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";

//若沒填寫商品種類時的行為
if ($_POST['campingPlaceName'] == '') {
    header("Refresh: 2; url=./orderPlaceIndex.php");
    $objResponse['success'] = false;
    $objResponse['info'] = "請填寫營區名稱";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

$arrParam = [];

$sql = "UPDATE `ordercampingplace` SET";
$sql .= " `campingPlaceName` = ? ";
$arrParam[] = $_POST['campingPlaceName'];


if ($_FILES["campingPlaceImg"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "campingPlace_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["campingPlaceImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $strDatetime . "." . $extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    $isSuccess = move_uploaded_file($_FILES["campingPlaceImg"]["tmp_name"], "./images/" . $imgFileName);

    if ($isSuccess) {
        //先查詢出特定 id (itemId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `campingPlaceImg` FROM `ordercampingplace` WHERE `campingPlaceId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST["editCampingPlaceId"]
        ];
        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 itemImg 的資料
        if ($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll()[0];

            //若是 itemImg 裡面不為空值，代表過去有上傳過
            if ($arrImg['campingPlaceImg'] !== NULL) {
                //刪除實體檔案
                @unlink("./images/" . $arrImg['campingPlaceImg']);
            }
            $sql .= " , `campingPlaceImg` = ? ";
            $arrParam[] = $imgFileName;
        }
    }
}


$sql .= " WHERE `campingPlaceId` = ?";
$arrParam[] = (int)$_POST["editCampingPlaceId"];

$stmt = $pdo->prepare($sql);

$stmt->execute($arrParam);


header("Refresh: 3; url=./orderPlaceIndex.php");

if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
