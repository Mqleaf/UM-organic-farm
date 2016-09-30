<?php
//产品类型名
function get_category_name($catid) {
    // query database for the name for a category id
    $db = db_connect();
    $query = "select catname from categories
             where catid = '".$catid."'";
    $result = @$db->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $row = $result->fetch_object();
    return $row->catname;
}
//产品列表
function get_products($catid){
    if((!$catid)||($catid=='')) {
        return false;
    }
    $db = db_connect();
    $query = "select * from products where catid ='".$catid."'";
    $result = @$db->query($query);
    if(!$result){
        return false;
    }
    $num_products = @$result->num_rows;
    if($num_products==0){
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
}
//产品详情
function get_product_detail($productid){
    if((!$productid)||($productid=='')){
        return false;
    }
    $db = db_connect();
    $query = "select * from products where productid ='".$productid."'";
    $result = @$db->query($query);
    if(!$result){
        return false;
    }
    $result = @$result->fetch_assoc();
    return $result;
}
//计算价格
function calculate_price($cart) {
    $price = 0.0;
    if(is_array($cart)) {
        $conn = db_connect();
        foreach($cart as $new => $qty) {
            $query = "select price from products where productid='".$new."'";
            @$result = $conn->query($query);
            if ($result) {
                $item = $result->fetch_assoc();
                $item_price = $item['price'];
                $price +=$item_price*$qty;
            }
        }
    }
    return $price;
}
//计算数量
function calculate_items($cart){
    $items=0;
    if(is_array($cart)){
        foreach($cart as $new => $qty){
            $items +=$qty;
        }
    }
    return $items;
}
//计算运费，先按统一费用，需要再修改
function calculate_shipping_cost() {
    return 10.00;
}
?>