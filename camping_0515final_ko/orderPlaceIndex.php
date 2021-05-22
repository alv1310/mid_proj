<?php
session_start();
require_once './db.inc.php';
require_once './templates/tittle_admin.php';

$sqlTotal = "SELECT count(1) AS `count` FROM `orderplaceprice`";
$stmtTotal = $pdo->query($sqlTotal);
$arrTotal = $stmtTotal->fetchAll()[0];
$total = $arrTotal['count'];

// $total = $pdo->query($sqlTotal)->fetchAll()[0]['count'];

$numPerPage = 5;
$totalPages = ceil($total / $numPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page < 1 ? 1 : $page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>預約場地</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <style>
        body {
            min-height: 100vh;
            background-color: #FFE53B;
            background-image: linear-gradient(147deg, #96c93d 0%, #00b09b 100%);
        }

        .border {
            border: 1px solid;
        }

        .w500px {
            width: 550px;
            height: 300px;
        }

        .btn-title {
            color: #fff;
            background-color: #f8b500;
            border-color: #f8b500;
        }

        .indexa {
            color: white;
        }

        .indexa:hover {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- 新增營區場地頭 -->
    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <h3>編輯營區場地</h3>

                <?php
                $sql = "SELECT `campingPlaceId`, `campingPlaceName`, `campingPlaceImg` FROM `ordercampingplace` ";
                $stmt = $pdo->query($sql);
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                ?>
                    <ul>

                        <?php for ($i = 0; $i < count($arr); $i++) { ?>
                            <li><?php echo $arr[$i]['campingPlaceName'] ?>
                                <a href="javascript:" type="button" data-toggle="modal" class="editChg" data-id1=<?= $arr[$i]['campingPlaceId'] ?>data-target="#exampleModalCenter3">修改</a>
                                | <a href="./orderPlaceCategoryDelete.php?deleteCampingPlaceId=<?php echo $arr[$i]['campingPlaceId'] ?>">刪除</a>
                            </li>
                        <?php } ?>

                    <?php } ?>

                    </ul>


                    <form name="myForm" enctype="multipart/form-data" method="POST" action="./orderPlaceAdd.php">
                        <table class="border">
                            <thead>
                                <tr>
                                    <th class="border">營區名稱</th>
                                    <th class="border">營區配置圖</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border">
                                        <input type="text" name="campingPlaceName" value="" maxlength="40" />
                                    </td>
                                    <td class="border">
                                        <input type="file" name="campingPlaceImg" value="" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="modal-footer">
                            <button type="submit" name="smb" class="btn btn-primary">新增</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </form>
            </div>
        </div>
    </div>
    </div>
    <!-- 新增營區場地尾 -->

    <!-- 新增營區修改頭 -->
    <div class="modal fade " id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <h3>編輯露營場地</h3>

                <form name="myForm" enctype="multipart/form-data" method="POST" action="orderPlaceCategoryUpdate.php">
                    <table class="border">
                        <thead>
                            <tr>
                                <th class="border">營區名稱</th>
                                <th class="border">營區配置圖</th>
                                <th class="border">新增時間</th>
                                <th class="border">更新時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT `campingPlaceId`, `campingPlaceName`, `campingPlaceImg`, `created_at`, `updated_at`
                         FROM  `ordercampingplace`
                        WHERE `campingPlaceId` = ? ";

                            $arrParam = [
                                (int)$_GET['editCampingPlaceId']
                            ];

                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($arrParam);

                            if ($stmt->rowCount() > 0) {
                                $arr = $stmt->fetchAll()[0];
                            ?>
                                <tr>
                                    <td class="border">
                                        <input type="text" name="campingPlaceName" value="<?php echo $arr['campingPlaceName']; ?>" maxlength="40" />
                                    </td>
                                    <td class="border">
                                        <?php if ($arr['campingPlaceImg'] !== NULL) { ?>
                                            <img class="w500px" src="./images/<?php echo $arr['campingPlaceImg'] ?>"><br>
                                            <input type="file" name="campingPlaceImg" value="" />
                                        <?php } ?>
                                    </td>
                                    <td class="border"><?php echo $arr['created_at']; ?></td>
                                    <td class="border"><?php echo $arr['updated_at']; ?></td>
                                </tr>
                            <?php
                            } else {
                            ?>
                                <tr>
                                    <td colspan="4">沒有資料</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <?php if ($stmt->rowCount() > 0) { ?>
                            <button type="submit" name="chg" class="btn btn-primary">修改</button>
                        <?php } ?>
                        <button href="javascript:" type="button" class="btn btn-secondary editcancel" data-dismiss="modal">取消</button>
                    </div>
                    <input type="hidden" name="editCampingPlaceId" value="<?php echo (int)$_GET['editCampingPlaceId']; ?>">
                    <input type="hidden" name="page" value="<?php echo $page ?>">
                </form>
            </div>
        </div>
    </div>
    <!-- 新增營區修改尾 -->


    <!-- 新增露營場地區域地頭 -->
    <div class="modal fade " id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <h3>新增營區區域</h3>

                <form name="myForm" enctype="multipart/form-data" method="POST" action="orderPlaceCategoryAdd.php">
                    <table class="border">
                        <tbody>
                            <tr>
                                <td class="border">
                                    營區選擇
                                </td>
                                <td class="border">
                                    <select name="campingPlaceId">
                                        <?php
                                        $sql = "SELECT `campingPlaceId`, `campingPlaceName` FROM `ordercampingplace` ";
                                        $stmt = $pdo->query($sql);
                                        if ($stmt->rowCount() > 0) {
                                            $arr = $stmt->fetchAll();
                                            for ($i = 0; $i < count($arr); $i++) {
                                        ?>
                                                <option value="<?php echo $arr[$i]['campingPlaceId'] ?>"><?php echo $arr[$i]['campingPlaceName'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    營區區域
                                </td>
                                <td class="border">
                                    <input type="text" name="campingPlaceArea" value="" maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    場地型態
                                </td>
                                <td class="border">
                                    <input type="text" name="campingPlaceType" value="" maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    場地尺寸
                                </td>
                                <td class="border">
                                    <input type="text" name="campingPlaceSize" value="" maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    場地帳數
                                </td>
                                <td class="border">
                                    <input type="text" name="tentQty" value="" maxlength="3" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    平日價格
                                </td>
                                <td class="border">
                                    <input type="text" name="weekdaysPrice" value="" maxlength="11" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    假日價格
                                </td>
                                <td class="border">
                                    <input type="text" name="holidayPrice" value="" maxlength="11" />
                                </td>
                            </tr>
                            <tr>
                                <td class="border">
                                    連續預定價格
                                </td>
                                <td class="border">
                                    <input type="text" name="continuousPrice" value="" maxlength="11" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="submit" name="smb" class="btn btn-primary">新增</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 新增露營場地區域地尾 -->

    <!-- 新增首頁修改頭 -->
    <div class="modal fade " id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <?php
                $sql = "SELECT `orderplaceprice`.`campingAreaId`,`ordercampingplace`.`campingPlaceName`, `ordercampingplace`.`campingPlaceImg`, `orderplaceprice`.`campingPlaceArea`, `orderplaceprice`.`campingPlaceType`,`orderplaceprice`.`campingPlaceSize`,`orderplaceprice`.`tentQty`,
                 `orderplaceprice`.`weekdaysPrice`,`orderplaceprice`.`holidayPrice`,`orderplaceprice`.`continuousPrice`
                 FROM `ordercampingplace` INNER JOIN `orderplaceprice`
                 ON `ordercampingplace`.`campingPlaceId` = `orderplaceprice`.`orderPlaceId`
                   WHERE `campingAreaId` = ? ";

                $arrParam = [
                    (int)$_GET['campingAreaId']
                ];

                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);


                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll()[0];
                ?>
                    <form name="myForm" enctype="multipart/form-data" method="POST" action="orderPlaceUpdate.php">
                        <table class="border">
                            <tbody>
                                <tr>
                                    <td class="border">
                                        營區名稱
                                    </td>
                                    <td class="border">
                                        <?php echo $arr['campingPlaceName'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        營區配置圖
                                    </td>
                                    <td class="border">
                                        <img class="w500px" src="./images/<?php echo $arr['campingPlaceImg'] ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        營區區域
                                    </td>
                                    <td class="border">
                                        <input type="text" name="campingPlaceArea" value="<?php echo $arr['campingPlaceArea'] ?>" maxlength="11" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        場地型態
                                    </td>
                                    <td class="border">
                                        <input type="text" name="campingPlaceType" value="<?php echo $arr['campingPlaceType'] ?>" maxlength="3" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        場地尺寸
                                    </td>
                                    <td class="border">
                                        <input type="text" name="campingPlaceSize" value="<?php echo $arr['campingPlaceSize'] ?>" maxlength="100" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        場地帳數
                                    </td>
                                    <td class="border">
                                        <input type="text" name="tentQty" value="<?php echo $arr['tentQty'] ?>" maxlength="100" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        平日價格
                                    </td>
                                    <td class="border">
                                        <input type="text" name="weekdaysPrice" value="<?php echo $arr['weekdaysPrice'] ?>" maxlength="100" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        假日價格
                                    </td>
                                    <td class="border">
                                        <input type="text" name="holidayPrice" value="<?php echo $arr['holidayPrice'] ?>" maxlength="100" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border">
                                        連續預定價格
                                    </td>
                                    <td class="border">
                                        <input type="text" name="continuousPrice" value="<?php echo $arr['continuousPrice'] ?>" maxlength="100" />
                                    </td>
                                </tr>

                            <?php
                        } else {
                            ?>
                                <tr>
                                    <td colspan="9">沒有資料</td>
                                </tr>
                            <?php
                        }
                            ?>
                            </tbody>
                            <input type="hidden" name="campingAreaId" value="<?php echo (int)$_GET['campingAreaId']; ?>">
                            <input type="hidden" name="page" value="<?php echo $page ?>">
                        </table>
                        <div class="modal-footer">
                            <button type="submit" name="chg" class="btn btn-primary">修改</button>
                            <button type="button" class="btn btn-secondary editcancel" data-dismiss="modal">取消</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    <!-- 新增首頁修改尾 -->

    <form name="myForm" entype="multipart/form-data" method="POST" action="orderPlaceDelete.php">

        <div class="row py-2">
            <div class="col-lg-11 mx-auto">
                <div class="card rounded shadow border-0">
                    <div class="card-body p-2 bg-white rounded">
                        <div class="table-responsive">
                            <table id="example" style="width:100%" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="11">
                                            <button type="button" class="btn btn-title" data-toggle="modal" data-target="#exampleModalCenter">
                                                編輯營區場地
                                            </button>
                                            <button type="button" class="btn btn-title" data-toggle="modal" data-target="#exampleModalCenter1">
                                                新增營區區域
                                            </button>
                                            <button type="button" class="btn btn-title">
                                                <a href="orderPlaceIndex.php" class="indexa">露營區一覽</a>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border">勾選</th>
                                        <th class="border">營區名稱</th>
                                        <th class="border">營區配置圖</th>
                                        <th class="border">營區區域</th>
                                        <th class="border">場地型態</th>
                                        <th class="border">場地尺寸</th>
                                        <th class="border">場地帳數</th>
                                        <th class="border">平日價格</th>
                                        <th class="border">假日價格</th>
                                        <th class="border">連續預定價格</th>
                                        <th class="border">功能</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT `orderplaceprice`.`campingAreaId`,`ordercampingplace`.`campingPlaceName`, `ordercampingplace`.`campingPlaceImg`, `orderplaceprice`.`campingPlaceArea`, `orderplaceprice`.`campingPlaceType`,`orderplaceprice`.`campingPlaceSize`,`orderplaceprice`.`tentQty`,
                                    `orderplaceprice`.`weekdaysPrice`,`orderplaceprice`.`holidayPrice`,`orderplaceprice`.`continuousPrice`
                                      FROM `ordercampingplace` INNER JOIN `orderplaceprice`
                                       ON `ordercampingplace`.`campingPlaceId` = `orderplaceprice`.`orderPlaceId`
                                      ORDER BY `campingPlaceName` DESC,  `campingPlaceArea` ASC
                                      LIMIT ?, ? ";

                                    $arrParam = [
                                        ($page - 1) * $numPerPage,
                                        $numPerPage
                                    ];

                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute($arrParam);
                                    if ($stmt->rowCount() > 0) {
                                        $arr = $stmt->fetchAll();
                                        for ($i = 0; $i < count($arr); $i++) {
                                    ?>
                                            <tr>
                                                <td class="border">
                                                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['campingAreaId']; ?>" />
                                                </td>
                                                <td class="border"><?php echo $arr[$i]['campingPlaceName'] ?></td>
                                                <td class="border">
                                                    <?php if ($arr[$i]['campingPlaceImg'] !== NULL) { ?>
                                                        <img class="w500px" src="./images/<?php echo $arr[$i]['campingPlaceImg'] ?>">
                                                    <?php } ?>
                                                </td>
                                                <td class="border"><?php echo $arr[$i]['campingPlaceArea'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['campingPlaceType'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['campingPlaceSize'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['tentQty'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['weekdaysPrice'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['holidayPrice'] ?></td>
                                                <td class="border"><?php echo $arr[$i]['continuousPrice'] ?></td>
                                                <td class="border">

                                                    <a href="javascript:" type="button" data-toggle="modal" class="btn btn-primary editButton" data-id=<?= $arr[$i]['campingAreaId'] ?>data-target="#exampleModalCenter2">編輯</a>


                                                    <!-- <a id="edit" type="button" name="button" class="btn btn-primary" href="?campingAreaId=<?php echo $arr[$i]['campingAreaId']; ?>">
                                                        編輯
                                                    </a>
                                                    <a id="pId<?php echo $arr[$i]['campingAreaId']; ?>" hidden data-toggle="modal" data-target="#exampleModalCenter2"></a> -->

                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td class="border" colspan="11">沒有資料</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border" colspan="11">
                                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                                            <?php } ?>
                                        </td>

                                        <?php if ($total > 0) { ?>
                                    <tr>
                                        <td class="border" colspan="11"><input class="btn-primary" type="submit" name="smb" value="刪除"></td>
                                    </tr>
                                <?php } ?>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(function() {
            $(document).ready(function() {
                $('#example').DataTable();
            });
        });

        // console.log('window', window.location.search);
        // const pId = window.location.search.replace('?campingAreaId=', 'pId')
        // const btn = document.getElementById(pId);
        // btn.click();

        const edit_data = document.querySelectorAll('.editButton');
        //使用forEach對每個按鈕作點擊的事件監聽
        edit_data.forEach(
            (item) => {
                item.addEventListener('click', function(e) {
                    //取得按鈕內data-id的sql的值  （data-id=< ?= $arr[$i]['campingAreaId'] ?>)
                    const edit_id = item.getAttribute('data-id');
                    //網址跳轉到點擊的營區ID
                    location.href = `orderPlaceIndex.php?page=${<?= $page ?>}&campingAreaId=${edit_id}`;

                })
            });

        //如果有讀取到campingAreaId
        //就執行bootstrap的彈窗
        if (location.search.includes('campingAreaId')) {
            $('#exampleModalCenter2').modal('show');
        };


        const edit_chg = document.querySelectorAll('.editChg');
        edit_chg.forEach(
            (chgedit) => {
                chgedit.addEventListener('click', function(e) {
                    const edit_id1 = chgedit.getAttribute('data-id1');
                    location.href = `orderPlaceIndex.php?editCampingPlaceId=${edit_id1}`;
                })
            });

        if (location.search.includes('editCampingPlaceId')) {
            $('#exampleModalCenter3').modal('show');
        };

        //若取消編輯營區場地則將網址清空並返回所在頁面
        const edit_cancel = document.querySelectorAll('.editcancel')
        edit_cancel.forEach(
            (cnledit) => {
                cnledit.addEventListener('click', function(e) {
                    document.location.href = "orderPlaceIndex.php?page=<?php echo $page ?>";
                });
            });
    </script>
</body>

</html>