<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<style>
.stype1 {<?php if($action == 'add'||$stype == '1'){echo 'display:table-row;';}else{echo 'display:none;';} ?>}
.stype2 {<?php if($stype == '2'){echo 'display:table-row;';}else{echo 'display:none;';} ?>}
</style>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>排名</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 排名模块</td>
<td>
<input type="radio" name="post[mid]" value="99" id="m_5"<?php if($mid == 99 || $action== 'add') echo ' checked';?>/><label for="m_5"> 首页</label>
<input type="radio" name="post[mid]" value="0" id="m_6"<?php if($mid == 0) echo ' checked';?>/><label for="m_6"> 全网</label>
<?php foreach($info_type as $k=>$v){ ?>
<input type="radio" name="post[mid]" value="<?php echo $v['catid']; ?>" id="m_4"<?php if($mid == $v['catid']) echo ' checked';?>/><label for="m_4"> <?php echo $v['name']; ?></label>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 推广类型</td>
<td>
<input type="hidden" id="stype" value="<?php if($stype){echo $stype;}else{ echo '1';} ?>" />
<input type="radio" name="post[stype]" onchange="change_stype(1)" value="1" <?php if($stype == 1 || $action == 'add') echo 'checked'; ?>/>包月&nbsp;&nbsp;
<input type="radio" name="post[stype]" onchange="change_stype(2)" value="2" <?php if($stype == '2'){echo 'checked';} ?> />单条</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 关键词</td>
<td><input type="text" size="40" name="post[word]" id="word" value="<?php echo $word;?>"/> <span id="dword" class="f_red"></span></td>
</tr>
<tr id="tr_price" class="stype1">
<td class="tl"><span class="f_red">*</span> 出价</td>
<td><input type="text" size="20" name="post[price]" id="price" value="<?php echo $price;?>"/> <span id="dprice" class="f_red"></span></td>
</tr>
<tr id="tr_least" class="stype2" >
<td class="tl"><span class="f_red">*</span> 充值</td>
<td><input type="text" size="20" name="post[least]" id="least" value="<?php echo $least;?>" /><span id="dleast" class="f_red"></span></td>
</tr>
<tr id="tr_spend" class="stype2">
<td class="tl"><span class="f_red">*</span> 每次点击花费</td>
<td><input type="text" size="20" name="post[spend]" id="spend" value="<?php echo $spend; ?>" /><span id="dspend" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 单位</td>
<td>
<input type="radio" name="post[currency]" value="money" <?php if($currency == 'money') echo 'checked';?>/> <?php echo $DT['money_name'];?>&nbsp;
<input type="radio" name="post[currency]" value="credit" <?php if($currency == 'credit') echo 'checked';?>/> <?php echo $DT['credit_name'];?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 会员名称</td>
<td><input type="text" size="20" name="post[username]" id="username" value="<?php echo $username;?>"/> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 创意ID</td>
<td><input type="text" size="10" name="post[tid]" id="key_id" readonly="readonly" placeholder="" value="<?php echo $tid;?>" "/> <img src="<?php echo $MODULE[2]['linkurl'];?>image/img_select.gif" width="12" height="12" title="选择信息ID" class="c_p" onclick="Sid();"/> <span id="dkey_id" class="f_red"></span>&nbsp;&nbsp;<span style="font-size:12px;">(填写会员名称后，可点击左侧按钮查找)</span></td>
</tr>
<tr id="tr_time" class="stype1">
<td class="tl"><span class="f_red">*</span> 投放时段</td>
<td><?php echo dcalendar('post[fromtime]', $fromtime);?> 至 <?php echo dcalendar('post[totime]', $totime);?> <span id="dtime" class="f_red"></span></td>
</tr>
<tr class="stype2">
<td class="tl"><span class="f_red">*</span> 推广状态</td>
<td>
<input type="radio" name="post[spread_status]" <?php if($action == 'add' || $spread_status == '3'){echo 'checked';} ?> value="3" />立即开启&nbsp;&nbsp;
<input type="radio" name="post[spread_status]" <?php if($spread_status == '1'){echo 'checked';} ?> value="1" />暂不开启
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 排名状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过&nbsp;
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 备注事项</td>
<td><input type="text" size="60" name="post[note]" value="<?php echo $note;?>"/></td>
</tr>
</tbody>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
function change_stype(i){
	$('#stype').val(i);
	if(i == '1'){
		$('.stype1').css('display','table-row');
		$('.stype2').css('display','none');	
	}else{
		$('.stype1').css('display','none');
		$('.stype2').css('display','table-row');
	}
}
function Sid() {
	if(Dd('username').value == ''){alert('请先填写用户名');return false;}
	Dwidget('?moduleid=3&file=spread&action=search_ideas&username='+Dd('username').value,Dd('username').value+'的可用创意');
}
function check() {
	var l;
	var f;
	var stype = Dd('stype').value;
	f = 'word';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('请输入关键词', f);
		return false;
	}
	f = 'price';
	l = Dd(f).value.length;
	if(l < 1 && stype == '1') {
		Dmsg('请填写出价', f);
		return false;
	}

	if(stype == '1'){		
		if(Dd('postfromtime').value.length != 10 || Dd('posttotime').value.length != 10) {
			Dmsg('请选择投放时段', 'time');
			return false;
		}
	}

	f = 'least';
	l = Dd(f).value.length;
	if(l < 1 && stype == '2'){
		Dmsg('请填写充值数目','least');
		return false;
	}

	f = 'spend';
	l = Dd(f).value.length;
	if(l < 1 && stype == '2'){
		Dmsg('请填写每次点击花费','spend');
		return false;
	}

	f = 'username';
	l = Dd(f).value.length;
	if(l < 3) {
		Dmsg('请填写会员名称', f);
		return false;
	}

	f = 'key_id';
	l = Dd(f).value.length;
	if(l < 1) {
		Dmsg('请填写创意ID', f);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>
