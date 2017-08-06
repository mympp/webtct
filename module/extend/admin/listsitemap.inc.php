<?php
defined('DT_ADMIN') or exit('Access Denied');
require DT_ROOT.'/include/tcdb.class.php';

$category = new tcdb('category');
$area = new tcdb('area');
$areaid = $area->field('areaid')->all();
$AREA = [];
foreach($areaid as $k=>$v){
	array_push($AREA,$v['areaid']);
}
array_unshift($AREA,'0');		//所有地区id

switch($m){
	case 'company':
		//企业模块配置信息
		$company = [];
		$catid = $category->field('catid')->where(['moduleid'=>4,'parentid'=>0])->all();
		$CAT = [];
		foreach($catid as $k=>$v){
			array_push($CAT,$v['catid']);
		}
		array_unshift($CAT,'0');		//企业模块类型id
		$mode = [0,1,2,3,4];		//运作模式：不限 生产商 贸易商 服务商 其他机构
		$type = [0,1,2,3];			//运作性质：不限 企业单位 事业单位或社会团体 个体经营
		//$page = [1];				//分页数字为1
		//企业模块列表的地址拼接方式为 catid-areaid-mode-type-page.HTML
		$company[0] = $CAT;
		$company[1] = $AREA;
		$company[2] = $mode;
		$company[3] = $type;
		//$company[4] = $page;
		$c = CartesianProduct($company);
		buildSoSitemap($c,$MODULE[4]['linkurl'],'Company');
	break;
	case 'mall':
		//产品模块配置信息
		//产品分类页
		$catid = $category->field('catid')->where(['moduleid'=>16])->all();
		$CAT = [];
		foreach($catid as $k=>$v){
			array_push($CAT,$v['catid']);
		}
		array_unshift($CAT,'0');		//企业模块类型id
		//产品模块分类列表的地址拼接方式为 catid-stype-areaid.HTML
		$stype = [0,1,2,3];		//运作形式
		$vip = [0];	//vip只取0值
		$i = 1;
		while(count($CAT) > 50){
			$mCAT = array_slice($CAT,0,50);
			array_splice($CAT,0,50);
			$mall[0] = $mCAT;
			$mall[1] = $stype;
			$mall[2] = $AREA;
			$mall[3] = $vip;
			$c = CartesianProduct($mall);
			buildSoSitemap($c,$MODULE[16]['linkurl'],'Mall'.$i);
			$i++;
		}
		$mall[0] = $CAT;
		$mall[1] = $stype;
		$mall[2] = $AREA;
		$c = CartesianProduct($mall);
		buildSoSitemap($c,$MODULE[16]['linkurl'],'Mall'.$i);
	break;
	case 'mall_keshi':
		//产品模块科室搜索列表页
		$catid = $category->field('catid')->where(['moduleid'=>12])->all();
		$CAT = [];
		foreach($catid as $k=>$v){
			array_push($CAT,$v['catid']);
		}
		array_unshift($CAT,'0');		//企业模块类型id
		//产品模块分类列表的地址拼接方式为 catid-stype-areaid.HTML
		$stype = [0,1,2,3];
		$vip = [0];	//vip只取0值
		$i = 1;
		while(count($CAT) > 50){
			$mCAT = array_slice($CAT,0,50);
			array_splice($CAT,0,50);
			$mall[0] = $mCAT;
			$mall[1] = $stype;
			$mall[2] = $AREA;
			$mall[3] = $vip;
			$c = CartesianProduct($mall);
			buildSoSitemap($c,$MODULE[16]['linkurl'],'MallKeshi'.$i,'ks');
			$i++;
		}
		$mall[0] = $CAT;
		$mall[1] = $stype;
		$mall[2] = $AREA;
		$c = CartesianProduct($mall);
		buildSoSitemap($c,$MODULE[16]['linkurl'],'MallKeshi'.$i,'ks');
	break;
	case 'sell':
		//产品模块科室搜索列表页
		$catid = $category->field('catid')->where(['moduleid'=>5])->all();
		$CAT = [];
		foreach($catid as $k=>$v){
			array_push($CAT,$v['catid']);
		}
		array_unshift($CAT,'0');		//企业模块类型id
		$typeid = [0,1,2];		//0供应，1需求，2其他
		$vip = [0];	//vip只取0值
		$sell[0] = $CAT;
		$sell[1] = $typeid;	
		$sell[2] = $AREA;
		$sell[3] = $vip;
		$c = CartesianProduct($sell);
		buildSoSitemap($c,$MODULE[5]['linkurl'],'Sell');
	break;
}

msg('SiteMaps 更新成功', '?moduleid='.$moduleid.'&file=setting#sitemaps');
/**
* sitemap文件生成
* @param array $arr,参数组合
* @param string $url,地址前缀
* @return bool
*/
function buildSoSitemap($arr,$url,$modulename,$linkname = 'so'){
	$start = '<?xml version="1.0" encoding="UTF-8"?>';
	$start .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$end = "</urlset>";
	$data = '';
	$p = 0;
	$data = $start;
	$today = date('Y-m-d',time());
	foreach($arr as $k => $v){
		if(($k != 0) && ($k % 9999 == 0)){
			$data .= $end;
			$data = convert($data, DT_CHARSET, 'UTF-8');
			$page = empty($p) ? '' : $p;
			$b = file_put(DT_ROOT.'/sitemap/list/sitemap'.$modulename.'List'.$page.'.xml',$data);
			$p++;
			$data = $start; 
		}
			$sourl = implode('-',$v);
			$data .= '<url>';
			$data .= "<loc>$url"."$linkname-$sourl.html</loc>";
			$data .= '<lastmod>'.$today.'</lastmod>';
			$data .= '<changefreq>Daily</changefreq>';
			$data .= '<priority>0.8</priority>';
			$data .= '</url>';
	}
	if(strlen($data) != 0){
		$data .= $end;
		$data = convert($data, DT_CHARSET, 'UTF-8');
		$page = empty($p) ? '' : $p;
		file_put(DT_ROOT.'/sitemap/list/sitemap'.$modulename.'List'.$page.'.xml',$data);
	}
}
/**
* 笛卡尔乘积处理，将所有数组元素的组合计算汇总
* @param array $arr	,包含所有参数的数组
* @return array
*/
function CartesianProduct($arr){
	if(count($arr) == 1){	//当前数组只有一个元素时，将数组值拆分为数组返回
		$back = [];
		foreach($arr as $k=>$v){
			foreach($v as $kk => $vv){
				$back[] = array($vv);
			}
		}
		return $back;
	}else{
		//当数组元素个数超过1时
		$key = array_keys($arr);
		$key_first = $key[0];
		$arr_first = $arr[$key_first];	//提取第一个元素
		unset($arr[$key_first]);		//移去第一个元素
		$cartesian = CartesianProduct($arr);		//获取剩余数组的笛卡尔乘积组合
		
		$back = [];	//返回数组
		foreach($arr_first as $k => $v){
			foreach($cartesian as $ck => $cv){
				$c = $cv;
				array_unshift($c,$v);
				$back[] = $c;
			}
		}
		return $back;
	}
}

?>