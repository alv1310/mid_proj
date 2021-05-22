<!-- 以下為情報誌用 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand mr-3" href="#">後台管理介面</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="../../admin/admin.php" class="btn btn-light mr-3">會員管理</a>
        <a href="../../productlist.php" class="btn btn-light mr-3">產品管理</a>
        <a href="../../acadmin.php" class="btn btn-light mr-3">活動管理</a>
        <a href="../../cart.php" class="btn btn-light mr-3">訂單系統</a>
        <a href="../../orderPlaceIndex.php" class="btn btn-light mr-3">場地預約管理</a>
        <div class="collapse navbar-collapse mr-3" id="navbarNavAltMarkup">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    情報誌
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="./admin.php">文章列表 </a>
                    <a class="dropdown-item" href="./category.php">文章類別 </a>
                    <a class="dropdown-item" href="./new.php">新增文章 </a>
                    <a class="dropdown-item" href="./atag.php">文章標籤 </a>
                </div>
            </div>
        </div>
    </div>

    <a href="#" onclick="window.open(' ../../templates/clearcart.php ', '清空購物車', config='height=100,width=100');">清空購物車</a>
    　|　
    <a href="../../index.php">檢視前台</a>　|　
    <a href="../../logout.php?logout=1">登出</a></div>
</nav>


</body>

</html>