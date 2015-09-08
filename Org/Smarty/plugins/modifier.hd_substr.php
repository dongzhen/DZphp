<?php

function smarty_modifier_hd_substr($string, $len='10')
{
   return mb_substr($string,0,$len,'utf-8');
}

/* vim: set expandtab: */

?>
