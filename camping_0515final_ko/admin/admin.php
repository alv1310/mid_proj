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
    <title>後端管理頁面</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./memberCss.css">
    <style>
        tr th {
            border: 2px solid;
        }

        tr td {
            border: 1px solid;
        }

        .w200px {
            width: 200px;
        }
    </style>
</head>

<body>
    <?php require_once './templates/tittle.php'
    ?>

    <!-- <form name="myForm" method="POST" action="deleteIds.php" class="container-fluid"> -->
    <div class="container my-5">
        <table class="border2" class="ml-5">
            <thead>
                <tr>
                    <!-- <th class="border2">選擇</th> -->
                    <th class="border2">ID</th>
                    <th class="border2">會員信箱</th>
                    <th class="border2">姓名</th>
                    <th class="border2">手機號碼</th>
                    <th class="border2">地址</th>
                    <th class="border2">註冊時間</th>
                    <th class="border2">修改時間</th>
                    <th class="border2">功能</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT `mId`, `email`, `name`, `phone`, `address`,
                        `created_at`, `updated_at`
                    FROM `member`
                    ORDER BY `created_at` ASC";
                $stmt = $pdo->query($sql);
                $arr = $stmt->fetchAll();
                // echo "<pre>";
                // print_r($arr);
                // echo "</pre>";
                if ($stmt->rowCount() > 0) {
                    for ($i = 0; $i < count($arr); $i++) {
                ?>
                        <tr>
                            <!-- <td class="border2">
                                <input type="checkbox" name="chk[]" value="" />
                            </td> -->
                            <td class="border2"><?php echo $arr[$i]['mId'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['email'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['name'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['phone'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['address'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['created_at'] ?></td>
                            <td class="border2"><?php echo $arr[$i]['updated_at'] ?></td>
                            <td>
                                <div class="accordion" id="accordionExample">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $arr[$i]['mId'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $arr[$i]['mId'] ?>">編輯
                                    </button>
                                    <a href="./deleteId.php?delete=<?php echo $arr[$i]['mId'] ?>">刪除</a>
                                </div>
                            </td>

                        </tr>
                        <form name="myForm" method="POST" action="updateEdit.php">
                            <tr>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                            <input type="text" name="email" value="<?php echo $arr[$i]['email'] ?>" maxlength="10" />
                                        </div>
                                </td>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                            <input type="text" name="name" value="<?php echo $arr[$i]['name'] ?>" maxlength="10" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                            <input type="text" name="phone" value="<?php echo $arr[$i]['phone'] ?>" maxlength="10" />
                                        </div>
                                </td>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">
                                            <input type="text" name="address" value="<?php echo $arr[$i]['address'] ?>" maxlength="10" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div id="collapse<?php echo $arr[$i]['mId'] ?>" class="collapse" aria-labelledby="heading<?php echo $arr[$i]['mId'] ?>" data-parent="#accordionExample">
                                        <div class="card-body p-0">

                                            <input type="submit" name="smb" value="送出" class="hideSubmit">

                                        </div>
                                        <input type="hidden" name="mId" value="<?php echo (int)$arr[$i]['mId'] ?>">
                                    </div>
                                </td>
                            </tr>
                        </form>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td class="border2" colspan="9">沒有資料</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        </container>
        <!-- <input type="submit" name="smb" value="刪除"> -->
        <!-- </form> -->




        <script>
            // const hideSubmit = document.querySelectorAll(.hideSubmit)
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

        <script>
            $('.hideSubmit').hide();
            $('.accordion button').click(function() {

                $(this).closest('tr').next().next().find('.hideSubmit').show();
            });
        </script>
</body>

</html>