<?php
require_once('./db.inc.php');


switch ($_REQUEST['state']) {
    case 1:
        echo '新增';
        $sqlAdd = "INSERT INTO `productcategory` (`cat_id`, `cat_name`) VALUES (?,?)";
        $arrAdd = [$_REQUEST['cat_id_new'], $_REQUEST['cat_name_new']];
        $stmtAdd = $pdo->prepare($sqlAdd);
        $stmtAdd->execute($arrAdd);
        header('refresh:0.1;url=./productcategory.php');
        break;

    case 2:
        echo "編輯";
        $sqlEdit = "UPDATE `productcategory` SET `cat_id` = ?, `cat_name` = ? WHERE id = ?";
        $stmt = $pdo->prepare($sqlEdit);
        // $strIds = join(",", $_REQUEST['id']);
        // $strCatIds = join(",", $_REQUEST['cat_id']);
        // $strCatnames = join(",", $_REQUEST['cat_name']);
        for ($i = 0; $i < count($_REQUEST['id']); $i++) {
            $arrCatSingle = [$_REQUEST['cat_id'][$i], $_REQUEST['cat_name'][$i], $_REQUEST['id'][$i]];
            $stmt->execute($arrCatSingle);
        }
        // 接著刪除
        if (isset($_REQUEST['chk'])) {
            $strIds = join(",", $_REQUEST['chk']);
            $sqlDelete = "DELETE FROM `productcategory` WHERE FIND_IN_SET (`cat_id`,?)";
            $stmtDelte = $pdo->prepare($sqlDelete);
            $stmtDelte->execute([$strIds]);
        }

        header('refresh:1;url=./productcategory.php');
        echo "更新完成";
        break;

    default:
        header('refresh:2;url=./productcategory.php');
        echo '未有任何更新';
}
