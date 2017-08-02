<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
isset($MODULE[16]) or dheader($MODULE[2]['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/module/'.$module.'/carriage.class.php';
$do=new carriage();
if($submit){
	if($post){
		foreach($post as $k=>$v){
			if($k==0){          //添加设置
				if($v['high_price']!=''&&$v['low_price']!=''&&$v['express_percent']!=''&&$v['logistics_percent']!=''){
					if($db->get_one("select itemid from {$db->pre}mall_carriage where username='$_username' and low_price<=$v[low_price] and high_price>=$v[low_price]")!=false){
						dmsg('最低价格'.$v['low_price'].'在已制定的价格范围内');
					}else if($db->get_one("select itemid from {$db->pre}mall_carriage where username='$_username' and low_price<=$v[high_price] and high_price>=$v[high_price]")!=false){
						dmsg('最高价格'.$v['high_price'].'在已制定的价格范围内');
					}else{
						$v['addtime']=time();
						$v['username']=$_username;
						if($do->add($v)===false){
							dmsg('添加失败','carriage.php');
						}
					}
				}
			}else{
				if($v['delete']=='1'){      //删除设置
					$do->delete($v['itemid']);
				}else{                   //修改设置
					$do->itemid=$v['itemid'];
					$do->edit($v);
				}
			}
		}
		dmsg('更新完成','carriage.php');
	}
}else{
	$carriage_data=$do->get_list("username = '$_username'");
}
include template('carriage', $module);
?>