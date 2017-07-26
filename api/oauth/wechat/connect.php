<?php
require '../../../common.inc.php';
require 'init.inc.php';
$state = random(16);
if($DT_MOB['browser'] == 'weixin') dheader('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WX_ID.'&redirect_uri='.urlencode(WX_CALLBACK).'&response_type=code&scope=snsapi_userinfo#wechat_redirect');
dheader(WX_PCONNECT_URL.'?appid='.WX_ID.'&redirect_uri='.urlencode(WX_CALLBACK).'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect');
?>