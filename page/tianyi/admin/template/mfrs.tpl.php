<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<div class="tt">场地搜索</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 搜" class="btn" onclick="Go('?file=<?php echo $file;?>');"/>&nbsp;
</td>
</tr>
</table>
</div>
</form>
<form method="post">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="100">排序</th>
<th width="100">ID</th>
<th>产地名</th>
<th width="80">操作</th>
</tr>
<?php foreach($DAREA as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="ids[]" value="<?php echo $v['id'];?>"/></td>
<td><input name="mfrs[<?php echo $v['id'];?>][listorder]" type="text" size="5" value="<?php echo $v['listorder'];?>"/></td>
<td>&nbsp;<?php echo $v['id'];?></td>
<td><input name="mfrs[<?php echo $v['id'];?>][mfrsname]" type="text" size="20" value="<?php echo $v['mfrsname'];?>"/></td>
<td>
<a href="?file=<?php echo $file;?>&action=delete&id=<?php echo $v['id'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<div class="btns">
<span class="f_r">
产地总数:<strong class="f_red"><?php echo count($AREA);?></strong>&nbsp;&nbsp;
当前目录:<strong class="f_blue"><?php echo count($DAREA);?></strong>&nbsp;&nbsp;
</span>
<input type="submit" name="submit" value="更新产地" class="btn" onclick="this.form.action='?file=<?php echo $file;?>&action=update'"/>&nbsp;&nbsp;
<input type="submit" value="删除选中" class="btn" onclick="if(confirm('确定要删除选中产地吗？此操作将不可撤销')){this.form.action='?file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;&nbsp;
</div>
</form>
<br/>
<br/>
<br/>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>