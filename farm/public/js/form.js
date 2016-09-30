/**
 * Created by dell on 2016/9/16.
 */
$(function(){
    /*Register form*/
    $(document).on("input", function () {});
    $('#username').on('blur',function(){
        var len=$(this).val().length;
        if(len>=2&&len<=20){
            $('#dis_un').text('');
            var val=$(this).val();
            $.post('admin/Register.php',{username:val,type:'name'},function(data,status,xhr){
               if(status=='success'){
                    console.log(data);
                    if(data=="1"){
                        $('#dis_un').text('This username has been registered');
                    }
                }else {
                    console.log(status)
                }
            })
        }else {
            $('#dis_un').text('length of username:2-20');
        }
    });

    $('#remail').on('blur',function() {    //注册邮箱失去焦点才检测
        if ($(this).val() != '') {    //输入不为空就检测
            var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;    //正则表达式判断邮箱格式
            if (reg.test($(this).val())) {    //是邮箱格式
                $.post('admin/Register.php', {email: $(this).val(),type: 'email'}, function(data, textStatus, xhr) {
                    if (textStatus == 'success') {
                        if (data == '1') {    //后台返回1 表示已被注册
                            $('#dis_em').text('This email address has been registered');
                        }else{    //邮箱可用
                            $('#dis_em').text('');
                        }
                    }
                });
            }else{    //不是邮箱格式
                $('#dis_em').text('Please enter a valid email address');
            }
        }else{
            $('#dis_em').text('Please enter email address');
        }
    });

    $('#password').on('blur',function(){    //密码检测
        if ($(this).val() == '') {
            $('#dis_pwd').text('Please enter password');
        }else if(($(this).val().length < 6)||($(this).val().length > 20)){
            $('#dis_pwd').text('Password length:6-20');
        }else{
            $('#dis_pwd').text('');
        }
    });

    $('#confirm').on('blur',function() {    //确认密码检测
        var val = $('#password').val();
        if (val != '') {
            if ($(this).val() == '') {
                $('#dis_con_pwd').text('Please enter password again');
            }else if($(this).val() != val){
                $('#dis_con_pwd').text('Password is inconsistent');
                $('#reg_btn').addClass('disabled');
            }else{
                $('#dis_con_pwd').text('');
                $('#reg_btn').removeClass('disabled');
            }
        }else{
            $('#dis_con_pwd').text('');
        }
    });
    $('#code').on('blur',function(){
        if($(this).val()==''){
            $('#dis_code').text('Please enter verification code');
        }else{
            $.post('admin/Register.php',{code:$(this).val(),type:'code'},function(data,textStatus,xhr){
                if(textStatus=='success'){
                    if(data=='0'){
                        $('#dis_code').text('verification code is incorrect');
                    }else{
                        $('#dis_code').text('');
                    }
                }
            })
        }
    });




    /*Login Form 登录表单*/
    $('#email').on('blur',function() {    //邮箱失去焦点才检测
        if ($(this).val() != '') {    //输入不为空就检测
            var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;    //正则表达式判断邮箱格式
            if (reg.test($(this).val())) {    //是邮箱格式
                $('#not_em').text('');
            }else{    //不是邮箱格式
                $('#not_em').text('Please enter a valid email address');
            }
        }else{
            $('#not_em').text('Please enter email address');
        }
    });
    $('#lpassword').on('blur',function(){
        if($(this).val()==''){
            $('#not_pwd').text('Please enter password');
        }else if(($(this).val().length < 6)){
            $('#not_pwd').text('Password length:6-20');
        }else {
            $('#not_pwd').text('');
            $.post('admin/Login.php',{password:$(this).val(),email:$('#email').val(),type:'password'},function(data,textStatus,xhr){
                if(textStatus=='success'){
                    if(data=='0'){
                        $('#not_user').text('Email or password is incorrect, please try again');
                        $('#login_btn').addClass('disabled');
                    }else{
                        $('#not_user').text('');
                        $('#login_btn').removeClass('disabled');
                    }
                }
            })
        }
    });
    $('#lcode').on('blur',function(){
        if ($(this).val() == '') {
            $('#not_code').text('Please enter verification code');
        }else{
            $.post('admin/Login.php',{code:$(this).val(),type:'code'},function(data,textStatus,xhr){
                if(textStatus=='success'){
                    if(data=='0'){
                        $('#not_code').text('verification code is incorrect');
                    }else {
                        $('#not_code').text('');
                    }
                }
            })
        }
    });


});