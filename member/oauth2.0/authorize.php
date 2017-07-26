<?php
/**
 * Created by PhpStorm.
 * User: wusiyuan
 * Date: 16/8/30
 * Time: 下午3:35
 */
// include our OAuth2 Server object
require_once __DIR__.'/server.php';
require '../config.inc.php';
require '../../common.inc.php';
require 'init.inc.php';
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();
//验证参数
if (!$server->validateAuthorizeRequest($request, $response)) {
    $arr['code']              = $response->getStatusCode();
    $arr['error']             = $response->getParameters()['error'];
    $arr['error_description'] = $response->getParameters()['error_description'];
    echo json_encode($arr);
    die;
//    $response->send();
//    die;
}

/**
* 处理跳转到注册页面
*/
if(isset($_GET['register']) && $_GET['register'] == '1'){
	$register_url = DT_PATH.'member/register.php?'.http_build_query($_GET);
	set_cookie('auth', '');
	set_cookie('userid', '');
	header('Location:'.$register_url);
	exit;
}

//显示登录授权页面
if (empty($_POST)) {
    $_SESSION['authorize_login'] = 'authorize';
    $clientInfo = getClientInfo();
    if(!$clientInfo){
        //跳转到申请接入页面
        dalert("您还没申请接入！");exit;
    }
    $clientName = $clientInfo['client_name'];
    $clientUrl  = $clientInfo['client_url'];
    $scopearr   = explode(',',$clientInfo['scope']);
    include template('oauth_login', $module.'/oauth');
}else{
    //是否授权登录
    $is_authorized = ($_POST['authorized'] === 'yes');
    if(!$_username){
        $_SESSION['authorize_login'] = 'authorize';
        $clientInfo = getClientInfo();
        if(!$clientInfo){
            //跳转到申请接入页面
            dalert("您还没申请接入！");exit;
        }
        $clientName = $clientInfo['client_name'];
        $clientUrl  = $clientInfo['client_url'];
        include template('oauth_login', $module.'/oauth');
    }
    $server->handleAuthorizeRequest($request, $response, $is_authorized,$_username);
    if ($is_authorized) {
        // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
        //$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);
        //exit("SUCCESS! Authorization Code: $code"." ".$response->getHttpHeader('Location'));
        //带code跳转到用户callback
        $url = $response->getHttpHeader('Location');
        header("Location: $url");exit;
    }
    $response->send();
}
function getClientInfo(){
    global $db;
    $client_id  = $_REQUEST['client_id'];
    return $db->get_one("select client_name,client_url,scope from oauth_clients where client_id = '{$client_id}' limit 1");
}