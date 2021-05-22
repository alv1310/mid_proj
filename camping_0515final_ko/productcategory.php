<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>Document</title>
</head>

<?php
require_once('./db.inc.php');
?>

<body>
    <!-- TODO:導入JS進行動態刪除 -->
    <!-- 將類別載入 -->
    <h1>產品類別清單</h1>
    <hr>
    <!-- 新增類別開始 -->
    <!-- edit請做類別(state)判斷 -->
    <div class="inline">
        新增類別=>
        <form name="add" method="post" action="peditcategory.php?state=1">
            <!-- <input type="hidden" name="state" value="1"> -->
            <input type="text" name="cat_id_new" onkeyup="value=value.replace(/[\W]/g,'') " 　　 onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" placeholder="新增類別代碼(限3位英數字)" maxlength="3">

            <input type="text" name="cat_name_new" placeholder="新增類別名稱(最多10位)" maxlength="10">
            <input type="submit" value="新增">
        </form>
    </div>

    <hr>
    <table>
        <thead>
            <tr>
                <th>選取刪除 </th>
                <th>代碼</th>
                <!--cat_id-->
                <th>類別名稱</th>
                <!--cat_name-->
            </tr>
        </thead>
        <tbody>
            <!-- php迴圈 -->

            <?php
            $sqlCat = "SELECT `cat_id`,`cat_name`,`id` from `productcategory`";
            $stmtCat = $pdo->query($sqlCat);
            if ($stmtCat->rowCount() > 0) {
                $arrCat = $stmtCat->fetchall();
            ?>
                <!-- 補充判斷為更新狀態 -->
                <form name="edit" method="post" action="peditcategory.php?state=2">
                    <!-- <input type="hidden" name="state" value="2"> -->

                    <?php
                    for ($i = 0; $i < count($arrCat); $i++) { ?>
                        <tr>
                            <td><input type="checkbox" class="ck" name="chk[]" value="<?php echo $arrCat[$i]['cat_id']; ?>">
                                <input type="hidden" name="id[]" value="<?php echo $arrCat[$i]['id'] ?>">
                            </td>
                            <td><input type="text" name="cat_id[]" value="<?php echo $arrCat[$i]['cat_id'] ?>"></td>

                            <td><input type="text" name="cat_name[]" value="<?php echo $arrCat[$i]['cat_name'] ?>">
                            </td>
                        </tr>
                    <?php
                    } ?>
                    <!-- update clase tag     -->
                    <div class="right">
                        <input type="submit" value="更新資料">

                    </div>
                </form>
            <?php } else {
            ?>
                <!-- 置入無資料預設值 -->
                <tr>
                    <td colspan="3">(尚未建立類別)</td>
                </tr>
                <!-- backup... -->
                <tr>
                    <td><input type="checkbox" class="ck" name="chk[]" value="<?php echo $arrCat[$i]['cat_id']; ?>" /></td>
                    <td><input type="text" id="
                            <?php echo 'id' . $arrCat[$i]['id'] ?>" value="<?php echo $arrCat[$i]['cat_id'] ?>"></td>
                    <td><input type="text" id="<?php echo 'name' . $arrCat[$i]['id'] ?>" value="<?php echo $arrCat[$i]['cat_name'] ?>"></td>
                </tr>
                <!-- backup... -->
            <?php
            }
            ?>



        </tbody>
    </table>

</body>

</html>