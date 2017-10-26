<?php

defined('IN_DESTOON') or exit('Access Denied');
define('MD_ROOT', DT_ROOT . '/module/' . $module);
require_once DT_ROOT .'/models/autoload.php';

require DT_ROOT . '/include/module.func.php';
require MD_ROOT . '/global.func.php';
$table = $DT_PRE . $module . '_' . $moduleid;
$table_data = $DT_PRE . $module . '_data_' . $moduleid;

$logo_title = '共享';
$logo_url = 'www.tecenet.com/gongxiang/';

$CATEGORY = getDownCategory();
$CAT = [];
foreach ($CATEGORY as $k => $v) {
    $CAT[$v['catid']] = $v['catname'];
}

//文件类型
$FILEEXT = [
    'img' => '图片文件',
    'mov' => '音频/视频文件',
    'exe' => '应用程序',
    'pdf' => 'PDF文档',
    'doc' => 'Word文档',
    'xls' => 'Excel工作表',
    'ppt' => 'PPT幻灯片',
    'swf' => 'Flash影片',
    'chm' => 'CHM文件',
    'rar' => '压缩文件',
    'hlp' => '帮助文件',
    'oth' => '其他文件类型',
];
?>