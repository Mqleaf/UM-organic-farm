/**
 * Created by dell on 2016/9/20.
 */
$(function(){
    $('#ship_name').blur(function(){
        var len=$(this).val().length;
        if(len>=2&&len<=20){
            var reg=/^[A-Za-z0-9\u4e00-\u9fa5]+$/;
            if(reg.test($(this).val())){
                $('#nok_name').text('');
            }else{
                $('#nok_name').text('Please enter a valid name');
            }
        }else {
            $('#nok_name').text('Length of name:2-20');
        }
    });
    $('#ship_address').blur(function(){
        if ($(this).val() == '') {
            $('#nok_address').text('Please enter an address');
        }else if($(this).val().length < 10){
            $('#nok_address').text('Length of address cannot less than 10');
        }else{
            $('#nok_address').text('');
        }
    });
    function checkTel(val){
        if (val!= '') {
            var reg1 = /\(?(13|14|15|18)(\d)\)?[ -.]?(\d{4})[ -.]?(\d{4})/;
            var reg2 = /[0-9-()（）]{7,18}/;
            if (reg1.test(val)||reg2.test(val)) {
                $('#nok_tel').text('');
                $('#purchase').removeClass("disabled");
            }else{
                $('#nok_tel').text('Please enter a valid telephone number');
                $('#purchase').addClass("disabled");
            }
        }else{
            $('#nok_tel').text('Please enter telephone number');
            $('#purchase').addClass("disabled");
        }
    }
    $('#ship_tel').blur(function() {
        var val = $(this).val();
        checkTel(val);
    });
    $('form').submit(function(){
        if(($('#nok_name').text()!='')||($('#nok_address').text()!='')||($('#nok_tel').text()!='')){
            return false;
        }
        if($('#ship_name').val()==''||$('#ship_address').val()==''||$('#ship_tel').val()==''){
            return false;
        }
        checkTel($('#ship_tel').val());
    })
});