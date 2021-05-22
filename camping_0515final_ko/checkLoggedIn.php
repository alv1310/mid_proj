<?php
if(isset($_SESSION['email']) && ($_SESSION['email'] != "")){
    if($_SESSION['identity'] == "users"){
        echo "已經登入，將跳往首頁";
        header("Refresh: 1 ;url=./index.php");
        exit();
    }else{
        echo "已登入，將跳往管理員頁面";
        header("Refresh: 1 ;url=./admin/admin.php");
        exit();
    }
}