<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script>
	web_arr=new Array();
	<?php foreach($web_lists as $k=>$v){ ?>
	web_arr[<?php echo $v['mid']; ?>]=new Array();
	web_arr[<?php echo $v['mid']; ?>]['name']='<?php echo $v[name]; ?>';
	web_arr[<?php echo $v['mid']; ?>]['url']='<?php echo $v[url]; ?>';
	<?php } ?>
	function website_select(id){
		Dd('web_name').value=web_arr[id]['name'];
		Dd('web_url').value=web_arr[id]['url'];
	}
	
	function change_type(v){
		switch(v){
			case 0:
				Dd('tr_infotype').style.cssText='display:table-row;'
				Dd('tr_keyword').style.cssText='display:table-row;';
			break;
			case 1:
				Dd('tr_infotype').style.cssText='display:table-row;'
				Dd('tr_keyword').style.cssText='display:none;';
			break;
			case 2:
				Dd('tr_infotype').style.cssText='display:none;'
				Dd('tr_keyword').style.cssText='display:table-row;';
			break;
			case 3:
				Dd('tr_infotype').style.cssText='display:none;'
				Dd('tr_keyword').style.cssText='display:none;';
			break;
		}
	}
	
	function check(){
		if(Dd('web_name').value == ''){
			Dmsg('网站名不可为空','web_name');
			return false;
		}
		
		if(Dd('web_url').value == ''){
			Dmsg('域名不可为空','web_url');
			return false;
		}
		
		var select_index = Dd('infotype').selectedIndex;
		var select_value = Dd('infotype').options[select_index].value;
		
		if(Dd('type0').checked){		//单一分类单一词
			if(select_value == 0){
				Dmsg('请选择分类','infotype');
				return false;
			}
			
			if(Dd('keyword').value == ''){
				Dmsg('请填写作用词','keyword');
				return false;
			}
		}
		
		if(Dd('type1').checked){		//单一分类所有词
			if(select_value == 0){
				Dmsg('请选择分类','infotype');
				return false;
			}
		}
		
		if(Dd('type2').checked){		//所有分类单一词
			if(Dd('keyword').value == ''){
				Dmsg('请填写作用词','keyword');
				return false;
			}
		}
		
		if(Dd('score').value == ''){
			Dmsg('请填写分数','score');
			return false;
		}
		
		if(isNaN(Dd('score').value)){
			Dmsg('请填写数字','score');
			return false;
		}
		
		return true;
	}
</script>
<div class="tt">添加规则</div>
<form action="?" method="post" onsubmit="return check()">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="ruleid" value="<?php echo $ruleid; ?>" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td class="tl"><span class="f_red">*</span> 等级</th>
	<td >
		<select name="post[level]">
			<option value="0" <?php echo $level=='0'?'selected="selected"':''; ?> >0</option>
			<option value="1" <?php echo $level=='1'?'selected="selected"':''; ?> >1</option>
			<option value="2" <?php echo $level=='2'?'selected="selected"':''; ?> >2</option>
			<option value="3" <?php echo $level=='3'?'selected="selected"':''; ?> >3</option>
			<option value="4" <?php echo $level=='4'?'selected="selected"':''; ?> >4</option>
			<option value="5" <?php echo $level=='5'?'selected="selected"':''; ?> >5</option>
		</select>
	</td>
</tr>
<tr style="<?php if($action=='edit'){echo 'display:none;';} ?>" >
	<td class="tl"><span class="f_red">*</span>作用网站</td>
	<td>
		<?php echo select_website('webiste','website','','website_select(this.options[this.options.selectedIndex].value)','80px','120px'); ?>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span>网站名</td>
	<td ><input id="web_name" type="text" name="post[web_name]" value="<?php echo $web_name; ?>" readonly="readonly" />
		&nbsp;&nbsp;<span id="dweb_name" class="f_red"></span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span>域名</td>
	<td ><input id="web_url" type="text" name="post[web_url]" value="<?php echo $web_url; ?>" readonly="readonly" style="width:280px;" />
	&nbsp;&nbsp;<span id="dweb_url" class="f_red"></span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span>规则类型</td>
	<td>
		<input type="radio" id="type0" name="post[type]" value="0" onclick="change_type(0)" <?php if($action=='add'){echo 'checked="checked"';} ?> <?php if($action=='edit'&&$type=='0'){echo 'checked="checked"';} ?> />针对单一分类单一词&nbsp;&nbsp;
		<input type="radio" id="type1" name="post[type]" onclick="change_type(1)" value="1" <?php if($action=='edit'&&$type=='1'){echo 'checked="checked"';} ?> />针对单一分类所有词&nbsp;&nbsp;
		<input type="radio" id="type2" name="post[type]" onclick="change_type(2)" value="2" <?php if($action=='edit'&&$type=='2'){echo 'checked="checked"';} ?> />针对所有分类单一词&nbsp;&nbsp;
		<input type="radio" id="type3" name="post[type]" onclick="change_type(3)" value="3" <?php if($action=='edit'&&$type=='3'){echo 'checked="checked"';} ?> />针对所有分类所有词&nbsp;&nbsp;
	</td>
</tr>
<tr id="tr_infotype" style="<?php if($type==0|$type==1){echo 'display: table-row';}else{echo 'display:none;';} ?> ">
	<td class="tl">作用分类</td>
		<td >
		<?php echo select_info_type('post[infotype]','infotype',$infotype,'','',''); ?>&nbsp;&nbsp;<span id="dinfotype" class="f_red"></span>
	</td>
</tr>
<tr id="tr_keyword" style="<?php if($type==0|$type==2){echo 'display: table-row';}else{echo 'display:none;';} ?> ">
	<td class="tl">作用词</td>
		<td>
		<input id="keyword" type="text" name="post[keyword]" value="<?php echo $keyword; ?>" /> &nbsp;&nbsp;<span id="dkeyword" class="f_red"></span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span>分数</td>
	<td><input id="score" type="text" name="post[score]" value="<?php echo $score; ?>" />&nbsp;&nbsp;<span id="dscore" class="f_red"></span></td>
</tr>
<tr>
</tr>
</table>
<div class="btns">
<input type="submit" value="确定" class="btn" />
</div>
</form>

<?php include('footer'); ?>