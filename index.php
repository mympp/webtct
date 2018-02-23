<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
use models\helpers\widget\redirect\pc_to_wap;
use models\helpers\data\tcdb;
use models\module\baseModule;

require 'common.inc.php';
require_once __DIR__ . '/models/autoload.php';

if(!isset($homepage)){
    //判断是否移动端需要跳转到wap网站
    pc_to_wap::forword('');
}

$username = $domain = '';
if (isset($homepage) && check_name($homepage)) {
    $username = $homepage;
} else if (!$cityid) {
    $host = get_env('host');
    if (substr($host, 0, 4) == 'www.') {
        $whost = $host;
        $host = substr($host, 4);
    } else {
        $whost = $host;
    }
    if ($host && strpos(DT_PATH, $host) === false) {
        if (substr($host, -strlen($CFG['com_domain'])) == $CFG['com_domain']) {
            $www = substr($host, 0, -strlen($CFG['com_domain']));
            if (check_name($www)) {
                $username = $homepage = $www;
            } else {
                include load('company.lang');
                $head_title = $L['not_company'];
                if ($DT_BOT) dhttp(404, $DT_BOT);
                include template('com-notfound', 'message');
                exit;
            }
        } else {
            if ($whost == $host) {//301 xxx.com to www.xxx.com
                $w3 = 'www.' . $host;
                $c = $db->get_one("SELECT userid FROM {$DT_PRE}company WHERE domain='$w3'");
                if ($c) d301('http://' . $w3);
            }
            $c = $db->get_one("SELECT username,domain FROM {$DT_PRE}company WHERE domain='$whost'" . ($host == $whost ? '' : " OR domain='$host'"), 'CACHE');
            if ($c) {
                $username = $homepage = $c['username'];
                $domain = $c['domain'];
            }
        }
    }
}

if ($username) {
    $moduleid = 4;
    $module = 'company';
    $MOD = cache_read('module-' . $moduleid . '.php');
    include load('company.lang');
    require DT_ROOT . '/module/' . $module . '/common.inc.php';
    include DT_ROOT . '/module/' . $module . '/init.inc.php';
} else {
    if ($DT['safe_domain']) {
        $safe_domain = explode('|', $DT['safe_domain']);
        $pass_domain = false;
        foreach ($safe_domain as $v) {
            if (strpos($DT_URL, $v) !== false) {
                $pass_domain = true;
                break;
            }
        }
        $pass_domain or dhttp(404);
    }

    $AREA or $AREA = cache_read('area.php');
    if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'];
    $seo_title = $DT['seo_title'];
    $head_keywords = $DT['seo_keywords'];
    $head_description = $DT['seo_description'];
    if ($city_template) {
        include template($city_template, 'city');
    } else {
        if (isset($open) && $open == 'pc') {    //带有open参数时不跳转移动端
            $head_mobile = '';
            $head_link = '';
        }

        //引入静态文件
        //if($DT['index_html']){
        //	$html_file = $CFG['com_dir'] ? DT_ROOT.'/'.$DT['index'].'.'.$DT['file_ext'] : DT_CACHE.'/index.inc.html';
        //	if(!is_file($html_file)) tohtml('index');
        //	if(is_file($html_file)) exit(include($html_file));
        //}

        $area_db = new tcdb('area');
        $area_first = $area_db->field('areaid,areaname')->where(['parentid' => 0])->limit(0, 80)->select();        //一级地区数据
        $category_db = new tcdb('category');
        $hr_catid = $category_db->field('catid,catname')->where(['moduleid' => 28, 'parentid' => 0])->limit(0, 30)->order('catid asc')->select();        //人才分类
        $sell_catid = $category_db->field('catid,catname')->where(['moduleid' => 5, 'parentid' => 0])->limit(0, 30)->order('catid asc')->select();        //供应分类
        $buy_catid = $category_db->field('catid,catname')->where(['moduleid' => 6, 'parentid' => 0])->limit(0, 30)->order('catid asc')->select();        //需求分类
        $job_catid = $category_db->field('catid,catname')->where(['moduleid' => 9, 'parentid' => 0])->limit(0, 30)->order('catid asc')->select();        //维修、工程师分类
        $company_catid = $category_db->field('catid,catname')->where(['moduleid' => 4, 'parentid' => 0])->limit(0, 30)->order('catid asc')->select();        //企业经营范围
        $keshi_catid = $category_db->field('catid,catname')->where(['moduleid' => 12, 'parentid' => 0])->limit(0, 100)->order('catid asc')->select();        //科室分类
        $mall_catid = $category_db->field('catid,catname,catdir')->where(['moduleid' => 16, 'parentid' => 0])->limit(0, 100)->order('catid asc')->select();        //产品分类

        //推荐vip产品
        $mallModule = baseModule::moduleInstance('mall');
        //$vipMalls = $mallModule->getVipMalls(16);
        $vipMalls = $mallModule->getCache('getVipMalls',[16],(3600*24));

        //维修资料
        /* @var \models\module\CurlContentModule $curlContentModule */

        $curlContentModule = baseModule::moduleInstance('CurlContent');
        $repairData = $curlContentModule->getCache('getIndexRepairData', [], 3600);

        include template('index2017');
    }
}

?>
