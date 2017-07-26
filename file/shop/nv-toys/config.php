<?php
require '../../../common.inc.php';

defined('IN_DESTOON') or exit('Access Denied');
define('USERNAME','jingxing');
define('USERID',55538);

require DT_ROOT.'/include/tcdb.class.php';
$mall = new tcdb('mall'); 

$member = new tcdb('member');
$mem = $member->where(['username'=>USERNAME])->one();

?>