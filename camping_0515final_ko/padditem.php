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

<h1>新增商品</h1>
<h3>商品基本資料</h3>
<form action="padditemsql.php" method="POST" enctype="multipart/form-data">
    <table>
        <tbody>
            <tr>
                <td>商品類別</td>
                <td><?php
                    $sqlCat = "SELECT `id`,`cat_id`,`cat_name` FROM `productCategory`";
                    $stmtCat = $pdo->query($sqlCat);
                    if ($stmtCat->rowCount() > 0) {
                        $arrCat = $stmtCat->fetchAll();
                    ?>
                        <select name="category" id="cat_selector" class="s2">
                            <?php
                            for ($i = 0; $i < count($arrCat); $i++) {
                            ?>
                                <option value="<?php echo $arrCat[$i]['cat_id'] ?>" style="line-height: 200px;">
                                    <?php echo $arrCat[$i]['cat_id'] . "-" . $arrCat[$i]['cat_name'] ?>
                                </option>
                            <?php }
                            ?>
                        </select> <?php
                                } else {
                                    echo '請先建立清單';
                                } ?>
                </td>
                <td>商品編號</td>
                <td><?php
                    $sqlPid = "SELECT max(product_id) AS`Pid` FROM `productList`";
                    $stmtPid = $pdo->query($sqlPid);
                    if ($stmtPid->rowCount() > 0) {
                        $resultPid = $stmtPid->fetchAll()[0];
                        // 生成商品編號
                        $Pid = (int)$resultPid['Pid'] + 1;
                    ?>
                        <input type="text" value="<?php echo $Pid ?>" disabled>
                        <input type="hidden" name="Pid" value="<?php echo $Pid ?>">
                    <?php } ?>
                </td>

            </tr>
            <tr>
                <td>商品名稱</td>
                <td><input type="text" name="product_name" placeholder="商品名稱"></td>
                <td>商品TAG</td>
                <td>
                    <!-- 0513更改 -->
                    <select name="product_tag" class="s2">
                        <?php
                        $sqlTag = "SELECT `tagId`,`tagName` FROM `ataglist`";
                        $stmtTag = $pdo->query($sqlTag);
                        if ($stmtTag->rowCount() > 0) {
                            $resultTag = $stmtTag->fetchAll();
                            for ($i = 0; $i < count($resultTag); $i++) { ?>
                                <option value="<?php echo $resultTag[$i]['tagId']; ?>"><?php echo $resultTag[$i]['tagName']; ?></option>
                        <?php
                            }
                        }
                        ?>
                </td>
                <!-- <td><input type="text" name="product_tag" placeholder="商品tag"></td> -->
                <!-- 0513更改 -->
            </tr>
            <tr>
                <td>商品簡介</td>
                <td colspan="3"><input class="w_input" type="text" name="product_desc" placeholder="商品簡介"></td>
            </tr>
            <tr>
                <td>設定租金(/日)</td>
                <td> <input type="text" name="product_price" placeholder="日租租金"></td>
                <td>上傳主圖</td>
                <td> <input type="file" name="product_img" placeholder="上傳圖片檔案" style="padding:10px;border:none;"></td>
            </tr>



        </tbody>
    </table>



    <input type="reset" value="重設">
    <input type="submit" value='新增品項'>
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