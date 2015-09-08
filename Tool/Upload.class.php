<?php
/**
 * 文件上传处理类
 * @author  hdxj <houdunwangxj@gmail.com>
 */
class Upload{
	//1 能设置储存目录
	//2 设置上传类型
	//3 设置上传大小 
	public $error;//记录错误
	private $dir;//上传目录
	private $allowSize;//允许大小
	private $allowType;//允许上传类型
	//构造函数
      public function __construct($dir='Upload',$allowSize='2000000',$allowType=array('jpg','gif','png','jpeg')){
      		$this->dir=$dir;
      		$this->allowSize=$allowSize;
      		$this->allowType=$allowType;
      }
      //上传处理
      public function upload(){
      		//没有上传数据时
      		if(empty($_FILES))return false;
      		//将数据规范化,name='a[]' name='b'表单类型统一
      		$files = $this->format();
      		//去除非法文件
      		$files = $this->check($files);
      		//移动上传文件
      		return $this->moveUploadFile($files);
      }
      //数据规范化
      private function format(){
      		$fileData=array();
      		foreach($_FILES as $f){
      			if(is_array($f['name'])){
      				foreach($f['name'] as $id=>$name){
      					$tmp=array();
      					$tmp['name']=$f['name'][$id];
      					$tmp['type']=$f['type'][$id];
      					$tmp['tmp_name']=$f['tmp_name'][$id];
      					$tmp['error']=$f['error'][$id];
      					$tmp['size']=$f['size'][$id];
      					$fileData[]=$tmp;
      				}
      			}else{
      				$fileData[]=$f;
      			}
      		}
      		return $fileData;
      }
      //去除非法文件
      //大小、类型、上传出错的文件、合法上传文件
      private function check($files){
      		//储存验证通过上传文件
      		$data=array();
      		foreach($files as $id=>$f){
      			//上传出错误的
      			if($f['error']!=0)continue;
      			//不是上传文件
      			if(!is_uploaded_file($f['tmp_name']))continue;
      			//上传大小
      			if($f['size']>$this->allowSize)continue;
      			//文件类型
      			$info =pathinfo($f['name']);
      			if(!in_array($info['extension'],$this->allowType))continue;
      			$data[]=$f;
      		}
      		return $data;
      }
      private function moveUploadFile($files){
      		//创建目录
      		is_dir($this->dir) or mkdir($this->dir,0755,true);
      		//目录不存在
      		if(!is_dir($this->dir)){
      			$this->error='上传目录创建失败...';
      			return false;
      		}
      		//储存，成功移动后的文件
      		$data=array();
      		foreach($files as $f){
      			//获得文件信息
      			$info = pathinfo($f['name']);
      			$destination=$this->dir.'/'.mt_rand(1,1000).time().'.'.$info['extension'];
      			if(move_uploaded_file($f['tmp_name'], $destination)){
      				$f['path']=$destination;
      				$f['time']=time();//上传时间
      				$f['ext']=$info['extension'];//扩展名
      				$f['filename']=$info['filename'];//扩展名
      				$data[]=$f;
      			}
      		}
      		return $data;
      }
}