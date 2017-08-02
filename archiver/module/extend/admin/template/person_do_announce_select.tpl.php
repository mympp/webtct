<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">添加公告</div>
<form method="post" action="?">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" id="actions" value="add_daoru"/>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <th scope="col"><input type="checkbox" onclick="checkall(this.form);"/></th>
    <th scope="col">时间-发布者</th>
    <th scope="col">对话内容</th>
  </tr>

<?php foreach($result as $k=>$v){ ?>
  <tr onmouseover="this.className='on';" onmouseout="this.className='';">
    <td><input type="checkbox" name="contents[]" value="<?php echo htmlspecialchars($k).",".$v;?>"/></td>
    <td width="30%"><?php echo $k;?></td>
    <td>  <?php echo $v;?>  </td>
  </tr>
<?php } ?>

  <tr>
    <td>&nbsp;</td>
    <td><?php echo type_select('announce', 1, 'post[typeid]', '请选择分类', $typeid, 'id="typeid"');?> <a href="?file=type&item=<?php echo $file;?>" class="t">[管理分类]</a> <span id="dtypeid" class="f_red"></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value=" 确 定 " /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<br/><br/><br/>
<?php include tpl('footer');?>