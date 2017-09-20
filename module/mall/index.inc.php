<?php
use models\helpers\widget\redirect\pc_to_wap;

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT . '/models/autoload.php';
$wapurl = pc_to_wap::forword('chanpin');

require DT_ROOT . '/module/' . $module . '/common.inc.php';

if (!check_group($_groupid, $MOD['group_index'])) {
    include load('403.inc');
}
$tc = 8;
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
$list = 1;
$action = isset($action) ? $action : 0;
include DT_ROOT . '/include/seo.inc.php';
$destoon_task = "moduleid=$moduleid&html=index";
if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . mobileurl($moduleid, 0, 0, $page);

/**
 * 新版首页处理流程
 */
//整理分类数据
$category_db = new tcdb('category');
foreach ($CAT as $t) {        //$CAT数据读于common.inc.php文件
    $CATDETAIL[$t['catid']] = $t;
}
$KESHI = $category_db->field('catid,catname')->where(['parentid' => 0, 'moduleid' => 12])->order('catid asc')->all();    //科室分类
$nowdate = strtotime(date('Y-m-d', time()));

//热门搜索词
$keyword_data_db = new tcdb('keyword_data');
$keywords = $keyword_data_db->field('itemid,word')
    ->order('itemid desc')->limit(0, 120)->select();

//首页广告位
$ad_db = new tcdb('ad');
$ads = $ad_db->field('image_url,image_src,image_alt')
    ->where(['pid' => 199, 'status' => 3])
    ->where(['totime' => $nowdate], '>')->all();

//顶部推荐产品
$mall_db = new tcdb('mall');
$top_malls = $mall_db->field('itemid,thumb,title,linkurl,catid')
    ->where(['groupid' => 7, 'status' => 3])
    ->where(['thumb' => ''], '<>')->order('hits desc')->limit(0, 8)->select();

//楼层产品信息
$floor_catid = [1170, 1198, 1185, 1208];        //使用基础外科手术器械，临床检验分析仪器，医用电子仪器设备，医用卫生材料及辅料作为首页产品楼层内容
$floor = [];
$addtimeLimit = time() - (3600 * 24 * 90);
foreach ($floor_catid as $k => $t) {
    //手术器械楼层产品
    $floor[$k]['malls'] = $mall_db
        ->field('itemid,thumb,title,linkurl,company,username')
        ->where(['status' => 3])->where(['thumb' => ''], '<>')
        ->where(['catid' => $CATDETAIL[$t]['arrchildid']], 'in')
        ->order('itemid desc')->limit(0, 5)->select();
    $floorCondition = $mall_db->getCondition();
    //手术器械楼层热门
    $floor[$k]['hits'] = $mall_db
        ->field('itemid,thumb,title,linkurl,hits')
        ->where($floorCondition)
        ->where(['addtime' => $addtimeLimit], '>')
        ->order('hits desc')->limit(0, 5)->select();
    if (empty($floor[$k]['hits'])) {
        $floor[$k]['hits'] = $mall_db
            ->field('itemid,thumb,title,linkurl,hits')
            ->where($floorCondition)
            ->order('itemid desc')->limit(5, 5)->select();
    }
}
//楼层供应商
$company_db = new tcdb('company');
$companys = $company_db->field('company,linkurl,thumb')
    ->where(['groupid' => 7])->order('pnum desc')->limit(0, 10)->select();
$companys_new = $company_db->field('company,linkurl')
    ->where(['hits' => 0], '<>')->where(['pnum' => 3], '>')
    ->order('userid desc')->limit(0, 6)->select();
$area_db = new tcdb('area');
$mainarea = $area_db->field('areaid,areaname')->where(['parentid' => 0])->all();
//行业资讯
$article_db = new tcdb('article_21');
$articles = $article_db->field('itemid,title,thumb,linkurl')
    ->where(['status' => 3, 'catid' => 839])->where(['thumb' => ''], '<>')
    ->order('itemid desc')->limit(0, 8)->select();
//招标信息
$buy_db = new tcdb('buy_6');
$buys = $buy_db->field('title,linkurl')->where(['status' => 3])
    ->order('itemid desc')->limit(0, 5)->select();
//友情链接
$link_db = new tcdb('link');
$links = $link_db->field('title,linkurl')
    ->where(['status' => 3, 'link_moduleid' => 16])
    ->order('listorder asc')->limit(0, 30)->select();
$menu_index = 'index';    //导航样式标记

include template('index', $module);
?>