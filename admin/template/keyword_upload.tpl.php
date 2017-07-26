<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">
var _del = 2;
function download(){
	window.open('<?php echo "?file=$file&action=download"; ?>');
}
</script>
<div class="tt">关键词批量上传</div>

<form action="?" enctype="multipart/form-data" method="post" onsubmit="return confirm('确认提交？')">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<input type="hidden" value="upload" name="action" />
<input type="hidden" value="1" name="submit" />
<table cellpadding="2" cellspacing="1" class="tb" style="text-align: center;">
	<tr>
		<th>模块</th>
		<th>分类</th>
		<th>上传文件</th>
		<th>操作</th>
	</tr>
	<tr>
		<td>
				<?php 
				$br=0;
				foreach($MODULE as $v) {
					if($v['moduleid'] < 4 || $v['islink']) continue;
					echo '<input type="checkbox" name="moduleid_key[]" value="'.$v['moduleid'].'" />'.$v['name'];
					$br++;
					if($br%7==0){
						echo '<br/>';
					}
				} 
				?>
		</td>
		<td>
		<?php
if(is_file(DT_ROOT.'/admin/keyword_catname.php')){
	require_once DT_ROOT.'/admin/keyword_catname.php';
	$keyword_cat_html ='';
	foreach ($keyword_cats as $key => $keyword_cat) {
		$keyword_cat_html .= '<option value="'.$key.'">'.$keyword_cat.'</option>';
	}
}
?>
			<select name="parent_catid">
			<option value="0">请选择分类</option>
			<?php echo $keyword_cat_html; ?>
			</select>
		</td>
		<td>
			<input type="file" name="csvfile" />
		</td>
		<td>
			<input type="submit" value="提交" class="btn" />&nbsp;&nbsp;
			<input type="button" value="下载模版" class="btn" onclick="download()" />
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">Menuon('2');</script>
<div class="tt">批量功能说明</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="f_gray">
-上传文件只能是csv文件<br/>
-上传文件中最多只能有1000条数据<br/>
-相关词不填写默认为关键词，拼音不填写由系统自动生成，搜索量不填写默认为0<br/>
</td>
</tr>
</table>
<?php include tpl('footer');?>