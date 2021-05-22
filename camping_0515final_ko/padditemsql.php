<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>SQL作動中[新增]</title>
</head>
<?php

require_once('./db.inc.php');

$sqlAddPL = "INSERT INTO `productlist` (`cat_id`, `product_id`, `product_name`, `product_desc`, `product_img`, `tag_id`, `product_price`) VALUES (?,?,?,?,?,?,?) ";

// $sqlAddIF = "INSERT INTO `productinfo` (`cat_id`, `product_id`, `product_mtr`, `product_pack`, `product_cid`, `product_packsize`, `product_fullsize`, `product_weight`, `product_person`, `tag_id`) VALUES (?,?,?,?,?,?,?,?,?,?)";

$sqlAddTag = "INSERT INTO `atagmap` (`tagId`,`pId`,obj) VALUES (?,?,?) ";

if ($_FILES["product_img"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = date("YmdHis") + $_REQUEST['Pid'];

    //找出副檔名
    $extension = pathinfo($_FILES["product_img"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $strDatetime . "." . $extension;

    //移動暫存檔案到實際存放位置
    $isSuccess = move_uploaded_file($_FILES["product_img"]["tmp_name"], "./images/" . $imgFileName);

    //若上傳失敗，則不會繼續往下執行，回到管理頁面
    if (!$isSuccess) {
        header("Refresh: 3; url=./padditem.php");
        echo "圖片上傳失敗";
        exit();
    }
}

if ($imgFileName == null) {
    $imgFileName = "noimage.jpg";
}

$dataAddPL = [
    $_REQUEST['category'],
    $_REQUEST['Pid'],
    $_REQUEST['product_name'],
    $_REQUEST['product_desc'],
    $imgFileName,
    $_REQUEST['product_tag'],
    $_REQUEST['product_price']
];

$dataAddTag = [
    $_REQUEST['product_tag'], $_REQUEST['Pid'], '2'
];
$stmtAddPL = $pdo->prepare($sqlAddPL);
$stmtAddPL->execute($dataAddPL);
$stmtAddTag = $pdo->prepare($sqlAddTag);
$stmtAddTag->execute($dataAddTag);

if ($stmtAddPL->rowCount() > 0) {
    header("Refresh: 1; url=./templates/close.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./padditem.php");
    echo "新增失敗，請與系統管理者聯繫。";
}
