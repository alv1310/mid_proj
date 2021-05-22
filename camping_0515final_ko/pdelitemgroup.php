<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>SQL作動中[刪除多筆]</title>
</head>
<?php

require_once('./db.inc.php');

$strIds = join(",", $_POST['chk']);
$count = 0;

$sqlGetImg = "SELECT `product_img` FROM `productlist` WHERE FIND_IN_SET(`product_id`, ?) ";
$stmtGetImg = $pdo->prepare($sqlGetImg);
$stmtGetImg->execute([$strIds]);

if ($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll();

    for ($i = 0; $i < count($arrImg); $i++) {
        //若是 studentImg 裡面不為空值，代表過去有上傳過
        if ($arrImg[$i]['product_img'] !== NULL) {

            if ($arrImg[$i]['product_img'] !== "noimage.jpg") {
                //刪除實體檔案
                @unlink("./images/" . $arrImg[$i]['product_img']);
            }
        }
    }
    $sqlDel = "DELETE FROM `productlist` WHERE FIND_IN_SET(`product_id`, ?) ";
    $sqlDelTag = "DELETE FROM `atagmap` WHERE `pId` = ? ";
    $stmtDel = $pdo->prepare($sqlDel);
    $stmtDelTag = $pdo->prepare($sqlDelTag);
    $stmtDel->execute([$strIds]);
    $stmtDelTag->execute([$strIds]);
    $count = $stmtDel->rowCount();
}

header("Refresh: 1; url=./productlist.php");
if ($count > 0) {
    echo "刪除成功";
} else {
    echo "刪除失敗";
}
