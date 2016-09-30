<?php
@session_start();
//未登录，跳转至欢迎界面
if (!isset($_SESSION['user'])) {
    header('location:welcome.php');
    exit();   //防止继续执行
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once 'public/layout/header.php'?>
    <link rel="stylesheet" href="public/css/home.css" type="text/css">
</head>
<body>
<!--导航栏-->
<?php require_once 'public/layout/nav.php'?>
<!--主体内容-->
<?php require_once 'public/layout/home.php'?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/form.js"></script>
</body>
</html>
<!--