<?php
session_start();
unset($_SESSION['cart']);
header("Refresh: 2; url=./close.php");
echo ('購物車已清空。請重新整理網頁');
