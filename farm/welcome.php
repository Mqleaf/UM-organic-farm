<?php
@session_start();    //开始 session
//已登录，跳转至主页
if (isset($_SESSION['user'])) {
    header('location:index.php');
    exit();
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
<!--注册表单/登录表单-->
<?php require_once 'public/layout/form.php'?>
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