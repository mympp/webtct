<?php
/**
 * Created by PhpStorm.
 * User: wusiyuan
 * Date: 16/8/30
 * Time: 下午3:41
 */

// include our OAuth2 Server object
require_once __DIR__.'/server.php';
require '../../common.inc.php';
require 'init.inc.php';
// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}
$token = $_POST['access_token'];
if(!$token){
    $arr['code']              = '300';
    $arr['error']             = 'token param can not be null';
    $arr['error_description'] = 'token error';
    echo json_encode($arr);
    die;
}
$returnInfo = array();
global $db;
$userInfo = $db->get_one("select client_id,user_id,access_token,expires from oauth_access_tokens where access_token = '{$token}'");
if($userInfo){
    if(strtotime($userInfo['expires'] - time()) <= 3600){
        //token未过期
        $returnInfo['access_token'] = $userInfo['access_token'];
        $returnInfo['client_id']    = $userInfo['client_id'];
        //查询用户openid
        $openid = $db->get_one("select openid from {$db->pre}open_user where client_id = '{$userInfo['client_id']}' and username = '{$userInfo['user_id']}'");
        if(!$openid){
            //生成一个openid并保存
            $salt = '&*@qwe';
            $open_id = md5(md5($userInfo['user_id'].$salt).$userInfo['client_id']);
            $time = time();
            $sql = "insert into {$db->pre}open_user(client_id,username,openid,addtime)
                    values('{$userInfo['client_id']}','{$userInfo['user_id']}','{$open_id}','{$time}')";
            $db->query($sql);
            $returnInfo['openid'] = $open_id;
        }else{
            $returnInfo['openid'] = $openid['openid'];
        }
    }else{
        $arr['code']              = '300';
        $arr['error']             = 'token overdue';
        $arr['error_description'] = 'token overdue';
        echo json_encode($arr);
        die;
    }
}
echo json_encode($returnInfo);
