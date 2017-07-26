<?php
/*
time:2015/10/27
who ：xiaolv
rel : wap_message.php
add:页面跳转提示信息
*/
define('DT_WAP', true);
header('P3P: CP=CAO PSA OUR');
header("Expires:-1");
header("Last-Modified:".gmdate ("D, d M Y H:i:s")."GMT"); 
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT "); 
header("Cache-Control:no-cache,must-revalidate");
header("Pragma:no-cache");
header("Content-type:text/html; charset=utf-8");
require 'global.func.php';
include load('wap.lang');
$EXT['wap_enable'] or wap_msg($L['msg_wap_close']);
$TP = 'touch';
if($TP == 'touch') {
	$back_link = $head_link = $head_name = '';
}
$pagesize = $EXT['wap_pagesize'] ? $EXT['wap_pagesize'] : 10;
$offset = ($page-1)*$pagesize;
$maxlength = $EXT['wap_maxlength'] ? $EXT['wap_maxlength'] : 500;
$pages = '';
$areaid = isset($areaid) ? intval($areaid) : 0;
$head_title = $DT['sitename'].$L['wap_version'];
$kw = $kw ? trim($kw) : '';
if(strtolower($CFG['charset'] != 'utf-8') && $kw) {
	$kw = convert($kw, 'utf-8', $CFG['charset']);
	$DT_URL = convert(urldecode($DT_URL), 'utf-8', $CFG['charset']);
}
if(strlen($kw) < $DT['min_kw'] || strlen($kw) > $DT['max_kw']) $kw = '';
$keyword = $kw ? str_replace(array(' ', '*'), array('%', '%'), $kw) : '';
$len = 30;

if (!DT_DEBUG) {
?>
<script type="text/javascript">window.onerror=function(){return true;}</script>
<?php 
}
if ($lazy) {
?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.lazyload.js"></script>
<?php
}
?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>lang/{DT_LANG}/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/page.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jsfunction.js"></script>