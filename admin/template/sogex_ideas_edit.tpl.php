<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(1);</script>
<div class="tt"><?php if($action=='add'){ ?>添加创意<?php }elseif($action=='edit'){ ?>修改创意<?php } ?></div>
<form action="?" method="post" onsubmit="return check()">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td class="tl"><span class="f_red">*</span> 创意标题</td>
	<td><input type="text" id="name" name="post[name]" value="<?php echo $name; ?>" />&nbsp;<span id="dname" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 创意关联地址</td>
	<td><input type="text" id="url" name="post[url]" value="<?php echo $url; ?>" style="width:300px;"  /><span id="durl" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"> 相关图片</td>
	<td>
	<input name="post[thumb]" type="text" size="60" id="thumb" value="<?php echo $thumb;?>" readonly="readonly"/>&nbsp;&nbsp;<span onclick="Dthumb(3,360,320, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 客观评分</td>
	<td><input type="text" name="post[score]" id="score" value="<?php echo $score; ?>" /><span id="dscore" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 创意描述</td>
	<td><textarea name="post[description]" id="description" style="width:300px;height:120px;" ><?php echo $description; ?></textarea>&nbsp;<span id="ddescription" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 会员名</td>
	<td><input type="text" name="username" id="username" value="<?php echo $username ?>" /><span id="dusername" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 创意状态</td>
	<td><input type="radio" name="post[status]" value="1"   <?php if($status=='1')echo 'checked="checked"'; ?>  />未通过&nbsp;&nbsp;<input type="radio" name="post[status]" value="2" <?php if($status=='2'||$status=='')echo 'checked="checked"'; ?>   />待审核&nbsp;&nbsp;
		<input type="radio" name="post[status]" value="3"  <?php if($status=='3')echo 'checked="checked"'; ?>   />已通过&nbsp;&nbsp;<input type="radio" name="post[status]" value="4" <?php if($status=='4')echo 'checked="checked"'; ?>   />已过期&nbsp;&nbsp;</td>
</tr>
</table>
<div class="sbt">
<input type="submit" value="确定" class="btn" />&nbsp;&nbsp;<input type="reset" class="btn" value="重置" />
</div>
</form>
<script type="text/javascript">
	function check(){
		var l;
		var f;
		
		f='name';
		if(Dd(f).value==''){
			Dmsg('创意名称不能为空!',f);
			return false;
		}
		
		f='url';
		if(Dd(f).value==''){
			Dmsg('创意关联地址不可为空!',f);
			return false;
		}
		
		var regUrl = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
		var result = Dd('url').value.match(regUrl);
        if(result==null) {
                Dmsg('网页地址格式错误','url');
                return false;
        }	
		
		f='score';
		if(Dd(f).value==''){
			Dmsg('客服评分不能为空!',f);
			return false;
		}
		
		if(isNaN(Dd(f).value)){
			Dmsg('客服评分必须为数字',f);
			return false;
		}
		
		if(parseInt(Dd(f).value) < 0 || parseInt(Dd(f).value) > 10){
			Dmsg('客服评分需在0-10内',f);
			return false;
		}
		
		f='description';
		if(Dd(f).value==''){
			Dmsg('创意描述不可为空!',f);
			return false;
		}
		
		
		f = 'username';
		if(Dd(f).value==''){
			Dmsg('用户名不能为空!',f);
			return false;
		}
		
		return true;
	}
</script>
<?php include tpl('footer'); ?>