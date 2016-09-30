<?php
include ('admin/cart/product_sc_fns.php');
@session_start();
$productid = $_GET['productid'];
$product = get_product_detail($productid);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once 'public/layout/header.php'?>
    <link rel="stylesheet" href="public/css/show_product.css">
</head>
<body>
<!--导航栏-->
<?php require_once 'public/layout/nav.php'?>
<!--注册表单/登录表单-->
<?php require_once 'public/layout/form.php'?>
<!--主体内容-->
<?php
do_html_header($product['title']);
display_product_detail($product);
?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/form.js"></script>
<script src="public/js/show_product.js"></script>
</body>
</html>
<!--