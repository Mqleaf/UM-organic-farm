<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/9/15
 * Time: 23:03
 */
class Register{
    private $username;
    private $db;
    private $email;
    private $pwd;
    private $con;
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
    //验证用户名唯一性
    public function uniqueName()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            if('xmlhttprequest'==strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
                $this->username = $_POST['username'];    //接受用户名
                $sql = "SELECT * FROM users WHERE username = '".$this->username."'";  //查询
                $query = $this->db->query($sql);//获取结果
                $row = mysqli_fetch_row($query);
                $count = $row[0];
                if ($count) {
                    echo "1".header('Content-type:text/plain');//header('Content-type:text/plain')是解决新浪云未实名认证时的提示信息，一般不用写
                }else{
                    echo "0".header('Content-type:text/plain');
                }
            }
        }else{
            $sql = "SELECT * FROM users WHERE username = '".$this->username."'";  //查询
            $row = mysqli_fetch_row($this->db->query($sql));
            $count = $row[0];
            if($count){
                echo "<script>alert('This username has been registered');history.go(-1);</script>";
                exit();
            }
        }

    }

    //验证邮箱唯一性
    public function uniqueEmail(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            if('xmlhttprequest'==strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
                $this->email = $_POST['email'];    //接受用户名
                $sql = "SELECT * FROM users WHERE email = '".$this->email."'";   //查询
                $row = mysqli_fetch_row($this->db->query($sql));
                $count = $row[0];
                if ($count) {
                    echo "1".header('Content-type:text/plain');
                }else{
                    echo "0".header('Content-type:text/plain');
                }
            }
        }else{
            $sql = "SELECT * FROM users WHERE email = '".$this->email."'";   //查询
            $row = mysqli_fetch_row($this->db->query($sql));
            $count = $row[0];
            if($count){
                echo "<script>alert('This email address has been registered');history.go(-1);</script>";
                exit();
            }
        }
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
    //检查邮箱格式
    public function checkEmailFormat()
    {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if (!preg_match($pattern,$this->email)) {
            echo "<script>alert('Email format is incorrect');history.go(-1);</script>";
            exit();
        }
    }
    //检查用户名格式
    public function checkNameFormat()
    {
        $length = strlen($this->username);
        if (trim($this->username) == '' || $length < 2 || $length > 20) {
            echo "<script>alert('Username length:2-20');history.go(-1);</script>";
            exit();
        }
    }
    //检查密码格式和确认，加密密码
    public function checkPwd(){
        if (trim($this->pwd) == '' || strlen($this->pwd) < 6 || strlen($this->pwd) > 20) {
            echo "<script>alert('Password length:6-20');history.go(-1);</script>";
            exit();
        }
        if ($this->pwd != $this->con) {
            echo "<script>alert('Password is inconsistent');history.go(-1);</script>";
            exit();
        }
        $this->pwd = md5($this->pwd);
    }
    public function doRegister()
    {
        $this->email = $_POST['email'];
        $this->username = $_POST['username'];
        $this->code = $_POST['code'];
        $this->pwd = $_POST['password'];
        $this->con = $_POST['confirm'];
        $this->checkCode();
        $this->checkPwd();
        $this->checkNameFormat();
        $this->checkEmailFormat();
        $this->uniqueName();
        $this->uniqueEmail();
        $sql = "INSERT INTO users (username, email, password) VALUES ('".$this->username."','".$this->email."','".$this->pwd."')";
        $result = $this->db->query($sql);        //将数据录入数据库
        if ($result) {
            $this->db->close();        //关闭数据库连接
            echo "<script>alert('Registered, please login');location.href = '../welcome.php';</script>";
            exit();
        }else{
            echo $this->db->error;
            exit();
        }
    }

}
@session_start();
$reg = new Register();
switch ($_POST['type']) {    //根据传递的type执行对应操作
    case 'code':
        $reg->checkCode();
        break;
    case 'name':
        $reg->uniqueName();
        break;
    case 'email':
        $reg->uniqueEmail();
        break;
    case 'all':
        $reg->doRegister();
        break;
    default:
        echo "wrong";
        break;
}