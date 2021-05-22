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
                                                    <h5 class="mb-0"><a href="#" class="text-dark d-inline-block align-middle"><?php echo $arr[$i]["product_name"] ?></a></h5>
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