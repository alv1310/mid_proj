<?php
session_start();
require_once './db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="./memberCss.css">
</head>

<body>
  <?php
  require_once './templates/tittle.php'
  ?>

  <form class="w-350 mx-auto p-5 bgg" name="myForm" method="POST" action="./signUp.php">

    <div class="form-group mb-4">
      <h3>會員註冊</h3>
      <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Email Address 會員帳號" name="email" value="" maxlength="50">
    </div>

    <div class="form-group mb-4">
      <input type="password" class="form-control" placeholder="Password 會員密碼" name="password" value="" maxlength="50">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Password 再次輸入密碼" name="pwdAgain" value="" maxlength="50">
    </div>

    </div>

    <div class="d-flex justify-content-around">
      <button type="submit" class="btn btn-warning">註冊</button>
    </div>
  </form>





  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>