<?php 
require_once '../common.inc.php';
require_once '../include/tcdb.class.php';
require_once '../models/opensearch/cloudSearch.class.php';
require_once 'common.inc.php';

$keyword_db = new tcdb('keyword');
$keyword = $keyword_db->where(['itemid'=>$itemid])->one();		//关键词内容

$module_arr=array(16=>'产品',9=>'维修',6=>'招标',7=>'科技',5=>'供求',13=>'品牌',4=>'网店',21=>'资讯',15=>'共享',10=>'问答');

$relevant = new relevant();
$relevant->setKeyword($keyword['word']);

//相关产品
$mall_relevant = $relevant->getRelevant(16,16);

//相关维修
$fuwu_relevant = $relevant->getRelevant(9,8);

//相关招标
$relevant->setSort('addtime');
$zhaobiao_relevant = $relevant->getRelevant(6,6);

//相关科技
$relevant->setSort();
$tech_relevant = $relevant->getRelevant(7,8);

//相关供应
$relevant->setSort('addtime');
$relevant->openDbSearch('sell_5','itemid,title,linkurl,introduce,validated,hits,level,edittime');
$sell_relevant = $relevant->getRelevant(5,6);

//相关品牌
$relevant->setSort();
$relevant->closeDbSearch();
$brand_relevant = $relevant->getRelevant(13,16);

//相关网店
$company_relevant = $relevant->getRelevant(4,16);

//相关资讯
$relevant->setSort('addtime');
$article_relevant = $relevant->getRelevant(21,8);

//相关共享
$relevant->setSort();
$relevant->openDbSearch('down_15','itemid,title,linkurl,introduce,fileext,downtype,dprice');
$down_relevant = $relevant->getRelevant(15,12);

//相关问答
$relevant->openDbSearch('know','itemid,title,linkurl,introduce,edittime,credit,answer,agree,against,hits');
$know_relevant = $relevant->getRelevant(10,6);

//seo设置
$ztitle=$keyword['word'].'产品价格报价及售后维修_优质'.$keyword['word'].'厂家/招标/供求 - 天成医疗网';
$zdescription='天成医疗网为您提供最全面，丰富的'.$keyword['word'].'相关商品详细参数信息，包括'.$keyword['word'].'价格、'.$keyword['word'].'维修、'.$keyword['word'].'厂家；涵盖了'.$keyword['word'].'招标、品牌型号、规格参数、所在地区、相关资讯等内容。';
$zkeywords=$keyword['word'].','.$keyword['word'].'价格,'.$keyword['word'].'批发,'.$keyword['word'].'厂家,'.$keyword['word'].'供应,'.$keyword['word'].'招标,天成医疗热词榜';


include DT_ROOT.'/hot/template/show.php';

class relevant{
	
	private $keyword;
	private $searchIndex = 'tecenet';
	private $sort;
	
	private $db_search = false;	//默认不进行数据库搜索
	private $db_search_tablename;
	private $db_search_field ;
		
	function __construct(){

	}
	
	private function dbSearch($itemid_arr){
		if($itemid_arr == false) return false;
		$module_db = new tcdb($this->db_search_tablename);
		$itemid_str = '';
		foreach($itemid_arr as $v){
			$itemid_str .= $v['itemid'].',';
		}
		$itemid_str = substr($itemid_str,0,-1);
		return $module_db->field($this->db_search_field)->Where(['itemid'=>$itemid_str],'in')->all();
	}
	
	public function setKeyword($keyword){
		$this->keyword = $keyword;
	}
	
	public function setSort($sort = ''){
		$this->sort = $sort;
	}
	
	public function openDbSearch($tablename,$field){
		$this->db_search = true;
		$this->db_search_tablename = $tablename;
		$this->db_search_field = $field;
	}
	
	public function closeDbSearch(){
		$this->db_search = false;
	}
	
	public function getRelevant($moduleid,$pagesize){
		$cSearch = new cloudSearch($this->searchIndex);
		//$cSearch->setIndex($this->searchIndex);
		$cSearch->setPageSize($pagesize);
		$cSearch->setFilter(['moduleid'=>$moduleid]);
		
		if(!empty($this->sort)) $cSearch->setSort($this->sort);
		if($this->db_search){		//开启数据搜索
			$cSearch->setField('itemid');
			return $this->dbSearch($cSearch->search($this->keyword));
		}else{		//不开启数据库搜索
			return $cSearch->search($this->keyword);
		}
		
	}
}
?>