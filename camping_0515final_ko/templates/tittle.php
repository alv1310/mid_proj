<!-- 前台header -->
<!-- LIST: 會員登入+情報誌 (其他不加) -->
<!-- 0513 -->
<!DOCTYPE html>
<html lang="zh-tw">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/memberCss.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<style>
  .logo,
  .logo:hover,
  .logo:visited,
  .logo:active {
    color: #FFD700;
    text-decoration: none;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5 bg-dark">
  <div class="mr-4">
    <h5 class="my-0 mr-md-auto font-weight-normal ">
      <a href="./index.php" class="logo">CAMP 露營趣</a>
    </h5>
  </div>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="p-2 text-light" href="./itemList.php">情報誌 <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="p-2 text-light" href="./cart_itemList.php">商品列表 <span class="sr-only">(current)</span></a>
      </li>
    </ul>

    <!-- <a href="#" onclick="window.open(' ./cart_addcart1.php ', '新增商品', config='height=700,width=700');">
            新增商品</a> -->
    <a class="p-2 text-light " href="./cart_modal.php" data-toggle="modal" data-target="#exampleModalCentercart"><i class="fas fa-shopping-cart cart"></i>(<span id="cartItemNum">
        <?php
        if (isset($_SESSION["cart"])) {
          echo count($_SESSION["cart"]);
        } else {
          echo 0;
        }
        ?>
      </span>)</a>
    <?php
    if (!isset($_SESSION["email"])) { ?>
      <a href="./login.php" class="mr-4 btn btn-warning mx-3">登入</a>
    <?php } else { ?>
      <span class="text-light">你好，<?php echo $_SESSION["email"] ?></span>

      <a href="./logout.php?logout=1" class="btn btn-warning mx-3">登出</a>
    <?php } ?>
  </div>
</nav>


<div class="modal fade " id="exampleModalCentercart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
<!-- 以下為一鍵輸入付款資訊 -->
<script>
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
</script>