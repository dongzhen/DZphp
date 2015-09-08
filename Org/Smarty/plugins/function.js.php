<?php

function smarty_function_js($params)
{
	// print_r($_SERVER);
	$root='http://'.$_SERVER['HTTP_HOST'].
	dirname($_SERVER['SCRIPT_NAME']);
  return "<script type='text/javascript' src='".$root.'/Tpl/'.$params['file']."'>
  </script>";
}

?>
