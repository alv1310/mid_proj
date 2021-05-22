<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>SQL作動中[刪除單筆]</title>
</head>
<?php


require_once('./db.inc.php');

$sqlGetImg = "SELECT `product_img` FROM `productlist` WHERE `product_id` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$arrGetImgParam = [(int)$_REQUEST['Pid']];
$stmtGetImg->execute($arrGetImgParam);

//若有找到 studentImg 的資料
if ($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll()[0];

    //若是 studentImg 裡面不為空值，代表過去有上傳過
    if ($arrImg['product_img'] !== NULL) {

        if ($arrImg['product_img'] !== "noimage.jpg") {
            //刪除實體檔案
            @unlink("./images/" . $arrImg['product_img']);
        }
    }
}
//SQL 語法
$sqlDel = "DELETE FROM `productlist` WHERE `product_id` = ? ";
$sqlDelTag = "DELETE FROM `atagmap` WHERE `pId` = ? ";

$stmt = $pdo->prepare($sqlDel);
$stmtTag = $pdo->prepare($sqlDelTag);
$stmt->execute($arrGetImgParam);
$stmtTag->execute($arrGetImgParam);

header("Refresh: 1; url=./templates/close.php");

if ($stmt->rowCount() > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}
