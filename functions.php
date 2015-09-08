<?php
//打印
function p($data){
	echo "<pre>".print_r($data,true).'</pre>';
}
//自动加载类
function __autoload($className){
	if(substr($className,-10)=='Controller' && require_array(
		array(
			MODULE_PATH.'Controller/'.$className.'.class.php',
			DZPHP_PATH.'Controller.class.php'
		)
	)){}else if(substr($className,-5)=='Model' && require_array(
		array(
			MODULE_PATH.'Model/'.$className.'.class.php',
			DZPHP_PATH.'Model.class.php'
		)
	)){}else{
		require DZPHP_PATH.'Tool/'.$className.'.class.php';
	}
}
/**
 * 文件加载
 * @param  [array] $files [文件以数组形式传参]
 * @return [type]        [description]
 */
function require_array($files){
	foreach($files as $f){
		if(is_file($f)){
			require $f;
			return true;
		}
	}
}
//配置项处理函数
function C($name=null,$value=null){
	static $config=array();
	if(is_null($name)){//返回所有配置项
		return $config;
	}else if(is_array($name)){//批量设置配置项
		$config=array_merge($config,$name);
	}else if(is_null($value)){//读取某一个配置项
		return isset($config[$name])?$config[$name]:null;
	}else{//设置一个配置项
		$config[$name]=$value;
	}
}
//打印用户定义常量
function print_const(){
	$const= get_defined_constants(true);
	p($const['user']);
}
?>