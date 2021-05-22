<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';


$sql = "UPDATE `member` 
        SET 
        `email` = ?,
        `name` = ?,
        `phone` = ?,
        `address` = ?
        WHERE `mId` = ? 
        " ;

$arrParam = [
    $_POST['email'],
    $_POST['name'],
    $_POST['phone'],
    $_POST['address']
];
$arrParam[] = (int)$_POST['mId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

header("Refresh: 1; url=./admin.php");

if( $stmt->rowCount() > 0 ){
    echo "更新成功";
} else {
    echo "沒有任何更新";
}