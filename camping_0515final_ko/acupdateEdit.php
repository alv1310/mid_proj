<?php
require_once('./db.inc.php'); //引用資料庫連線


//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `activities` 
        SET 
        `acname` = ?,
        `acregion` = ?, 
        `acprice` = ?, 
        `acearliestday` = ?  
        WHERE `acid` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['acname'],
    $_POST['acregion'],
    $_POST['acprice'],
    $_POST['acearliestday']
];

//SQL 結尾
// $sql.= "WHERE `id` = ?";
$arrParam[] = (int)$_POST['acid'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

header("Refresh: 1; url=./acadmin.php");

if( $stmt->rowCount() > 0 ){
    echo "更新成功";
} else {
    echo "沒有任何更新";
}