/**
 * Created by dell on 2016/9/10.
 */
$(function(){
    $('body').scrollspy({target:'.side-nav'});
    $('#mytab a').click(function(){
        $(this).tab('show');
    });
    $("[data-toggle='tooltip']").tooltip();
    FastClick.attach(document.body);
});