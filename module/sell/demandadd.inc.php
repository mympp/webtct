<?php 
defined('IN_DESTOON') or exit('Access Denied');
//if($_POST) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/tcdb.class.php';
require DT_ROOT.'/module/sell/sell.class.php';
require DT_ROOT.'/include/upload.class.php';

//分类信息
$maincat = get_maincat($catid ? $CAT['parentid'] : 0, $moduleid);
//用户信息
if($_userid){
	$member_db = new tcdb('member');
	$member = $member_db->field('truename,mobile')->where(['userid'=>$_userid])->one();
}
var_dump($member);
if($submit){
    $imagePath = '';
    if(!empty($_FILES['image']['name'])){
        $allowType = ['image/gif','image/png','image/jpeg'];
        if(!in_array($_FILES['image']['type'],$allowType)){
            message('上传图片格式错误','demandadd.php');
        }else{
            $monthDir='/file/upload/'.date('Ym',time()).'/';      //月文件夹
            $dayDir='/file/upload/'.date('Ym/d',time()).'/';     //保存地址
            $lastDot=strrpos($_FILES['image']['name'],".");
            $format=substr($_FILES['image']['name'],$lastDot+1);
            $upload = new upload($_FILES,$dayDir,'',$format);
            $upload->set_savename();
            $upload->set_savepath($dayDir);
            if($upload->save()){
                $imagePath = substr(DT_PATH,0,-1).$upload->savepath.$upload->savename;
                $post['thumb'] = $imagePath;
            }
        }
    }
		
	if(empty($post['title'])) message('请填写需求产品信息','demandadd.php');
	$content = '';	//需求详细内容
	$post['areaid'] = $areaid;	//地区id
    $post['ip'] = $DT_IP;		//用户ip
	//添加用户信息到需求信息中
	if(!empty($member)){
		$post['username'] = $_username;
	}
	$post['typeid'] = 1;	//需求信息分类标记
	//其他联系方式
	if(!empty($contact)){
		switch($contact['type']){
			case 'qq':
				$post['qq'] = $contact['value'];
			break;
			case 'wechat':
				$content .= '<br/>联系微信：'.$contact['value'].'<br/>';
			break;
			case 'email':
				$post['email'] = $contact['value'];
			break;
		}
	}
	//产品规格
	if(!empty($post['model'])){
		$content .= '产品规格：'.$post['model'].'<br/>';
	}
	unset($post['model']);

	//截止时间
	$post['totime'] = strtotime($post['totime']);
	//添加时间
	$post['addtime'] = $post['edittime'] = time();
	$post['adddate'] = $post['editdate'] = date('Y-m-d',time());
	
	//备注
	$post['note'] = $content;
	$post['status'] = 2;
	//标题
	$post['title'] = '求购：'.$post['title'];
	//信息简介
	$post['introduce'] = empty($content) ? $post['title'] : mb_substr(strip_tags($content),0,200,'UTF-8');

	$do = new sell();
	$sell_db = new tcdb('sell_5');
	$sell_db->add($post);
	$itemid = $sell_db->getInsertId();
	$sell_data_db = new tcdb('sell_data_5');
	$sell_data_db->add(['itemid'=>$itemid,'content'=>$content]);
	$do->update($itemid);
	message('需求发布成功','demandadd.php');
}else{
	include template('demandadd', $module);
}

?>