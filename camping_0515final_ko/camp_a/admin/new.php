<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

$totalCategories = $pdo->query("SELECT count(1) AS `count` FROM `aCategoryList`")->fetchAll()[0]['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增文章</title>
    <style>
        .border {
            border: 1px solid;
        }

        img.aImg {
            width: 250px;
        }
    </style>
</head>

<body>
    <?php require_once './templates/title.php' ?>
    <hr>
    <div class="container">
        <h3 class="text-primary">新增文章</h3>
        <?php
        if ($totalCategories > 0) {
        ?>

            <form name="myForm" method="POST" enctype="multipart/form-data" action="add.php" class="form-group py-2 px-2">

                <div class="form-group">
                    <label for="" class="text-secondary">文章標題</label>
                    <input class="form-control" type="text" name="aTitle" value="" maxlength="100">
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">文章類別</label>
                    <select class="form-control" name="aCategoryId" id="">
                        <?php
                        //SQL 敘述
                        //顯示所有商品種類
                        $sql = "SELECT `aCatId`, `aCatName` FROM `aCategoryList` ";
                        $stmt = $pdo->query($sql);
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll();
                            for ($i = 0; $i < count($arr); $i++) {
                        ?>
                                <option value="<?php echo $arr[$i]['aCatId'] ?>"><?php echo $arr[$i]['aCatName'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">作者</label>
                    <input class="form-control" type="text" name="author" value="" maxlength="30">
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">內文</label>
                    <textarea class="form-control" name="aContent" id="" rows="10" maxlength="2000"></textarea>
                </div>

                <div class="form-group">
                    <label for="" class="text-secondary">文章配圖</label>
                    <input type="file" class="form-control-file" name="aImg" value="" />
                    <!-- <input type="file" id=""> -->
                </div>

                <div class="form-group">
                    <input class="btn btn-primary my-2" type="submit" name="smb" value="新增">
                </div>

            </form>

        <?php
        } else {
            echo "請先建立文章類別";
        }
        ?>

    </div>
</body>

</html>