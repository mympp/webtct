<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<form action="?" method="post">
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="move" value="<?php echo $move; ?>" />
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th width="120">规则类型</th>
	<td><?php if($rule['type'] == 1){echo '自动回复';}else{echo '关键词回复';} ?></td>
</tr>
<?php if($rule['type'] != 1){ ?>
<tr>
	<th width="120">关键词</th>
	<td>
		<input type="text" name="post[keyword]" value='<?php echo $rule['keyword']; ?>' />&nbsp;&nbsp;
		关键词以英文双引号括住，多个关键词以中竖线分隔。例子："游戏"|"小游戏"|"天成游戏"
	</td>
</tr>
<?php } ?>
<tr>
	<th width="120">回复内容</th>
	<td>
		<textarea name="post[content]" id="content" class="dsn"><?php echo $rule['content'];?></textarea>
		<?php echo deditor($moduleid, 'content', $MOD['editor'], '100%', 350);?>
	</td>
</tr>
<tr>
	<th width="120">状态</th>
	<td>
		<input type="radio" name="post[status]" <?php if($rule['status'] == 3) echo 'checked=""'; ?> value="3"/>开启&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="post[status]" <?php if($rule['status'] != 3) echo 'checked=""'; ?> value="0"/>关闭
	</td>
</tr>
<tr>
	<th width="120"></th>
	<td>
		<input type="submit" name="submit" value="提交" class="btn"/>
	</td>
</tr>
</table>

</form>
<?php include tpl('footer');?>