<?php
defined('DT_ADMIN') or exit('Access Denied');
require 'sogex_common.inc.php';
$menus = array (
	array('返回sogex管理首页','?file=sogex'),
	array('添加网站','?file='.$file.'&action=add'),
    array('网站列表', '?file='.$file),
    array('评分规则', '?file='.$file.'&action=rule'),
);

$web_message=new web_message();
$limit = get_cache('website_rule');
if($submit){
	switch($action){
		case 'add':
			$post['addtime'] = time();
			$post['updatetime'] = time();
			if($web_message->add($post)){
				dmsg('添加成功','?file='.$file);
			}else{
				msg('添加失败');
			}
		break;
		case 'edit':
			$post['updatetime'] = time();
			$web_message->mid = $mid;
			if($web_message->edit($post)){
				dmsg('修改成功','?file='.$file);
			}else{
				msg('修改失败');
			}
		break;
		case 'delete':
			$mid = $post['mid'];
			if($web_message->delete($mid)){
				dmsg('删除成功','?file='.$file);
			}else{
				msg('删除失败');
			}
		break;
		case 'update_rule':
				//修改评分参数
			 	$db->query("update {$db->pre}setting set item_value = $traffic_forecast where item_key = 'traffic_forecast'");
			 	$db->query("update {$db->pre}setting set item_value = $keywords_num where item_key = 'keywords_num'");
			 	$db->query("update {$db->pre}setting set item_value = $ipavg where item_key = 'ipavg'");
			 	$db->query("update {$db->pre}setting set item_value = $pvavg where item_key = 'pvavg'");
			 	$db->query("update {$db->pre}setting set item_value = $baidu_site where item_key = 'baidu_site'");
				$db->query("update {$db->pre}setting set item_value = $tc_site where item_key = 'tc_site'");
				$db->query("update {$db->pre}setting set item_value = $pv_ip_ratio where item_key = 'pv_ip_ratio'");
				set_cache('website_rule');	//修改参数缓存
				dmsg('修改成功','?file='.$file);
		break;
	}
}else{
	switch($action){
		case 'add':
			if(!empty($url)){
				$website = new website($url);
				$wdata = $website->get_all();
				extract($wdata);
			}
			include tpl($file.'_edit');
		break;
		case 'delete':
			if($web_message->delete($itemid)){
				dmsg('删除成功','?file='.$file);
			}else{
				msg('删除失败');
			}
		break;
		case 'edit':
			$web_message->mid = $itemid;
			$message = $web_message->get_one();
			extract($message);
			$website = new website($url);
			if($get_data){			//获取评分参数
				$wdata = $website->get_all();
				extract($wdata);
			}
			include tpl($file.'_edit');
		break;
		case 'rule':
			$wsetting = get_cache('website_rule');
			extract($wsetting);
			include tpl($file.'_rule');
		break;
		default:
			$info_type = get_cache($info_type);
			$lists=$web_message->get_list("mid <> ''",'addtime');
			include tpl($file);
	}
}

class website {
	
	protected $url1 ;		//第一个数据地址,chinaz
	protected $url2 ;			//第二个数据地址,aizhan
	protected $url3 ;		//第三个数据地址,baidu
	protected $str1 ;
	protected $str2 ;
	protected $str3 ;
	public $host ;		//
	protected $website_data = array();
	
	function __construct($host){
		$host = str_replace('http://','',$host);	//
		$host = str_replace('www.','',$host);
		$this->host = $host;
		$this->url1 = 'http://seo.chinaz.com/?m=&host='.$host;
		$this->url2 = 'http://www.aizhan.com/cha/'.$host;
		$this->url3 = 'http://www.baidu.com/s?wd=site:'.$host;
	}
	
