<?php
session_start();
session_destroy();
header("Refresh: 3; url=../index.php");

$objResponse['success'] = true;
$objResponse['info'] = "您已登出…3秒後自動回登入頁";
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
