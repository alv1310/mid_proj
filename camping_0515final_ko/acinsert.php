<?php
// require_once('./checkSession.php'); //引入判斷是否登入機制
require_once('./db.inc.php'); //引用資料庫連線

//SQL 敘述
$sql = "INSERT INTO `activities` 
        (`acname`, `acregion`, `acprice`, `acearliestday`)
        VALUES (?, ?, ?, ? )";


//繫結用陣列
$arr = [
    $_POST['acname'],
    $_POST['acregion'],
    $_POST['acprice'],
    $_POST['acearliestday'],
];

$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);
if($pdo_stmt->rowCount() > 0) {
    header("Refresh: 1; url=./acadmin.php");
    echo "新增成功";
} else {
    header("Refresh: 1; url=./acadmin.php");
    echo "新增失敗";
}