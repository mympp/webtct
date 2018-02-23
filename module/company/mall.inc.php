<?php
use models\helpers\widget\nlp\scws;
use models\helpers\view\pagination;
use models\helpers\query\MallValidateQuery;
use models\config\config;

defined('IN_DESTOON') or exit('Access Denied');
use models\helpers\widget\redirect\pc_to_wap;

require_once 'new.init.inc.php';

if($itemid){
    $wapurl = pc_to_wap::forword('chanpin/itemid-'.$itemid.'.html');
}else{
    $wapurl = pc_to_wap::forword('gongsi/shop-'.$homepage.'/mall.html');
}
require_once 'new.left.inc.php';

$scws = new scws();
$stopWord = $scws->getStopWord();

$moduleid = 16;
$module = 'mall';
$MOD = cache_read('module-' . $moduleid . '.php');
$table = $DT_PRE . 'mall';
$table_data = $DT_PRE . 'mall_data';
if ($itemid) {
    $item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
    if (!$item || $item['status'] < 3 || $item['username'] != $username) dheader($MENU[$menuid]['linkurl']);
    unset($item['template']);
    extract($item);
    $CAT = get_cat($catid);
    $content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
    $t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
    $content = $t['content'];

    $CP = $MOD['cat_property'] && $CAT['property'];
    if ($CP) {
        require DT_ROOT . '/include/property.func.php';
        $options = property_option($catid);
        $values = property_value($moduleid, $itemid);
    }
    require DT_ROOT . '/module/' . $module . '/global.func.php';
    $RL = $relate_id ? get_relate($item) : array();
    $P1 = get_nv($n1, $v1);
    $P2 = get_nv($n2, $v2);
    $P3 = get_nv($n3, $v3);
    if ($step) {
        extract(unserialize($step));
    } else {
        $a1 = 1;
        $p1 = $item['price'];
        $a2 = $a3 = $p2 = $p3 = '';
    }
    $unit or $unit = $L['unit'];
    $adddate = timetodate($addtime, 3);
    $editdate = timetodate($edittime, 3);
    $linkurl = $MOD['linkurl'] . $linkurl;
    $thumbs = get_albums($item);
    $albums = get_albums($item, 1);
    $album_js = 1;
    $amount = number_format($amount, 0, '.', '');
    $update = '';
    include DT_ROOT . '/include/update.inc.php';
    $head_canonical = $linkurl;
    //$head_title = $title . $DT['seo_delimiter'] . $head_title;
    $head_title = $title . '_'. $companyInfo['company'];
    $head_keywords = $keyword;
    $head_description = $introduce ? $introduce : $title;
    if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . mobileurl($moduleid, 0, $itemid, $page);;

    //过滤敏感词
    $content = str_replace($stopWord, '*', $content);        //产品内容过滤
    $title = str_replace($stopWord, '*', $title);
    $introduce = str_replace($stopWord, '*', $introduce);
    //新版数据
    $mallRegisterPic = (new MallValidateQuery())->getRegisterPic($itemid);
    $baiduServerUrl = config::getConfig('customerServer','baidu');  //百度商桥地址
} else {
    $typeid = isset($typeid) ? intval($typeid) : 0;
    $view = isset($view) ? 1 : 0;
    $url = "file=$file";
    $condition = "username='$username' AND status=3";
    if ($typeid) {
        $MTYPE = get_type('mall-' . $userid);
        $condition .= " AND mycatid='$typeid'";
        $url .= "&typeid=$typeid";
        $head_title = $MTYPE[$typeid]['typename'] . $DT['seo_delimiter'] . $head_title;
    }
    if ($kw) {
        $condition .= " AND (keyword  LIKE '%$keyword%'  or introduce  LIKE '%$keyword%' ) ";
        $url .= "&kw=$kw";
        $head_title = $kw . $DT['seo_delimiter'] . $head_title;
    }
    if ($view) {
        $url .= "&view=$view";
    }
    $demo_url = userurl($username, $url . '&page={destoon_page}', $domain);
    $pagesize = intval($menu_num[$menuid]);
    if (!$pagesize || $pagesize > 100) $pagesize = 16;
    if ($view) $pagesize = ceil($pagesize / 2);
    $offset = ($page - 1) * $pagesize;
    $r = $db->get_one("SELECT COUNT(*) AS num FROM {$table} WHERE $condition", 'CACHE');
    $items = $r['num'];
    $pages = home_pages($items, $pagesize, $demo_url, $page);
    $lists = array();
    if ($items) {
        $result = $db->query("SELECT " . $MOD['fields'] . " FROM {$table} WHERE $condition ORDER BY edittime DESC LIMIT $offset,$pagesize");
        while ($r = $db->fetch_array($result)) {
            $r['alt'] = $r['title'];
            $r['title'] = set_style($r['title'], $r['style']);
            $r['linkurl'] = $homeurl ? $MOD['linkurl'] . $r['linkurl'] : userurl($username, "file=$file&itemid=$r[itemid]", $domain);
            if ($kw) {
                $r['title'] = str_replace($kw, '<span class="highlight">' . $kw . '</span>', $r['title']);
                $r['introduce'] = str_replace($kw, '<span class="highlight">' . $kw . '</span>', $r['introduce']);
                //过滤敏感词
                $r['title'] = str_replace($stopWord, '*', $r['title']);
                $r['introduce'] = str_replace($stopWord, '*', $r['introduce']);
            }
            $lists[] = $r;
        }
        $db->free_result($result);
    }
    if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . 'index.php?moduleid=4&username=' . $username . '&action=' . $file . ($typeid ? '&typeid=' . $typeid : '') . ($page > 1 ? '&page=' . $page : '');

    if($template == 'homepage'){
        //新版模版数据
        $childType = [];
        $typename = '';
        if(!empty($typeid)){
            foreach($companyMallType as $key => $type){
                if($type['parentid'] == $typeid){
                    $childType[] = $type;
                }
                if($type['typeid'] == $typeid){
                    $typename = $type['typename'];
                    $typeurl = $type['linkurl'];
                }
            }
        }
        $mallLists = $homepageModule->buildMallTypeLink($lists);
        //新版分页按钮
        $pagination = new pagination($page,$items,$pagesize);
        $homepageModule->setSearchRewriteFunc('mallTypeRewrite');
        $pagination->setModule($homepageModule);
        $pagination->setCurrentTip('class="on"');
        $pages = $pagination->show(DT_PATH.'index.php',[
            'div' => ['class' => 'pagination'],
            'form' => ['id' => 'hotForm','method'=>'get'],
        ],['typeid'=>$typeid,'page'=>$page,'homepage' => $username,'file'=>$file]);

        $head_title = $companyInfo['company'].'_'.$head_title;
    }

}
include template('mall', $template);
?>