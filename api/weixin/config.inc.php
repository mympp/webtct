<?php
use models\helpers\data\tcdb;
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

$settingDb = new tcdb('setting');
$weixinSetting = $settingDb->field('item_key,item_value')
    ->where(['item'=>'weixin'])->all();

if(empty($weixinSetting)){
    exit('Missing configuration...');
}

$setting = [];
foreach($weixinSetting as $value){
    $setting[$value['item_key']] = $value['item_value'];
}

if(empty($setting['appid']) || empty($setting['appsecret'])){
    exit('Missing configuration...');
}

define('WX_APPID', $setting['appid']);
define('WX_APPSECRET', $setting['appsecret']);
define('WX_APPTOKEN', $setting['apptoken']);
?>