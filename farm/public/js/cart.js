/**
 * Created by dell on 2016/9/20.
 */
$(document).ready(function(){
    function updateTotal(){
        var len = $('.item').length;
        var count = 0.00;
        var total = 0;
        for(var i=0;i<len;i++){
            count += parseInt($('.qty').eq(i).val());
            total += $('.qty').eq(i).val()*$('.price').eq(i).text();
        }
        total = total.toFixed(2);
        $('.count span').text(count);
        $('.total').text(total);
    }
    function updateSubtotal(count){
        var qty = count.val();
        var price = parseFloat(count.parent().prev('.price').text());
        var subtotal = (qty*price).toFixed(2);
        count.parent().next('.subtotal').text(subtotal);
    }
    //更改数量时，更新小计和总计
    $('.qty').change(function(){
        updateSubtotal($(this));
        updateTotal();
        var id=$(this).attr('name');
        var num=$(this).val();
        $.post('cart.php',{id:id,num:num,save:true},function(data,textStatus,xhr){
            if(textStatus=='success'){
            }else{
                alert('Cannot modify the cart,please try again.');
            }
        })
    });
    //删除项目
    $('.remove').click(function() {
        $(this).parents('tr').find('.qty').val(0);
        $(this).parents('tr').hide();
        updateTotal();
        var id = $(this).parents('tr').find('.qty').attr('name');
        var num = $(this).parents('tr').find('.qty').val();
        $.post('cart.php',{id:id,num:num,save:true},function(data,textStatus,xhr){
            if(textStatus=='success'){
            }else{
                alert('Cannot modify the cart,please try again.');
            }
        })
    });
});