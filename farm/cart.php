<?php
include ('admin/cart/product_sc_fns.php');
@session_start();    //开始 session
@$new = $_GET['new'];//从产品列表添加到购物车
@$quantity = $_GET['quantity'];
//session中创建购物车
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
    $_SESSION['items']=0;
    $_SESSION['total_price']=0.00;
}
//增加新商品
if($new){
    //计算
    if(isset($_SESSION['cart'][$new])){
        $_SESSION['cart'][$new]+=$quantity;
    }else{
        $_SESSION['cart'][$new]=$quantity;
    }
    $_SESSION['total_price']=calculate_price($_SESSION['cart']);
    $_SESSION['items']=calculate_items($_SESSION['cart']);
}
//保存数量修改
if(isset($_POST['save'])){
    $id=$_POST['id'];
    $num=$_POST['num'];
    if($num =='0'){
        unset($_SESSION['cart'][$id]);
    }else{
        $_SESSION['cart'][$id]=$num;
    }
    $_SESSION['total_price']=calculate_price($_SESSION['cart']);
    $_SESSION['items']=calculate_items($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'public/layout/header.php'?>
    <link rel="stylesheet" href="public/css/cart.css">
</head>

<body>
<!--导航栏-->
<?php require_once 'public/layout/nav.php'?>
<!--注册表单/登录表单-->
<?php
if(!isset($_SESSION['user'])){
    require_once 'public/layout/form.php';
}
?>
<!--主体内容-->
<?php
do_html_header('Shopping Cart');
//显示商品
if(($_SESSION['cart'])&&(array_count_values($_SESSION['cart']))){
    display_cart($_SESSION['cart']);
    display_cart_btns($new);
}else{
    display_cart_warning();
}
?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/form.js"></script>
<script src="public/js/cart.js"></script>
</body>
</html>
<!--