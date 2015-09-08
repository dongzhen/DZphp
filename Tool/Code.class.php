<?php
//画形状
//指定宽度、高度、验证码数量、设置文字大小、文字颜色、背景颜色、字体
class Code{
	public $width =100;//宽度
	public $height=30;//高度
	public $num=4;//文字数量
	public $font_size = 16;//文字大小
	public $font_color;//文字颜色
	public $bg_color='#dcdcdc';//背景色
	public $font_file;//字体
	private $code;//验证码文字
	private $fontColorRes;//文字颜色资源
	private $img;//画布资源（在类的所有方法中共享）
	//构造函数
	public function __construct(){
		$this->font_file=EASYPHP_PATH.'Tool/font.ttf';
	}
	public function create(){
		//创建画布资源
		$this->createRes();
		//获得验证码的文字
		$this->getCode();
		//写字
		$this->createText();
		//画杂线(干扰线)
		$this->setFix();
		//输出显示 
		$this->show();
	}
	//画杂线(干扰线)
	private function setFix(){
		//画点
		for($i=0;$i<100;$i++){
			imagesetpixel($this->img,mt_rand(0,$this->width),
				mt_rand(0,$this->height),$this->fontColorRes);
		}
		//画线
		for($i=0;$i<5;$i++){
			imageline($this->img,mt_rand(0,$this->width),
				mt_rand(0,$this->height),mt_rand(0,$this->width),
				mt_rand(0,$this->height), $this->fontColorRes);
		}
	}
	//显示验证码
	private function show(){
		header("Content-type:image/png");
		imagepng($this->img);
	}
	//创建画布
	private function createRes(){
		$this->img = imagecreatetruecolor($this->width, $this->height);
		$color = $this->getColor($this->bg_color);
		$borderColor =$this->getColor("#333333");
		imagefill($this->img, 0,0, $color);
		imagerectangle($this->img, 0, 0, $this->width-1,$this->height-1, $borderColor);
		
	}
	//获得验证码的文字
	private function getCode(){
		$c='123456789asdfghjklzxcvbnmqwertyuip';
		$code = '';
		for($i=0;$i<$this->num;$i++){
			$index = mt_rand(0,strlen($c)-1);
			$code.=$c[$index];
		}
		$this->code = strtoupper($code);
		$_SESSION['code']=$this->code;
	}
	//写字
	private function createText(){
		//文字盒子(空间大小)
		$box=imagettfbbox($this->font_size, 0, $this->font_file, $this->code);
		//将16进制颜色转为PHP能处理的颜色资源
		$color=null;
		if($this->font_color){
			$color = $this->getColor($this->font_color);
			$this->fontColorRes=$color;
		}
		//每一个字点的宽度
		$font_w = $this->width/$this->num;
		for($i=0;$i<$this->num;$i++){
			if(!$this->fontColorRes){
				$color=imagecolorallocate($this->img, mt_rand(0,200), mt_rand(0,200), mt_rand(0,200));
			}
			$x=$i*$font_w+5;
			imagettftext($this->img, $this->font_size, mt_rand(-20,20), $x, $this->height*0.8, 
				$color, $this->font_file, $this->code[$i]);
		}
	}
	//将16进制颜色 转为PHP函数能处理的颜色
	private function  getColor($color){
		$color = substr($color,1);//去除#
		$red  = hexdec(substr($color,0,2));//红  ff   
		$green  = hexdec(substr($color,2,2));//绿  ff   
		$blue= hexdec(substr($color,4,2));//蓝  ff   
		return imagecolorallocate($this->img, $red, $green, $blue);
	}
}
?>