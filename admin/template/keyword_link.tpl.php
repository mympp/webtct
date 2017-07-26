<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<script type="text/javascript">
var _del = 0;
</script>
<form method="post" action="?">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="status" value="<?php echo $status;?>"/>
<input type="hidden" id="move" name="move" value="update_link" />
<input type="hidden" id="keyword_id" name="post[0][keyword_id]" value="<?php echo $key_id;?>" />
<input type="hidden" name="update_status_value" value="<?php if($status==3){echo 2;}else{echo 3;} ?>" />
<div class="tt">友情链接管理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>网站名称</th>
<th>网站地址</th>
<th>联系人</th>
</tr>
<?php foreach($lists as $k=>$v) { ?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="更新时间：<?php echo timetodate($v['updatetime'], 6);?>">
<td><input name="post[<?php echo $v['itemid']; ?>][update]" type="checkbox" value="1" onclick="if(this.checked){_del++;}else{_del--;}"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][link_name]" type="text" size="15" value="<?php echo $v['link_name'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][link_url]" type="text" size="20" value="<?php echo $v['link_url'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][contact]" type="text" size="15" value="<?php echo $v['contact'];?>"/></td>
</tr>
<?php } ?>
<tr>
<th> </th>
<th>网站名称</th>
<th>网站地址</th>
<th>联系人</th>
</tr>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td class="f_red">新增</td>
<td><input name="post[0][link_name]" type="text" size="15" value=""/></td>
<td><input name="post[0][link_url]" type="text" size="20" id="keyword" value="http://"/></td>
<td><input name="post[0][contact]" type="text" size="20" id="keyword"/></td>
</tr>
<tr>
<td> </td>
<td height="30" colspan="11">
&nbsp;&nbsp;<input type="submit" name="submit" value="删 除" onclick="if(_del && !confirm('提示:您选择删除'+_del+'个友情链接？确定要删除吗？')){ return false;}else{Dd('move').value='delete_link';return true;}" class="btn"/>
&nbsp;&nbsp;<input type="submit" name="submit" value="更 新" onclick="if(!confirm('确定更新友情链接？')){return false;}else{Dd('move').value='update_link';return true;}" class="btn"/>
</td>
</tr>
</table>
</form>
<div class="pages"><?php echo $pages;?></div>

<script type="text/javascript">
function get_letter(word) {
	makeRequest('file=<?php echo $file;?>&action=letter&word='+word, '?', '_get_letter');
}
function _get_letter() {
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		if(xmlHttp.responseText) {
			if(Dd('letter').value == '') Dd('letter').value = xmlHttp.responseText;
		}
	}
}
</script>
<div class="tt">关键词描述</div>
<form action="?" method="post">
	<input type="hidden" name="action" value="content" />
	<input type="hidden" name="file" value="<?php echo $file; ?>" />
	<input type="hidden" id="keyword_id" name="itemid" value="<?php echo $key_id;?>" />
	<input type="hidden" name="move" value="<?php echo  empty($keyword_content)? 'add':'update'; ?>" />
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
		<td>关键词描述</td>
		<td>
			<textarea name="content" style="width:500px;height:85px;"><?php echo $keyword_content; ?></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="更新" class="btn"/></td>
	</tr>
	</table>
</form>
<script type="text/javascript">Menuon(<?php echo $status==3 ? '0' : '1';?>);</script>
<?php include tpl('footer');?>