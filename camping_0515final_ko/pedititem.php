<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/product.css">
    <title>編輯商品</title>
</head>

<?php
require_once('./db.inc.php');
?>
<h1>編輯商品</h1>
<h3>商品基本資料</h3>
<!-- 先讀取商品資訊 -->
<?php
$sqlRead = "SELECT `cat_id`,`product_name`,`tag_id`,`product_desc`,`product_price`,`product_img` FROM `productList` WHERE product_id = ? ";
$arrpush = [$_REQUEST['Pid']];
$stmtRead = $pdo->prepare($sqlRead);
$stmtRead->execute($arrpush);
$arrRead = $stmtRead->fetchAll()[0];
?>
<form action="pedititemsql.php" method="POST" enctype="multipart/form-data">
    <table>
        <tbody>
            <tr>
                <!-- TODO:商品類別預設值 -->
                <td>商品類別</td>
                <td><?php
                    $sqlCat = "SELECT `id`,`cat_id`,`cat_name` FROM `productCategory`";
                    $stmtCat = $pdo->query($sqlCat);
                    if ($stmtCat->rowCount() > 0) {
                        $arrCat = $stmtCat->fetchAll();
                    ?>
                        <select name="category" id="cat_selector" class="s2">
                            <!-- 判別原本設定 -->
                            <?php
                            for ($i = 0; $i < count($arrCat); $i++) {

                                if ($arrCat[$i]['cat_id'] == $arrRead['cat_id']) {
                            ?>
                                    <option value="<?php echo $arrCat[$i]['cat_id'] ?>" style="line-height: 200px;" selected>
                                        <?php echo $arrCat[$i]['cat_id'] . "-" . $arrCat[$i]['cat_name'] ?>
                                    </option>

                                <?php } else { ?>
                                    <option value="<?php echo $arrCat[$i]['cat_id'] ?>" style="line-height: 200px;">
                                        <?php echo $arrCat[$i]['cat_id'] . "-" . $arrCat[$i]['cat_name'] ?>
                                    </option>
                            <?php }
                            }
                            ?>
                        </select>
                    <?php
                    } else {
                        echo '請先建立清單';
                    } ?>
                </td>
                <td>商品編號</td>
                <td>
                    <input type="text" value="<?php echo $_REQUEST['Pid'] ?>" disabled>
                    <input type="hidden" name="product_id" value="<?php echo $_REQUEST['Pid'] ?>">

                </td>

            </tr>
            <tr>
                <td>商品名稱</td>
                <td><input type="text" name="product_name" placeholder="商品名稱" value="<?php echo $arrRead['product_name'] ?>"></td>
                <td>商品TAG</td>
                <td><?php
                    $sqlTag = "SELECT `tagId`,`tagName` FROM `ataglist`";
                    $stmtTag = $pdo->query($sqlTag);
                    if ($stmtTag->rowCount() > 0) {
                        $arrTag = $stmtTag->fetchAll();
                    ?>
                        <select name="tag_id" id="Tag_selector" class="s2">
                            <!-- 判別原本設定 -->
                            <?php
                            for ($i = 0; $i < count($arrTag); $i++) {

                                if ($arrTag[$i]['tagId'] == $arrRead['tag_id']) {
                            ?>
                                    <option value="<?php echo $arrTag[$i]['tagId'] ?>" style="line-height: 200px;" selected>
                                        <?php echo  $arrTag[$i]['tagName'] ?>
                                    </option>

                                <?php } else { ?>
                                    <option value="<?php echo $arrTag[$i]['tagId'] ?>" style="line-height: 200px;">
                                        <?php echo $arrTag[$i]['tagName'] ?>
                                    </option>
                            <?php }
                            }
                            ?>
                        </select>
                    <?php
                    } else {
                        echo '請先建立清單';
                    } ?>
                </td>






                <!--?php echo $arrRead['tag_id'] ?-->
                <!-- <td><input type="text" name="tag_id" placeholder="商品tag" value=""></td> -->
            </tr>
            <tr>
                <td>商品簡介</td>
                <td colspan="3"><input class="w_input" type="text" name="product_desc" placeholder="商品簡介" value="<?php echo $arrRead['product_desc'] ?>"></td>
            </tr>
            <tr>
                <td>設定租金(/日)</td>
                <td> <input type="text" name="product_price" placeholder="日租租金" value="<?php echo $arrRead['product_price'] ?>"></td>

                <td>更改主圖</td>
                <td> <input type="file" name="product_img" placeholder="上傳圖片檔案" style="padding:10px;border:none;"></td>
            </tr>



        </tbody>
    </table>



    <input type="reset" value="重設">
    <input type="submit" value='更改產品資訊'>
</form>
<!--還沒做的
<hr>
<h3>商品詳情</h3>
<table>
    <tr>
        <td>商品包裝尺寸</td>
        <td>
            <input type="text" name="product_packsize" placeholder="商品包裝尺寸">
        </td>
        <td>商品本體尺寸</td>
        <td>
            <input type="text" name="product_fullsize" placeholder="商品本體尺寸">
        </td>
    </tr>
    <tr>

        <td>商品本體重量</td>
        <td>
            <input type="text" name="product_weight" placeholder="商品本體重量">
        </td>
        <td>商品建議人數</td>
        <td><input type="text" name="product_person" placeholder="商品建議人數"></td>

    </tr>
    <tr>
        <td>商品材質</td>
        <td><input type="text" name="product_name" placeholder="商品材質"></td>
    </tr>
    <tr>
        <td>內容物</td>
        <td><input type="text" name="product_desc" placeholder="內容物"></td>
    </tr>
    <tr>
        <td>商品介紹</td>
        <td colspan="3"><textarea rows="4" cols="70" name="comment" form="usrform" name="product_tag" placeholder="商品介紹"></textarea></td>
    </tr>
    -->
</table>