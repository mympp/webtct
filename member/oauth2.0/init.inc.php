<?php
//defined('IN_DESTOON') or exit('Access Denied');
$session = new dsession();
define('QQ_ID','testclient');
define('QQ_SECRET', 'testpass');
define('QQ_CALLBACK', 'http://www.tctest.com/member/oauth2.0/callback.php');
define('QQ_CONNECT_URL', 'http://www.tctest.com/member/oauth2.0/authorize.php');
define('QQ_TOKEN_URL', 'http://www.tctest.com/member/oauth2.0/token.php');
define('QQ_ME_URL', 'http://www.tctest.com/member/oauth2.0/me.php');
define('QQ_USERINFO_URL', 'http://www.tctest.com/member/oauth2.0/userinfo.php');
?>