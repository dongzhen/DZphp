<?php
/**
 * 数据库处理模型
 */
class Model{
	public $error;
	public $table;//操作表
	public $opt=array(
		'field'=>' * ',
		'where'=>'',
		'group'=>'',
		'order'=>'',
		'limit'=>'',
		'having'=>''
	);
	//构造函数 
	public function __construct($table=null){
		//设置表名
		if($table)$this->table =$table;
		//数据库连接
		if(!@mysql_connect(C('DB_HOST'),C('DB_USER'),C('DB_PASSWORD'))){
			die('数据库连接失败');
		}
		//设置字符集
		mysql_query("SET NAMES ".C('DB_CHARSET'));
		//连接数据库
		if(!@mysql_select_db(C('DB_NAME'))){
			die('数据库连接失败');
		}
	}
	public function field($arg){
		$this->opt['field']=$arg;
		return $this;
	}
	public function where($arg){
		$this->opt['where']=" WHERE ".$arg;
		return $this;
	}
	public function group($arg){
		$this->opt['group']=" GROUP BY  ".$arg;
		return $this;
	}
	public function having($arg){
		$this->opt['having']=" HAVING ".$arg;
		return $this;
	}
	public function order($arg){
		$this->opt['order']=" ORDER BY  ".$arg;
		return $this;
	}
	public function limit($arg){
		$this->opt['limit']=" LIMIT ".$arg;
		return $this;
	}
	//查找一条
	public function find(){
		$data = $this->select();
		return $data?current($data):$data;
	}
	//查询
	
	public function select(){
		$sql = "SELECT {$this->opt['field']} FROM ".$this->table.$this->opt['where'].
		$this->opt['group'].$this->opt['having'].$this->opt['order'].$this->opt['limit'];
		return $this->query($sql);
	}
	//删除
	public function delete(){
		//必须有条件
		if(empty($this->opt['where']))return false;
		$sql = "DELETE FROM ".$this->table.$this->opt['where'].
		$this->opt['order'].$this->opt['limit'];
		return $this->exe($sql);
	}

	// 更新
	public function update($data){
		//必须有条件 
		if(empty($this->opt['where']))return false;
		//UPDATE CLASS set cname='xx'
		$sql ="UPDATE ".$this->table. " SET ";
		foreach($data as $name=>$value){
			$sql.=$name."='$value',";
		}
		$sql =substr($sql,0,-1).$this->opt['where'];

		return $this->exe($sql);
	}



	//插入数据
	public function insert($data){
		$sql="INSERT INTO ".$this->table;
		$field =array_keys($data);
		$values= array_values($data);
		$sql.="(".implode(',', $field).") VALUES('".implode("','", $values)."')";
		return $this->exe($sql);
	}
	//查结果集的查询 (select)
	public function query($sql){
		$result = mysql_query($sql);
		if($result){
			$rows=array();
			while($row=mysql_fetch_assoc($result)){
				$rows[]=$row;
			}
			return $rows;
		}else{
			die(mysql_error());
		}
	}
	//没结果集的查询 (update,delete,insert)
	public function exe($sql){
		$status = mysql_query($sql);
		if($status){
			$insertId = mysql_insert_id();
			return $insertId?$insertId:true;
		}else{
			die(mysql_error());
		}
	}
	//获取受影响条数
	public function getAffectedRow(){
		return mysql_affected_rows();
	}
}