<?php
session_start();
require_once('./db.inc.php');
// $cartPayIdArr = ["APPLE PAY", "雅馬遜配", "信用卡", "貨到付款"];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="icon" href="./img/phoca-cart-r.svg" type="image/x-icon" />
    <title>購物車後台頁面</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }

        .img {
            width: 150px;
            height: 150px;
        }

        .customModel {
            width: 800px;
        }

        .payimg {
            font-size: 1.5rem;
        }

        .cart {
            font-size: 3rem;
        }

        .orderStatus {
            padding: 2px;
        }

        .member {
            padding: 50px;
        }
    </style>
</head>

<body>
    <?php
    require_once('./templates/tittle_admin.php');
    ?>




    <hr>

    <!-- 新增頁面開始 -->
    <div class="container"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModalCenter">
            <i class="fas fa-shopping-cart cart"></i>
        </button>
        (<span id="cartItemNum">
            <?php
            if (isset($_SESSION["cart"])) {
                echo count($_SESSION["cart"]);
            } else {
                echo 0;
            }
            ?>
        </span>)
        <!-- <a href="#" onclick="window.open(' ./cart_addcart1.php ', '新增商品', config='height=700,width=700');">
            新增商品</a> -->
        <a href="./cart_addcart1.php">新增商品</a>
    </div>



    <!-- Modal彈出視窗開始 -->
    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">購物車列表</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myForm" method="POST" action="./cart_addOrder.php">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="p-2 px-3 text-uppercase">商品名稱</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">價格</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">數量</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">小計</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">功能</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //放置結合當前資料庫資料的購物車資訊
                                $arr = [];

                                $total = 0;

                                if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
                                    //SQL 敘述
                                    $sql = "SELECT `productlist`.`product_id`,`productlist`.`product_name`,`productlist`.`qty`,`productlist`.`product_price`,`productcategory`.`cat_id`, `productcategory`.`cat_name` FROM `productlist` INNER JOIN `productcategory` ON `productlist`.`cat_id`=`productcategory`.`cat_id` WHERE `product_id` =  ? ";
                                    //比對購物車裡面所有項目的 itemId，然後透過 SQL 查詢來取得完整的資料
                                    for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
                                        $arrParam = [
                                            (int)$_SESSION["cart"][$i]["product_id"]
                                        ];
                                        //查詢
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute($arrParam);
                                        //若商品項目個數大於 0，則把買家購買的數量加到查詢結果當中
                                        if ($stmt->rowCount() > 0) {
                                            $arrItem = $stmt->fetchAll()[0];
                                            $arrItem['cartQty'] = $_SESSION["cart"][$i]["cartQty"];
                                            $arr[] = $arrItem;
                                        }
                                    }
                                    for ($i = 0; $i < count($arr); $i++) {
                                        //計算總額
                                        $total += (int)$arr[$i]["product_price"] * (int)$arr[$i]["cartQty"];
                                ?>
                                        <tr>
                                            <th scope="row" class="border-0">
                                                <div class="p-2">

                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h6 class="mb-0"><a href="#" class="text-dark d-inline-block align-middle"><?php echo $arr[$i]["product_name"] ?></a></h6>
                                                        <span class="text-muted font-weight-normal font-italic d-block">Category: <?php echo $arr[$i]["cat_name"] ?></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="border-0 align-middle"><strong>$<?php echo $arr[$i]["product_price"] ?></strong></td>
                                            <!-- 多選 -->


                                            <td class="border-0 align-middle">
                                                <input type="text" class="form-control" name="cartQty[]" value="<?php echo $arr[$i]["cartQty"] ?>" maxlength="3">
                                            </td>
                                            <td class="border-0 align-middle">
                                                <input type="text" class="form-control" name="subtotal[]" value="<?php echo ($arr[$i]["product_price"] * $arr[$i]["cartQty"]) ?>" maxlength="10">
                                            </td>
                                            <td class="border-0 align-middle"><a href="./cart_deleteCart.php?idx=<?php echo $i ?>" class="text-dark">刪除</a></td>
                                        </tr>
                                        <input type="hidden" name="product_id[]" value="<?php echo $arr[$i]["product_id"] ?>" />
                                        <input type="hidden" name="product_price[]" value="<?php echo $arr[$i]["product_price"] ?>" />
                                        <input type="hidden" name="product_name[]" value="<?php echo $arr[$i]["product_name"] ?>" />

                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>


                        <?php if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) { ?>
                            <div class="row d-flex justify-content-end pl-3 pr-3 pb-3">
                                <h3>目前總額: <mark><?php echo (int)$total ?></mark></h3>
                                <input type="hidden" id="total" name="total" value="<?php echo $total ?>" />
                            </div>

                        <?php } ?>



                        <!-- 新增訂單收件人訊息列 -->
                        </table>
                        <table class="member container">
                            <thead>

                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">收件人
                                        <input type="text" name="nNN" id="nNN" value="" maxlength="10" size="40" />
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">收貨地址
                                        <input type="text" name="nAA" id="nAA" value="" maxlength="50" size="40"></input>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">收件人手機
                                        <input type="text" name="nCC" id="nCC" value="" maxlength="10" size="40" />
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">付款方式
                                        <input type="radio" name="cartPayId" id="cartPayId" value="1" maxlength="10" checked /><i class="fab fa-apple-pay payimg"></i>
                                        <input type="radio" name="cartPayId" id="cartPayId" value="2" maxlength="10" /><i class="fab fa-amazon-pay payimg"></i>
                                        <input type="radio" name="cartPayId" id="cartPayId" value="3" maxlength="10" /><i class="fab fa-cc-visa payimg"></i>

                                    </th>
                                </tr>
                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">物流方式
                                        <input type="radio" name="cartLogisticsId" id="cartLogisticsId" value="1" maxlength="10" checked />宅配
                                        <input type="radio" name="cartLogisticsId" id="cartLogisticsId" value="2" maxlength="10" />小七
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border" style="display:flex; justify-content:space-between">備註
                                        <a href="javascript:autoComplete()" style="color:white">123</a>
                                        <input type="text" name="cartDescription" id="cartDescription" value="" maxlength="20" size="40" />
                                        <input type="hidden" name="cartStatus" id="cartStatus" value="待出貨">
                                    </th>
                                </tr>

                            </thead>



                        </table>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                            <button type="submit" name="smb" class="btn btn-primary">新增</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 訂單分類頁面 -->


    <!-- 查詢頁面開始 -->
    <?php
    $sqlTotal = "SELECT COUNT(1) AS `count` FROM `cartOrder`";
    //執行 SQL語法,並回傳 建立 PDOstatment物件
    $stmtTotal = $pdo->query($sqlTotal);
    //查詢結果 取得第一筆資料 索引為0
    $arrTotal = $stmtTotal->fetchAll()[0];
    //資料表總筆數
    $total = $arrTotal['count'];

    //每頁幾筆
    $numPerpage = 5;
    //總頁數 ceil()為無條件進位
    $totalPages = ceil($total / $numPerpage);

    //目前第幾頁
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    //若page 小於1:則回傳1
    $page = $page < 1 ? 1 : $page;

    ?>
    <form action="cart_deleteIds.php" name="myForm" method="POST" class="container ">
        <table style="width: 1200px;">
            <thead style="border:2px solid;">
                <tr>
                    <th class="border  " style="width: 2%;">選擇</th>
                    <th class="border" style="width: 5%;">訂單編號</th>
                    <th class="border" style="width: 10%;">建立日期</th>
                    <th class="border" style="width: 7%;">會員姓名</th>
                    <th class="border" style="width: 7%;">收件人</th>
                    <th class="border" style="width: 20%;">收貨地址</th>
                    <th class="border" style="width: 10%;">收件人手機</th>
                    <th class="border" style="width: 7%;">訂單狀態</th>
                    <th class="border" style="width: 7%;">配送狀態</th>
                    <th class="border" style="width: 7%;">付款狀態</th>
                    <th class="border" style="width: 5%;">合計</th>
                    <th class="border" style="width: 5%;">備註</th>
                    <th class="border" style="width: 10%;">功能</th>
                </tr>
            </thead>
            <tbody>
                <?php

                //商品種類 SQL 敘述，取得商品種類總筆數
                $sql = "SELECT `cartOrder`.`cartOrderId`,`cartOrder`.`created_at`,`member`.`name`,`cartOrder`.`nNN`,`cartOrder`.`nAA`,`cartOrder`.`nCC`,`cartOrder`.`cartStatus`,`cartLogistics`.`cartLogisticsName`,`carPay`.`cartPayName`,`cartOrder`.`cartTotal`,`cartOrder`.`cartDescription`
                FROM `cartOrder`
                
                INNER JOIN `member`
                ON `cartOrder`.`mid` = `member`.`mId`
                INNER JOIN `carPay`
                ON `cartOrder`.`cartPayId` = `carPay`.`cartPayId`
                INNER JOIN `cartLogistics`
                ON `cartOrder`.`cartLogisticsId` = `cartLogistics`.`cartLogisticsId`
                ORDER BY `cartOrder`.`created_at` DESC
                
                LIMIT ?,?";
                $arrParam = [
                    ($page - 1) * $numPerpage,
                    $numPerpage
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                //若往只有商品種類編號，則整合字串來操作sql語法


                //若商品項目個數大於0，則列出商品
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                    for ($i = 0; $i < count($arr); $i++) {
                ?>

                        <tr>
                            <th scope="row"><input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['cartOrderId']; ?>"></th>
                            <td>
                                <?php echo $arr[$i]['cartOrderId']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['created_at']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['name']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['nNN']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['nAA']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['nCC']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['cartStatus']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['cartLogisticsName']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['cartPayName']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['cartTotal']; ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['cartDescription']; ?>
                            </td>


                            <td scope="col">
                                <a href="javascript:" data-toggle="modal" data-target="#exampleModalCenter1"> <i class="fas fa-edit" data-id=<?= $arr[$i]['cartOrderId']  ?>></i></a>
                                <a href="javascript:delete_it(<?= $arr[$i]['cartOrderId'] ?>)"><i class="fas fa-trash"></i></a>
                                <a id="itemMenu<?php echo $arr[$i]['cartOrderId']; ?>" href="?page=<?= $page ?>&detail=<?php echo $arr[$i]['cartOrderId'] ?>">詳細內容</a>
                                <a id="itemClose<?php echo $arr[$i]['cartOrderId']; ?>" href="cart.php?page=<?= $page ?>" style="display:none">關閉內容</a>


                            </td>
                        </tr>
                        <!-- 預設放商品詳細頁 放在備份用A1 -->
                        <tr id="itemDetail<?php echo $arr[$i]['cartOrderId']; ?>" class="itemDetail" style="display: none">



                            <td colspan="13" class="flex col">
                                <div style="width:600px; text-align:center; display:flex; justify-content:space-between; border-bottom: 1px solid #000; padding: 4px 0">
                                    <span style="width:33%">商品名稱</span>
                                    <span style="width:33%">商品數量</span>
                                    <span style="width:33%">商品金額</span>
                                </div>
                                <?php
                                $sqla = "SELECT `cartorder`.`cartorderId`,`cartitem`.`cartName`,`cartitem`.`cartName`,`cartitem`.`cartBuyQty`,
                                `cartitem`.`cartBuyP`
                                FROM `cartorder`
                                INNER JOIN `cartitem`
                                ON `cartorder`.`cartOrderId` = `cartitem`.`cartorderid`
                                WHERE `cartorder`.`cartOrderId` = ?";
                                $stmta = $pdo->prepare($sqla);
                                $arra = [
                                    $arr[$i]["cartOrderId"]
                                ];
                                $stmta->execute($arra);
                                if ($stmta->rowCount() > 0) {
                                    $arrb = $stmta->fetchAll(PDO::FETCH_ASSOC);
                                    for ($j = 0; $j < count($arrb); $j++) {

                                ?>

                                        <div style="width:600px; text-align:center; display:flex; justify-content:space-between">
                                            <span style="width:33%;text-align:left;padding-bottom:8px"><?php echo $arrb[$j]['cartName']; ?></span>

                                            <span style="width:33%;padding-bottom:8px"><?php echo $arrb[$j]['cartBuyQty']; ?></span>

                                            <span style="width:33%;padding-bottom:8spx"><?php echo $arrb[$j]['cartBuyP']; ?></span>

                                        </div>
                                <?php }
                                } ?>
                            </td>

                        </tr>

                <?php }
                } ?>



            </tbody>
            <tfoot>

                <tr>
                    <td class=" border" colspan="13">
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <a href="?page=<?php echo $i ?>">
                                <?php echo $i ?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <input class="btn btn-outline-primary" type="submit" name="smb" value="刪除">

    </form>
    </table>
    </form>


    <!-- 編輯彈出開始 -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">商品編輯</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="myForm" method="POST" action="cart_updateEdit.php" enctype="multipart/form-data">
                        <table class="border">
                            <tbody>
                                <?php
                                if (isset($_GET['cartOrderId'])) {

                                    $sql = "SELECT `cartOrder`.`cartOrderId`,`cartOrder`.`created_at`,`member`.`name`,`cartOrder`.`nNN`,`cartOrder`.`nAA`,`cartOrder`.`nCC`,`cartOrder`.`cartStatus`,`cartOrder`.`cartLogisticsId`,`cartOrder`.`cartPayId`,`cartOrder`.`cartTotal`,`cartOrder`.`cartDescription` ,`cartlogistics`.`cartLogisticsName`,`carpay`.`cartPayName` FROM `cartOrder` INNER JOIN `member` ON `cartOrder`.`mid` = `member`.`mId` INNER JOIN `cartlogistics` ON `cartlogistics`.`cartLogisticsId` = `cartOrder`.`cartLogisticsId` INNER JOIN `carpay` ON `carpay`.`cartPayId` = `cartOrder`.`cartPayId` WHERE `cartOrderId` = ?";

                                    //設定繫結值
                                    $arrParam = [
                                        // $_SESSION['itemId']
                                        // $arr[$i]['itemId']
                                        $_GET['cartOrderId']
                                    ];

                                    //查詢
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute($arrParam);
                                    if ($stmt->rowCount() > 0) {
                                        $arr = $stmt->fetchAll()[0];
                                ?>

                                        <tr>
                                            <td class="border">訂單編號</td>
                                            <td class="border">
                                                <input type="text" name="cartOrderId" value="<?php echo $arr['cartOrderId']; ?> " maxlength="9" disabled="disabled" />
                                                <input type="hidden" name="cartOrderId" value="<?php echo $arr['cartOrderId']; ?> " maxlength="9" />

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">會員姓名</td>
                                            <td class="border">
                                                <input type="text" disabled="disabled" name="name" value="<?php echo $arr['name'] ?>" maxlength="10" />
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="border">建立訂單日期</td>
                                            <td class="border">
                                                <input type="text" disabled="disabled" name="created_at" value="<?php echo $arr['created_at'] ?>" maxlength="10" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">收件人</td>
                                            <td class="border">
                                                <input type="text" name="nNN" value="<?php echo $arr['nNN'] ?>" maxlength="10" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">收件人電話</td>
                                            <td class="border">
                                                <input type="text" name="nCC" value="<?php echo $arr['nCC'] ?>" maxlength="10" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">收件人地址</td>
                                            <td class="border">
                                                <textarea type="text" name="nAA" value="" maxlength="20"><?php echo $arr['nAA'] ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">訂單狀態</td>
                                            <td class="border">
                                                <select name="cartStatus" class="orderStatus">
                                                    <option value="待出貨">待出貨</option>
                                                    <option value="已出貨">已出貨</option>
                                                    <option value="訂單完成">訂單完成</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border">備註</td>
                                            <td class="border">
                                                <input type="text" name="cartDescription" value="<?php echo $arr['cartDescription'] ?>" maxlength="10" />
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
                                }
                                ?>
                            </tbody>

                        </table>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closee" data-dismiss="modal">關閉</button>
                            <button type="submit" name="smb" class="btn btn-primary">修改</button>
                            <input type="hidden" name="page" value="<?php echo $page ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // console.log('window', window.location.search);
        // const pId = window.location.search.replace('itemId=', 'pId')
        // const btn = document.getElementById(pId);

        // btn.click();

        // function delete_it(id) {
        //     if (confirm(`是否要刪除編號為 ${itemId} 的資料?`)) {
        //         location.href = 'index.php?itemId=' + itemId;
        //     }
        // }
        //點擊後跳轉到 刪除頁面的 API
        function delete_it(cartOrderId) {
            if (confirm(`是否要刪除編號為 ${cartOrderId} 的資料?`)) {
                location.href = 'cart_delete.php?cartOrderId=' + cartOrderId;
            }
        }
        //.fa-edit為按鈕的 class
        const edit_data = document.querySelectorAll('.fa-edit');
        //使用forEach對每個按鈕作點擊的事件監聽
        edit_data.forEach(
            (item) => {
                item.addEventListener('click', function(e) {
                    //取得按鈕內data-id的sql的值  （data-id=< ?= $arr[$i]['itemId'] ?>)
                    const edit_id = item.getAttribute('data-id');
                    //網址跳轉到點擊的商品ID
                    location.href = `cart.php?page=${<?= $page ?>}&cartOrderId=${edit_id}`;

                })
            });
        //編輯畫面按關閉時 自動回到首頁為按鈕的 class
        const edit_data1 = document.querySelectorAll('.closee');
        //使用forEach對每個按鈕作點擊的事件監聽
        edit_data1.forEach(
            (item) => {
                item.addEventListener('click', function(e) {
                    //取得按鈕內data-id的sql的值  （data-id=< ?= $arr[$i]['itemId'] ?>)

                    //網址跳轉到點擊的商品ID
                    location.href = `cart.php?page=${<?= $page ?>}`;

                })
            });
        //如果有讀取到itemId
        //就執行bootstrap的彈窗
        if (location.search.includes('cartOrderId')) {
            $('#exampleModalCenter1').modal('show');
        };

        //下拉隱藏
        // hide order detail
        const itemId = window.location.search.replace(/\?page=\d+&detail=/g, '');
        const detail = document.getElementById(`itemDetail${itemId}`);
        const openMenu = document.getElementById(`itemMenu${itemId}`);
        const closeMenu = document.getElementById(`itemClose${itemId}`);
        if (location.search.includes('detail')) {
            detail.style.display = '';
            openMenu.innerHTML = '';
            closeMenu.style.display = 'inline';
        }

        detail.addEventListener('click', () => {
            location.href = `cart.php?page=${<?= $page ?>}`;
        });

        function autoComplete() {
            const receiver = document.getElementById('nNN');
            const receiverPhone = document.getElementById('nCC');
            const receiverAddress = document.getElementById('nAA');
            const receiverDescription = document.getElementById('cartDescription');

            receiver.value = '皮卡丘大姨媽';
            receiverPhone.value = '0978978978';
            receiverAddress.value = '台北市大安區大安路2段999號';
            receiverDescription.value = '吃老衲一棒';
        };


        // const addOne = document.getElementById('addOne');

        // addOne.addEventListener('click',()=>{
        //     const addOneV = addOne.value;

        // })
        // const addOne = document.getElementById('addOne');
        // addOne.addEventListener('click', function() => {
        //     const a = addOne.Value;
        //     console.log(a)
        // })

        // function ShowValue() {
        //     var v = document.getElementById("addOne").value;
        //     alert(v);
        // }
        // const count = document.getElementById('count')
        // const add = document.getElementById('add')
        // const sub = document.getElementById('sub')
        // sub.addEventListener('click', function() {
        //     count.innerText = +count.innerText - 1
        // })

        // add.addEventListener('click', function() {
        //     count.innerText = +count.innerText + 1
        // })
        // const addpS = document.getElementById('addpS')
        // const addpP = document.getElementById('addpP')
        // const addTotal = document.getElementById('addTotal')
        // const s = addpS.value
        // const p = addpP.value

        // console.log(s)
        // console.log(p)

        // function() {

        // }

        // addPs.addEventListener('click', () => {

        // })
    </script>



</body>

</html>