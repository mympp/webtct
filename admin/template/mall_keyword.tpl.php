<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">
var _del = 0;
</script>
<?php 
	require_once DT_ROOT.'/admin/keyword_catname.php';
	$keyword_cat_mall ='';
	foreach ($keyword_mall_cats as $key => $keyword_cat) {
		$keyword_cat_mall .= '<option value="'.$key.'">'.$keyword_cat.'</option>';
	}
?>
<!-- <?php if($action == 'mall'){ ?> -->

<div class="tt">推荐关键词</div>
<form method="post" action="?">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="status" value="<?php echo $status;?>"/>
<input type="hidden" name="update_mall_keyword" value="1" />
<input type="hidden" id="move" name="move" value="update" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类</th>
<th>关键词</th>
<th>相关词</th>
<th>拼音</th>
<th>结果</th>
<th>总搜索</th>
<th>本月</th>
<th>本周</th>
<th>今日</th>
<th>状态</th>
<th>友情链接与描述</th>
<th>操作</th>
</tr>
<?php foreach($lists as $k=>$v) { ?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="更新时间：<?php echo timetodate($v['updatetime'], 6);?>">
<td><input name="post[<?php echo $v['itemid']; ?>][update]" type="checkbox" value="1" onclick="if(this.checked){_del++;}else{_del--;}"/></td>
<td>
<input type="hidden" name="post[<?php echo $v['itmid']; ?>][parent_catid]" value="<?php echo $v['parent_catid']; ?>" /> 
<?php if(isset($keyword_mall_cats[$v['parent_catid']])) echo $keyword_mall_cats[$v['parent_catid']]; ?></td>
<td><input name="post[<?php echo $v['itemid'];?>][word]" type="text" size="15" value="<?php echo $v['word'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][keyword]" type="text" size="20" value="<?php echo $v['keyword'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][letter]" type="text" size="15" value="<?php echo $v['letter'];?>"/></td>
<td><?php echo $v['items'];?></td>
<td><input name="post[<?php echo $v['itemid'];?>][total_search]" type="text" size="5" value="<?php echo $v['total_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][month_search]" type="text" size="5" value="<?php echo $v['month_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][week_search]" type="text" size="4" value="<?php echo $v['week_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][today_search]" type="text" size="3" value="<?php echo $v['today_search'];?>"/></td>
<td>
<?php if($v['status']==3){echo '启动'; } else { echo '待审';} ?>
<input type="hidden" name="post[<?php echo $v['itemid']; ?>][status]" value="<?php echo $v['status']; ?>" />
</td>
<td><input type="button" class="btn" value="操作" onclick="Dwidget('?file=keyword&action=link_list&key_id=<?php echo $v['itemid'];?>', '<?php echo $v['keyword']; ?>-操作')"/></td>
<td><?php printf('<a target=_blank href="hot/show-%s.html" title="%s"> 进入 </a>',$v['itemid'],$v['keyword']);?></td>
</tr>
<?php } ?>
<tr>
	<td></td>
	<td colspan="12">
&nbsp;&nbsp;
<input type="submit" name="submit" value="撤销推荐" onclick="if(!confirm('提示：你确定将已选关键词撤销推荐?')){return false;}else{Dd('move').value='change_parent_catid';return true;}" class="btn" />
&nbsp;&nbsp;<input type="submit" name="submit" value="更 新" onclick="if(!confirm('确定更新关键词？')){return false;}else{Dd('move').value='update';return true;}" class="btn"/>
	</td>
</tr>
</table>
</form>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">Menuon(0);</script>

<!-- <?php  }else{  ?> -->
<div class="tt">搜索关键词</div>
<form action="?">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>&status=<?php echo $status;?>');"/>
</td>
</tr>
</table>
</form>
<div class="tt">搜索结果</div>
<form method="post" action="?">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="submit" value="1" />
<input type="hidden" id="move" name="move" value="change_parent_catid" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类</th>
<th>关键词</th>
<th>相关词</th>
<th>拼音</th>
<th>结果</th>
<th>总搜索</th>
<th>本月</th>
<th>本周</th>
<th>今日</th>
<th>状态</th>
<th>操作</th>
</tr>
<?php foreach($lists as $k=>$v) { ?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="更新时间：<?php echo timetodate($v['updatetime'], 6);?>">
<td><input name="post[<?php echo $v['itemid']; ?>][update]" type="checkbox" value="1" onclick="if(this.checked){_del++;}else{_del--;}"/></td>
<td>
<input type="hidden" name="post[<?php echo $v['itemid']; ?>][parent_catid]" value="<?php echo $v['parent_catid']; ?>" />
<?php if(isset($keyword_mall_cats[$v['parent_catid']])) echo $keyword_mall_cats[$v['parent_catid']]; ?></td>
<td><input name="post[<?php echo $v['itemid'];?>][word]" type="text" size="15" value="<?php echo $v['word'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][keyword]" type="text" size="20" value="<?php echo $v['keyword'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][letter]" type="text" size="15" value="<?php echo $v['letter'];?>"/></td>
<td><?php echo $v['items'];?></td>
<td><input name="post[<?php echo $v['itemid'];?>][total_search]" type="text" size="5" value="<?php echo $v['total_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][month_search]" type="text" size="5" value="<?php echo $v['month_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][week_search]" type="text" size="4" value="<?php echo $v['week_search'];?>"/></td>
<td><input name="post[<?php echo $v['itemid'];?>][today_search]" type="text" size="3" value="<?php echo $v['today_search'];?>"/></td>
<td>
<?php if($v['status']==3){echo '启动'; } else { echo '待审';} ?>
<input type="hidden" name="post[<?php echo $v['itemid']; ?>][status]" value="<?php echo $v['status']; ?>" />
</td>
<td><?php printf('<a target=_blank href="hot/show-%s.html" title="%s"> 查看 </a>',$v['itemid'],$v['keyword']);?></td>
</tr>
<?php } ?>
<tr>
	<td></td>
	<td>
关键词划分到  
<select name="parent_catid">
<?php echo $keyword_cat_mall; ?>	
</select>
	</td>
	<td colspan="10">
		<input type="submit" value="提交" class="btn" />
	</td>
</tr>
</table>

</form>
<div class="pages"><?php echo $pages;?></div>
<div class="divline"></div>
<div class="tt">添加推荐词</div>
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="move" value="update" />
<input type="hidden" name="update_mall_keyword" value="1" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>模块</th>
<th>分类</th>
<th>关键词</th>
<th>相关词</th>
<th>拼音</th>
<th>结果</th>
<th>总搜索</th>
<th>本月</th>
<th>本周</th>
<th>今日</th>
<th colspan="3">状态</th>
</tr>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td class="f_red">新增</td>
<td>
产品<input type="hidden" name="post[0][moduleid]" value="16" />
</td>
<td>
<select name="post[0][parent_catid]">
	<option value="0">请选择分类</option>
	<?php echo $keyword_cat_mall; ?>	
</select>
</td>
<td><input name="post[0][word]" type="text" size="15" value="" onblur="get_letter(this.value);" onkeyup="Dd('keyword').value=this.value;"/></td>
<td><input name="post[0][keyword]" type="text" size="20" id="keyword"/></td>
<td><input name="post[0][letter]" id="letter" type="text" size="15" value=""/></td>
<td><input name="post[0][items]" type="text" size="3" value="0"/></td>
<td><input name="post[0][total_search]" type="text" size="5" value="1"/></td>
<td><input name="post[0][month_search]" type="text" size="5" value="1"/></td>
<td><input name="post[0][week_search]" type="text" size="4" value="1"/></td>
<td><input name="post[0][today_search]" type="text" size="3" value="1"/></td>
<td colspan="3">
<select name="post[0][status]">
<option value="3"<?php echo $status==3 ? ' selected' : '';?>>启用</option>
<option value="2"<?php echo $status==2 ? ' selected' : '';?>>待审</option>
</select>
</td>
</tr>
<tr>
	<td></td>
	<td colspan="11">
		<input type="submit" class="btn" value="提交" /> 
	</td>
</tr>
</table>
</form>
<script type="text/javascript">Menuon(1);</script>

<!-- <?php  }  ?> -->
<?php include tpl('footer');?>