<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:16
 */
require_once __DIR__.'/server.php';
require '../../common.inc.php';
require 'init.inc.php';
$token   = $_POST['access_token'];
$openid  = $_POST['openid'];
$client_id = $_POST['oauth_consumer_key'];
$user = array();
$arr  = array();
//查询token是否存在或过期
$userInfo = $db->get_one("select * from oauth_access_tokens where access_token = '{$token}' and client_id = '{$client_id}'");
if($userInfo && (time()-strtotime($userInfo['expires']))<= 3600){
    global $db;
    //token未过期
    $salt = '&*@qwe';
    if(md5(md5($userInfo['user_id'].$salt).$userInfo['client_id']) == $openid){
        //openid正确，获取用户信息
        $username = $db->get_one("select username from {$db->pre}open_user where openid='{$openid}' and client_id = '{$userInfo['client_id']}'");
        if($username){
            //********根据scope获取用户的指定资料*********//
            $scpe = $db->get_one("select scope from oauth_access_tokens where access_token='{$token}' and client_id = '{$client_id}' limit 1");
            if(!$scpe){
                $arr['code']              = '300';
                $arr['error']             = 'user scope is not exists';
                $arr['error_description'] = 'scope error';
                echo json_encode($arr);
                die;
            }
            $scpearr = explode(',',$scpe['scope']);
            if(in_array('validate',$scpearr)){
                //用户授权获取认证信息
                //查询用户是否已实名认证
                $va = $db->get_one("SELECT itemid FROM {$DT_PRE}validate WHERE type='truename' AND username='{$username['username']}' and status = 3");
                if($va){
                    $validate = 1;
                }else{
                    $validate = 0;
                }
                $user['validateStatus']   = $validate;
            }
            $time = time();
            //查询用户公司名称和真名
            $fields = 'userid,username,company,email,gender,truename,mobile,msn,qq,ali,forbid';
            $com = $db->get_one("SELECT $fields FROM {$DT_PRE}member WHERE  username='{$username['username']}'");
            //获取用户头像
            $avatar = useravatar($username['username'], 'large');
            //更新用户登录次数和登录时间
            $sql = "update {$db->pre}open_user set logintimes = logintimes + 1,logintime = '{$time}' where openid = '{$openid}'";
            $db->query($sql);
            $user = $com;
            $user['openid']   = $openid;
            $user['avatar']   = $avatar;
        }
    }else{
        $arr['code']              = '300';
        $arr['error']             = 'invalid_openid';
        $arr['error_description'] = 'openid error';
        echo json_encode($arr);
        die;
    }
}else{
    $arr['code']              = '300';
    $arr['error']             = 'invalid_token';
    $arr['error_description'] = 'token error';
    echo json_encode($arr);
    die;
}
echo json_encode($user);