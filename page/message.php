<?php
require '../common.inc.php';
require DT_ROOT.'/include/post.func.php';
$action=$post['action'];
if($action=='save'){
$title=$post['title'];
$content=$post['content'];
captcha($captcha, $need_captcha);
if(!$post['mobile']||!$post['email']||!$post['truename']){echo "<script>alert('请仔细填写表单所有项目！!');</script>";exit();}
if($post['truename']){$content .="<dd>联系姓名：".$post['truename']."</dd>";}
if($post['qq']){$content .="<dd>联系QQ：".$post['qq']."</dd>";}
if($post['mobile']){$content .="<dd>联系手机：".$post['mobile']."</dd>";}
if($post['email']){$content .="<dd>联系邮箱：".$post['email']."</dd>";}
$touser='youki2012';
$typeid=4;
$fromuser=$_username;
send_message($touser,$title, $content , 4, $fromuser);
echo "<script>alert('提交成功！请勿重复提交!');window.parent.document.getElementById('but').disabled=true;window.parent.document.getElementById('but').value='已提交成功，请勿重复提交！';</script>";
}
?>