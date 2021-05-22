<?php
require_once 'db.inc.php';
require_once './templates/tittle_admin.php';

//SQL 敘述: 取得資料表總筆數
$sqlTotal = "SELECT count(1) AS `count` FROM `activities`";

//執行 SQL 語法，並回傳、建立 PDOstatment 物件
$stmtTotal = $pdo->query($sqlTotal);

//查詢結果，取得第一筆資料(索引為 0)
$arrTotal = $stmtTotal->fetchAll()[0];

//資料表總筆數
$total = $arrTotal['count'];

/**
 * 上面的作法，可以直接寫成： 
 * $total = $pdo->query($sqlTotal)->fetchAll()[0]['count'];
 */

//每頁幾筆
$numPerPage = 5;

// 總頁數，ceil()為無條件進位
$totalPages = ceil($total / $numPerPage);

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;
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
        <form name="myForm" method="POST" action="acdeleteIds.php">
            <table class="border">
                <thead>
                    <tr>
                        <th class="border">選擇</th>
                        <th class="border">名稱</th>
                        <th class="border">地區</th>
                        <th class="border">價格</th>
                        <th class="border">最早預定時間</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //SQL 敘述
                    $sql = "SELECT `acid`, `acname`, `acregion`, `acprice`, `acearliestday`
                FROM `activities` 
                ORDER BY `acid` ASC 
                LIMIT ?, ? ";

                    //設定繫結值
                    $arrParam = [
                        ($page - 1) * $numPerPage,
                        $numPerPage
                    ];

                    //查詢分頁後的學生資料
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($arrParam);

                    //資料數量大於 0，則列出所有資料
                    if ($stmt->rowCount() > 0) {
                        $arr = $stmt->fetchAll();
                        for ($i = 0; $i < count($arr); $i++) {
                    ?>
                            <tr>
                                <td class="border">
                                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['acid'] ?>" />
                                </td>
                                <td class="border"><?php echo $arr[$i]['acname'] ?></td>
                                <td class="border"><?php echo $arr[$i]['acregion'] ?></td>
                                <td class="border"><?php echo $arr[$i]['acprice'] ?></td>
                                <td class="border"><?php echo $arr[$i]['acearliestday'] ?></td>
                                <td class="border">
                                    <a href="./acedit.php?id=<?php echo $arr[$i]['acid']; ?>">編輯</a>
                                    <a href="./acdelete.php?id=<?php echo $arr[$i]['acid']; ?>">刪除</a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="border" colspan="9">沒有資料</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border" colspan="9">
                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                            <?php } ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="submit" name="smb" value="刪除">
        </form>

    </body>

    </html>