<?php
//应用处理类
class App{
	static public function run(){
		//默认开启session处理
		session_start();
		//是否为POST提交
		define('IS_POST',!empty($_POST));
		//模块
		$model =isset($_GET['m'])?ucfirst($_GET['m']):'Index';
		//控制器
		$controller =isset($_GET['c'])?ucfirst($_GET['c']):'Index';
		//动作
		$action =isset($_GET['a'])?$_GET['a']:'Index';
		//控制器类名
		$class= $controller.'Controller';
		//模块目录
		define('MODULE_PATH',APP_PATH.$model.'/');
		//模块名称
		define('MODULE',$model);
		//控制器名称
		define('CONTROLLER',$controller);
		//动作
		define('ACTION',$action);
		//网站根目录
		define('__ROOT__','http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
		//网站入口文件URL
		define('__WEB__','http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
		//模块URL
		define('__MODULE__',__WEB__.'?m='.MODULE);
		//控制器URL
		define('__CONTROLLER__',__MODULE__.'&c='.CONTROLLER);
		//动作URL
		define('__ACTION__',__CONTROLLER__.'&a='.ACTION);
		//模板目录url
		define('__VIEW__',__ROOT__.'/'.MODULE_PATH.'/View');
		
		// p(__VIEW__);
		//加载框架核心配置项
		C(require DZPHP_PATH.'config.php');
		//加载模块配置项
		if(is_file(MODULE_PATH.'Config/config.php')){
			C(require MODULE_PATH.'Config/config.php');
		}
		//控制器文件
		$controllerFile = APP_PATH.$model.'/Controller/'.$class.'.class.php';
		require $controllerFile;
		$obj = new $class;
		$obj->$action();
	}
}