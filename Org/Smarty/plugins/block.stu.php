<?php
//读取学生信息
function smarty_block_stu($params, $content, &$smarty)
{
    //第一次执行此函数时$content无值 ，所以不处理（忽略）
   if(empty($content))return; 
   $where=isset($params['where'])?" where ".$params['where']:'';
   $order=isset($params['order'])?" order by ".$params['order']:'';
   $limit=isset($params['limit'])?" limit ".$params['limit']:'';
   $sql ="select * from stu $where $order $limit";
   $data =query($sql);
   foreach($data as $d){
        $d['sex']=$d['sex']==1?'男':'女';
        $tmp=$content;
        foreach($d as $name=>$value){
            $tmp=str_replace('[$field.'.$name.']', $value, $tmp);
        }
        echo $tmp;
   }
}

?>
