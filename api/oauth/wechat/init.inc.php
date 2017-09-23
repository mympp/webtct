<?php
use models\helpers\data\tcdb;
defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

$settingDb = new tcdb('setting');
$weixinSetting = $settingDb->field('item_key,item_value')
    ->where(['item'=>'weixin'])->all();
if(empty($weixinSetting)){
    dalert('Error Params');
}

$setting = [];
foreach($weixinSetting as $value){
    $setting[$value['item_key']] = $value['item_value'];
}

if(empty($setting['appid']) || empty($setting['appsecret'])){
    dalert('Error Params');
}

$site = 'wechat';
$session = new dsession();

define('WX_ID', $setting['appid']);
define('WX_SECRET', $setting['appsecret']);
define('WX_CALLBACK', DT_PATH.'api/oauth/'.$site.'/callback.php');
define('WX_CONNECT_URL', 'https://open.weixin.qq.com/connect/qrconnect');
define('WX_PCONNECT_URL', 'https://open.weixin.qq.com/connect/oauth2/authorize');//2016-2-18--授权获取微信个人资料
define('WX_TOKEN_URL', 'https://api.weixin.qq.com/sns/oauth2/access_token');
define('WX_QRCODE_URL','https://open.weixin.qq.com/connect/qrconnect');
define('WX_USERINFO_URL', 'https://api.weixin.qq.com/sns/userinfo');
?>