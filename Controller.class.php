<?php
class Controller extends Smarty{
	//构造函数
	public function __construct(){
		$this->template_dir=MODULE_PATH.'/View/'.CONTROLLER.'/';
		$this->compile_dir=MODULE_PATH.'/View/'.CONTROLLER.'/Compile';
		$this->left_delimiter='{dz:';
		is_dir($this->template_dir) or mkdir($this->template_dir,0755,true);
		is_dir($this->compile_dir) or mkdir($this->compile_dir,0755,true);
		if(method_exists($this, '__init'))$this->__init();
	}
	//操作成功时的提示界面
	public function success($message='操作成功',$url=null){
		$this->template_dir=MODULE_PATH.'View/Public/';
		$this->compile_dir=MODULE_PATH.'View/Public/Compile/';
		$this->assign('message',$message);
		$this->assign('url',$url);
		$this->display('success.html');
		exit;
	}
	public function error($message='操作失败',$url=null){
		$this->template_dir=MODULE_PATH.'View/Public/';
		$this->compile_dir=MODULE_PATH.'View/Public/Compile/';
		$this->assign('message',$message);
		$this->assign('url',$url);
		$this->display('error.html');
		exit;
	}
}