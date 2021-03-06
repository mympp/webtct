<?php
namespace database;

require __DIR__.'/config.php';

class db{
	
	var $con;
	var $condition;
	protected $result;
	var $field;
	var $start;
	var $pagesize;
	var $order;
	var $table;
	var $tb_pre ;
	var $errmsg;
	var $query_str;
	
	/**
	* @param string $table:数据库表名，不需要填写前缀
	* @return 
	*/
	function __construct($table,$pre = ''){
		$this->tb_pre = $pre;
		$this->table = $this->tb_pre.$table;
		$this->field = '*';
		$this->start = 0;
		$this->pagesize = 10;
		$this->order = '';
		$this->errmsg = '';
		$this->field = '*';
		$this->con = new \mysqli(DB_HOST,DB_USER,DB_PSW,DB_NAME,DB_PORT);
		mysqli_query($this->con,"SET NAMES UTF8");
		if(!$this->con) return false;
	}
	
	//数据库执行方法
	public function query($str){
		$this->query_str = $str;
		$result =  mysqli_query($this->con,$str);
		$this->restart();
		if($result){
			return $result;
		}else{
			$this->errmsg = mysqli_error($this->con);
			return false;
		}
	}
	
	//增加限定条件方法
	public function order($order){
		if(is_array($order)){
			$order_str = implode(',',$order);
			$this->order = ' order by '.$order_str;
		}else{
			$this->order = ' order by '.$order;
		}
		return $this;
	}
	
	public function limit($start = 0,$pagesize = 10){
		$this->start = $start;
		$this->pagesize = $pagesize;
		return $this;
	}
	
	public function field($field){
		if($field == '') return $this;
		if(is_array($field)){
			$this->field = implode(',',$field);
		}else{
			$this->field = $field;
		}
		return $this;
	}
	
	public function where($where ,$relation = '=',$and = true){
		if(empty($where)) return $this;
		$link = $and ? 'and' : 'or';
		if(empty($this->condition)){
			$this->condition = 'where ';
		}else{
			$this->condition .= ' '.$link.' ';
		}
		if(is_array($where)){
			$condition_str = array();
			foreach($where as $k => $v){
				if($relation == 'in'){
					$condition_str[] = "$k $relation ($v)";
				}else{
					$condition_str[] = "$k $relation '$v'";
				}
			}
			$this->condition .= implode(" $link ",$condition_str);
		}else{
			$this->condition .= $where;
		}
		return $this;
	}
	
	/**
	* @param array $where 搜索条件
	* @param array $and and拼接方式，默认为 true
	* @param string $point 模糊匹配的方向,默认为all及两边都模糊匹配，其他可选值为left和right
	* @return
	*/
	public function likeWhere($where,$and = true,$point = 'all'){
		if(empty($where)) return $this;
		if(!is_array($where)) return $this;
		$condition_str = [];
		foreach($where as $k => $v){
			if(empty($v)) continue;
			$str = "$k like ";
			switch($point){
				case 'left':
					$str .= "'%$v'";
				break;
				case 'right':
					$str .= "'$v%'";
				break;
				default:
					$str .= "'%$v%'";
			}
			$condition_str[] = $str;
		}
		$link = $and === true ? ' and ' : ' or ';
		$condition .= implode(' '.$link,$condition_str);
		if(empty($condition)) return $this;
		if(empty($this->condition)){
			$this->condition = ' where ';
		}else{
			$this->condition .= $link;
		}
		$this->condition .= $condition; 		
		return $this;
	}
	
	//逻辑操作方法
	public function all(){
		$str = 'select '.$this->field.' from '.$this->table.' '.$this->condition.$this->order;
		$this->result = $this->query($str);
		return $this->result();
	}
	
	public function select(){
		$str = 'select '.$this->field.' from '.$this->table.' '.$this->condition.$this->order.' limit '.$this->start.','.$this->pagesize;
		$this->result = $this->query($str);
		return $this->result();
	}
	
	public function one(){
		$str = 'select '.$this->field.' from '.$this->table.' '.$this->condition.$this->order.' limit 0,1';
		$this->result = $this->query($str);
		if($this->result == false) return '';
		$result = $this->result();
		if(empty($result[0])) return '';
		$this->restart();
		return $result[0];
	}
	
	public function add($data){
		if(!is_array($data)) return false;
		$key_arr = array();
		$value_arr = array();
		foreach($data as $k => $v){
			$key_arr[] = $k;
			$value_arr[] = $v;
		}
		$key_str = implode(",",$key_arr);
		$value_str = implode("','",$value_arr);
		return $this->query('insert into '.$this->table."(".$key_str.") values ('".$value_str."')");
	}
	
	/**
	* //批量添加数据
	* @param array $key 一维数组，保存键值顺序
	* @param array $data 二维数组，保存多个添加记录信息
	* @return
	*/
	public function batchAdd($key,$data){
		if(!is_array($key)) return false;
		if(!is_array($data)) return false;
		$key_str = implode(',',$key);	
		$values_str = ''; 
		foreach($data as $dk=>$dv){
			$value_arr = [];
			foreach($key as $kk=>$kv){	//按键值的顺序排列数据
				$value_arr[] = $dv[$kv];
			}
			$values_str .= " ('".implode("','",$value_arr)."'),";
		}
		$values_str = substr($values_str , 0 ,-1);
		return $this->query('insert into '.$this->table.' ('.$key_str.') values'.$values_str);
	}
	
	public function edit($data , $condition = null){
		if(!is_array($data)) return false;
		if(!empty($condition)) $this->where($condition);
		$update_str = ' set ';
		foreach($data as $k=>$v){
			$update_str .=' '.$k." = '".$v."' ,";
		}
		$update_str = substr($update_str,0,-1);
		return $this->query('update '.$this->table.$update_str.$this->condition);
	}
	
	public function delete($condition = null){
		if(!empty($condition)) $this->where($condition);
		return $this->query('delete from '.$this->table.' '.$this->condition);
	}
	
	public function insert_id(){
		return mysqli_insert_id($this->con);
	}
	
	public function count($name = 'count'){
		$this->field("count(*) as $name");
		return $this->one();
	}
	
	//结果处理
	protected function restart(){
		$this->field = '*';
		$this->condition = '';
		$this->start = 0;
		$this->pagesize = 10;
		$this->order = '';
	}
	
	protected function result(){
		if(!$this->result) return false;
		$back = array();
		while($r = mysqli_fetch_assoc($this->result)){
			$back[] = $r;
		}
		return $back;
	}
}
?>