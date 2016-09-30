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
do_html_header("Order is Processed");
//获取数据
@$card_type=$_POST['card_type'];
@$card_number=$_POST['card_number'];
@$card_password=$_POST['card_password'];
//验证表单
validateCardNumber($card_number,$card_type);
//显示购物车或提示
if(($_SESSION['cart'])&&(array_count_values($_SESSION['cart'])&&($card_type)&&($card_number)&&($card_password))){
    display_cart($_SESSION['cart'],false,0);
    display_shipping(calculate_shipping_cost());
    //处理提交的付款表单，此处直接返回true，真实项目需更改
    if(process_card($_POST)){
        $_SESSION['cart']=array();
        $_SESSION['total_price']=0.00;
        $_SESSION['items']=0;
        $_SESSION['orderid']="";
        echo "<div class='well'>Thank you for shopping with us, your order has been placed.</div>";
    }else{
        echo "<div class='well'>Could not process your card.Please try again.</div>";
    }
}else{
    display_purchase_warning('You did not fill in all fields, please try again','purchase.php');
}

?>

<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/fastclick.js"></script>
<script src="public/js/home.js"></script>
</body>
</html>
<!--