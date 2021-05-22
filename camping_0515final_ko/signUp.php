<?php
session_start();
require_once './db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = '尚未填寫完成';


if ($_POST["email"]  == "" || $_POST["password"] == "") {
    header("Refresh: 3; url=./register.php");
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

if ($_POST["password"] !== $_POST["pwdAgain"]) {
    header("Refresh: 3; url=./register.php");
    $_POST["password"] . "<br>";
    $_POST["pwdAgain"] . "<br>";
    $objResponse['info'] = '密碼不一致';
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}


$sql = "INSERT INTO `member`(`email`,`password`) 
        VALUES (?,?)";
$arrParam = [
    $_POST["email"],
    sha1($_POST["password"])
];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = '註冊成功';
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    header("Refresh: 1.5; url=./login.php");
} else {
    $objResponse['info'] = '註冊失敗';
    json_encode($objResponse, JSON_UNESCAPED_UNICODE);
}
