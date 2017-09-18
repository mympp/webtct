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
	private $client;
	private $doc_search ;
	
	//配置参数
	private $ACCESS_KEY = 'LTAILHN0udXsPM8k';
	private $SECRET = '917ls8ePMdHUuSecvQB9ONB2ciJJcn';
	private $HOST = 'http://opensearch-cn-hangzhou.aliyuncs.com';
	private $KEY_TYPE = 'aliyun';
	private $APP_NAME = 'yisou';
	private $SEARCH_TABLE = 'info';
	
	//搜索参数
	private $search_hits = 20;
	private $search_format = 'json';
	
	//搜索结果
	private $result_num;		//搜索结果数目
	
	function __construct($appname = ''){
		$this->create($appname);
	}
	
	private function create($appname){
		$this->client = new CloudsearchClient($this->ACCESS_KEY,$this->SECRET,['hosts'=>$this->HOST],$this->KEY_TYPE);
		$this->doc_search = new CloudsearchSearch($this->client);
		if(empty($appname)){
			$this->doc_search->addIndex($this->APP_NAME);
		}else{
			$this->doc_search->addIndex($appname);
			$this->APP_NAME = $appname;
		}
		$this->doc_search->setFormat($this->search_format);
		$this->result_num = 0;
	}
	
	/**
	* 执行搜索
	* @param string $word 搜索关键词
	* @param int $start 搜索偏移量，默认为0
	* @parma string $index 搜索索引名称，默认为single单字中文分词模式
	* @return bool or array
	*/
	public function search($word,$start = 0,$index = 'single'){
		$this->result_num = 0;	//重置搜索结果数目
		$this->doc_search->setHits($this->search_hits);
		$this->doc_search->setStartHit($start);
		$this->doc_search->setQueryString("$index:'$word'");
		$result = json_decode($this->doc_search->scroll(),true);
		if($result['status'] == 'OK'){
			$this->result_num = $result['result']['total'];
			return $result['result']['items'];
		}else{
			return false;
		}
	}
	
	//-------------------get--------------------
	
	//获取搜索结果总数目
	public function getResultNum(){
		return $this->result_num;
	}
	
	//获取过滤条件
	public function getFilter(){
		return $this->doc_search->getFilter();
	}
	
	//---------------------set--------------------
	
	//设置每页显示数目
	public function setPageSize($hits){
		if(is_int($hits)){
			$this->search_hits = $hits;
			return true;
		}else{
			return false;
		}
	}
	
	//设置过滤条件
	public function setFilter($condition){
		if(is_array($condition)){
			foreach($condition as $k=>$v){
				$this->doc_search->addFilter("$k='$v'");
			}
			return true;
		}else{
			return false;
		}
	}
	
	//设置搜索应用
	public function setIndex($index){
		$this->doc_search->addIndex($index);
	}
	
	//重置过滤条件
	public function reset(){
		$this->create();
	}
	
	/**
	* 设置排序，
	* @param string $sort，排序的字段
	* @param string $sortChar，排序顺序，默认-表示倒序，+表示顺序
	* @return
	*/
	public function setSort($sort,$sortChar = '-'){
		if(is_array($sort)){
			foreach($sort as $k=>$v){
				$this->doc_search->addSort($sort,$sortChar);
			}
		}else{
			$this->doc_search->addSort($sort,$sortChar);
		}
	}
	
	//设置返回内容的字段
	public function setField($field){
		if(is_array($field)){
			foreach($field as $k=>$v){
				$this->doc_search->addFetchFields($v);
			}
		}else{
			$this->doc_search->addFetchFields($field);
		}
	}
	
	
}
?>