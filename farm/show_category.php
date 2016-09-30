<?php
include ('admin/cart/product_sc_fns.php');
@session_start();
$catid = $_GET['catid'];
$name = get_category_name($catid);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once 'public/layout/header.php'?>
    <link rel="stylesheet" href="public/css/show_category.css">
</head>
<body>
<!--导航栏-->
<?php require_once 'public/layout/nav.php'?>
<!--注册表单/登录表单-->
<?php require_once 'public/layout/form.php'?>
<!--主体内容-->
<?php
do_html_heading($name);
$product_array = get_products($catid);
display_products($product_array);
?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/form.js"></script>
</body>
</html>
<!--