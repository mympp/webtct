<?php
defined('IN_DESTOON') or exit('Access Denied');
global $db,$pages, $page, $pagesize, $offset, $pagesize;
require DT_ROOT.'/module/search/common.func.php';

if(!isset($infotype)) {echo -1;return ;}
if(!isset($page)) {echo -1;return ;}	//缺少必要参数,返回-1
define('SO_SKIN',DT_PATH.'skin/sogex');

switch($infotype){
	case '0':		//全网列表
		$count_spread = $db->get_one("select count(*) as c from {$db->pre}spread where status = 3 and spread_status = 3 and mid = 99 and least > spend group by tid");	//推广总数
		if($count_spread['c'] > $page*$pagesize){		//推广总数比已展示内容要多，继续展示剩余的推广页面
			$spread_data = $db->query("select * from {$db->pre}spread where status = 3 and spread_status = 3 and mid = 99 group by tid order by total desc limit ".($page*$pagesize).",$pagesize");		//推广列表
			$tags = array();
			while($value = $db->fetch_array($spread_data)){
				$tags[] = $value; 
			}
			include tempalte('list_sogex_spread','tag');	//输出内容
			$scount = count($tags);
			if($scount<$pagesize){		//剩余推广页面不能填充列表，调用新闻补充
				$npagesize = $pagesize - $scount;	 //输出数目
				$news_data = $db->query("select * from {$db->pre}sogex_info where status = 3 order by addtime desc limit 0,$npagesize"); 
				$tags = array();
				while($value= $db->fetch_array($news_data)){
					$tags[]=$value;
				}
				include template('list_sogex_news','tag');		//输出内容
			}
			
		}else{			//推广总数比已展示内容少，展示补充的新闻	
			$noffset = ($page*$pagesize)-$count_spread['c'];	//补充内容的开始位置
			$news_data = $db->query("select * from {$db->pre}sogex_info where status = 3 order by addtime desc limit $noffset,$pagesize"); 
			$tags = array();
			while($value= $db->fetch_array($news_data)){
				$tags[]=$value;
			}
			include template('list_sogex_news','tag');		//输出内容
		}
	break;
	case '1':			//产品列表
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mmall' : 'list_sogex_mall';
		$rpage = rand(1,10);
		$put_page = $rpage*10;
		$tags = tag("table=sogex_info_mall&condition=status = 3 and thumb <> ''&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '2':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mcompany' : 'list_sogex_company';
		if($vip == '1'){		//返回vip商家信息
			$vip_company = $db->query("select linkurl from {$db->pre}view_company_vip");
			$vip_arr = array();
			while($r = $db->fetch_array($vip_company)){
				$vip_arr[] = $r['linkurl'];
			}
			$count = count($vip_arr);
			$vip_url = implode("','",$vip_arr);
			$tags = tag("table=view_sogex_company_vip&condition=status = 3 and url in ('$vip_url')&pagesize=10&template=null");
			include template($template,'tag');
			exit;
		}
		
		tag("table=sogex_info_company&condition=status = 3 and thumb <> ''&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '3':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mnews' : 'list_sogex_news';
		tag("table=sogex_info_news&condition=status = 3&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '4':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mfuwu' : 'list_sogex_fuwu';
		tag("table=sogex_info_fuwu&condition=status = 3&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '5':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mjob' : 'list_sogex_job';
		tag("table=sogex_info_job&condition=status = 3&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '6':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mgongqiu' : 'list_sogex_gongqiu';
		tag("table=sogex_info_gongqiu&condition=status = 3&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
	case '7':
		$put_page = $page+1;
		$template = $mobile == '1' ? 'list_sogex_mtech' : 'list_sogex_tech';
		tag("table=sogex_info_tech&condition=status = 3&order=itemid desc&page=$put_page&pagesize=$pagesize&template=$template");
	break;
}

?>
