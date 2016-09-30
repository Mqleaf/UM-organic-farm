<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/9/24
 * Time: 13:54
 */
//purchase验证checkout提交的表单
function validateName($name){
    $len=strlen($name);
    if($len<2||$len>20){
        display_purchase_warning('Length of name:2-20','javascript:history.go(-1)');
        exit();
    }else{
        $pattern = '/^[A-Za-z0-9\x{4e00}-\x{9fa5}]+$/u';
        $result = preg_match($pattern,$name);
        if(!$result){
            display_purchase_warning('Please enter a valid name','javascript:history.go(-1)');
            exit();
        }
    }
}
function validateAddress($address){
    if(strlen($address)==0){
        display_purchase_warning('Please enter address','javascript:history.go(-1)');
        exit();
    }else if(strlen($address)<10){
        display_purchase_warning('Length of address cannot less than 10','javascript:history.go(-1)');
        exit();
    }
}
function validateTel($tel){
    if(strlen($tel)==0){
        display_purchase_warning('Please enter telephone number','javascript:history.go(-1)');
        exit();
    }else{
        $pattern1 = "/\\(?(13|14|15|18)(\\d)\\)?[ -.]?(\\d{4})[ -.]?(\\d{4})/";
        $pattern2 = "/[0-9-()（）]{7,18}/";
        @$result = preg_match($pattern1,$tel)||preg_match($pattern2,$tel);
        if (!$result) {
            display_purchase_warning('Please enter a valid telephone number','javascript:history.go(-1)');
            exit();
        }
    }
}
//process验证purchase提交的表单
//从右到左，奇数位直接相加，偶数位*2（如果>9，则个位数+十位数），两个和相加%10
function luhnCheckSum($sCardNum){
    $iEvenSum=0;
    $iOddSum=0;
    $bIsEven=true;
    for($i=strlen($sCardNum)-1;$i>=0;$i--){
        $iNum=(int)substr($sCardNum,$i,1);
        if($bIsEven)
        {
            $iEvenSum+=$iNum;
        }
        else
        {
            $iNum=$iNum*2;
            if($iNum>9)
            {
                $iNum =intval($iNum/10)+($iNum%10);
            }
            $iOddSum+=$iNum;
        }
        $bIsEven=!$bIsEven;
    }
    return(($iEvenSum+$iOddSum)%10==0);
}
function validateCardNumber($number,$type){
    if(strlen($number)==0){
        display_purchase_warning('Please enter card number','javascript:history.go(-1)');
        exit();
    }else{
        if($type=='Credit Card'){
            $reg= "/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|35(?:[2][8-9][0-9]{12}|[3-8][0-9]{13})|3[47][0-9]{13})$/";
        }else{
            $reg= "/^[0-9]{16,19}$/";
        }
        @$result = preg_match($reg,$number)||preg_match($reg,$number);
        if (!($result&&luhnCheckSum($number))) {
            display_purchase_warning('Please enter a valid card number','javascript:history.go(-1)');
            exit();
        }
    }
}
?>