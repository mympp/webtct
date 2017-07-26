
<?php
/*
time:2015-5-12
who:陈韬
where：批量上传功能
what:
relation:/module/rc_job/admin/upload.inc.php、/module/rc_job/admin/download.inc.php
管理数据库：
*/
defined('IN_DESTOON') or exit('Access Denid');
include tpl('header');
show_menu($menus);

?>
<style type="text/css">
.tb input[type="text"]{
	width:140px;
}
</style>

<div class="tt">批量上传<?php echo $upload_type=='product'?'商品':''; ?></div>
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
<!-- 上传招聘 -->
<?php if($upload_type=='job') { ?>            
<form action="<?php echo "?moduleid=$moduleid&file=upload&action=insert&upload_type=job"; ?>" method="post" enctype="multipart/form-data" onsubmit="return check(<?php echo $num ?>,'<?php echo '?moduleid='.$moduleid; ?>')">
<input type="text" name="num" value="<?php echo $num; ?>" style="display:none;" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>信息标题</th>
<th>招聘人数</th>
<th>工作地区</th>
<th>学历要求</th>
<th>工作经验</th>
<th>会员名</th>
</tr>
<?php foreach($result as $k=>$v) {
	if($k==0){
		continue;
	}	
?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $k; ?></td>
<td>
<input type="text" id="<?php echo 'title_'.$k; ?>" name="<?php echo "post[$k][title]"; ?>" value="<?php echo $v[0]; ?>" />
<input type="hidden" id="<?php echo 'level_'.$k; ?>" name="<?php echo "post[$k][level]"; ?>" value="<?php echo $v[1]; ?>" />
<input type="hidden" id="<?php echo 'catid_'.$k; ?>" name="<?php echo "post[$k][catid]"; ?>" value="<?php echo $v[2]; ?>" />
<input type="hidden" id="<?php echo 'hangye_'.$k; ?>" name="<?php echo "post[$k][hangye]"; ?>" value="<?php echo $v[3]; ?>" />
</td>
<td><input type="text" id="<?php echo 'total_'.$k; ?>" name="<?php echo "post[$k][total]"; ?>" value="<?php echo $v[4]; ?>" />
<input type="hidden" id="<?php echo 'minsalary_'.$k; ?>" name="<?php echo "post[$k][minsalary]]"; ?>" value="<?php echo $v[5]; ?>" />
<input type="hidden" id="<?php echo 'maxsalary_'.$k; ?>" name="<?php echo "post[$k][maxsalary]]"; ?>" value="<?php echo $v[6]; ?>" />
</td>
<td><input type="text" id="<?php echo 'areaid_'.$k; ?>" name="<?php echo "post[$k][areaid]"; ?>" value="<?php echo $v[7]; ?>" />
<input type="hidden" id="<?php echo 'type_'.$k; ?>" name="<?php echo "post[$k][type]]"; ?>" value="<?php echo $v[8]; ?>" />
<input type="hidden" id="<?php echo 'gender_'.$k; ?>" name="<?php echo "post[$k][gender]]"; ?>" value="<?php echo $v[9]; ?>" />
<input type="hidden" id="<?php echo 'marriage_'.$k; ?>" name="<?php echo "post[$k][marriage]"; ?>" value="<?php echo $v[10]; ?>" />
</td>
<td><input type="text" id="<?php echo 'education_'.$k; ?>" name="<?php echo "post[$k][education]".$k; ?>" value="<?php echo $v[11]; ?>" />
<input type="hidden" id="<?php echo 'minage_'.$k; ?>" name="<?php echo "post[$k][minage]]"; ?>" value="<?php echo $v[12]; ?>" />
<input type="hidden" id="<?php echo 'maxage_'.$k; ?>" name="<?php echo "post[$k][maxage]]"; ?>" value="<?php echo $v[13]; ?>" />
</td>
<td><input type="text" id="<?php echo 'experience_'.$k; ?>" name="<?php echo "experience_".$k; ?>"  value="<?php echo $v[14]; ?>" />
</td>
<td>
<input type="hidden" id="<?php echo 'content_'.$k; ?>" name="<?php echo "post[$k][content]]"; ?>" value="<?php echo $v[15]; ?>" />
<input type="text" id="<?php echo 'username_'.$k; ?>" name="<?php echo "post[$k][username]"; ?>" value="<?php echo $v[16]; ?>" />
</td>
</tr>
<?php }?>
</table>
<input type="submit" value="提交" class="btn" onclick="" style="margin-left:15px;margin-top:5px;" />
</form>

