<?php
require '../common.inc.php';
require DT_ROOT.'/include/post.func.php';
$action=$post['action'];
if($action=='save'){
$d = $db->get_one("select * FROM {$db->pre}message WHERE title='认证取回《".$r[title]."》' and status=2");
if(!$d){
$title=$post['title'];
$content=$post['content'];
if(!$post['pics1']||!$post['pics2']||!$post['pics3']||!$post['username']){echo "<script>alert('请仔细填写表单所有项目！!');</script>";}
$content .="<dl><dt><b>取回认领资料</b></dt>";
//echo "<script>alert('".$post['getback']."');</script>";exit;
if($post['types']){$content .="<dd>取回项目：".$post['types']."</dd>";}
if($post['getback']==2){$content .="<dd>取回原账号：".$post['username']."</dd>";
$content .="<dd>取回规则：取回原有账号自行管理！</dd>";
}
if($post['getback']==0){$content .="<dd>转移新账号：".$post['username']."</dd>";
$content .="<dd>取回规则：转移所选取回项目到新账号！由新账号管理！</dd>";
}
if($post['qq']){$content .="<dd>联系QQ：".$post['qq']."</dd>";}
if($post['mobile']){$content .="<dd>联系手机：".$post['mobile']."</dd>";}
if($post['email']){$content .="<dd>联系邮箱：".$post['email']."</dd>";}
if($post['pics1']){$content .="<dd>营业执照：".$post['pics1']."&nbsp;&nbsp;<a href='".$post['pics1']."' target='_blank'>查看</a></dd>";}
if($post['pics2']){$content .="<dd>代码证：".$post['pics2']."&nbsp;&nbsp;<a href='".$post['pics2']."' target='_blank'>查看</a></dd>";}
if($post['pics3']){$content .="<dd>国税地税：".$post['pics3']."&nbsp;&nbsp;<a href='".$post['pics3']."' target='_blank'>查看</a></dd>";}
$content .="</dl>";
$touser='gztc';
$typeid=4;
$fromuser=$_username;
send_message($touser,$title, $content , 4, $fromuser);
echo "<script>alert('提交成功！请勿重复提交!');window.parent.document.getElementById('but').disabled=true;window.parent.document.getElementById('but').value='已提交成功，请勿重复提交！';</script>";
}
}
else{
include template('official','brand');
}
?>