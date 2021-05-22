<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMO用新增項目</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <?php
    session_start();
    require_once('./db.inc.php'); ?>

    <?php
    for ($i = 0; $i < count($_REQUEST['itemid']); $i++) {

        if ((int)$_REQUEST['qty'][$i] > 0) {

            $_SESSION['cart'][] = [
                "product_id" => (int)$_REQUEST['itemid'][$i],
                "cartQty" => $_REQUEST['qty'][$i]
            ];
        } else {
            // echo "none";
        }
    }

    // print_r($_SESSION['cart']);
    echo "DEMO模式:新增購物車成功。";
    // unset($_SESSION['cart']);
    header("Refresh: 0.5; url=./cart.php");



    ?>