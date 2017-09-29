<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header',$module);?>
<?php echo load('profile.js');?>
<?php if($is_company && !$_edittime) { ?>
<div class="warn">贵公司尚未完善详细资料！完善的商业信息有助于获得别人的信任，结交潜在的商业伙伴，获取商业机会，请尽快完善</div>
<?php } ?>
<?php if(isset($success)) { ?>
<div class="ok">资料保存成功，您可以：<a href="edit.php" class="t">继续完善</a> &nbsp;|&nbsp; <a href="<?php echo $DT['file_my'];?>" class="t">发布信息</a> &nbsp;|&nbsp; <a href="./" class="t">返回商务室首页</a></div>
<?php if($_groupid>5) { ?>
<script>msgtip("资料保存成功！","完善资料成功！<br>一个优秀的网店需要一套美丽的风格和外观&nbsp;&nbsp;<div class='lh20'><input type='button' value=' 进入网店装修 ' class='btn2' onmouseover=this.className='btn2y' onmouseout=this.className='btn2' onclick=document.location='style.php'></div>")</script>
<?php } ?>
<?php } ?>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="Tab0"><a href="javascript:Tab(0);"><span>个人资料</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab1"><a href="javascript:Tab(1);"><span>密码管理</span></a></td>
<?php if($is_company) { ?>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab2"><a href="javascript:Tab(2);"><span>公司/网店资料</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab3"><a href="javascript:Tab(3);"><span>公司/网店联系方式</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab4"><a href="javascript:Tab(4);"><span>公司/网店介绍</span></a></td>
<?php } ?>
</tr>
</table>
</div>
<form method="post" action="edit.php" onsubmit="return Dcheck();" id="dform">
<input type="hidden" name="tab" id="tab" value="<?php echo $tab;?>"/>
<table cellpadding="6" cellspacing="1" class="tb">
<tbody id="Tabs0" style="display:;">
<tr>
<td class="tl">会员名</td>
<td class="tr f_b"><?php echo $_username;?></td>
</tr>
<tr>
<td class="tl">Email</td>
<td class="tr"><?php echo $_email;?><?php if($vemail) { ?>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/v_email.gif" title="已认证" align="absmiddle"/><?php } ?>
<?php if($DT['mail_type'] != 'close') { ?>&nbsp;&nbsp;<a href="send.php?action=email" class="t">[修改]</a><?php } ?>
</td>
</tr>
<?php if($vtruename) { ?>
<tr>
<td class="tl"><span class="f_red">*</span>真实姓名</td>
<td class="tr"><input type="hidden" name="post[truename]" id="truename" value="<?php echo $truename;?>"/><?php echo $truename;?>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/v_truename.gif" title="已认证" align="absmiddle"/>
<span id="dtruename" class="f_red"></span></td>
</tr>
<?php } else { ?>
<tr>
<td class="tl"><span class="f_red">*</span>真实姓名</td>
<td class="tr"><input type="text" size="10" name="post[truename]" id="truename" value="<?php echo $truename;?>"/>&nbsp;<span id="dtruename" class="f_red"></span></td>
</tr>
<?php } ?>
<tr>
<td class="tl"><span class="f_red">*</span>性别</td>
<td class="tr">
<input type="radio" name="post[gender]" value="1" <?php if($gender==1) { ?>checked="checked"<?php } ?>
/> 先生
<input type="radio" name="post[gender]" value="2" <?php if($gender==2) { ?>checked="checked"<?php } ?>
/> 女士
</td>
</tr>
<?php if(!$is_company) { ?>
<tr>
<td class="tl"><span class="f_red">*</span>所在地区</td>
<td class="tr"><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?>&nbsp;<span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">联系地址</td>
<td class="tr"><input type="text" size="40" name="post[address]" id="daddress" value="<?php echo $address;?>"/>&nbsp;<span id="ddaddress" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">邮政编码</td>
<td class="tr"><input type="text" size="8" name="post[postcode]" id="postalcode" value="<?php echo $postcode;?>"/></td>
</tr>
<tr>
<td class="tl">联系电话</td>
<td class="tr"><input type="text" size="20" name="post[telephone]" id="telephone" value="<?php echo $telephone;?>"/>&nbsp;<span id="dtelephone" class="f_red"></span></td>
</tr>
<?php } ?>
<?php if($vmobile) { ?>
<tr>
<td class="tl">手机号码</td>
<td class="tr"><input type="hidden" name="post[mobile]" id="mobile" value="<?php echo $mobile;?>"/><?php echo $mobile;?>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/v_mobile.gif" title="已认证" align="absmiddle"/><?php if($DT['sms']) { ?>&nbsp;&nbsp;<a href="send.php?action=mobile" class="t">[修改]</a><?php } ?>
</td>
</tr>
<?php } else { ?>
<tr>
<td class="tl">手机号码</td>
<td class="tr"><input type="text" size="20" name="post[mobile]" id="mobile" value="<?php echo $mobile;?>"/></td>
</tr>
<?php } ?>
<tr>
<td class="tl">部门</td>
<td class="tr">
<input type="text" size="20" name="post[department]" id="department" value="<?php echo $department;?>"/>
</td>
</tr>
<tr>
<td class="tl">职位</td>
<td class="tr"><input type="text" size="20" name="post[career]" id="career" value="<?php echo $career;?>"/></td>
</tr>
<?php if($DT['im_qq']) { ?>
<tr>
<td class="tl">QQ</td>
<td class="tr">
<?php if(check_dingzhi_member($_childusername!=''?$_childusername:$_username,'qq_kefu')) { ?>
<textarea name="post[qq]" style="height:80px;width:140px;" class="fl"><?php echo $qq;?></textarea>
<span class="fl" style="margin-left:18px;">
可填写多个客服qq：<br/>
格式：qq号码|备注;(使用英文分号)<br/>
例：1000000|张三;10000001|李四;
</span>
<?php } else { ?><input type="text" size="20" name="post[qq]" id="qq" value="<?php echo $qq;?>"/>
<?php } ?>
</td>
</tr>
<?php } ?>
<?php if($DT['im_ali']) { ?>
<tr>
<td class="tl">阿里旺旺</td>
<td class="tr"><input type="text" size="20" name="post[ali]" id="ali" value="<?php echo $ali;?>"/></td>
</tr>
<?php } ?>
<?php if($DT['im_msn']) { ?>
<tr>
<td class="tl">MSN</td>
<td class="tr"><input type="text" size="30" name="post[msn]" id="msn" value="<?php echo $msn;?>"/></td>
</tr>
<?php } ?>
<?php if($DT['im_skype']) { ?>
<tr>
<td class="tl">Skype</td>
<td class="tr"><input type="text" size="20" name="post[skype]" id="skype" value="<?php echo $skype;?>"/></td>
</tr>
<?php } ?>
<tr>
<td class="tl">站内信提示音</td>
<td class="tr">
<div id="audition"></div>
<input type="radio" name="post[sound]" value="0" <?php if($sound==0) { ?>checked="checked"<?php } ?>
 id="sound_0"/><label for="sound_0"> 无</label>&nbsp;&nbsp;
<input type="radio" name="post[sound]" value="1" <?php if($sound==1) { ?>checked="checked"<?php } ?>
 id="sound_1"/> <a href="javascript:Inner('audition', sound('message_1'));Dd('sound_1').checked=true;void(0);" title="点击试听">提示音1</a>&nbsp;&nbsp;
<input type="radio" name="post[sound]" value="2" <?php if($sound==2) { ?>checked="checked"<?php } ?>
 id="sound_2"/> <a href="javascript:Inner('audition', sound('message_2'));Dd('sound_2').checked=true;void(0);" title="点击试听">提示音2</a>&nbsp;&nbsp;
<input type="radio" name="post[sound]" value="3" <?php if($sound==3) { ?>checked="checked"<?php } ?>
 id="sound_3"/> <a href="javascript:Inner('audition', sound('message_3'));Dd('sound_3').checked=true;void(0);" title="点击试听">提示音3</a>&nbsp;&nbsp;
</td>
</tr>
<?php if($MFD) { ?><?php echo fields_html('<td class="tl">', '<td class="tr">', $user, $MFD);?><?php } ?>
</tbody>
<tbody id="Tabs1" style="display:none;">
<tr>
<td class="tl">新登录密码</td>
<td class="tr"><input type="password" size="20" name="post[password]" id="password" onblur="validator('password');" autocomplete="off"/>&nbsp;<span class="f_gray">如不更改密码,请留空</span> <span id="dpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">重复新密码</td>
<td class="tr"><input type="password" size="20" name="post[cpassword]" id="cpassword" autocomplete="off"/>&nbsp;<span id="dcpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">现有密码</td>
<td class="tr f_red"><input type="password" size="20" name="post[oldpassword]" id="oldpassword" autocomplete="off"/>&nbsp; 如要更改密码，需输入现有密码 <span id="doldpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">新支付密码</td>
<td class="tr"><input type="password" size="20" name="post[payword]" id="payword" onblur="validator('payword');" autocomplete="off"/>&nbsp;<span class="f_gray">如不更改支付密码，请留空</span> <span id="dpayword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">重复新支付密码</td>
<td class="tr"><input type="password" size="20" name="post[cpayword]" id="cpayword" autocomplete="off"/>&nbsp;<span id="dcpayword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">现有支付密码</td>
<td class="tr f_red"><input type="password" size="20" name="post[oldpayword]" id="oldpayword" autocomplete="off"/>&nbsp; 支付密码默认和注册设置密码相同&nbsp;&nbsp;<a href="send.php?action=payword"  class="t">找回支付密码</a><span id="doldpayword" class="f_red"></span></td>
</tr>
</tbody>
<?php if($is_company) { ?>
<tbody id="Tabs2" style="display:none;">
<tr>
<td class="tl">公司名称</td>
<td class="tr f_b"><?php echo $_company;?></td>
</tr>
<tr><td class="tl">英文名称</td><td class="tr"><input type="text" name="post_fields[encompany]" id="encompany" value="<?php echo $encompany;?>" size="60"/> <span class="f_red" id="dencompany"></span>选填企业的英文名称</td></tr>
<tr>
<tr class=""><td class="tl">宣传副标题</td><td class="tr"><input type="text" name="post_fields[btitle]" id="btitle" value="<?php echo $btitle;?>" size="30" maxlength="30"  onfocus="if(this.value.length>20){Dd('dbtitle').innerText='不能超过20个汉字';}else{Dd('dbtitle').innerText='';}" class="inputtext"> <span class="f_red" id="dbtitle"></span><br>写宣传广告语，如：国内销量遥遥领先知名红罐凉茶-加X宝</td></tr>
<td class="tl"><span class="f_red">*</span>公司/网店类型</td>
<td class="tr"><?php echo dselect($COM_TYPE, 'post[type]', '请选择', $type, 'id="type"', 0);?>&nbsp;<span id="dtype" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>形象图片</td>
<td class="tr"><input name="post[thumb]" type="text" size="60" id="thumb" value="<?php echo $thumb;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span><br/>
<span class="f_gray">建议使用LOGO、办公环境等标志性图片，最佳大小为<?php echo $MOD['thumb_width'];?>px*<?php echo $MOD['thumb_height'];?>px</span><span id="dthumb" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>所在地区</td>
<td class="tr"><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?>&nbsp;<span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<?php if($brandid) { ?>
<?php $brandname=',';?>
<?php $tagss = tag("moduleid=13&condition=itemid in (0".$brandid."0)&pagesize=30&order=pnum desc&template=null&debug=0")?>
<?php if(is_array($tagss)) { foreach($tagss as $i => $t) { ?>
<?php $brandname .=$t['title'].',';?>
<?php } } ?>
<?php } ?>
<td class="tl">加入品牌/厂商<br>合作经销网络</td>
<td class="tr"><input type="button" onclick="divbox('boxdd',860,'选择厂商/品牌信息','<?php echo $MODULE['13']['linkurl'];?>tree.php?tz=1&checked=1')" value="到厂商/品牌目录去查找" class="btn2" onmouseover="this.className='btn2y'" onmouseout="this.className='btn2'" /><br>已选择品牌/厂商信息 &nbsp;<input type="text" name="post_fields[brandname]" id="brandname" value="<?php echo $brandname;?>" size=60   readonly="readonly"><input type="text" name="post_fields[brandid]" id="brandid" value="<?php echo $brandid;?>"  style="display:none"><a href="javascript:void(0)" onclick="Dd('brandname').value='';Dd('brandid').value='';"> 清空所选</a><br><span style="font-size:12px;" class="f_gray">网店名字可以随意。但是品牌/厂商绝不随意且重复信息，选择或创建一个自己的品牌/厂商信息。</span><br><span style="font-size:12px;" class="f_gray">创建一个品牌/厂商信息，让其他网店也可以经销推广您的产品/品牌信息！<a href="javascript:void(0)" onclick="divbox('boxdd',860,'选择厂商/品牌信息','<?php echo $MODULE['13']['linkurl'];?>tree.php?tz=1&checked=1&actions=add')"><font  class="f_red">点击创建</font></a></span>
<style type="text/css">
#brandid{width:380px;}
</style>
<?php if($_REQUEST['actions']&&$_REQUEST['brandid']) { ?>
<?php $brandid=intval($_REQUEST['brandid']);?>
<?php $tagss = tag("moduleid=13&condition=itemid=$brandid&pagesize=1&order=itemid desc&template=null&debug=0")?>
<?php if(is_array($tagss)) { foreach($tagss as $i => $t) { ?>
<?php $brandname=urlencode($t['title']);?>
<?php } } ?>
<script type="text/javascript">
divbox('boxdd',860,'选择厂商/品牌信息','<?php echo $MODULE['13']['linkurl'];?>tree.php?tz=1&checked=1&fname=<?php echo $brandname;?>');
</script>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>经营范围</td>
<td class="tr">
<div id="catesch"></div><div id="cate"><?php echo ajax_category_select('', '', 0, 4, 'size="2" style="height:120px;width:160px;"');?></div>
<input type="button" value=" 添加↓ " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="addcate(<?php echo $MOD['cate_max'];?>);"/>
<input type="button" value=" ×删除 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="delcate();"/>
<?php if($DT['schcate_limit']) { ?><input type="button" value=" 搜索 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="schcate(4);"/><?php } ?>
&nbsp;最多可添加 <strong class="f_red"><?php echo $MOD['cate_max'];?></strong> 个主营行业
<br/><select name="cates" id="cates" size="2" style="height:100px;width:380px;margin-top:5px;">
<?php if(is_array($cates)) { foreach($cates as $c) { ?>
<option value="<?php echo $c;?>"><?php echo strip_tags(cat_pos(get_cat($c), '/'));?></option>
<?php } } ?>
</select>
<input type="hidden" name="post[catid]" value="<?php echo $catid;?>" id="catid"/><br/>
<span id="dcatid" class="f_red"></span></td>
</tr>
<script type="text/javascript">
function ses(dd){
var ss;
ss=document.getElementById(dd);
var kk;
for(var i=0;i<ss.options.length;i++)
  {
   if (ss.options[i].text!=undefined||ss.options[i].text!=''){kk=kk+ss.options[i].text+',';}
  }
kk=kk.replace("undefined","");
document.getElementById('business').value=kk;
  }
</script>
<tr>
<td class="tl"><span class="f_red">*</span>更多经营范围</td>
<td class="tr"><input type="text" size="80" name="post[business]" id="business" value="<?php echo $business;?>" maxlength="250" />&nbsp;<span id="dbusiness" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">成立年份</td>
<td class="tr"><input type="text" size="15" name="post[regyear]" id="regyear" value="<?php echo $regyear;?>" maxlength="4"/>&nbsp;<span id="dregyear" class="f_red"></span> <span class="f_gray">(年份，如：2004)</span></td>
</tr>
<tr>
<td class="tl">经营模式</td>
<td class="tr">
<span id="com_mode"><?php echo $mode_check;?></span> <span class="f_gray">(最多可选<?php echo $MOD['mode_max'];?>种)</span></td>
</tr>
<tr>
<td class="tl">运作规模</td>
<td class="tr"><?php echo dselect($COM_SIZE, 'post[size]', '请选择规模', $size, '', 0);?></td>
</tr>
<tr>
<td class="tl">注册资本</td>
<td class="tr"><?php echo dselect($MONEY_UNIT, 'post[regunit]', '', $regunit, '', 0);?> <input type="text" size="6" name="post[capital]" id="capital" value="<?php echo $capital;?>"/> 万</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>销售的产品<br/>/(提供的服务)</td>
<td class="tr"><input type="text" size="80" name="post[sell]" id="sell" value="<?php echo $sell;?>" maxlength="200"/> <span class="f_red"  id="dsell"></span><br><span class="f_gray" >多个产品或服务请用'|'号隔开</span></td>
</tr>
<tr>
<td class="tl">采购的产品<br/>/(需要的服务)</td>
<td class="tr"><input type="text" size="80" name="post[buy]" id="buy" value="<?php echo $buy;?>" maxlength="200"/> <br><span class="f_gray" id="dbuy">多个产品或服务请用'|'号隔开</span></td>
</tr>
<?php if($CFD) { ?><?php echo fields_html('<td class="tl">', '<td class="tr">', $user, $CFD);?><?php } ?>
</tbody>
<tbody id="Tabs3" style="display:none;">
<tr>
<td class="tl"><span class="f_red">*</span>业务地址</td>
<td class="tr"><input type="text" size="60" name="post[address]" id="daddress" value="<?php echo $address;?>" maxlength="200"/>&nbsp;<span id="ddaddress" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">邮政编码</td>
<td class="tr"><input type="text" size="8" name="post[postcode]" id="postalcode" value="<?php echo $postcode;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>业务电话</td>
<td class="tr"><input type="text" size="20" name="post[telephone]" id="telephone" value="<?php echo $telephone;?>"/>&nbsp;<span id="dtelephone" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">业务传真</td>
<td class="tr"><input type="text" size="20" name="post[fax]" id="fax" value="<?php echo $fax;?>"/></td>
</tr>
<tr>
<td class="tl">业务Email</td>
<td class="tr"><input type="text" size="30" name="post[mail]" id="ymail" value="<?php echo $mail;?>"/> <span class="f_gray" id="demail">[公开]</span>
<script type="text/javascript">
if(Dd('ymail').value==''){Dd('ymail').value='<?php echo $_email;?>';}
</script>
</td>
</tr>
<tr>
<td class="tl">官方网址</td>
<td class="tr"><input type="text" size="30" name="post[homepage]" id="homepage" value="<?php echo $homepage;?>"/></td>
</tr>
<tr>
<td class="tl">浮动客服</td>
<td class="tr">
<textarea name="post_fields[contacts]" rows="7" cols="60"><?php echo $contacts;?></textarea>
<br>
可填可不填，若填写浮动客服内容将按此项显示！若不填写。浮动客服将按已有联系内容显示！
<br>注：浮动客服功能仅有收费会员享有
</td>
</tr>
</tbody>
<tbody id="Tabs4" style="display:none;">
<tr>
<td class="tl"><span class="f_red">*</span>公司/网店介绍</td>
<td class="tr"><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $group_editor, '95%', 300);?><br/><?php if(in_array('content', $_E)) { ?><?php if(isset($_U['content'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
&nbsp;<?php } ?>
<span id="dcontent" class="f_red"></span><span id="dcontent" class="f_red"></span></td>
</tr>
</tbody>
<?php } ?>
<tr>
<td class="tl">&nbsp;</td>
<td class="tr" height="30"><input type="submit" name="submit" value=" 保 存 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></td>
</tr>
</table>
</form>
<?php echo load('clear.js');?>
<script type="text/javascript">
var vid = '';
function validator(id) {
if(!Dd(id).value) return false;
vid = id;
makeRequest('moduleid=<?php echo $moduleid;?>&action=member&job='+id+'&value='+Dd(id).value+'&userid=<?php echo $userid;?>', AJPath, '_validator');
}
function _validator() {
if(xmlHttp.readyState==4 && xmlHttp.status==200) {
Dd('d'+vid).innerHTML = xmlHttp.responseText ? xmlHttp.responseText : '';
}
}
function Dcheck() {
if(Dd('truename').value == '') {
Tab(0);
Dmsg('请填写真实姓名', 'truename');
return false;
}
if(Dd('password').value != '') {
if(Dd('cpassword').value == '') {
Tab(1);
Dmsg('请重复输入密码', 'cpassword');
return false;
}
if(Dd('password').value != Dd('cpassword').value) {
Tab(1);
Dmsg('两次输入的密码不一致', 'password');
return false;
}
if(Dd('oldpassword').value == '') {
Tab(1);
Dmsg('请输入密码', 'oldpassword');
return false;
}
}
if(Dd('payword').value != '') {
if(Dd('cpayword').value == '') {
Tab(1);
Dmsg('请重复输入支付密码', 'cpayword');
return false;
}
if(Dd('payword').value != Dd('cpayword').value) {
Tab(1);
Dmsg('两次输入的支付密码不一致', 'payword');
return false;
}
if(Dd('oldpayword').value == '') {
Tab(1);
Dmsg('请输入支付密码', 'oldpayword');
return false;
}
}
<?php if(!$is_company) { ?>
if(Dd('areaid_1').value == 0) {
Tab(0);
Dmsg('请选择所在地', 'areaid');
return false;
}
<?php } ?>
<?php if($MFD) { ?><?php echo fields_js($MFD);?><?php } ?>
<?php if($is_company) { ?>
<?php if($CFD) { ?><?php echo fields_js($CFD);?><?php } ?>
if(Dd('type').value == '') {
Tab(2);
Dmsg('请选择公司类型', 'type');
return false;
}
if(Dd('areaid_1').value == 0) {
Tab(2);
Dmsg('请选择公司所在地', 'areaid');
return false;
}
if(Dd('catid').value.length < 2) {
Tab(2);
Dmsg('请选择公司主营行业', 'catid');
return false;
}
if(Dd('thumb').value.length < 2) {
Tab(2);
Dmsg('请上传公司LOGO', 'thumb');
return false;
}
if(Dd('business').value.length < 6) {
Tab(2);
Dmsg('企业经营范围描述最少6字', 'business');
return false;
}
if(Dd('daddress').value.length < 5) {
Tab(3);
Dmsg('请填写公司地址', 'daddress');
return false;
}
if(Dd('sell').value.length < 1) {
Tab(2);
Dmsg('请填写销售的产品', 'sell');
return false;
}
if(Dd('telephone').value.length < 6) {
Tab(3);
Dmsg('请填写公司电话', 'telephone');
return false;
}
if(FCKLen('content') < 10) {
Tab(4);
Dmsg('公司介绍不能少于10字，当前已经输入'+FCKLen('content')+'字', 'content');
return false;
}
<?php } ?>
return true;
}
</script>
<script type="text/javascript">
s('edit');
<?php if($tab) { ?>
Tab(<?php echo $tab;?>);
<?php } else { ?>
m('Tab0');
<?php } ?>
</script>
<?php include template('footer',$module);?>