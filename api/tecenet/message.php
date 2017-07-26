<?php
require '../../common.inc.php';
require DT_ROOT.'/include/post.func.php';
$action=$post['action'];
if($action=='save'){
$title=$post['title'];
$content=$post['content'];
if($post['captcha']){
captcha($captcha, $need_captcha);
}
if($post['truename']){$content .="<dd>联系姓名：".$post['truename']."</dd>";}
if($post['qq']){$content .="<dd>联系QQ：".$post['qq']."</dd>";}
if($post['mobile']){$content .="<dd>联系手机：".$post['mobile']."</dd>";}
if($post['email']){$content .="<dd>联系邮箱：".$post['email']."</dd>";}
if($post['files']){$content .="<dd>上传文件：<a href='".$post['files']."' target='_blank'>".$post['files']."</a></dd>";}
$touser=$post['touser'];
$typeid=4;
$fromuser='';
//echo $touser.$title.$content.$typeid.$fromuser;
//send_message('youki2012','ce', 'ce' , 4, 'temnet110');
send_message($touser,$title,$content, 4, $fromuser);
echo "<h3>提交成功！可关闭窗口!</h3>";
echo "<script>alert('提交成功！请勿重复提交!');window.parent.document.getElementById('but').disabled=true;window.parent.document.getElementById('but').value='已提交成功，请勿重复提交！';</script>";
}
?>