<?php
class sphinxSearch extends SphinxClient{
	
	public $indexes ;		//数据索引
	
	function __construct(){
		parent::__construct();
		$this->setServer('121.14.195.22',9312);		//外网服务器使用10.10.1.156,测试服务器使用121.14.195.22
		$this->setArrayResult(true);
		$this->setMatchMode(SPH_MATCH_EXTENDED2);
		$this->setRankingMode(SPH_RANK_SPH04);
		$this->indexes = 'info,info_rt';
	}
	
	/**
	* 设置过滤条件
	* @param array $condition
	* @return object or bool
	*/
	public function setCondition($condition){
		if(!is_array($condition)) return false;
		foreach($condition as $k=>$v){
			if(!is_string($k)) continue;
			$this->setFilter($k,array($v));
		}
		return $this;
	}
	
	/**
	* 设置精确匹配字符串
	* @param undefined $match 
	* @return string or bool
	*/
	protected function setExactQuery($match){
		if(!is_array($match)) return false;
		$query_str = '';		//搜索内容字符串
		foreach($match as $k=>$v){
			if(!is_string($k)) continue;		//非字符串键值不处理
			$query_str .= "@$k($v)|";
		}
		if($query_str == '') return false;
		$query_str = substr($query_str,0,-1);
		if($query_str == '') return false;
		return $query_str;
	}
	
	/**
	* 内容精确匹配
	* @param array $match 需要匹配内容
	* @param array $condition 匹配限制条件
	* @param int $page 匹配页数
	* @param int $pagesize 匹配单次数据大小
	* @return array or bool
	*/
	public function exactMatch($match,$condition = array('status'=>3),$page = 1,$pagesize = 12){
		if(!is_array($match)) return false;
		if(!is_array($condition)) return false;
		
		$query_str = $this->setExactQuery($match);
		//设置搜索过滤条件
		$this->setCondition($condition);
		
		//分页数据
		$start = ($page-1)<0 ? 0 :$page-1;
		$this->setLimits($start,$pagesize,999999);
		
		return $this->query($query_str,$this->indexes);
		
	}
}
?>