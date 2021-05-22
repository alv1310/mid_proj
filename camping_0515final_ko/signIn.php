<?php
session_start();
require_once('./db.inc.php');

$objResponse['success'] = false;
$objResponse['info'] = "登入失敗";

if (isset($_POST['email']) && isset($_POST['password'])) {
    switch ($_POST['identity']) {
        case 'admin':
            //管理員
            $sql = "SELECT `email`, `password`
                    FROM `admin` 
                    WHERE `email` = ? 
                    AND `password` = ? ";
            break;
        case 'users':
            //一般會員
            $sql = "SELECT `email`, `password`, `name`
                    FROM `member`
                    WHERE `email` = ? 
                    AND `password` = ? 
                    AND `isActivated` = 1 ";
            break;
    }

    $arrParam = [
        $_POST['email'],
        sha1($_POST['password'])
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if ($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll()[0];

        if ($_POST['identity'] === 'admin')
            header("Refresh: 3; url=./admin/admin.php");
        elseif ($_POST['identity'] === 'users')
            header("Refresh: 3; url=./index.php");


        $_SESSION['email'] = $arr['email'];
        $_SESSION['identity'] = $_POST['identity'];

        $objResponse['success'] = true;
        $objResponse['info'] = "登入成功!!! 權限為「{$_SESSION['identity']}」，3秒後自動進入頁面";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        exit();
    }
    header("Refresh: 3; url=./login.php");
    $objResponse['info'] = "登入失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
} else {
    header("Refresh: 3; url=./login.php");
    $objResponse['info'] = "請確實登入";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
}
