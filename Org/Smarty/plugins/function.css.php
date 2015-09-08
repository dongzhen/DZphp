<?php

function smarty_function_css($params, &$smarty)
{
    print_r($smarty);
    $root='http://'.$_SERVER['HTTP_HOST'].
    dirname($_SERVER['SCRIPT_NAME']);
   return "<link rel='stylesheet' type='text/css' href='".$root.'/Tpl/'.$params['file']."'/>";   
}

/* vim: set expandtab: */

?>
