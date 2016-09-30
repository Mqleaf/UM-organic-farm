<div class="container">
    <div class="content">
        <!-- 注册表单 -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="register" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Register</h4>
                    </div>
                    <form id="register" action="admin/Register.php" method="post" accept-charset="utf-8" class="form-horizontal">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username" class="col-sm-3 control-label sr-only">Username:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="username" id="username" minlength="2" maxlength="20" placeholder="Username" required="">
                                </div>
                                <!-- 错误提示信息 -->
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="dis_un"></h6>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label sr-only">Email:</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" id="remail" placeholder="Email" required="">
                                </div>
                                <!-- 错误提示信息 -->
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="dis_em"></h6>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label sr-only">Password:</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="6" maxlength="20" required="">
                                </div>
                                <!-- 错误提示信息 -->
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="dis_pwd"></h6>
                            </div>

                            <div class="form-group">
                                <label for="confirm" class="col-sm-3 control-label sr-only">Confirm password:</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm password" minlength="6" maxlength="20" required="">
                                </div>
                                <!-- 错误提示信息 -->
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="dis_con_pwd"></h6>
                            </div>

                            <div class="form-group">
                                <label for="code" class="col-sm-3 control-label sr-only">Verification code :</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="code" id="code" placeholder="Verification code" required="" maxlength="4" size="100">
                                </div>
                                <!-- 错误提示信息 -->
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="dis_code"></h6>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <img src="admin/Captcha.php" alt="" id="codeimg" onclick="javascript:this.src = 'admin/Captcha.php?'+Math.random();">
                                    <span>Click image to switch code</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="reset" class="btn btn-default" value ="Reset" />
                            <button type="submit" class="btn btn-success" id="reg_btn">Register</button>
                        </div>

                        <input type="hidden" name="type" value="all">
                    </form>
                </div>
            </div>
        </div>

        <!-- 登陆表单 -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="login" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Login</h4>
                    </div>
                    <form id="login" action="admin/Login.php" method="post" accept-charset="utf-8" class="form-horizontal">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label sr-only">Email:</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="">
                                </div>
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="not_em"></h6>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label sr-only">Password:</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" id="lpassword" placeholder="Password" minlength="6" maxlength="20" required="">
                                </div>
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="not_pwd"></h6>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-sm-3 control-label sr-only">Verification code :</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="code" id="lcode" placeholder="Verification code" required="" maxlength="4">
                                </div>
                                <h6 style="margin-left:1.5rem;color: #a63807;" id="not_code"></h6>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <img src="admin/Captcha.php" alt="" id="codeimg" onclick="javascript:this.src = 'admin/Captcha.php?'+Math.random();">
                                    <span>Click image to switch code</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3">
                                    <h6 style="color: #a63807;" id="not_user"></h6>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="reset" class="btn btn-default" value ="Reset" />
                            <button id="login_btn" type="submit" class="btn btn-success" name="login">Login</button>
                        </div>

                        <input type="hidden" name="type" value="all">

                    </form>
                </div>
            </div>
        </div>

    </div><!-- /.content -->
</div><!-- /.container -->
