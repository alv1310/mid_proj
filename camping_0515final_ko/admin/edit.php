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
    <title>修改會員資料</title>
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
    <form name="myForm" method="POST" action="updateEdit.php">
        <table class="border">
            <tbody>
                <?php
                $sql2 = "SELECT `mId`, `email`, `name`, `phone`, `address`, 
                    `created_at`, `updated_at`
                FROM `member` 
                WHERE `mId` = ?";
                $stmt = $pdo->prepare($sql2);
                $arrParam = [
                    (int)$_GET['mId']
                ];
                $stmt->execute($arrParam);
                if($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll()[0];
                ?>
                    <tr>
                        <td class="border">ID</td>
                        <td class="border">
                            <?php echo $arr['mId']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="border">會員信箱</td>
                        <td class="border">
                            <input type="text" name="email" value="<?php echo $arr['email'] ?>" maxlength="10" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border">姓名</td>
                        <td class="border">
                            <input type="text" name="name" value="<?php echo $arr['name'] ?>" maxlength="10" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border">手機號碼</td>
                        <td class="border">
                            <input type="text" name="phone" value="<?php echo $arr['phone'] ?>" maxlength="10" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border">地址</td>
                        <td class="border">
                            <input type="text" name="address" value="<?php echo $arr['address'] ?>" maxlength="10" />
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
        <input type="hidden" name="mId" value="<?php echo (int)$_GET['mId'] ?>">
    </form>
</body>

</html>