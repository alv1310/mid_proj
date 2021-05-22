<?php
session_start();
require_once('./db.inc.php');

function GetSQLValueString($theValue, $theType)
{
    switch ($theType) {
        case "string":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_ADD_SLASHES) : "";
            break;
        case "int":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
            break;
        case "email":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_EMAIL) : "";
            break;
        case "url":
            $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_URL) : "";
            break;
    }
    return $theValue;
}
function MakePass($length)
{
    $possible = "0123456789!@#$%^&*()qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    $str = "";
    while (strlen($str) < $length) {
        $str .= substr($possible, rand(0, strlen($possible)), 1);
    }
    return ($str);
}

// 確認是否登入

require_once './checkLoggedIn.php';

// 補發密碼信



if (isset($_POST["m_email"])) {
    $muser = GetSQLValueString($_POST["m_email"], 'string');
    $query_RecFindUsdr = "SELECT `email` FROM `member` WHERE `email` = ? ";
    $stmt = $pdo->prepare($query_RecFindUsdr);
    $stmt->execute([$muser]);
    if ($stmt->rowCount() == 0) {
        header("Location: admin_passmail.php?errMsg=1&username={$muser}");
    } else {
        $arr = $stmt->fetchAll()[0];
        $email = $arr["email"];
        // echo $email;
        // 取出其中的email值
        $newPassword = MakePass(10);
        $newPassword2 = $newPassword;
        $newPassword3 = sha1($newPassword);
        // $mpass = password_hash($newPassword, PASSWORD_DEFAULT)
        $sqlPasswordUpdate = "UPDATE `member` SET `password`='{$newPassword3}' WHERE `email` = ? ";
        // $Ppd->query($sqlPasswordUpdate);
        $stmt2 = $pdo->prepare($sqlPasswordUpdate);
        $stmt2->execute([$email]);


        // 連接資料庫更改密碼
        // 以下開始寄信
        $objResponse = [];
        $objResponse['success'] = true;
        $objResponse['info'] = "您的新密碼為{$newPassword}";

        $mailcontent = "你好，<br> 您的帳號為:{$email} <br> 您的新密碼為:{$newPassword}<br>";
        $mailFrom ="=?UTF-8?B?" . base64_encode("會員管理系統") . "?=<service@e-happy.com.tw>";
        $mailto = $email;
        $mailSubject ="=?UTF-8?B?" . base64_encode("補寄密碼信") . "?=";
        $mailHeader = "From:".$mailFrom."\r\n";
        $mailHeader.= "Content-type:text/html;charset=UTF-8";
        // if (!@mail($mailto, $mailSubject, $mailcontent, $mailHeader)) die("郵寄失敗!");
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
        // header("Refresh: 5;url=./index.php");
        
        

        

        // include("./PHPMailer/_lib/class.phpmailer.php");
        // mb_internal_encoding('UTF-8');

        // $mail = new PHPMailer();
        // $mail->IsSMTP();
        // $mail->SMTPAuth = true ;
        // $mail->SMTPSecure = "ssl";
        // $mail->Host = "ssl://smtp.gmail.com";
        // $mail->Port = 465;
        // $mail->CharSet = "utf8";

        // $mail->Username = "develcatman2@gmail.com";
        // $mail->Password = "qqpr1557";

        // $mail->From = "develcatman2@gmail.com";
        // $mail->FromName = "你今晚的惡夢";

        // $mail->Subject = "測試用";
        // $mail->Body = "你好啊";
        // $mail->IsHTML(true);
        // $mail->AddAddress($email,"{$email}");
        // if (!$mail->send()) die("郵寄失敗!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我忘記密碼了</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./memberCss.css">
</head>

<body>
    <?php if (isset($_GET["mailStats"]) && ($_GET["mailStats"] == "1")) { ?>
        <script>
            alert('密碼信寄件成功!');
            // window.location.href = 'index.php'
        </script>
        
    <?php } ?>
    <?php
    require_once './templates/tittle.php'
    ?>
    <form class="w-350 mx-auto p-5 bgg" name="myForm" method="POST" action="">

        <?php  ?>


        <div class="form-group mb-4">
            <h3>忘記密碼T T</h3>
            <p>請輸入您的帳號，系統將發送十位數密碼至您的信箱</p>

            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Email Address 會員帳號" name="m_email" value="" id="m_email" maxlength="50">
        </div>

        <div class="d-flex justify-content-around">
            <input type="submit" name="button" id="button" class="btn btn-warning" value="寄送密碼信"></input>
            <input type="button" name="button2" id="button2" value="回到上一頁" onclick="window.history.back();">
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>