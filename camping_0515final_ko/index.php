<?php
session_start();
$title = "Camp露營趣- (首頁)";
require_once './db.inc.php';
require_once './templates/tittle.php';
?>

<body>


  <div class="container-fluid ">
    <div class="jumbotron heroSection ">
      <h1 class=" display-4 text-light">無負擔，輕鬆露營去!</h1>
      <p class=" lead text-light" style="text-shadow:3px 3px 3px #cccccc;">不用擔心任何裝備，沒經驗可以輕鬆露營!快來體驗我們的露營租賃服務吧。</p>
      <!-- <hr class="my-4" style="border-color:#fff;"> -->
      <p class=" text-light">享受露營，就從這裡開始。</p>
      <br>
      <br>
      <br>
      <br>
      <br>
      <!-- <a class="btn btn-primary btn-lg text-light" href="#" role="button">Learn more</a> -->
    </div>
  </div>

  <?PHP
  require_once './templates/tpl-product-list.php';
  require_once './templates/tpl-footer.php';
  ?>