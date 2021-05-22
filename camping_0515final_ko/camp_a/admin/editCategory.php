<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯文章類別</title>
    <style>
        .border {
            border: 1px solid;
        }

        img.aImg {
            width: 250px;
        }

        .w400 {
            width: 50%;
        }
    </style>
</head>

<body>

    <?php require_once './templates/title.php'; ?>
    <hr>

    <div class="container">
        <h3 class="text-primary">編輯文章類別</h3>

        <form class="form-group py-2 px-2" name="myForm" method="POST" action="updateCategory.php">

            <?php
            $sql = "SELECT `aCatId`, `aCatName`, `created_at`, `updated_at`
                    FROM `aCategoryList`
                    WHERE `aCatId` = ? ";
            $arrParam = [(int)$_GET['editaCatId']];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);
            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll()[0];
            ?>
                <div class="form-group">
                    <label for="" class="text-secondary">文章類別</label>
                    <input class="form-control my-2" type="text" name="aCatName" value="<?php echo $arr['aCatName']; ?>" maxlength="100">
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">新增時間</label>
                    <input class="form-control" type="text" name="created_at" value="<?php echo $arr['created_at'] ?> " maxlength="30" disabled>
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">更新時間</label>
                    <input class="form-control" type="text" name="updated_at" value="<?php echo $arr['updated_at'] ?>" maxlength="30" disabled>
                </div>

            <?php   } else { ?>
                <div>沒有資料</div>
            <?php } ?>

            <?php if ($stmt->rowCount() > 0) { ?>
                <td class="border" colspan="3">
                    <input class="btn btn-primary mx-2 my-2" type="submit" name="smb" value="更新">
                </td>
            <?php } ?>
            <!-- 原本網址中以GET形式顯示的 category id 在 form 表單會以POST形式傳送 所以將值存在下方 hidden input 的 value 中 才可用input hidden將這個值傳送到updateCategory.php中 -->
            <input type="hidden" name="editaCatId" value="<?php echo (int)$_GET['editaCatId']; ?>">

        </form>
    </div>

</body>

</html>