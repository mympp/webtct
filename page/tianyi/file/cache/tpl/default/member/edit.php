<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header',$module);?>
<?php echo load('profile.js');?>
<?php if($is_company && !$_edittime) { ?>
<div class="warn">贵公司尚未完善详细资料！完善的商业信息有助于获得别人的信任，结交潜在的商业伙伴，获取商业机会，请尽快完善</div>
<?php } ?>
<?php if(isset($success)) { ?>
<div class="ok">资料保存成功，您可以：<a href="?action=index" class="t">继续完善</a> &nbsp;|&nbsp; <a href="<?php echo $DT['file_my'];?>" class="t">发布信息</a> &nbsp;|&nbsp; <a href="./" class="t">返回商务室首页</a></div>
<?php } ?>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="Tab0"><a href="javascript:Tab(0);"><span>个人资料</span></a></td>
<td class="tab" id="Tab1"><a href="javascript:Tab(1);"><span>密码管理</span></a></td>
<?php if($is_company) { ?>
<td class="tab" id="Tab2"><a href="javascript:Tab(2);"><span>公司资料</span></a></td>
<td class="tab" id="Tab3"><a href="javascript:Tab(3);"><span>公司联系方式</span></a></td>
<td class="tab" id="Tab4"><a href="javascript:Tab(4);"><span>公司介绍</span></a></td>
<?php } ?>
</tr>
</table>
</div>
<form method="post" action="?" onsubmit="return Dcheck();" id="dform">
<input type="hidden" name="tab" id="tab" value="<?php echo $tab;?>"/>
<table cellpadding="6" cellspacing="1" class="tb">
<tbody id="Tabs0" style="display:;">
<tr>
<td class="tl">会员名</td>
<td class="tr f_b"><?php echo $_username;?></td>
</tr>
<tr>
<td class="tl">头像</td>
<td class="tr f_b"><a href="avatar.php"><img src="<?php echo useravatar($_username, 'large');?>&time=<?php echo $DT_TIME;?>" width="128" height="128" title="点击修改"/></a></td>
</tr> 
<tr>
<td class="tl">昵称</td>
<td class="tr"><?php echo $_passport;?><?php if($_passport == $_username) { ?>&nbsp;&nbsp;<a href="send.php?action=passport" class="t">[修改]</a><?php } ?>
</td>
</tr>
<tr>
<td class="tl">邮件</td>
<td class="tr"><?php echo $_email;?><?php if($vemail) { ?>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/v_email.gif" title="已认证" align="absmiddle"/><?php } ?>
<?php if($DT['mail_type'] != 'close') { ?>&nbsp;&nbsp;<a href="send.php?action=email" class="t">[修改]</a><?php } ?>
</td>
</tr>
<?php if($vtruename) { ?>
<tr>
<td class="tl"><span class="f_red">*</span> 姓名</td>
<td class="tr"><input type="hidden" name="post[truename]" id="truename" value="<?php echo $truename;?>"/><?php echo $truename;?>&nbsp;&nbsp;<img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/v_truename.gif" title="已认证" align="absmiddle"/></td>
</tr>
<?php } else { ?>
<tr>
<td class="tl"><span class="f_red">*</span> 姓名</td>
<td class="tr"><input type="text" size="10" name="post[truename]" id="truename" value="<?php echo $truename;?>"/>&nbsp;<span id="dtruename" class="f_red"></span></td>
</tr>
<?php } ?>
<tr>
<td class="tl"><span class="f_red">*</span> 性别</td>
<td class="tr">
<input type="radio" name="post[gender]" value="1" <?php if($gender==1) { ?>checked="checked"<?php } ?>
/> 先生
<input type="radio" name="post[gender]" value="2" <?php if($gender==2) { ?>checked="checked"<?php } ?>
/> 女士
</td>
</tr>
<?php if(!$is_company) { ?>
<tr>
<td class="tl"><span class="f_red">*</span> 所在地区</td>
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
<td class="tl">手机</td>
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
<td class="tr"><input type="text" size="20" name="post[department]" id="department" value="<?php echo $department;?>"/></td>
</tr>
<tr>
<td class="tl">职位</td>
<td class="tr"><input type="text" size="20" name="post[career]" id="career" value="<?php echo $career;?>"/></td>
</tr>
<?php if($DT['im_qq']) { ?>
<tr>
<td class="tl">QQ</td>
<td class="tr"><input type="text" size="20" name="post[qq]" id="qq" value="<?php echo $qq;?>"/> 如果图标无法点亮，请点<a href="http://shang.qq.com/v3/widget.html" target="_blank" class="b">这里</a>设置</td>
</tr>
<?php } ?>
<?php if($DT['im_ali']) { ?>
<tr>
<td class="tl">阿里旺旺</td>
<td class="tr"><input type="text" size="20" name="post[ali]" id="ali" value="<?php echo $ali;?>"/> 如果是淘宝旺旺，请填写TB:旺旺帐号，例如：TB:abcd，否则无法点亮</td>
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
<td class="tl">重复登录密码</td>
<td class="tr"><input type="password" size="20" name="post[cpassword]" id="cpassword" autocomplete="off"/>&nbsp;<span id="dcpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">现有密码</td>
<td class="tr f_red"><input type="password" size="20" name="post[oldpassword]" id="oldpassword" autocomplete="off"/>&nbsp;如要更改密码，需输入现有密码 <span id="doldpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">新支付密码</td>
<td class="tr"><input type="password" size="20" name="post[payword]" id="payword" onblur="validator('payword');" autocomplete="off"/>&nbsp;<span class="f_gray">如不更改支付密码，请留空</span> <span id="dpayword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">重复支付密码</td>
<td class="tr"><input type="password" size="20" name="post[cpayword]" id="cpayword" autocomplete="off"/>&nbsp;<span id="dcpayword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">现有支付密码</td>
<td class="tr f_red"><input type="password" size="20" name="post[oldpayword]" id="oldpayword" autocomplete="off"/>&nbsp;支付密码默认和注册设置密码相同&nbsp;&nbsp;<a href="send.php?action=payword"  class="t">找回支付密码</a><span id="doldpayword" class="f_red"></span></td>
</tr>
</tbody>
<?php if($is_company) { ?>
<tbody id="Tabs2" style="display:none;">
<tr>
<td class="tl">公司名</td>
<td class="tr f_b"><?php echo $_company;?></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>公司类型</td>
<td class="tr"><?php echo dselect($COM_TYPE, 'post[type]', '请选择111', $type, 'id="type"', 0);?><?php if(in_array('type', $_E)) { ?>&nbsp;<?php if(isset($_U['type'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dtype" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">形象图片</td>
<td class="tr"><input name="post[thumb]" type="text" size="60" id="thumb" value="<?php echo $thumb;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,<?php echo $MOD['thumb_width'];?>,<?php echo $MOD['thumb_height'];?>, Dd('thumb').value, true);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span>
<?php if(in_array('thumb', $_E)) { ?>&nbsp;<?php if(isset($_U['thumb'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
<br/><span class="f_gray">建议使用LOGO、办公环境等标志性图片，最佳大小为<?php echo $MOD['thumb_width'];?>px*<?php echo $MOD['thumb_height'];?>px</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 首页-简介大图</td>
<td class="tr"><input name="post[image]" type="text" size="60" id="image" value="<?php echo $image;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('image').value, true, 'image');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('image').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('image').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>所在地区</td>
<td class="tr"><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?><?php if(in_array('areaid', $_E)) { ?>&nbsp;<?php if(isset($_U['areaid'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dareaid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>主营行业</td>
<td class="tr">
<div id="catesch"></div><div id="cate"><?php echo ajax_category_select('', '', 0, 4, 'size="2" style="height:80px;width:160px;"');?></div>
<input type="button" value=" 添加↓ " class="btn" onclick="addcate(<?php echo $MOD['cate_max'];?>);"/>
<input type="button" value=" ×删除 " class="btn" onclick="delcate();"/>
<?php if($DT['schcate_limit']) { ?><input type="button" value=" 搜索 " class="btn" onclick="schcate(4);"/><?php } ?>
&nbsp;最多可添加 <strong class="f_red"><?php echo $MOD['cate_max'];?></strong> 个主营行业
<br/><select name="cates" id="cates" size="2" style="height:100px;width:380px;margin-top:5px;">
<?php if(is_array($cates)) { foreach($cates as $c) { ?>
<option value="<?php echo $c;?>"><?php echo strip_tags(cat_pos(get_cat($c), '/'));?></option>
<?php } } ?>
</select>
<input type="hidden" name="post[catid]" value="<?php echo $catid;?>" id="catid"/><br/>
<span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>主要经营范围</td>
<td class="tr"><input type="text" size="80" name="post[business]" id="business" value="<?php echo $business;?>" maxlength="250"/><?php if(in_array('business', $_E)) { ?>&nbsp;<?php if(isset($_U['business'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dbusiness" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>注册号</td>
<td class="tr"><input type="text" size="30" name="post[register]" id="register" value="<?php echo $register;?>" maxlength="250"/><?php if(in_array('register', $_E)) { ?>&nbsp;<?php if(isset($_U['register'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dregister" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>注册地址</td>
<td class="tr"><input type="text" size="80" name="post[readdress]" id="readdress" value="<?php echo $readdress;?>" maxlength="250"/><?php if(in_array('readdress', $_E)) { ?>&nbsp;<?php if(isset($_U['readdress'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dreaddress" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>登记机关</td>
<td class="tr"><input type="text" size="60" name="post[reoffice]" id="reoffice" value="<?php echo $reoffice;?>" maxlength="250"/><?php if(in_array('reoffice', $_E)) { ?>&nbsp;<?php if(isset($_U['reoffice'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dreoffice" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>公司成立年份</td>
<td class="tr"><input type="text" size="15" name="post[regyear]" id="regyear" value="<?php echo $regyear;?>" maxlength="4"/><?php if(in_array('regyear', $_E)) { ?>&nbsp;<?php if(isset($_U['regyear'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dregyear" class="f_red"></span> <span class="f_gray">(年份，如：2004)</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>注册日期</td>
<td class="tr"><?php echo dcalendar('retime',$retime);?><?php if(in_array('retime', $_E)) { ?>&nbsp;<?php if(isset($_U['retime'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dretime" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>营业期限</td>
<td class="tr"><span><?php echo dcalendar('starttime',$starttime);?><span id="dstarttime" class="f_red"></span></span>&nbsp;至&nbsp;<span><?php echo dcalendar('endtime',$endtime);?><span id="dendtime" class="f_red"></span></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>法定代表人</td>
<td class="tr"><input type="text" size="80" name="post[legalPerson]" id="legalPerson" value="<?php echo $legalPerson;?>" maxlength="250"/><?php if(in_array('legalPerson', $_E)) { ?>&nbsp;<?php if(isset($_U['legalPerson'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dlegalPerson" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">经营模式</td>
<td class="tr">
<span id="com_mode"><?php echo $mode_check;?></span> <span class="f_gray">(最多可选<?php echo $MOD['mode_max'];?>种)</span></td>
</tr>
<tr>
<td class="tl">公司规模</td>
<td class="tr"><?php echo dselect($COM_SIZE, 'post[size]', '请选择规模', $size, '', 0);?></td>
</tr>
<tr>
<td class="tl">注册资本</td>
<td class="tr"><?php echo dselect($MONEY_UNIT, 'post[regunit]', '', $regunit, '', 0);?> <input type="text" size="6" name="post[capital]" id="capital" value="<?php echo $capital;?>"/> 万<?php if(in_array('capital', $_E)) { ?>&nbsp;<?php if(isset($_U['capital'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl">销售的产品<br/>(提供的服务)</td>
<td class="tr"><input type="text" size="50" name="post[sell]" id="sell" value="<?php echo $sell;?>" maxlength="200"/> <span class="f_gray">多个产品或服务请用'|'号隔开</span></td>
</tr>
<tr>
<td class="tl">采购的产品<br/>(需要的服务)</td>
<td class="tr"><input type="text" size="50" name="post[buy]" id="buy" value="<?php echo $buy;?>" maxlength="200"/> <span class="f_gray">多个产品或服务请用'|'号隔开</span></td>
</tr>
<?php if($CFD) { ?><?php echo fields_html('<td class="tl">', '<td class="tr">', $user, $CFD);?><?php } ?>
</tbody>
<tbody id="Tabs3" style="display:none;">
<tr>
<td class="tl"><span class="f_red">*</span>公司地址</td>
<td class="tr"><input type="text" size="60" name="post[address]" id="daddress" value="<?php echo $address;?>" maxlength="200"/><?php if(in_array('address', $_E)) { ?>&nbsp;<?php if(isset($_U['address'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="ddaddress" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">邮政编码</td>
<td class="tr"><input type="text" size="8" name="post[postcode]" id="postalcode" value="<?php echo $postcode;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>公司电话</td>
<td class="tr"><input type="text" size="20" name="post[telephone]" id="telephone" value="<?php echo $telephone;?>"/><?php if(in_array('telephone', $_E)) { ?>&nbsp;<?php if(isset($_U['telephone'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dtelephone" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">公司移动电话</td>
<td class="tr"><input type="text" size="20" name="post[mobilePhone]" id="mobilePhone" value="<?php echo $mobilePhone;?>"/><?php if(in_array('mobilePhone', $_E)) { ?>&nbsp;<?php if(isset($_U['mobilePhone'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dmobilePhone" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">公司传真</td>
<td class="tr"><input type="text" size="20" name="post[fax]" id="fax" value="<?php echo $fax;?>"/></td>
</tr>
<tr>
<td class="tl">公司Email</td>
<td class="tr"><input type="text" size="30" name="post[mail]" id="mail" value="<?php echo $mail;?>"/> <span class="f_gray">[公开]</span></td>
</tr>
<tr>
<td class="tl">公司网址</td>
<td class="tr"><input type="text" size="30" name="post[homepage]" id="homepage" value="<?php echo $homepage;?>"/></td>
</tr>
</tbody>
<tbody id="Tabs4" style="display:none;">
<tr>
<td class="tl"><span class="f_red">*</span>公司介绍</td>
<td class="tr"><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', $group_editor, '95%', 300);?><br/>
<?php if(in_array('content', $_E)) { ?><?php if(isset($_U['content'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
&nbsp;<?php } ?>
<span id="dcontent" class="f_red"></span></td>
</tr>
</tbody>
<?php } ?>
<tr>
<td class="tl">&nbsp;</td>
<td class="tr" height="30"><input type="submit" name="submit" value=" 保 存 " class="btn_g"/></td>
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
if(Dd('business').value.length < 4) {
Tab(2);
Dmsg('主要经营范围最少3字', 'business');
return false;
}
if(Dd('regyear').value.length < 4) {
Tab(2);
Dmsg('请填写公司成立年份', 'regyear');
return false;
}
if(Dd('register').value.length < 8) {
Tab(2);
Dmsg('请填写公司注册号', 'register');
return false;
}
if(Dd('reoffice').value.length < 3) {
Tab(2);
Dmsg('请填写登记机关', 'reoffice');
return false;
}
if(Dd('readdress').value.length < 2) {
Tab(2);
Dmsg('请填写公司注册地址', 'readdress');
return false;
}
if(Dd('retime').value.length < 2) {
Tab(2);
Dmsg('请选择公司成立日期', 'retime');
return false;
}
if(Dd('starttime').value.length < 8 ) {
Tab(2);
Dmsg('请选择公司营业期限起始时间', 'starttime');
return false;
}
if(Dd('endtime').value.length < 8 ) {
Tab(2);
Dmsg('请选择公司营业期限结束时间', 'endtime');
return false;
}
if(Dd('legalPerson').value.length < 2 ) {
Tab(2);
Dmsg('请填写法定代表人', 'legalPerson');
return false;
}
if(Dd('daddress').value.length < 5) {
Tab(3);
Dmsg('请填写公司地址', 'daddress');
return false;
}
if(Dd('telephone').value.length < 6) {
Tab(3);
Dmsg('请填写公司电话', 'telephone');
return false;
}
if(FCKLen('content') < 10) {
Tab(4);
Dmsg('公司介绍最少10字，当前已经输入'+FCKLen('content')+'字', 'content');
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