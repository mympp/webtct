<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/module/search/sphinxSearch.class.php';

$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
$type=isset($_GET['type'])?$_GET['type']:'';
$page=isset($_GET['page'])?$_GET['page']:'';
$keyword=isset($_POST['keyword'])?$_POST['keyword']:$keyword;

$keyword = str_replace('"','',$keyword);
$keyword = str_replace("'",'',$keyword);
$keyword = str_replace('\\','',$keyword);

if($keyword==''){
	header('Location:mindex.php');	exit;
}
$type=isset($_POST['type'])?$_POST['type']:$type;
$page=isset($_POST['page'])?$_POST['page']:$page;


$sphinx = new sphinxSearch();
$sword=getSegmentation($keyword);   //对搜索字符词进行分词
$sword_str=implode("','",$sword);     //分词数组组成字符词
$weight_str = getRuleWeight($sword_str);

if($weight_str != ''){
	$weight_str = '@weight'.$weight_str;
	$sphinx->setSortMode(SPH_SORT_EXPR,$weight_str);
}

$sphinx->setFieldWeights(array('web_title'=>15,'title'=>15,'keywords'=>9,'description'=>5));
$sphinx->setFilter('status',array(3));
if($type){
	$sphinx->setFilter('type',array($type));
}
$sphinx->setFilterRange('@weight',1,2000,true);
$pagesize=10;
if($page==''){$page=1;}
$start=($page-1)*$pagesize;

$sphinx->setLimits($start,$pagesize,9999999);

//$sphinx->setRankingMode(SPH_RANK_MATCHANY);
$sphinx->setRankingMode(SPH_RANK_SPH04);

$i_word = implode('"|"',$sword);

//最先开始分词搜索
$spresult_second = $sphinx->query('"'.$i_word.'"|"'.$keyword.'"',$sphinx->indexes);
$spresult_first = $sphinx->query("@web_title($keyword)|@description($keyword)",$sphinx->indexes);

if($start < $spresult_first['total']){
        if($start + $pagesize > $spresult_first['total']){
                $second_start = 0;
                $second_pagesize = $pagesize -( $spresult_first['total'] - $start);
                $sphinx->setLimits($second_start,$second_pagesize,9999999);
                $spresult_second = $sphinx->query('"'.$i_word.'"|"'.$keyword.'"',$sphinx->indexes);
                if($spresult_second['total'] != 0){
					$spresult['matches'] = array_merge($spresult_first['matches'],$spresult_second['matches']);
				}else{
					$spresult = $spresult_first;
				}
        }else{
                $spresult = $spresult_first;
        }
}else{
        $second_start = $start - $spresult_first['total'];
        $sphinx->setLimits($second_start,$pagesize,999999);
        $spresult = $sphinx->query('"'.$i_word.'"|"'.$keyword.'"',$sphinx->indexes);
}
$spresult['total'] = $spresult_first['total'] + $spresult_second['total'];

if(intval($spresult['total']) == 0 ){		//结果数目太少，开启拓词搜索
	$expand = get_expand($keyword,$sword);		//获取拓词
	if(!$expand) $spresult = $sphinx->query('"'.$i_word.'"|"'.$i_word.'"|'.$expand['search'],$sphinx->indexes);
}


$tagss=$spresult['matches'];

$pages=so_pages($spresult['total'],$page,$pagesize,$keyword,$type);

//查找推广
//查找信息推广类型，0表示全网搜索可以显示，99表示可放置在首页和全网搜索
$spread_type = '';
if($type){
	$spread_type = " and s.mid in (0,99,$type)";
}else{
	$spread_type = " and s.mid in (0,99)";
}

//包月类型推广
$spread_arr = array();		//推广数据
$spread_data_1 = $db->query("select i.ideaid as ideaid,s.itemid as itemid,i.name as title,i.url as url,i.description as description,i.addtime as addtime,i.thumb as thumb,i.default_name as default_name,i.default_description as default_description , s.tid as tid from {$db->pre}spread as s join {$db->pre}sogex_ideas as i on s.tid = i.ideaid where s.word = '$keyword' and i.status = 3 and s.status = 3 and s.stype = 1 and s.fromtime <= ".time()." and s.totime >= ".time()." $spread_type group by s.tid order by s.total desc ");
$select_tid = array();	//存放已经搜索出的创意id
while($v = $db->fetch_array($spread_data_1)){
	array_push($select_tid,$v['tid']);
	array_push($spread_arr,$v);	
}

