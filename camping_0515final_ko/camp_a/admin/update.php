<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//回傳狀態
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "沒有任何更新";

//用在繫結 SQL 用的陣列
$arrParam = [];

//SQL 語法
$sql = "UPDATE `articleList` SET ";

//aTitle SQL 語句和資料繫結
$sql .= "`aTitle` = ? ,";
$arrParam[] = $_POST['aTitle'];

if ($_FILES["aImg"]["error"] === 0) {
    //為上傳檔案命名
    $strDatetime = "item_" . date("YmdHis");

    //找出副檔名
    $extension = pathinfo($_FILES["aImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $aImg = $strDatetime . "." . $extension;

    //若上傳成功 (有夾帶檔案上傳)，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    $isSuccess = move_uploaded_file($_FILES["aImg"]["tmp_name"], "../../images/items/{$aImg}");

    if ($isSuccess) {
        //先查詢出特定 id (aId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `aImg` FROM `articleList` WHERE `aId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            (int)$_POST['aId']
        ];

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 aImg 的資料
        if ($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的商品資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll()[0];

            //若是 aImg 裡面不為空值，代表過去有上傳過
            if ($arrImg['aImg'] !== NULL) {
                //刪除實體檔案
                @unlink("../../images/items/" . $arrImg['aImg']);
            }

            //aImg SQL 語句字串
            $sql .= "`aImg` = ? ,";

            //僅對 aImg 進行資料繫結
            $arrParam[] = $aImg;
        }
    }
}

//itemPrice SQL 語句和資料繫結
$sql .= "`author` = ? , 
        `aContent` = ? , 
        `aCategoryId` = ? 
        WHERE `aId` = ? ";
$arrParam[] = $_POST['author'];
$arrParam[] = $_POST['aContent'];
$arrParam[] = $_POST['aCategoryId'];
$arrParam[] = (int)$_POST['aId'];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


// header("Refresh: 3; url=./edit.php?aId={$_POST['aId']}");
// header("Refresh: 3; url=./admin.php");
// header("Refresh: 3; url=./admin.php?page={$_POST[""]}");

// 使用POST得到 edit.php 中的hidden input帶的 name='page' 與 value="$_GET['page']"
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
header("Refresh: .5; url=./admin.php?page=$page");


if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "更新成功";
    $objResponse['page'] = $_POST['page'];
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
