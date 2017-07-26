<!--
time:2015-5-6
who:陈韬
where：批量上传功能
what:行15~19、40、79、88、134修改表格标题、输入框宽度和按钮间隔
relation:
管理数据库：
-->
<?php
defined('IN_DESTOON') or exit('Access Denid');
include tpl('header');
show_menu($menus);

?>
<style type="text/css">
.tb input[type="text"]{
	width:140px;
}
</style>

<div class="tt">批量上传<?php echo $upload_type=='fuwu'?'服务需求':'技术供应'; ?></div>
<div>
<?php
if($upload_success==0){
	msg('未上传文件');
}else if($upload_type_right==0){
	msg('错误类型，只允许csv格式');
}else{
	$handel=fopen($_FILES['upload_csv']['tmp_name'],'r');
	$result=input_csv($handel);
	$num=count($result)-1;
	}
?>
<!-- 服务需求 -->
<?php if($upload_type=='fuwu') { ?>            
<form action="<?php echo "?moduleid=$moduleid&file=upload&action=insert&upload_type=fuwu"; ?>" method="post" enctype="multipart/form-data" onsubmit="return check(<?php echo $num ?>,'<?php echo '?moduleid='.$moduleid; ?>')">
<input type="text" name="num" value="<?php echo $num; ?>" style="display:none;" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>信息标题</th>
<th>需要人数</th>
<th>工作性质</th>
<th>会员名</th>
<th>合作形式</th>
<th>工作经验</th>
<th>现居住地</th>
</tr>
<?php foreach($result as $k=>$v) {
	if($k==0){
		continue;
	}	
?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $k; ?></td>
<td><input type="text" id="<?php echo 'title_'.$k; ?>" name="<?php echo "post[$k][title]"; ?>" value="<?php echo $v[0]; ?>" />
<input type="hidden" id="<?php echo 'level_'.$k; ?>" name="<?php echo "post[$k][level]"; ?>" value="<?php echo $v[1]; ?>" />
<input type="hidden" id="<?php echo 'catid_'.$k; ?>" name="<?php echo "post[$k][catid]"; ?>" value="<?php echo $v[2]; ?>" />
</td>
<td><input type="text" id="<?php echo 'total_'.$k; ?>" name="<?php echo "post[$k][total]"; ?>" value="<?php echo $v[3]; ?>" />
<input type="hidden" id="<?php echo 'minsalary_'.$k; ?>" name="<?php echo "post[$k][minsalary]"; ?>" value="<?php echo $v[4]; ?>" />
<input type="hidden" id="<?php echo 'maxsalary_'.$k; ?>" name="<?php echo "post[$k][maxsalary]"; ?>" value="<?php echo $v[5]; ?>" />
</td>
<td><input type="text" id="<?php echo 'type_'.$k; ?>" name="<?php echo "post[$k][type]"; ?>" value="<?php echo $v[7]; ?>" />
<input type="hidden" id="<?php echo 'gender_'.$k; ?>" name="<?php echo "post[$k][gender]"; ?>" value="<?php echo $v[8]; ?>" />
<input type="hidden" id="<?php echo 'content_'.$k; ?>" name="<?php echo "post[$k][content]"; ?>" value="<?php echo $v[11]; ?>" />
</td>
<td><input type="text" id="<?php echo 'username_'.$k; ?>" name="<?php echo "post[$k][username]"; ?>" value="<?php echo $v[12]; ?>" />
</td>
<td><input type="text" id="<?php echo 'marriage_'.$k; ?>" name="<?php echo "post[$k][marriage]"; ?>" value="<?php echo $v[9]; ?>" />
</td>
<td><input type="text" id="<?php echo 'experience_'.$k; ?>" name="<?php echo "post[$k][experience]"; ?>" value="<?php echo $v[10]; ?>" /></td>
<td><input type="text" id="<?php echo 'areaid_'.$k; ?>" name="<?php echo "post[$k][areaid]]"; ?>" value="<?php echo $v[6]; ?>" />
</td>
</tr>
<?php }?>
</table>
<input type="submit" value="提交" class="btn" onclick="" style="margin-left:15px;margin-top:5px;" />
</form>
<!-- 技术供应 -->
<?php }else{  ?>

<form action="<?php echo "?moduleid=$moduleid&file=upload&action=insert&upload_type=jishu"; ?>" method="post" enctype="multipart/form-data" onsubmit="return jishu_check(<?php echo $num ?>,'<?php echo '?moduleid='.$moduleid.'&file=resume'; ?>')">
<input type="text" name="num" value="<?php echo $num; ?>" style="display:none;" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>工程师概述</th>
<th>真实姓名</th>
<th>形象logo</th>
<th>现居住地</th>
<th>工作状态</th>
<th>联系手机</th>
<th>电子邮件</th>
</tr>
<?php foreach($result as $k=>$v) {
	if($k==0){
		continue;
	}	
?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $k; ?></td>
<td><input type="text" id="<?php echo 'title_'.$k; ?>" name="<?php echo "post[$k][title]"; ?>" value="<?php echo $v[0]; ?>" />
<input type="hidden" id="<?php echo 'level_'.$k; ?>" name="<?php echo "post[$k][level]"; ?>" value="<?php echo $v[1]; ?>" />
<input type="hidden" id="<?php echo 'catid_'.$k; ?>" name="<?php echo "post[$k][catid]"; ?>" value="<?php echo $v[2]; ?>" />
</td>
<td><input type="text" id="<?php echo 'truename_'.$k; ?>" name="<?php echo "post[$k][truename]"; ?>" value="<?php echo $v[3]; ?>" />
</td>
<td>
<input type="file" id="<?php echo 'photo_'.$k; ?>" name="<?php echo "photo_$k"; ?>"/>&nbsp;&nbsp;<?php echo $v[4]; ?>
<input type="hidden" id="<?php echo 'gender_'.$k; ?>" name="<?php echo "post[$k][gender]"; ?>" value="<?php echo $v[5]; ?>" />
<input type="hidden" id="<?php echo 'marriage_'.$k; ?>" name="<?php echo "post[$k][marriage]"; ?>" value="<?php echo $v[6]; ?>" />
</td>
<td><input type="text" id="<?php echo 'areaid_'.$k; ?>" name="<?php echo "post[$k][areaid]"; ?>" value="<?php echo $v[7]; ?>" />
<input type="hidden" id="<?php echo 'birthday_'.$k; ?>" name="<?php echo "post[$k][birthday]"; ?>" value="<?php echo $v[8]; ?>" />
<input type="hidden" id="<?php echo 'education_'.$k; ?>" name="<?php echo "post[$k][education]"; ?>" value="<?php echo $v[9]; ?>" />
<input type="hidden" id="<?php echo 'school_'.$k; ?>" name="<?php echo "post[$k][school]"; ?>" value="<?php echo $v[10]; ?>" />
<input type="hidden" id="<?php echo 'type_'.$k; ?>" name="<?php echo "post[$k][type]"; ?>" value="<?php echo $v[11]; ?>" />
</td>
<td><input type="text" id="<?php echo 'situation_'.$k; ?>" style="width:50px;" name="<?php echo "post[$k][situation]"; ?>" value="<?php echo $v[16]; ?>" />
</td>
<td>
<input type="text" id="<?php echo 'mobile_'.$k; ?>" name="<?php echo "post[$k][mobile]"; ?>" value="<?php echo $v[14]; ?>" />
<input type="hidden" id="<?php echo 'experience_'.$k; ?>" name="<?php echo "post[$k][experience]"; ?>" value="<?php echo $v[12]; ?>" />
<input type="hidden" id="<?php echo 'content_'.$k; ?>" name="<?php echo "post[$k][content]"; ?>" value="<?php echo $v[13]; ?>" />
</td>
<td>
<input type="text" id="<?php echo 'email_'.$k; ?>" name="<?php echo "post[$k][email]"; ?>" value="<?php echo $v[15]; ?>" /></td>
</tr>
<?php }?>
</table>
<input type="submit" value="提交" class="btn" onclick="" style="margin-left:15px;margin-top:5px;" />
</form>

<?php } ?>

