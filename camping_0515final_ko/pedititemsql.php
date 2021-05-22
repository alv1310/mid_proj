<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>SQL作動中[編輯商品]</title>
</head>

<?php
require_once('./db.inc.php');

$sqlEdit = "UPDATE`productlist`
            SET `cat_id` = ?,
                `product_name` = ?,
                `product_desc` =?,
                `tag_id`=?,
                `product_price`=?";

$arrEdit = [
    $_REQUEST['category'],
    $_REQUEST['product_name'],
    $_REQUEST['product_desc'],
    $_REQUEST['tag_id'],
    $_REQUEST['product_price']
];





if ($_FILES["product_img"]["error"] === 0) {

    $strDatetime = date("YmdHis") + $_REQUEST['product_id'];

    $extension = pathinfo($_FILES["product_img"]["name"], PATHINFO_EXTENSION);

    $imgFileName = $strDatetime . "." . $extension;

    //移動暫存檔案到實際存放位置
    if (move_uploaded_file($_FILES["product_img"]["tmp_name"], "./images/" . $imgFileName)) {

        //刪除原檔案動作
        $sqlGetImg = "SELECT `product_img` FROM `productlist` WHERE `product_id` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);
        $arrGetImgParam = [
            (int)$_REQUEST['product_id']
        ];
        $stmtGetImg->execute($arrGetImgParam);
        if ($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll()[0];

            //若是 studentImg 裡面不為空值，代表過去有上傳過
            if ($arrImg['product_img'] !== NULL) {
                //刪除實體檔案
                @unlink("./images/" . $arrImg['product_img']);
            }


            $sqlEdit .= ",";

            //studentImg SQL 語句字串
            $sqlEdit .= "`product_img` = ? ";

            //僅對 studentImg 進行資料繫結
            $arrEdit[] = $imgFileName;
        }
    }
}


$sqlEdit .= " WHERE `product_id` = ? ";
$arrEdit[] = $_REQUEST['product_id'];
$arrTag = [$_REQUEST['tag_id'], $_REQUEST['product_id']];
$sqlTag = "UPDATE `atagmap` SET `tagId` = ? WHERE `pId` = ?";

$stmtEdit = $pdo->prepare($sqlEdit);
$stmtTag = $pdo->prepare($sqlTag);
$stmtEdit->execute($arrEdit);
$stmtTag->execute($arrTag);

if ($stmtEdit->rowCount() > 0) {
    header("Refresh: 1; url=./templates/close.php");
    echo "更新成功";
} else {
    header("Refresh: 3; url=./templates/close.php");
    echo "更新失敗，請與系統管理者聯繫。";
}
