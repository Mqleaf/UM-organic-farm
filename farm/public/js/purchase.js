/**
 * Created by dell on 2016/9/22.
 */
$(function(){
    //5432123456789012
    //从右到左，奇数位直接相加，偶数位*2（如果>9，则个位数+十位数），两个和相加%10
    function luhnCheckSum(sCardNum){
        var iEvenSum=0;
        var iOddSum=0;
        var bIsEven=true;
        for(var i=sCardNum.length-1;i>=0;i--)
        {
            var iNum=parseInt(sCardNum.charAt(i));
            if(bIsEven)
            {
                iEvenSum+=iNum
            }
            else
            {
                iNum=iNum*2;
                if(iNum>9)
                {
                    iNum=eval(iNum.toString().split("").join("+"));
                }
                iOddSum+=iNum;
            }
            bIsEven=!bIsEven
        }
        return((iEvenSum+iOddSum)%10==0);
    }
    $('#card_number').blur(function(){
        var val=$(this).val();
        if (val != '') {
            var reg1;
            if($('#card_type').val()=='Credit Card'){
                reg1 = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|35(?:[2][8-9][0-9]{12}|[3-8][0-9]{13})|3[47][0-9]{13})$/;
            }else{
                reg1 = /^[0-9]{16,19}$/;
            }
            if (reg1.test(val)&&luhnCheckSum(val)) {
                $('#nok_card_number').text('');
                $('#pay').removeClass("disabled");
            }else{
                $('#nok_card_number').text('Please enter a valid card number');
                $('#pay').addClass("disabled");
            }
        }else{
            $('#nok_card_number').text('Please enter card number');
        }
    });
    $('#card_password').blur(function(){
        var val=$(this).val();
        if (val == '') {
            $('#nok_card_password').text('Please enter password');
        }else{
            $('#nok_card_password').text('');
        }
    });
    $('form').submit(function(){
        if(($('#nok_card_number').text()!='')||($('#nok_card_password').text()!='')){
            return false;
        }
        if($('#card_number').val()==''||$('#card_password').val()==''){
            return false;
        }
    })
});