<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="rand" value="<?php echo $rand; ?>" />
<input type="hidden" name="rand_userid" value="<?php echo $member['userid']; ?>" />
<div class="tt">添加留言 </div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 用户账号</td>
<td>
<input type="text" name="post[username]" value="<?php echo $member['username']; ?>" /> 
<input type="checkbox" name="post[hidden]" value="1" <?php if($hidden) echo 'checked';?>/> 匿名留言
<input type="button" name="" value="随机匹配" class="btn" style="margin-left:35px;" onclick="window.location.href='?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=<?php echo $action; ?>&rand=1';" />&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($member['logintime']){ ?>
	<span>上次登陆：<?php echo date('Y-m-d H:i:s',$member['logintime']); ?></span>
<?php } ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($member['logintimes']){ ?>
	<span>登陆次数：<?php echo $member['logintimes']; ?></span>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> IP</td>
<td><input type="text" name="post[ip]" value="<?php echo $member['ip']; ?>"" /></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 留言内容</td>
<td><textarea name="post[content]" id="content"  rows="8" cols="70"></textarea></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 联系人</td>
<td><input type="text" name="post[truename]" value="<?php echo $member['truename']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 联系电话</td>
<td><input type="text" name="post[telephone]" value="<?php echo $member['mobile']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 电子邮件</td>
<td><input type="text" name="post[email]" value="<?php echo $member['email']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> QQ</td>
<td><input type="text" name="post[qq]" value="<?php echo $member['qq']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 阿里旺旺</td>
<td><input type="text" name="post[ali]" value="<?php echo $member['ali']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> MSN</td>
<td><input type="text" name="post[msn]" value="<?php echo $member['msn']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> Skype</td>
<td><input type="text" name="post[skype]" value="<?php echo $member['skype']; ?>" /></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 回复留言</td>
<td><textarea name="post[reply]" id="reply" rows="8" cols="70"></textarea></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 留言时间</td>
<td>
	<input type="text" name="post[addtime]" class="laydate-icon" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" />
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 回复时间</td>
<td>
	<input type="text" name="post[edittime]" class="laydate-icon" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" />
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 前台显示</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 是
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 否
</td>
</tr>

<?php if($DT['city']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 地区(分站)</td>
<td><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?></td>
</tr>
<?php } ?>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">Menuon(0);</script>
<script src="<?php echo DT_PATH.'file/script/laydate.js'; ?>"></script>
	<style type="text/css">@import "<?php echo DT_SKIN.'laydate.css'; ?>" </style>
	<style>@import "<?php echo DT_SKIN.'laydate_green.css'; ?>" </style>
<?php include tpl('footer');?>