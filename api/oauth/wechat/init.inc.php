<?php
defined('IN_DESTOON') or exit('Access Denied');
$OAUTH = cache_read('oauth.php');
$site = 'wechat';
$OAUTH[$site]['enable'] or dheader($MODULE[2]['linkurl'].$DT['file_login']);
$session = new dsession();

define('WX_ID', $OAUTH[$site]['id']);
define('WX_SECRET', $OAUTH[$site]['key']);
define('WX_CALLBACK', DT_PATH.'api/oauth/'.$site.'/callback.php');
define('WX_CONNECT_URL', 'https://open.weixin.qq.com/connect/qrconnect');
define('WX_PCONNECT_URL', 'https://open.weixin.qq.com/connect/oauth2/authorize');//2016-2-18--授权获取微信个人资料
define('WX_TOKEN_URL', 'https://api.weixin.qq.com/sns/oauth2/access_token');
define('WX_USERINFO_URL', 'https://api.weixin.qq.com/sns/userinfo');
?>