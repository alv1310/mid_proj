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
    <title>文章類別</title>
    <style>
        .border {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <?php require_once('./templates/title.php'); ?>
    <hr>
    <div class="container">

        <form class="form-group" name="myForm" method="POST" action="./insertCategory.php">
            <h3 class="text-primary">文章類別</h3>

            <ul class="border">
                <?php
                $sql = "SELECT `aCatId`, `aCatName` FROM `aCategoryList`";
                $stmt = $pdo->query($sql);
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                    for ($i = 0; $i < count($arr); $i++) {
                ?>
                        <li class="text-secondary">
                            <?php echo $arr[$i]['aCatName'] ?>

                            <a class="btn btn-outline-primary mx-2 my-2" href="./editCategory.php?editaCatId=<?php echo $arr[$i]['aCatId'] ?>">編輯</a>
                            <a class="btn btn-outline-primary mx-2 my-2" href="./deleteCategory.php?deleteaCatId=<?php echo $arr[$i]['aCatId'] ?>">刪除</a>
                        </li>
                <?php  }
                } ?>
            </ul>
            <label for="insertCategory">
                <h3 class="text-primary">新增類別</h3>
            </label>
            <form>
                <div class="form-group border px-2 py-2">


                    <input class="form-control mr-2 my-2" type="text" placeholder="新增類別名稱" name="aCatName" value="" maxlength="100">

                    <input class="btn btn-primary mr-2 my-2" type="submit" name="smb" value="新增">
                </div>
            </form>
        </form>


    </div>
</body>

</html>