	private function get_url1_data(){			//获取chinaz的数据
		$this->str1 = file_get_contents($this->url1);
		$start = strpos($this->str1,'<ul class="Manin01List01 tc">');
		$end = strpos($this->str1,'</ul>',$start);
		$middle_str = substr($this->str1,$start,($end-$start));
		$start = strpos($middle_str,'<li class="bbn">');
		$end = strpos($middle_str,'</li>');
		$middle_str = substr($middle_str,$start,($end-$start));
		$middle_arr = explode(' ',strip_tags($middle_str));
		$this->website_data['traffic_forecast'] = $this->process(trim($middle_arr[16])); //百度流量预计
		if(empty($this->website_data['traffic_forecast'])) $this->website_data['traffic_forecast'] = 0;
		$this->website_data['keywords_num'] = $this->process(trim($middle_arr[32]));		//关键词库
		if(empty($this->website_data['keywords_num'])) $this->website_data['keywords_num'] = 0;	
	}
	
	private function get_url2_data(){		//获取aizhan的数据
		$this->str2 = file_get_contents($this->url2);
		$start = strpos($this->str2,'<span id="alexa_IPPV">');
		$end = strpos($this->str2,'</span>',$start);
		$middle_str = substr($this->str2,$start,($end-$start));
		$middle_arr = explode(' ',strip_tags($middle_str));
		$this->website_data['ipavg'] = $this->process(trim($middle_arr[1]));
		if(empty($this->website_data['ipavg'])) $this->website_data['ipavg'] = 0;
		$this->website_data['pvavg'] = $this->process(trim($middle_arr[3]));
		if(empty($this->website_data['pvavg'])) $this->website_data['pvavg'] = 0;
	}
	
	private function get_url3_data(){		//获取baidu的数据
		$this->str3 = file_get_contents($this->url3);
		$start = strpos($this->str3,'该网站共有                <b style="color:#333">');
		$end = strpos($this->str3,'</b>',$start);
		$middle_str = substr($this->str3,$start,($end-$start));
		$middle_arr = explode(' ',strip_tags($middle_str));
		$this->website_data['baidu_site'] = $this->process(trim($middle_arr[16]));
		if(empty($this->website_data['baidu_site'])) $this->website_data['baidu_site'] = 0;
	}
	
	private function get_tc_data(){
		global $db;
		$num = $db->get_one("select count(*) as c from {$db->pre}sogex_info where url like '%".$this->host."%'");
		$this->website_data['tc_site'] = $num['c'];
		if(empty($this->website_data['tc_site'])) $this->website_data['tc_site'] = 0;
	}
	
	private function process($num){		//数字处理
		$num = str_replace(',','',$num);
		$find = strpos($num,'万');
		$back = $num;
		if($find){		//数字中存在万字
			$num_arr = explode('万',$num);
			$back = intval($num_arr[0])*10000+intval($num_arr[1]);
		}
		return $back;
	}
	
	public function get_traffic_forecast(){
		if(empty($this->website_data['traffic_forecast'])) $this->get_url1_data();
		return $this->website_data['traffic_forecaset'];
	}
	
	public function get_keywords_num(){
		if(empty($this->website_data['keywords_num'])) $this->get_url1_data();
		return $this->website_data['keywords_num'];
	}
	
	public function get_ipavg(){
		if(empty($this->website_data['ipavg'])) $this->get_url2_data();
		return $this->website_data['ipavg'];
	}
	
	public function get_pvavg(){
		if(empty($this->website_data['pvavg'])) $this->get_url2_data();
		return $this->website_data['pvavg'];
	}
	
	public function get_baidusite(){
		if(empty($this->website_data['baidu_site'])) $this->get_url3_data();
		return $this->website_data['baidu_site'];
	}
	
	public function get_tcsite(){
		if(empty($this->website_data['tc_site'])) $this->get_tc_data();
		return $this->website_data['tc_site'];
	}
	
	public function get_all(){
		if(empty($this->website_data['traffic_forecast']) || empty($this->website_data['keywords_num'])) $this->get_url1_data();
		if(empty($this->website_data['ipavg']) || empty($this->website_data['pvavg'])) $this->get_url2_data();
		if(empty($this->website_data['baidu_site'])) $this->get_url3_data();
		if(empty($this->website_data['tc_site'])) $this->get_tc_data();
		return $this->website_data;
	}
}
?>