$count1 = count($spread_arr);	//统计已获得推广数目
$limit = 6 - $count1;

if($limit > 0){
//单条类型推广 
$select_tid_str = implode(',',$select_tid);	//已搜索创意id到字符串
//搜索条件：符合搜索词（word=$keyword），通过审核(status=3),用户启动(spread_status=3)，单条类型(stype=2)，剩余比话费多(least>spend)，创意没有在包月类型已使用(tid not in ),搜索类型符合(spread_type)
$spread_data_2 = $db->query("select i.ideaid as ideaid,s.itemid as itemid ,i.name as title,i.url as url,i.description as description,i.addtime as addtime,i.thumb as thumb,i.default_name as default_name,i.default_description as default_description from {$db->pre}spread as s join {$db->pre}sogex_ideas as i on s.tid = i.ideaid  where s.word = '$keyword' and i.status = 3 and s.status = 3 and s.spread_status = 3 and stype = 2 and s.least > s.spend and s.tid not in ($select_tid_str) $spread_type group by s.tid order by s.spend desc LIMIT 0,$limit");

while($v = $db->fetch_array($spread_data_2)){
	array_push($spread_arr,$v);
}
}

//进行搜索记录
if($page == '1'){
	$uip = get_ip();
	$addtime = time();
	$db->query("insert into {$db->pre}sogex_record (word,username,total,ip,type,addtime) values ('$keyword','$_username','".$spresult['total']."','$uip',$type,'$addtime')");
}

$t = $type > 0 ? $type : 0;
$seo_message = array(0=>'产品详情/厂家/联系方式等信息',1=>'产品/详情/图片/厂家等信息',2=>'厂家/联系方式/公司介绍等信息',3=>'新闻/资讯/行业信息',4=>'维修/服务/工程师等信息',5=>'维修工程师/售后工程师/医疗器械维修等信息',6=>'供应/求购/需求_供求等信息',7=>'项目申报/科研项目转化/资质注册等信息');
$seo_title = '收录'.$spresult['total'].'条关于“'.$keyword.'”'.$seo_message[$t].'-天成医搜。';
$seo_desc = array();
$seo_desc[0] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关医疗产品/厂家/服务工程师/资讯等信息，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[1] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关产品信息/产品详情/产品图片/产品厂家等信息，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[2] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关厂家信息公司介绍/联系方式/公司介绍等信息，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[3] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关资讯/新闻/行业信息等，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[4] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关维修/服务/工程师等信息，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[5] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关维修工程师/售后工程师/医疗器械维修等信息，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[6] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关供应/求购/需求/供求信息等，点击查看更多'.$keyword.'医疗器械相关信息。';
$seo_desc[7] = '天成医搜收录'.$spresult['total'].'条'.$keyword.'的相关项目申报/科研项目转化/资质注册等信息，点击更多'.$keyword.'医疗器械相关信息。';
$seo_description = $seo_desc[$t];

$seo_key[0] = $keyword.'产品,'.$keyword.'厂家,'.$keyword.'搜索结果';
$seo_key[1] = $keyword.'产品,'.$keyword.'详情,'.$keyword.'图片';
$seo_key[2] = $keyword.'公司,'.$keyword.'厂家,'.$keyword.'生产厂家';
$seo_key[3] = $keyword.'资讯,'.$keyword.'新闻,'.$keyword.'行业信息';
$seo_key[4] = $keyword.'维修,'.$keyword.'服务';
$seo_key[5] = $keyword.'工程师,'.$keyword.'售后工程师,'.$keyword.'维修工程师';
$seo_key[6] = $keyword.'供应,'.$keyword.'求购,'.$keyword.'供求信息';
$seo_key[7] = $keyword.'项目申报,'.$keyword.'项目转化,'.$keyword.'资质注册';
$seo_keyword = $seo_key[$t];

/**
*	相关产品改为使用sphinx搜索
*/
$sphinx_mall = new sphinxSearch();
$sphinx_mall->setFilter('moduleid',array(16));
$sphinx_mall->setLimits(0,6,6);
$mall_result = $sphinx_mall->query("@title($keyword)","data");
$malls_data = $mall_result['matches'];
if(count($malls_data) == 0){
	$malls_result = $db->query("select * from {$db->pre}mall order by itemid desc limit 0,6");
	while($r = $db->fetch_array($malls_result)){
		$malls[] = $r;
	}
}else{
	foreach($malls_data as $v){
		$malls[] = $v['attrs'];
	}
}

include template('msearch', $module);

?>
