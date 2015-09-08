<?php
//1 加的位置  2 水印文件 3 透明度 

class Water{
	public $water_pos=9;
	public $water_img;
	public $water_pct=60;
	//构造函数
	public function __construct(){
		$this->water_img=EASYPHP_PATH.'Tool/logo.png';
	}
	/**
	 * 加水印
	 * 使用本方法时，必须设置$water_img（水印图片）属性
	 * 
	 * $img = new Water();
	 * $img->pos=3;//水印位置
	 * $img->water('1.jpg');//加水印
	 * 
	 * @param  [string] $file  图片文件
	 * @return [boolean] 成功或失败
	 */
	public function water($file){
		//获得图片资源
		$img= $this->getImageRes($file);
		//水印图资源
		$logo = $this->getImageRes($this->water_img);
		$pos = $this->waterPos(imagesx($img),imagesy($img),imagesx($logo),imagesy($logo));
		$info =getimagesize($file);//源图信息
		$waterImageInfo=getimagesize($this->water_img);//水印图信息
		if($waterImageInfo[2]==3){//png图
			imagecopy($img, $logo, $pos[0], $pos[1], 0, 0 ,imagesx($logo),imagesy($logo));
		}else{
			imagecopymerge($img, $logo, $pos[0], $pos[1], 0, 0 ,imagesx($logo),imagesy($logo),$this->water_pct);
		}
		// header("Content-type:image/jpeg");
		$func = str_replace('/', '',$info['mime']);
		return $func($img,$file);
	}
	//获得图片资源
	///
	/**
	 * [getImageRes description]
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	private function getImageRes($file){
		$info =getimagesize($file);//获得图片信息
		$mime = explode('/',$info['mime']);//文档类型
		$func = 'imagecreatefrom'.$mime[1];//创建图片函数
		return $func($file);//创建图片资源
	}
	//获得水印图片位置
	private function waterPos($img_w,$img_h,$water_w,$water_h){
		$x =$y=20;
		switch($this->water_pos){
			case 1:
				break;
			case 2:
				$x=($img_w-$water_w)/2;
				break;
			case 3:
				$x=($img_w-$water_w)-20;
				break;
			case 4:
				$y=($img_h-$water_h)/2;
				break;
			case 5:
				$x=($img_w-$water_w)/2;
				$y=($img_h-$water_h)/2;
				break;
			case 6:
				break;
			case 7:
				break;
			case 8:
				break;
			case 9:
			default:
				$x=($img_w-$water_w)-20;
				$y=($img_h-$water_h)-20;
		}
		return array($x,$y);
	}
}
?>