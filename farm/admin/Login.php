<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/9/16
 * Time: 1:50
 */
class Login
{
    private $email;
    private $password;
    private $code;

    function __construct()
    {
        if(!isset($_POST['type'])){  //非 post 方式提交不接受
            echo "<script>alert('You access the page does not exist!');history.go(-1);</script>";
            exit();
        }
        require "config.php";//引入配置文件
        $this->db = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME) or die('Database connection exception');
    }
    //检查验证码
    public function checkCode()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
                $this->code = $_POST['code'];    //接受用户名
                if ($this->code == $_SESSION['code']) {
                    echo "1".header('Content-type:text/plain');
                }else{
                    echo "0".header('Content-type:text/plain');
                }
            }
        }else{    //非ajax方式
            if ($this->code != $_SESSION['code']) {
                echo "<script>alert('Verification code is incorrect');history.go(-1);</script>";
                exit();
            }
        }
    }

    //验证邮箱格式
    public function checkMail()
    {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if (!preg_match($pattern,$this->email)) {
            echo "<script>alert('Email format is incorrect');history.go(-1);</script>";
            exit();
        }
    }
    //验证密码格式
    public function checkPwd()
    {
        if (!trim($this->password) == '') {
            $strlen = strlen($this->password);
            if ($strlen < 6 || $strlen > 20) {
                echo "<script>alert('Password length:6-20');history.go(-1);</script>";
                exit();
            }else{
                $this->password = md5($this->password);
            }
        }else{
            echo "<script>alert('Please enter the password');history.go(-1);</script>";
            exit();
        }
    }

    //用户和密码验证
    public function checkUser()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
                $this->password = $_POST['password'];
                $this->email = $_POST['email'];
                $pwd= md5($this->password);
                $sql = "SELECT username FROM users WHERE email = '".$this->email."' and password = '".$pwd."'";
                $row = mysqli_fetch_row($this->db->query($sql));
                $result = $row[0];
                if ($result) {
                    echo "1".header('Content-type:text/plain');
                }else{
                    echo "0".header('Content-type:text/plain');
                }
            }
        }else{    //非ajax方式
            $sql = "SELECT username FROM users WHERE email = '".$this->email."' and password = '".$this->password."'";
            $row = mysqli_fetch_row($this->db->query($sql));
            $result = $row[0];
            if (!$result) {        //用户名不存在，登陆失败
                echo "<script>alert('Email or password is incorrect, please try again');history.go(-1);</script>";
                exit();
            }else{        //用户存在，登陆成功
                $_SESSION['user'] = $result;    //将用户名保存到 session 会话中
                $this->db->close();        //关闭数据库连接
                //输出登陆成功信息，并跳转到主页
                echo "<script>alert('Login success!');location.href = '../index.php'</script>";
                exit();
            }
        }
    }

    public function doLogin()
    {
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        $this->code = $_POST['code'];
        $this->checkCode();
        $this->checkMail();
        $this->checkPwd();
        $this->checkUser();
    }

}
session_start();
$login = new Login();
switch ($_POST['type']) {    //根据传递的type执行对应操作
    case 'code':
        $login->checkCode();
        break;
    case 'password':
        $login->checkUser();
        break;
    case 'all':
        $login->doLogin();
        break;
    default:
        echo "wrong";
        break;
}
