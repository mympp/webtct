<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
if($DT['city']) {
	$DT['index_html'] = 0;
	$C = cache_read('module-2.php');
	$M = $C['linkurl'];
} else {
	$M = $MODULE[2]['linkurl'];
}
$data = '';
$data .= 'var DTPath = "'.DT_PATH.'";';
$data .= 'var SKPath = "'.DT_SKIN.'";';
$data .= 'var MEPath = "'.$M.'";';
$data .= 'var DTEditor = "'.DT_EDITOR.'";';
$data .= 'var CKDomain = "'.$CFG['cookie_domain'].'";';
$data .= 'var CKPath = "'.$CFG['cookie_path'].'";';
$data .= 'var CKPrex = "'.$CFG['cookie_pre'].'";';
file_put(DT_ROOT.'/file/script/config.js', $data);
$filename = $CFG['com_dir'] ? DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext'] : DT_CACHE.'/index.inc.html';
if(!$DT['index_html']) {
	if(is_file($filename)) unlink($filename);
	return false;
}
$destoon_task = "moduleid=1&html=index";
$AREA = cache_read('area.php');
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'];
$seo_title = $DT['seo_title'];
$head_keywords = $DT['seo_keywords'];
$head_description = $DT['seo_description'];
require DT_ROOT.'/include/tcdb.class.php';
$area_db = new tcdb('area');
$area_first = $area_db->field('areaid,areaname')->where(['parentid'=>0])->limit(0,80)->select();		//一级地区数据
$category_db = new tcdb('category');
$hr_catid = $category_db->field('catid,catname')->where(['moduleid'=>28,'parentid'=>0])->limit(0,30)->order('catid asc')->select();		//人才分类
$sell_catid = $category_db->field('catid,catname')->where(['moduleid'=>5,'parentid'=>0])->limit(0,30)->order('catid asc')->select();		//供应分类
$buy_catid = $category_db->field('catid,catname')->where(['moduleid'=>6,'parentid'=>0])->limit(0,30)->order('catid asc')->select();		//需求分类
$job_catid = $category_db->field('catid,catname')->where(['moduleid'=>9,'parentid'=>0])->limit(0,30)->order('catid asc')->select();		//维修、工程师分类
$company_catid = $category_db->field('catid,catname')->where(['moduleid'=>4,'parentid'=>0])->limit(0,30)->order('catid asc')->select();		//企业经营范围
$keshi_catid = $category_db->field('catid,catname')->where(['moduleid'=>12,'parentid'=>0])->limit(0,100)->order('catid asc')->select();		//科室分类
$mall_catid = $category_db->field('catid,catname,catdir')->where(['moduleid'=>16,'parentid'=>0])->limit(0,100)->order('catid asc')->select();		//产品分类
ob_start();
include template('index2017');
$data = ob_get_contents();
ob_clean();
file_put($filename, $data);
return true;


function isMobile(){
	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")){ 
        return true;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile' ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
}
?>