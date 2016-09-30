<?php
//订单插入数据库
function insert_order($order_details,$user){
    //extract($order_details);
    @$ship_name=$order_details['ship_name'];
    @$ship_address=$order_details['ship_address'];
    @$ship_tel=$order_details['ship_tel'];
    $db = db_connect();

    //开始事务，需将自动提交关闭
    $db->autocommit(FALSE);
    //获取用户id
    $query = "select id from users where username='".$user."'";
    $result = @$db->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $row = $result->fetch_row();
    $id = $row[0];
    //时间
    $date = date("Y-m-d");

    //将送货信息插入orders表格
    $query = "insert into orders values ('','".$id."','".$_SESSION['total_price']."',
    '".$date."','".$ship_name."','".$ship_address."','".$ship_tel."','')";
    //$query = "INSERT INTO orders(orderid, id, amount, date, ship_name, ship_address, ship_tel, order_status) VALUES ('','1','2','3','4','5','6','7')";
    $result = @$db->query($query);
    if (!$result) {
        return false;
    }

    //获取orderid
    $query = "select orderid from orders where id='".$id."' and
     amount > (".$_SESSION['total_price']."-.001) and
     amount < (".$_SESSION['total_price']."+.001) and
     date = '".$date."' and
     ship_name='".$ship_name."' and
     ship_address='".$ship_address."' and
     ship_tel='".$ship_tel."'";
    $result = @$db->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $row = $result->fetch_row();
    $orderid = $row[0];

    //将orderid保存到会话中，当订单付款后，修改订单状态
    $_SESSION['orderid']=$orderid;

    //将订单项目插入order_items
    foreach($_SESSION['cart'] as $productid =>$qty){
        $detail = get_product_detail($productid);
        $query = "delete from order_items where
              orderid = '".$orderid."' and productid = '".$productid."'";
        $result = $db->query($query);
        if(!$result) {
            return false;
        }
        $query = "insert into order_items values
              ('".$orderid."', '".$productid."', ".$detail['price'].", $qty)";
        $result = $db->query($query);
        if(!$result) {
            return false;
        }
    }

    //结束事务
    $db->commit();
    $db->autocommit(TRUE);

    return $id;
}
//处理提交的付款表单
function process_card($card_details) {
    // 处理用户信用卡/银行卡，此处省略
    //修改数据库中订单状态
    $db = db_connect();
    $query = "update orders set order_status = 'paid' where orderid = '".$_SESSION['orderid']."'";
    $result = $db->query($query);
    if(!$result) {
        return false;
    }
    return true;
}