<?php 
defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT.'/module/'.$module);
define('SO_SKIN',DT_PATH.'skin/sogex');
require_once DT_ROOT.'/include/module.func.php';
require_once DT_ROOT.'/module/search/common.func.php';

$info_type_lists = get_cache('info_type');	//读取数据类型缓存

?>
