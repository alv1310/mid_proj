<?php
require_once './checkAdmin.php';
require_once '../db.inc.php';

$total = $pdo->query("SELECT COUNT(1) AS `count` FROM `articleList`")->fetchAll()[0]['count'];

$numPerPage = 3;
// 總頁數，ceil()為無條件進位
$totalPages = ceil($total / $numPerPage);

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;

//商品種類 SQL 敘述，取得商品種類總筆數
$totalCategories = $pdo->query("SELECT count(1) AS `count` FROM `aCategoryList`")->fetchAll()[0]['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章列表</title>

    <style>
        .border {
            border: 1px solid;
        }

        img.aImg {
            width: 250px;
        }

        .w300 {
            width: 20%;
        }

        .w007 {
            width: 7%;
        }

        .w005 {
            width: 5%;
        }
    </style>
</head>

<body>
    <?php require_once './templates/title.php'; ?>
    <hr>
    <div class="container">
        <h3 class="text-primary">文章列表</h3>
        <?php
        if ($totalCategories > 0) {
        ?>
            <form class="form-group" name="myForm" entype="multipart/form-data" method="POST" action="deleteIds.php">
                <table class="border table-striped">
                    <thead>
                        <tr>
                            <th class="border text-primary w005">選取</th>
                            <th class="border text-primary">標題</th>
                            <th class="border text-primary">文章類別</th>

                            <th class="border text-primary">作者</th>
                            <th class="border text-primary w300">內文</th>
                            <th class="border text-primary">文章配圖</th>
                            <th class="border text-primary">新增時間</th>
                            <th class="border text-primary">更新時間</th>
                            <th class="border text-primary w007">功能</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT `articleList`.`aId`, `articleList`.`aTitle`, `articleList`.`aImg`, `articleList`.`author`, `articleList`.`aContent`, `articleList`.`aCategoryId`, `articleList`.`created_at`, `articleList`.`updated_at`, `aCategoryList`.`aCatName` 
                            FROM `articleList` 
                            INNER JOIN `aCategoryList` 
                            ON `articleList`.`aCategoryId` = `aCategoryList`.`aCatId` 
                            ORDER BY `articleList`.`aId` 
                            ASC 
                            LIMIT ?, ? ";

                        $arrParam = [($page - 1) * $numPerPage, $numPerPage];

                        //查詢分頁後的商品資料
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);

                        //若數量大於 0，則列出商品
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll();
                            for ($i = 0; $i < count($arr); $i++) {
                        ?>
                                <tr>
                                    <td class="border">
                                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['aId']; ?>">
                                    </td>
                                    <td class="border "><?php echo $arr[$i]['aTitle']; ?></td>
                                    <td class="border"><?php echo $arr[$i]['aCatName']; ?></td>

                                    <td class="border"><?php echo $arr[$i]['author']; ?></td>
                                    <td class="border"><?php echo $arr[$i]['aContent']; ?></td>
                                    <td class="border"><img class="aImg" src="../../images/items/<?php echo $arr[$i]['aImg']; ?>" /></td>
                                    <td class="border"><?php echo $arr[$i]['created_at']; ?></td>
                                    <td class="border"><?php echo $arr[$i]['updated_at']; ?></td>
                                    <td class="border">

                                        <a class="btn btn-primary mx-2 my-2" href="./edit.php?page=<?php echo $page ?>&aId=<?php echo $arr[$i]['aId']; ?>" role="button">編輯</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="border" colspan="9">沒有資料</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="border px-2 py-2" colspan="9">
                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                    <?php
                                    for ($i = 1; $i <= $totalPages; $i++) { ?>
                                        <a class="btn btn-outline-primary" href="?page=<?php echo $i ?>" role="button"><?php echo $i ?></a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php if ($total > 0) { ?>
                            <tr>
                                <td class="border" colspan="9">
                                    <input class="btn btn-primary mx-2 my-2" type="submit" name="smb" value="刪除">
                                </td>
                            </tr>
                        <?php } ?>
                    </tfoot>
                </table>
            </form>
        <?php
        } else {
            echo "請先建立文章類別";
        }
        ?>
    </div>
</body>

</html>