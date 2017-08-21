<?php
namespace models\helpers\widget;

//新版移动端上线后，将旧版移动端转移域名为wap2.tecenet.com,新版移动端使用wap.tecenet.com
//对于新旧两版网站，旧版中的产品，企业，资讯，分享，供应，招标内容，主动跳转到新版地址
class wap2_to_wap {
	
	private static $forword_host = 'http://wap.tecenet.com/';
	
	private static $module_id = [16,4,21,29,5,6];
	
	private static $module_link = [
		'16' => 'chanpin',
		'4' => 'company',
		'21' => 'zixun',
		'29' => 'share',
		'5' => 'gongying',
		'6' => 'zhaobiao',
	];
	
	private static $company_id = 4;
	
	private static $company_action = ['introduce','sell','buy','mall','news','contact','credit','message'];

	public static function forword($get){
		
		if(self::check($get)){
			if($get['moduleid'] == self::$company_id){
				return self::companyForword($get);
			}
			
			$forword_url = self::getForwordUrl($get);
			if(!empty($forword_url)){
				header('Location:'.$forword_url);
				exit;
			}
		}
	} 
	
	private static function companyForword($get){
		if(empty($get['username'])){
			$forword_url = self::$forword_host.'gongsi';
			header('Location:'.$forword_url);
			exit;
		}
		
		if(!empty($get['action'])){
			if(!in_array($get['action'],self::$company_action)){
				return false;
			}else{
				$forword_url = self::$forword_host.'gongsi/shop-'.$get['username'].'/'.$get['action'].'.html';
				header('Location:'.$forword_url);
				exit;
			}
		}else{
			$forword_url = self::$forword_host.'gongsi/shop-'.$get['username'].'.html';
			header('Location:'.$forword_url);
			exit;
		}
	}
	
	
	private static function getForwordUrl($get){
		$result = self::$forword_host;
		$moduleid = $get['moduleid'];
		if(isset(self::$module_link[$moduleid])){
			$result .= self::$module_link[$moduleid];
		}
		if(isset($get['itemid'])){
			$result .= '/show-'.$get['itemid'].'.html';
		}
		return $result;
	}
	
	private static function check($get){
		session_start();
		if(isset($_SESSION['wap2_open'])){
			return false;
		}
		
		if(isset($get['wap2']) && $get['wap2'] == 'open'){
			if(!isset($_SESSION['wap2_open'])) $_SESSION['wap2_open'] = 1;
			return false;
		}
		
		if(isset($get['action']) && ($get['action'] == 'ajax')){		//接口请求不跳转
			return false;
		}
		if(!isset($get['moduleid'])){		//不指定内容，不跳转
			return false;
		}
		if(!in_array($get['moduleid'],self::$module_id)){	//不再指定模块下的请求
			return false;
		}
		
		return true;
	}
	
}
?>