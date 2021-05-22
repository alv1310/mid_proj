<?php
require_once './templates/tittle_admin.php';
?>
<!DOCTYPYE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>我的 PHP 程式</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <style>
            .border {
                border: 1px solid;
            }
        </style>
    </head>

    <body>
        這裡是後端管理頁面 - <a href="./acadmin.php">活動列表</a> | <a href="./acnew.php">新增頁面</a>
        <hr />
        <form name="myForm" method="POST" action="./acinsert.php" enctype="multipart/form-data">
            <table class="border">
                <thead>
                    <tr>
                        <th class="border">名稱</th>
                        <th class="border">地區</th>
                        <th class="border">價格</th>
                        <th class="border">最早預定時間</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border">
                            <input type="text" name="acname" id="acname" value="" maxlength="100" />
                        </td>
                        <td class="border">
                            <input type="text" name="acregion" id="acregion" value="" maxlength="100" />
                        </td>
                        <td class="border">
                            <input type="Int" name="acprice" id="acprice" value="" maxlength="100" />
                        </td>
                        <td class="border">
                            <input type="Int" name="acearliestday" id="acearliestday" value="" maxlength="100" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border" colspan="5"><input type="submit" name="smb" value="新增"></td>
                    </tr>
                </tfoot>
            </table>
        </form>

    </body>

    </html>