<?php }else if($upload_type=='resume') {?>
<!-- 上传简历 -->
<form action="<?php echo "?moduleid=$moduleid&file=upload&action=insert&upload_type=resume"; ?>" method="post" enctype="multipart/form-data" onsubmit="return resume_check(<?php echo $num ?>,'<?php echo '?moduleid='.$moduleid.'&file=resume'; ?>')">
<input type="text" name="num" value="<?php echo $num; ?>" style="display:none;" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>简历标题</th>
<th>现居住地</th>
<th>免冠照片</th>
<th>毕业院校</th>
<th>工作经验</th>
<th>联系手机</th>
</tr>
<?php foreach($result as $k=>$v) {
	if($k==0){
		continue;
	}	
?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $k; ?></td>
<td>
<input type="text" id="<?php echo 'title_'.$k; ?>" name="<?php echo "post[$k][title]"; ?>" value="<?php echo $v[0]; ?>" />
<input type="hidden" id="<?php echo 'level_'.$k; ?>" name="<?php echo "post[$k][level]"; ?>" value="<?php echo $v[1]; ?>" />
<input type="hidden" id="<?php echo 'catid_'.$k; ?>" name="<?php echo "post[$k][catid]"; ?>" value="<?php echo $v[2]; ?>" />
<input type="hidden" id="<?php echo 'hangye_'.$k; ?>" name="<?php echo "post[$k][hangye]"; ?>" value="<?php echo $v[3]; ?>" />
<input type="hidden" id="<?php echo 'nplace_'.$k; ?>" name="<?php echo "post[$k][nplace]"; ?>" value="<?php echo $v[4]; ?>" />
</td>
<td><input type="text" id="<?php echo 'areaid_'.$k; ?>" name="<?php echo "post[$k][areaid]"; ?>" value="<?php echo $v[5]; ?>" />
<input type="hidden" id="<?php echo 'truename_'.$k; ?>" name="<?php echo "post[$k][truename]]"; ?>" value="<?php echo $v[6]; ?>" />
</td>
<td><input type="file" id="<?php echo 'photo_'.$k; ?>" name="<?php echo "photo_".$k; ?>" /><br/><?php echo $v[7]; ?>
<input type="hidden" id="<?php echo 'gender_'.$k; ?>" name="<?php echo "post[$k][gender]]"; ?>" value="<?php echo $v[8]; ?>" />
<input type="hidden" id="<?php echo 'marriage_'.$k; ?>" name="<?php echo "post[$k][marriage]"; ?>" value="<?php echo $v[9]; ?>" />
<input type="hidden" id="<?php echo 'birthday_'.$k; ?>" name="<?php echo "post[$k][birthday]"; ?>" value="<?php echo $v[10]; ?>" /> 
<input type="hidden" id="<?php echo 'education_'.$k; ?>" name="<?php echo "post[$k][education]"; ?>" value="<?php echo $v[11]; ?>" /> 
</td>
<td><input type="text" id="<?php echo 'school_'.$k; ?>" name="<?php echo "post[$k][school]".$k; ?>" value="<?php echo $v[12]; ?>" />
<input type="hidden" id="<?php echo 'type_'.$k; ?>" name="<?php echo "post[$k][type]]"; ?>" value="<?php echo $v[13]; ?>" />
</td>
<td><input type="text" id="<?php echo 'experience_'.$k; ?>" name="<?php echo "post[$k][experience]".$k; ?>"  value="<?php echo $v[14]; ?>" />
</td>
<td>
<input type="hidden" id="<?php echo 'content_'.$k; ?>" name="<?php echo "post[$k][content]]"; ?>" value="<?php echo $v[15]; ?>" />
<input type="text" id="<?php echo 'mobile_'.$k; ?>" name="<?php echo "post[$k][mobile]"; ?>" value="<?php echo $v[16]; ?>" />
<input type="hidden" id="<?php echo 'email_'.$k; ?>" name="<?php echo "post[$k][email]"; ?>" value="<?php echo $v[17]; ?>" /> 
<input type="hidden" id="<?php echo 'situtation_'.$k; ?>" name="<?php echo "post[$k][situtation_exp]"; ?>" value="<?php echo $v[18]; ?>" /> 
<input type="hidden" id="<?php echo 'education_exp_'.$k; ?>" name="<?php echo "post[$k][education_exp]"; ?>" value="<?php echo $v[19]; ?>" />
<input type="hidden" id="<?php echo 'student_exp_'.$k; ?>" name="<?php echo "post[$k][student_exp]"; ?>" value="<?php echo $v[20]; ?>" />
<input type="hidden" id="<?php echo 'work_exp_'.$k; ?>" name="<?php echo "post[$k][work_exp]"; ?>" value="<?php echo $v[21]; ?>" />
</td>
</tr>
<?php }?>
</table>
<input type="submit" value="提交" class="btn" onclick="" style="margin-left:15px;margin-top:5px;" />
</form>
<?php } ?>
</div>
<script type="text/javascript">

	function checkInArr(v,arr){
		var back=false;
		for(var a in arr){
			if(v==arr[a]){
				back=true;
				break;
			}
		}
		return back;
	}
	
	function isNum(v){
		if(!isNaN(v)){
			return true;
		}else{
			return false;
		}
	}
	
	function isPic(v){
		var re=/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/;
		return re.test(v);
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
	
	
	function check(num,str_url){
		
		var back=true;
		//alert(Dd('send['+i+'][career]').value);
		str_alert='csv文件内容错误：'+"\n";
		for(var i=1;i<=num;i++){
			
			var catid_arr=[];
			for(var j=2118;j<2137;j++){
				catid_arr.push(j.toString());
			}
			for(var j=2143;j<2149;j++){
				catid_arr.push(j.toString());
			}
			
			if(!checkInArr(Dd('catid_'+i).value,catid_arr)){
				str_alert+='行'+(i+1)+':"职位"错误值'+'\n';
				back=false;
			}
			
		
			if(Dd('title_'+i).value==''){
				str_alert+='行'+(i+1)+':"信息标题"不能为空'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('level_'+i).value,[0,1,2,3,4,5,6,7,8,9])){
				str_alert+='行'+(i+1)+':"级别"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('hangye_'+i).value,[1,2,3,4])){
				str_alert+='行'+(i+1)+':"行业"错误值'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('total_'+i).value)){
				str_alert+='行'+(i+1)+':"招聘人数"需填写数字'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('minsalary_'+i).value)){
				str_alert+='行'+(i+1)+':"最低待遇水平"需填写数字'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('maxsalary_'+i).value)){
				str_alert+='行'+(i+1)+':"最高待遇水平"需填写数字'+"\n";
				back=false;
			}
			
			if(Dd('areaid_'+i).value==''){
				str_alert+='行'+(i+1)+':"工作地区"不能为空'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('type_'+i).value,[0,1,2,3])){
				str_alert+='行'+(i+1)+':"工作性质"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('gender_'+i).value,[0,1,2])){
				str_alert+='行'+(i+1)+':"性别要求"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('marriage_'+i).value,[0,1,2])){
				str_alert+='行'+(i+1)+':"婚姻要求"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('education_'+i).value,[0,1,2,3,4,5,6])){
				str_alert+='行'+(i+1)+':"学历要求"错误值'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('minage_'+i).value)){
				str_alert+='行'+(i+1)+':"最低年龄要求"需填写数字'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('maxage_'+i).value)){
				str_alert+='行'+(i+1)+':"最高年龄要求"需填写数字'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('experience_'+i).value)){
				str_alert+='行'+(i+1)+':"工作经验"需填写数字'+"\n";
				back=false;
			}
			
			if(Dd('content_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"商品描述"不能为空'+"\n";
			}
			
			if(Dd('username_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"会员名"不能为空'+"\n";
			}
			
		}
		
		if(!back){
			str_alert+='请修改csv文件';
			alert(str_alert);
			window.location.href=str_url;
		}
		return back;
		
	}
	
	function resume_check(num,str_url){
				var back=true;
		//alert(Dd('send['+i+'][career]').value);
		str_alert='csv文件内容错误：'+"\n";
		for(var i=1;i<=num;i++){
			
			var catid_arr=['2118','2125','2127','2128','2136','2172','2277','2281','2283','2285','2286'];
			
			if(!checkInArr(Dd('catid_'+i).value,catid_arr)){
				str_alert+='行'+(i+1)+':"职位"错误值'+'\n';
				back=false;
			}
			
			
			if(Dd('title_'+i).value==''){
				str_alert+='行'+(i+1)+':"信息标题"不能为空'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('level_'+i).value,[0,1,2,3,4,5,6,7,8,9])){
				str_alert+='行'+(i+1)+':"级别"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('hangye_'+i).value,[1,2,3,4])){
				str_alert+='行'+(i+1)+':"行业"错误值'+"\n";
				back=false;
			}
			
			if(Dd('nplace_'+i).value==''){
				str_alert+='行'+(i+1)+':"籍贯"不能为空'+"\n";
				back=false;
			}
			
			if(Dd('photo_'+i).value!=''){
				if(!isPic(Dd('photo_'+i).value)){
					str_alert+='行'+(i+1)+':"免冠图片"格式只能为gif、jpg、png'+"\n";
					back=false;
				}
			}
			
			if(Dd('areaid_'+i).value==''){
				str_alert+='行'+(i+1)+':"工作地区"不能为空'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('type_'+i).value,[0,1,2,3])){
				str_alert+='行'+(i+1)+':"工作性质"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('gender_'+i).value,[1,2])){
				str_alert+='行'+(i+1)+':"性别要求"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('marriage_'+i).value,[1,2])){
				str_alert+='行'+(i+1)+':"婚姻要求"错误值'+"\n";
				back=false;
			}
			
			if(!isDate(Dd('birthday_'+i).value)){
				str_alert+='行'+(i+1)+':"生日"格式错误'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('education_'+i).value,[1,2,3,4,5,6])){
				str_alert+='行'+(i+1)+':"学历要求"错误值'+"\n";
				back=false;
			}
			
			if(!checkInArr(Dd('situtation_'+i).value,[0,1,2])){
				str_alert+='行'+(i+1)+':"求职状态"错误值'+"\n";
				back=false;
			}
			
			if(!isNum(Dd('experience_'+i).value)){
				str_alert+='行'+(i+1)+':"工作经验"需填写数字'+"\n";
				back=false;
			}
			
			if(!isMobile(Dd('mobile_'+i).value)){
				str_alert+='行'+(i+1)+':"联系电话"格式错误'+"\n";
				back=false;
			}
			
			if(!isEmail(Dd('email_'+i).value)){
				str_alert+='行'+(i+1)+':"电子邮件"格式错误'+"\n";
				back=false;
			}
			
			if(Dd('school_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"毕业院校"不能为空'+"\n";
			}
			
			if(Dd('content_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"商品描述"不能为空'+"\n";
			}
			
			if(Dd('truename_'+i).value==''){
				back=false;
				str_alert+='行'+(i+1)+':"会员名"不能为空'+"\n";
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