</div>
<script type="text/javascript">
	
	function isNum(v){
		if(!isNaN(v)){
			return true;
		}else{
			return false;
		}
	}
	
	function checkLevel(v){
		if(v>9||v<0){
			return false;
		}else{
			return true;
		}
	}
	
	function checkFuwuCatid(v){
		if(v=='280'||v=='1803'||v=='1805'||v=='1806'||v=='1807'){
			return true;
		}else{
			return false;
		}
	}
	
	function checkWorkType(v){
		if(v=='0'||v=='1'||v=='2'){
			return true;
		}else{
			return false;
		}
	}
	
	function checkMarriage(v){
		if(v=='0'||v=='1'||v=='2'||v=='3'){
			return true;
		}else{
			return false;
		}
	}
	
	function checkSex(v){
		if(v=='1'||v=='2'){
			return true;
		}else{
			return false;
		}
	}
	
	function isPic(v){
		var re=/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/;
		return re.test(v);
	}
	
	if(Dd('areaid_'+i).value==''){
		back=false;
		str_alert+='行'+(i+1)+':"工作地区"不能为空'+"\n";
	}
	
	function isBool(v){
		if(v==2||v==1||v=='2'||v=='1'){
			return true;
		}else{
			return false;
		}
	}
	
	function isMobile(v){
		var re=/^1[3,5,8]\d{9}$/;
		return re.test(v);
	}
	
	function isDate(v){
		 var re =/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
		 return re.test(v);
	}
	
	function isEmail(v){
		var re=/^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
		return re.test(v);
	}
	
	function checkEducation(v){
		if(v=='0'){
			return true;
		}else{
			return false;
		}
	}
	
	function checkGender(v){
		if(v=='0'||v=='1'||v=='2'){
			return true;
		}else{
			return false;
		}
	}
	
	function check(num,str_url){

		var back=true;
		//alert(Dd('send['+i+'][career]').value);
		str_alert='csv文件内容错误：'+"\n";
		
		for(var i=1;i<=num;i++){
			
			if(Dd('title_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"标题"不能为空'+"\n";
			}
			
			if(Dd('areaid_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"地区"不能为空'+"\n";
			}
			
			if(Dd('content_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"需求描述"不能为空'+"\n";
			}
			
			if(Dd('username_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"会员名"不能为空'+"\n";
			}
			
			
			if(!isNum(Dd('level_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"级别"需填写数字'+"\n";
			}else if(!checkLevel(Dd('level_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"级别"取值超过范围'+"\n";
			}
			
			
			if(!checkFuwuCatid(Dd('catid_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"服务分类"错误值'+"\n";
			}
		
			if(!isNum(Dd('total_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"需要人数"需填写数字'+"\n";
			}
			
			if(!isNum(Dd('minsalary_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"最低悬赏水平"需填写数字'+"\n";
			}
			
			
			if(!isNum(Dd('maxsalary_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"最高悬赏水平"需填写数字'+"\n";
			}
			
			if(!checkWorkType(Dd('type_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"工作类型"错误值'+"\n";
			}
			
			if(!checkGender(Dd('gender_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"性别要求"错误值'+"\n";
			}
			
			
			if(!checkMarriage(Dd('marriage_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"团队性质"错误值'+"\n"
			}
			
			if(!isNum(Dd('experience_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"工作经验"需填写数字'+"\n";
			}

			
		}
		
		if(!back){
			str_alert+='请修改csv文件';
			alert(str_alert);
			window.location.href=str_url;
		}
		return back;
		
		
	}
	
	function jishu_check(num,str_url){
		var back=true;
		//alert(Dd('send['+i+'][career]').value);
		str_alert='csv文件内容错误：'+"\n";
		for(var i=1;i<=num;i++){
			if(!isNum(Dd('level_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"级别"需填写数字'+"\n";
			}else if(!checkLevel(Dd('level_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"级别"取值超过范围'+"\n";
			}
			
			if(Dd('title_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"工程师概述"不能为空'+"\n";
			}
			
			if(Dd('truename_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"真实姓名"不能为空'+"\n";
			}
			
			if(Dd('content_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"自我描述"不能为空'+"\n";
			}
			
			if(Dd('areaid_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"地区"不能为空'+"\n";
			}
			
			if(Dd('school_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"合作单位"不能为空'+"\n";
			}
			
			if(!checkFuwuCatid(Dd('catid_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"服务分类"错误值'+"\n";
			}
			
			if(Dd('photo_'+i).value!=''){
				if(!isPic(Dd('photo_'+i).value)){
					back=false;
					str_alert+='行'+(i+1)+':"个人头像"格式只能jpg,gif,png'+"\n";
			
				}
			}
			
			if(!checkWorkType(Dd('type_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"工作类型"错误值'+"\n";
			}
			
			if(!checkGender(Dd('gender_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"性别要求"错误值'+"\n";
			}
			
			if(!checkMarriage(Dd('marriage_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"团队性质"错误值'+"\n"
			}
			
			if(!isDate(Dd('birthday_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"加入时间"格式错误'+"\n";
			}
			
			if(!isNum(Dd('experience_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"工作经验"需填写数字'+"\n";
			}
			
			if(!checkEducation(Dd('education_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"学历"错误值'+"\n";
			}
			
			if(!isMobile(Dd('mobile_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"联系电话"格式错误'+"\n";
			}
			
			if(!isEmail(Dd('email_'+i).value)){
				back=false;
				str_alert+='行'+(i+1)+':"电子邮件"格式错误'+"\n";
				
			}
			
		}
		if(!back){
			str_alert+='请修改csv文件';
			alert(str_alert);
			window.location.href=str_url;
		}
		return back;
	}
</script>
<?php
include tpl('footer');

?>
