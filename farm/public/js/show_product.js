/**
 * Created by dell on 2016/9/19.
 */
$(document).ready(function(){
    //验证产品数量
    function checkQuantity(){
        var quantity = $('#quantity').val();
        if(quantity==''||quantity<1){
            $('#add_to_cart').addClass("disabled");
            $('h6').text('Product quantity is wrong');
        }else{
            $('#add_to_cart').removeClass("disabled");
            $('h6').text('');
        }
    }
    checkQuantity();
    $('#quantity').change(function(){
        checkQuantity();
    })
});