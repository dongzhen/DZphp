<?php
//缩略图宽度、缩略图高度、
class Thumb{
	public $thumb_width =200;//缩略图宽度
	public $thumb_height=200;//缩略图高度
	public $thumb_fix='_thumb';//缩略图文件后缀
	public $thumb_pct=80;//图片压缩比
	public $type=1;//1 裁切原图，保证缩略图尺寸 不变  2 宽度固定，高度自增
	public function __construct(){}
	public function thumb($file){
		$imgInfo = getimagesize($file);
		//获得图像与缩略图画布尺寸
		$size = $this->getThumbSize($this->thumb_width,$this->thumb_height,$imgInfo[0],$imgInfo[1]);
		//画面资源
		$thumbRes = imagecreatetruecolor($size[0], $size[1]);
		//图片资源
		$imgRes = $this->getImageRes($file);
		$dst_x=$dst_y=0;//画布位置
		$src_x=$src_y=0;//原图取的左上角位置
		$dst_w=$size[0];//画布宽度
		$dst_h=$size[1];//画布高度
		$src_w=$size[2];//原图取的宽度
		$src_h=$size[3];//原图取的高度
		imagecopyresized($thumbRes, $imgRes, 
			$dst_x, $dst_y, 
			$src_x, $src_y, 
			$dst_w, $dst_h, 
			$src_w, $src_h);
		// header("Content-type:image/jpeg");
		$fileInfo=pathinfo($file);
		$thumbFile = $fileInfo['dirname'].'/'.$fileInfo['filename'].$this->thumb_fix.'.'.$fileInfo['extension'];
		$info = getimagesize($file);
		$func = str_replace('/','',$info['mime']);
		return $func($thumbRes,$thumbFile,$this->thumb_pct);
	}
	//获得图片资源
	private function getImageRes($file){
		$info =getimagesize($file);//获得图片信息
		$mime = explode('/',$info['mime']);//文档类型
		$func = 'imagecreatefrom'.$mime[1];//创建图片函数
		return $func($file);//创建图片资源
	}
	/**
	 * [getThumbSize description]
	 * @param  [int] $t_w   [缩略图宽度]
	 * @param  [int] $t_h   [缩略图高度]
	 * @param  [int] $img_w [图片宽度]
	 * @param  [int] $img_h [图片高度]
	 * @return [array]        [description]
	 */
	private function getThumbSize($t_w,$t_h,$img_w,$img_h){
		switch($this->type){
			case 1://保持缩略图尺寸不变
				//图片宽度绽放比例大于高度缩略比例，就裁切宽度
				//400 800  >200 200    缩放比例:2
					if($img_w/$t_w>$img_h/$t_h){
						$img_w=$img_h/$t_h*$t_w;
					}else{
						$img_h=$img_w/$t_w*$t_h;
					}
				break;
			case 2://宽度固定，图片裁切，动画面
				$p = $img_w/$t_w;//宽度缩放比例
				$t_h=$img_h/$p;
				break;
		}
		return array($t_w,$t_h,$img_w,$img_h);
	}
}