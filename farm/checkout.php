<?php
include ('admin/cart/product_sc_fns.php');
@session_start();

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php require_once 'public/layout/header.php'?>
</head>
<body>
<!--导航栏-->
<?php require_once 'public/layout/nav.php'?>
<!--主体内容-->
<?php
do_html_header("Checkout");
if(($_SESSION['cart'])&&(array_count_values($_SESSION['cart']))){
    display_cart($_SESSION['cart'],false,0);
    display_checkout_form();
}else{
    display_cart_warning();
}
?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/checkout.js"></script>
</body>
</html>
<!--