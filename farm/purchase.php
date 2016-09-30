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
do_html_header("Payment");
//获取数据
@$ship_name=$_POST['ship_name'];
@$ship_address=$_POST['ship_address'];
@$ship_tel=$_POST['ship_tel'];
//表单验证
validateName($ship_name);
validateAddress($ship_address);
validateTel($ship_tel);
//显示购物车或提示
if(($_SESSION['cart'])&&(array_count_values($_SESSION['cart'])&&($ship_name)&&($ship_address)&&($ship_tel))){
    //数据成功插入数据库，显示购物车，运费，账单
    if(insert_order($_POST,$_SESSION['user'])!=false){
        display_cart($_SESSION['cart'],false,0);
        display_shipping(calculate_shipping_cost());
        display_card_form($ship_name);
    }else{
        display_purchase_warning('Could not store data, please try again.');
    }
}else{
    display_purchase_warning('You did not fill in all fields, please try again');
}

?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
<script src="public/js/purchase.js"></script>
</body>
</html>
<!--