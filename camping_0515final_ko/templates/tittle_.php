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
    </ul>
    <?php
    if (!isset($_SESSION["email"])) { ?>
      <a href="./login.php" class="mr-4 btn btn-warning mx-3">登入</a>
    <?php } else { ?>
      <span class="text-light">你好，<?php echo $_SESSION["email"] ?></span>

      <a href="./logout.php?logout=1" class="btn btn-warning mx-3">登出</a>
    <?php } ?>
  </div>
</nav>