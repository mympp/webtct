<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">批量添加服务需求信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <td align="center" width="200"><span class="f_red">*</span><strong>信息标题</strong></td>
    <td align="center" width="50"><span class="f_red">*</span><strong>需求<br />分类</strong></td>
    <td align="center" width="50"><strong>相关<br />类别</strong></td>
    <td align="center" width="30"><strong>费用</strong></td>
    <td align="center" width="150"><span class="f_red">*</span><strong>所在地区</strong></td>
    <td align="center" width="200"><span class="f_red">*</span><strong>详细地址</strong></td>
    <td align="center" width="80"><strong>单位</strong></td>
    <td align="center" width="80"><strong>品牌</strong></td>
    <td align="center" width="80"><strong>型号</strong></td>
    <td align="center"><span class="f_red">*</span><strong>详细说明</strong></td>
    <td align="center"><strong>跟进会员</strong></td>
  </tr>
<form action="?" method="post">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="add" />
会员名：<input type="text" name="post[username]" size="15" readonly="readonly" value="<?php echo $_username;?>" />
联系人：<input type="text" name="post[truename]" size="15" readonly="readonly" value="<?php echo $_truename;?>" />
  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>

  <tr>
    <td align="left"><input type="text" name="title[]" size="30" value="" /></td>
    <td align="left">
	<select name="fenlei[]">
		<?php foreach($TYPE as $k=>$v){?>
		<option value="<?php echo $k;?>"><?php echo $v;?></option>
		<?php }?>
	</select>
	</td>
    <td align="left"><select name="leibei[]"><option value="280">其它</option></select></td>
    <td align="center"><input type="text" name="minsalary[]" value="0" size="3" /><br />至<br /><input type="text" name="maxsalary[]" value="0" size="3" /><br />元</td>
    <td align="left"><?php echo ajax_area_select('diziid[]', '请选择', $areaid);?><span id="dareaid" class="f_red"></span></td>
    <td align="left"><input type="text" name="address[]" size="30" value="" /></td>
    <td align="left"><input type="text" name="department[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="pinpai[]" size="10" value="" /></td>
    <td align="left"><input type="text" name="xinghao[]" size="10" value="" /></td>
    <td align="left" valign="top"><textarea name="content[]" rows="6" cols="45"></textarea></td>
    <td align="left" width="80"><select name="tobe[]"><option value="charles">刘卫东</option><option value="jsfwyb">刘文娟</option><option value="xzxisr">夏志新</option><option value="youki2012">客服小殷</option></select></td>
  </tr>


  <tr style="display:;">
    <td>&nbsp;</td>
    <td colspan="10" ><input type="submit" name="submit" value="确定" class="btn" /></td>
  </tr>

</form>
  <tr style="display:;">
    <td>&nbsp;</td>
    <td colspan="10" style="color:red"><b>温馨提示：</b><br />0.如果您觉得显示不全，可以右键点击“批量添加服务需求”选择在新标签中打开;<br />1.批量添加服务需求信息是直接通过验证的;<br />2.添加时间在当天跟后两天中随机选择;<br />3.批量添加最多添加十条最少添加一条;<br />4.联系电话为添加人的简历和公司上的联系电话;</td>
  </tr>
</table>

<?php include tpl('footer');?>