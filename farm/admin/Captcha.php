<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2016/9/11
 * Time: 13:19
 */
class Captcha{
    private $codeNum;    //验证码位数
    private $width;    //验证码图片宽度
    private $height;    //验证码图片高度
    private $img;    //图像
    private $lineFlag;    //是否生成干扰线条
    private $piexFlag;    //是否生成干扰点
    private $fontSize;    //字体大小
    private $code;    //验证码字符
    private $string;    //生成验证码的字符集
    private $font;    //字体
    function __construct($codeNum=4,$height = 50,$width = 150,$fontSize = 20,$lineFlag = true,$piexFlag = true)
    {
        $this->string = 'qwertyupmkjnhbgvfcdsxa123456789';
        $this->codeNum = $codeNum;
        $this->height = $height;
        $this->width = $width;
        $this->lineFlag = $lineFlag;
        $this->piexFlag = $piexFlag;
        $this->font = dirname(__FILE__).'/font/consola.ttf';// 取得文件所在的绝对目录
        $this->fontSize = $fontSize;
    }
    //创建图片资源
    public function createImage(){
        $this->img = imageCreate($this->width,$this->height);
        imagecolorallocate($this->img,mt_rand(190,255),mt_rand(190,255),mt_rand(190,255));//填充图像背景
    }
    //创建验证码
    public function createCode(){
        $strlen = strlen($this->string)-1;
        for($i=0;$i<$this->codeNum;$i++){
            $this->code .= $this->string[mt_rand(0,$strlen)];//从字符集中随机取出四个字符拼接
        }
        $_SESSION['code']=$this->code;//加入session
        //字符间隔
        $diff=$this->width/$this->codeNum;
        //为每个字符生成颜色//写入图像
        for($i=0;$i<$this->codeNum;$i++){
            $textColor=imagecolorallocate($this->img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
            imagettftext($this->img,$this->fontSize,mt_rand(-30,30),$diff*$i+mt_rand(3,8), mt_rand(20,$this->height-10),$textColor,$this->font,$this->code[$i]);
        }
    }
    //创建干扰线条（默认3条）
    public function createLines(){
        for($i=0;$i<3;$i++){
            $color=imagecolorallocate($this->img,mt_rand(160,200),mt_rand(160,200),mt_rand(160,200));
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }
    //创建干扰点    （默认一百个点）
    public function createPiexs(){
        for($i=0;$i<100;$i++){
            $color=imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
    }
    //显示图片
    public function show(){
        $this->createImage();
        $this->createCode();
        if($this->lineFlag){
            $this->createLines();
        }
        if($this->piexFlag){
            $this->createPiexs();
        }
        header('Content-type:img/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
    //提供验证码
    public function getCode(){
        return $this->code;
    }
}

session_start(); //开启session
$captcha = new Captcha();    //实例化验证码类(可自定义参数)
$captcha->show();    //调用输出