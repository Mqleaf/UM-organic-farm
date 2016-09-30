<!--数据库函数：连接数据库，查询结果转为数组-->
<?php
require "admin/config.php";
function db_connect(){
    @$result = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    if(!$result){
        return false;
    }
    $result->autocommit(TRUE);
    return $result;
}
function db_result_to_array($result){
    $res_array = array();
    for($i=0;$row=$result->fetch_assoc();$i++){
        $res_array[$i]=$row;
    }
    return $res_array;
}
?>