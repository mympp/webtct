<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(1);</script>
<div class="tt"><?php if($action=='add'){ ?>添加信息<?php }elseif($action=='edit'){ ?>修改信息<?php } ?></div>
<form action="?" method="post" onsubmit="return check()">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="infoid" value="<?php echo $infoid; ?>" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td class="tl"><span class="f_red">*</span> 页面标题</td>
	<td><input type="text" id="title" name="post[title]" value="<?php echo $title; ?>" />&nbsp;<span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 页面关键词</td>
	<td><input type="text" id="keywords" name="post[keywords]" value="<?php echo $keywords; ?>" /></td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 页面介绍</td>
	<td>
	<textarea name="post[description]" id="description" style="width:300px;height:90px;"><?php echo $description; ?></textarea>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 信息标签</td>
	<td><input type="text" name="post[tags]" id="tags" value="<?php echo $tags; ?>" style="width:300px;" />&nbsp;&nbsp;以|分割词组</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 来源网站</td>
	<td><input type="text" name="post[website]" id="website" value="<?php echo $website; ?>" />&nbsp;<span id="dwebsite" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 来源网站地址</td>
	<td><input type="text" name="post[website_url]" id="website_url" value="<?php echo $website_url; ?>" />&nbsp;<span id="dwebsite_url" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 原始地址</td>
	<td><input type="text" name="post[url]" id="url" value="<?php echo $url; ?>" />&nbsp;<span id="durl" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 信息类型</td>
	<td>
	<select name="post[type]" >
	<option value="1"  <?php if($type=='1')echo 'selected="selected"'; ?> >产品信息</option>
	<option value="2"  <?php if($type=='2')echo 'selected="selected"'; ?> >商家信息</option>
	<option value="3"  <?php if($type=='3')echo 'selected="selected"'; ?> >新闻信息</option>	
	</select>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 信息等级</td>
	<td>
		<select name="post[level]">
			<option value="0" <?php if($level=='0')echo 'selected="selected"'; ?> >0级</option>
			<option value="1" <?php if($level=='1')echo 'selected="selected"'; ?> >1级</option>
			<option value="2" <?php if($level=='2')echo 'selected="selected"'; ?> >2级</option>
			<option value="3" <?php if($level=='3')echo 'selected="selected"'; ?> >3级</option>
			<option value="4" <?php if($level=='4')echo 'selected="selected"'; ?> >4级</option>
			<option value="5" <?php if($level=='5')echo 'selected="selected"'; ?> >5级</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 客观评级</td>
	<td>
		<select name="post[star]">
			<option value="0"  <?php if($star=='0')echo 'selected="selected"'; ?> >0级</option>
			<option value="1"  <?php if($star=='1')echo 'selected="selected"'; ?> >1级</option>
			<option value="2"  <?php if($star=='2')echo 'selected="selected"'; ?> >2级</option>
			<option value="3"  <?php if($star=='3')echo 'selected="selected"'; ?> >3级</option>
			<option value="4"  <?php if($star=='4')echo 'selected="selected"'; ?> >4级</option>
			<option value="5"  <?php if($star=='5')echo 'selected="selected"'; ?> >5级</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 添加图片</td>
	<td><input name="post[thumb]" type="text" size="60" id="thumb" value="<?php echo $thumb;?>" readonly="readonly"/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,130,170, Dd('thumb').value);" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('thumb').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('thumb').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 信息内容</td>
	<td>
		<textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
		<?php echo deditor(3, 'content', $MOD['editor'], '100%', 350);?><br/><span id="dcontent" class="f_red"></span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 所在地区</td>
	<td>
		<?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_hid">*</span> 信息状态</td>
	<td>
		<input type="radio" name="post[status]" value="1"   <?php if($status=='1')echo 'checked="checked"'; ?>  />未通过&nbsp;&nbsp;<input type="radio" name="post[status]" value="2" <?php if($status=='2'||$status=='')echo 'checked="checked"'; ?>   />待审核&nbsp;&nbsp;
		<input type="radio" name="post[status]" value="3"  <?php if($status=='3')echo 'checked="checked"'; ?>   />已通过&nbsp;&nbsp;<input type="radio" name="post[status]" value="4" <?php if($status=='4')echo 'checked="checked"'; ?>   />已过期&nbsp;&nbsp;
	</td>
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
		
		f='title';
		if(Dd(f).value==''){
			Dmsg('标题不能为空!',f);
			return false;
		}
		
		f='website';
		if(Dd(f).value==''){
			Dmsg('来源网站不可为空!',f);
			return false;
		}
		
		f="website_url";
		if(Dd(f).value==''){
			Dmsg('来源网站域名不可为空!',f);
			return false;
		}
		
		f='url';
		if(Dd(f).value==''){
			Dmsg('原始地址不能为空!',f);
			return false;
		}
		
		
		f = 'content';
		l = FCKLen();
		if(l < 5) {
			Dmsg('信息内容最少5字，当前已输入'+l+'字', f);
			return false;
		}
		
		return true;
	}
</script>
<?php include tpl('footer'); ?>