<?php
//分页类
class Page{
	private $totalPage;//总页数
	private $selfPage;//当前页
	private $url;//url地址
	private $row;//每页显示条数
	public function __construct($total,$row=10){
		$this->row=$row;
		$this->totalPage= ceil($total/$row);
		$this->selfPage=isset($_GET['page'])?min(intval($_GET['page']),$this->totalPage):1;
		$this->url=$this->getUrl();
	}
	//获得当前页url
	private function getUrl(){
		if(isset($_GET['page']))unset($_GET['page']);
		$url=__WEB__.'?';
		foreach($_GET as $name=>$value){
			$url.=$name.'='.$value.'&';
		}
		$url.='page=';
		return $url;
	}
	//返回SQL语句需要的limit值
	public function limit(){
		return ($this->selfPage-1)*$this->row.",".$this->row;
	}
	//显示页面
	public function show(){
		$html='';
		for($i=1;$i<=$this->totalPage;$i++){
			if($i==$this->selfPage){
				$html.="<strong>{$i}</strong>";
			}else{
				$url = $this->url.$i;
				$html.="<a href='{$url}'>{$i}</a>";				
			}
		}
		return $html;
	}
}