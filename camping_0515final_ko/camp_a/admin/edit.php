<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';
?>
<!-- 文章列表中的編輯頁面 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯文章</title>
    <style>
        .border {
            border: 1px solid;
        }

        img.aImg {
            width: 250px;
        }

        .w300 {
            width: 300px;
        }
    </style>
</head>

<?php require_once './templates/title.php'; ?>
<hr>
<div class="container">
    <h3 class="text-primary">編輯文章</h3>

    <form class="form-group" name="myForm" enctype="multipart/form-data" method="POST" action="update.php">

        <?php
        //SQL 敘述
        $sql = "SELECT `articleList`.`aId`, `articleList`.`aTitle`, `articleList`.`aImg`, `articleList`.`author`, `articleList`.`aContent`, `articleList`.`aCategoryId`, `articleList`.`created_at`, `articleList`.`updated_at`,
                        `aCategoryList`.`aCatId`, `aCategoryList`.`aCatName`
                FROM `articleList` INNER JOIN `aCategoryList`
                ON `articleList`.`aCategoryId` = `aCategoryList`.`aCatId`
                WHERE `aId` = ? ";

        $arrParam = [
            (int)$_GET['aId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if ($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll()[0];
        ?>
            <input type="text" hidden name="page" value="<?php echo $_GET['page'] ?>">
            <div class="form-group">
                <label for="" class="text-secondary">文章標題</label>
                <input class="form-control" type="text" name="aTitle" value="<?php echo $arr['aTitle'] ?>" maxlength="100">
            </div>

            <div class="form-group">
                <label for="" class="text-secondary">文章類別</label>
                <select class="form-control" name="aCategoryId">
                    <option value="<?php echo $arr['aCatId']; ?>"><?php echo $arr['aCatName'] ?></option>
                    <?php
                    //顯示所有文章類別
                    $sqlCategory = "SELECT `aCatId`, `aCatName` FROM `aCategoryList`";
                    $stmtCategory = $pdo->query($sqlCategory);
                    if ($stmtCategory->rowCount() > 0) {
                        $arrCategory = $stmtCategory->fetchAll();
                        for ($j = 0; $j < count($arrCategory); $j++) {
                    ?>
                            <option value="<?php echo $arrCategory[$j]['aCatId'] ?>"><?php echo $arrCategory[$j]['aCatName'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="" class="text-secondary">作者</label>
                <input class="form-control" type="text" name="author" value="<?php echo $arr['author'] ?>" maxlength="30">
            </div>

            <div class="form-group">
                <label for="" class="text-secondary">內文</label><textarea class="form-control" name="aContent" id="" rows="10" maxlength="2000"><?php echo $arr['aContent'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="" class="text-secondary">文章配圖</label>
                <div>
                    <img class="aImg" src="../../images/items/<?php echo $arr['aImg'] ?>" /><br />
                </div>
                <input type="file" class="form-control-file my-2" name="aImg" value="" />

            </div>

            <div class="form-group">
                <label for="" class="text-secondary">新增時間</label>
                <input class="form-control" type="text" name="author" value="<?php echo $arr['created_at'] ?> " maxlength="30" disabled>
            </div>

            <div class="form-group">
                <label for="" class="text-secondary">更新時間</label>
                <input class="form-control" type="text" name="author" value="<?php echo $arr['updated_at'] ?>" maxlength="30" disabled>
            </div>

            <div class="form-group">
                <input class="btn btn-primary mx-2 my-2" type="submit" name="smb" value="新增">
            </div>

        <?php } else { ?>
            <div>沒有資料</div>
        <?php } ?>

        <input type="hidden" name="aId" value="<?php echo (int)$_GET['aId']; ?>">


    </form>
</div>

<body>

</body>

</html>