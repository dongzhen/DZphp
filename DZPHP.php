<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('PRC');
//框架入口文件
class DZPHP{
	//运行框架
	static public function run(){
		//定义常量
		define('DZPHP_PATH',dirname(__FILE__).'/');
		//加载框架运行的核心文件
		self::loadFile();
		self::createInitDir();
		App::run();
	}
	//加载框架运行的核心文件
	static private function loadFile(){
		$files = include DZPHP_PATH.'Files.php';
		foreach($files as $f){
			is_file($f) and require $f;
		}
	}
	//初始目录
	static public function createInitDir(){
		//如果应用已经存在,不再创建
		if(is_dir(APP_PATH))return;
		$dirs=array(
			APP_PATH,//应用目录
			APP_PATH.'Index/',//模块目录
			APP_PATH.'Index/Controller/',//控制器目录
			APP_PATH.'Index/Config/',//配置目录
			APP_PATH.'Index/Model/',//模型目录
			APP_PATH.'Index/View/Index/',//模板目录
			APP_PATH.'Index/View/Index/Compile/',//模板编译目录
			APP_PATH.'Index/View/Public/',//Public模板目录
			APP_PATH.'Index/View/Public/Compile/',//Public编译目录
		);
		foreach($dirs as $dir){
			is_dir($dir) or mkdir($dir,0755,true);
		}
		copy(DZPHP_PATH.'Tpl/Controller.php',APP_PATH.'Index/Controller/IndexController.class.php');
		copy(DZPHP_PATH.'Tpl/index.html',APP_PATH.'Index/View/Index/index.html');
		copy(DZPHP_PATH.'Tpl/success.html',APP_PATH.'Index/View/Public/success.html');
		copy(DZPHP_PATH.'Tpl/error.html',APP_PATH.'Index/View/Public/error.html');
		copy(DZPHP_PATH.'config.php',APP_PATH.'Index/Config/config.php');
	}
}
//运行框架
DZPHP::run();
?>