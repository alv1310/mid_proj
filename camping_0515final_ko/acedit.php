<?php
require_once('./db.inc.php'); //引用資料庫連線
require_once './templates/tittle_admin.php';
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的 PHP 程式</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
    .border {
        border: 1px solid;
    }
    .w200px {
        width: 200px;
    }
    </style>
</head>
<body>
這裡是後端管理頁面 - <a href="./acadmin.php">活動列表</a> | <a href="./acnew.php">新增頁面</a> 
<hr />
<form name="myForm" method="POST" action="acupdateEdit.php" enctype="multipart/form-data">
    <table class="border">
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `acid`, `acname`, `acregion`, `acprice`, `acearliestday`                   
                FROM `activities`  
                WHERE `acid` = ?";

        //設定繫結值
        $arrParam = [
            (int)$_GET['id']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll()[0];
        ?>
            <tr>
                <td class="border">名稱</td>
                <td class="border">
                    <input type="text" name="acname" value="<?php echo $arr['acname']; ?>" maxlength="90" />
                </td>
            </tr>
            <tr>
                <td class="border">地區</td>
                <td class="border">
                    <input type="text" name="acregion" value="<?php echo $arr['acregion'] ?>" maxlength="100" />
                </td>
            </tr>
            <tr>
                <td class="border">價格</td>
                <td class="border">
                    <input type="text" name="acprice" value="<?php echo $arr['acprice'] ?>" maxlength="100" />
                </td>
            </tr>    
            <tr>
                <td class="border">最早預定時間</td>
                <td class="border">
                    <input type="text" name="acearliestday" value="<?php echo $arr['acearliestday'] ?>" maxlength="100" />
                </td>
            </tr>            
                    
            
        <?php
        } else {
        ?>
            <tr>
                <td class="border" colspan="6">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
            <td class="border" colspan="6"><input type="submit" name="smb" value="修改"></td>
            </tr>
        </tfoo>
    </table>
    <input type="hidden" name="acid" value="<?php echo (int)$_GET['id'] ?>">
</form>
</body>
</html>