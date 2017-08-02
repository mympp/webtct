<?php
use models\helpers\data\tcdb;
use models\helpers\widget\grab;

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/models/autoload.php';

$mall_db = new tcdb('mall');
$mall = $mall_db->field('title,batchnum')->where(['itemid'=>$itemid])->one();

$keyword = '';
if(!empty($mall['batchnum'])){
	$batchnum = explode(' ',$mall['batchnum']);
	$count = count($batchnum);
	$keyword = $batchnum[($count-1)];
}


$grab = new grab();
$search_url = 'http://app1.sfda.gov.cn/datasearch/face3/search.jsp';
$keyword_list_26 = $grab->getGrab($search_url,['tableId'=>26,'keyword'=>urlencode($keyword)]);
$keyword_list_26 = replaceButton($keyword_list_26);
$title_list_26 = $grab->getGrab($search_url,['tableId'=>26,'COLUMN184'=>$title,'state'=>1]);var_dump($grab->getErrMsg());
$title_list_26 = replaceButton($title_list_26);

$title = $mall['title'];

include tpl('supersive', $module);

function replaceButton($string){
	$string = str_replace('<img src=images/dataanniu_09.gif width=57 height=17>','',$string);
	$string = str_replace('<img src=images/dataanniu_05.gif width=57 height=17>','',$string);
	$string = str_replace('<img src=images/dataanniu_03.gif width=57 height=17>','',$string);
	$string = str_replace('<img src=images/dataanniu_07.gif width=57 height=17>','',$string);
	return $string;
}

?>
