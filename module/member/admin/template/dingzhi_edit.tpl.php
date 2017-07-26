<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<?php if($action=='editmember'){ ?>
<!-- 修改定制会员 -->
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid;  ?>" />
<input type="hidden" name="submit" value="1"  />
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
<input type="hidden" name="action" value="editmember" />
<div class="tt">修改定制会员</div>
<table cellpadding="2" cellspacing="2">
	<tr>
		<td class="tl">会员名</td>
		<td class=""><?php echo $member['username'];?></td>
	</tr>
	<tr>
		<td class="tl">定制功能</td>
		<td>
			<?php foreach($functionlists as $k=>$v){
				$checked='';
				if(strpos($member['action'],'|'.$v['name'].'|')===false){
					$checked='';
				}else{
					$checked='checked="checked"';
				}
				echo '<input type="checkbox" name="power[]" value="'.$v['name'].'" '.$checked.' />'.$v['title'].'('.$v['name'].')&nbsp;';
			}?>
		</td>
	</tr>
	<tr>
		<td class="tl"></td>
		<td><input type="submit" value="提交" /></td>
	</tr>
</table>
</form>
<?php }else if($action=='editfunction'){ ?>
<!-- 修改定制功能 -->
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="action" value="editfunction" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="itemid" value="<?php echo $function['itemid']; ?>" />
<div class="tt">修改定制功能</div>
	<table cellpadding="2" cellspacing="1" class="tb" >
		<tr>
			<td class="tl">功能名</td>
			<td><input type="text" name="title" value="<?php echo $function[title]; ?>" /> </td>
		</tr>
		<tr>
			<td class="tl">权限名</td>
			<td><input type="text" name="name" value="<?php echo $function[name]; ?>" /></td>
		</tr>
		<tr>
			<td class="tl">简介</td>
			<td><textarea name="introduce"><?php echo $function[introduce]; ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="提交" class="btn" /></td>
		</tr>
	</table>
	
</form>
<?php } ?>