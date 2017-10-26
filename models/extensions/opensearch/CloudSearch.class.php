<?php
namespace models\extensions\opensearch;

use CloudsearchClient;
use CloudsearchDoc;
use CloudsearchIndex;
use CloudSearchSearch;
use CloudsearchSuggest;

require __DIR__.'/path/CloudsearchClient.php';
require __DIR__.'/path/CloudsearchDoc.php';
require __DIR__.'/path/CloudsearchIndex.php';
require __DIR__.'/path/CloudsearchSearch.php';
require __DIR__.'/path/CloudsearchSuggest.php';

class CloudSearch {
	//操作对象
	private $client;
	private $docSearch;

	//配置参数
	private $accessKey = 'LTAILHN0udXsPM8k';
	private $secret = '917ls8ePMdHUuSecvQB9ONB2ciJJcn';
	private $host = 'http://opensearch-cn-hangzhou.aliyuncs.com';
	private $keyType = 'aliyun';
	private $appName = 'yisou';
	private $searchTable = 'info';

	//搜索参数
	private $searchHits = 20;
	private $searchFormat = 'json';

	//搜索结果
	private $resultNum;		//搜索结果数目
	private $result;        //全部返回内容

	function __construct($appname = ''){
		$this->create($appname);
	}

	private function create($appname){
		$this->client = new CloudsearchClient($this->accessKey,$this->secret,['hosts'=>$this->host],$this->keyType);
		$this->docSearch = new CloudsearchSearch($this->client);
		if(empty($appname)){
			$this->docSearch->addIndex($this->appName);
		}else{
			$this->docSearch->addIndex($appname);
			$this->appName = $appname;
		}
		$this->docSearch->setFormat($this->searchFormat);
		$this->resultNum = 0;
	}

	/**
	 * 执行搜索
	 * @param string $word 搜索关键词
	 * @param int $start 搜索偏移量，默认为0
	 * @parma string $index 搜索索引名称，默认为single单字中文分词模式
	 * @return bool or array
	 */
	public function search($word='',$start = 0,$index = 'single'){
		$this->resultNum = 0;	//重置搜索结果数目
		$this->docSearch->setHits($this->searchHits);
		$this->docSearch->setStartHit($start);
		if(!empty($word))$this->docSearch->setQueryString("$index:'$word'");
		$result = json_decode($this->docSearch->scroll(),true);
		$this->result = $result;
		if($result['status'] == 'OK'){
			$this->resultNum = $result['result']['total'];
			return $result['result']['items'];
		}else{
			return false;
		}
	}

	//-------------------get--------------------

	//获取搜索结果总数目
	public function getResultNum(){
		return $this->resultNum;
	}

	//获取过滤条件
	public function getFilter(){
		return $this->docSearch->getFilter();
	}

	//获取所有返回内容
	public function getAllResult(){
		return $this->result;
	}

	//---------------------set--------------------

	//设置每页显示数目
	public function setPageSize($hits){
		if(is_int($hits)){
			$this->searchHits = $hits;
		}
		return $this;
	}

	//设置过滤条件
	public function setFilter($condition){
		if(is_array($condition) && !empty($condition)){
			foreach($condition as $k=>$v){
				$this->docSearch->addFilter("$k='$v'");
			}
		}
		return $this;
	}

	//设置搜索应用
	public function setIndex($index){
		$this->docSearch->addIndex($index);
	}

	//重置过滤条件
	public function reset($appName=''){
		$appName = empty($appName)?($this->appName):$appName;
		$this->create($appName);
		return $this;
	}

	/**
	 * 设置排序，
	 * @param string $sort，排序的字段
	 * @param string $sortChar，排序顺序，默认-表示倒序，+表示顺序
	 * @return
	 */
	public function setSort($sort,$sortChar = '-'){
		if(is_array($sort)){
			foreach($sort as $sortName){
				$this->docSearch->addSort($sortName,$sortChar);
			}
		}else{
			$this->docSearch->addSort($sort,$sortChar);
		}
		return $this;
	}

	//设置返回内容的字段
	public function setField($field){
		if(is_array($field)){
			foreach($field as $fieldName){
				$this->docSearch->addFetchFields($fieldName);
			}
		}else{
			$this->docSearch->addFetchFields($field);
		}
		return $this;
	}

}
?>