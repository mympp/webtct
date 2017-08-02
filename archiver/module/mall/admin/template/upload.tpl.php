
<?php
/*
time:2015-5-8
who:陈韬
where：批量上传功能
what:修改表格标题、输入框宽度和按钮间隔
relation:/module/job/admin/upload.inc.php、/module/job/admin/download.inc.php
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
<!-- 上传商品 -->
<?php if($upload_type=='product') { ?>            
<form action="<?php echo "?moduleid=$moduleid&file=upload&action=insert&upload_type=product"; ?>" method="post" enctype="multipart/form-data" onsubmit="return check(<?php echo $num ?>,'<?php echo '?moduleid='.$moduleid; ?>')">
<input type="text" name="num" value="<?php echo $num; ?>" style="display:none;" />
<div style="margin-left:30px;">

</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th></th>
<th>商品分类</th>
<th>商品名称</th>
<th>商品图片1<br/>
<span>默认:</span><input type="file" name="default_photo_one" id="default_photo_one" /></th>
<th>商品图片2<br/>
<span>默认:</span><input type="file" name="default_photo_two" id="default_photo_two" /></th>
<th>商品图片3<br/>
<span>默认:</span><input type="file" name="default_photo_three" id="default_photo_three" /> </th>
<th>会员名</th>
</tr>
<?php foreach($result as $k=>$v) {
	if($k==0){
		continue;
	}	
?>

<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><?php echo $k; ?></td>
<td><input type="text" id="<?php echo 'catid_'.$k; ?>" name="<?php echo "post[$k][catid]"; ?>" value="<?php echo $v[0]; ?>" />
<input type="hidden" id="<?php echo 'level_'.$k; ?>" name="<?php echo "post[$k][level]"; ?>" value="<?php echo $v[2]; ?>" />
</td>
<td><input type="text" id="<?php echo 'title_'.$k; ?>" name="<?php echo "post[$k][title]"; ?>" value="<?php echo $v[1]; ?>" />
<input type="hidden" id="<?php echo 'price_'.$k; ?>" name="<?php echo "post[$k][price]]"; ?>" value="<?php echo $v[3]; ?>" />
<input type="hidden" id="<?php echo 'amount_'.$k; ?>" name="<?php echo "post[$k][amount]"; ?>" value="<?php echo $v[4]; ?>" />
</td>
<td><input type="file" id="<?php echo 'photo_one_'.$k; ?>" name="<?php echo "photo_one_".$k; ?>" /><br/><?php echo $v[5]; ?>
<input type="hidden" id="<?php echo 'content_'.$k; ?>" name="<?php echo "post[$k][content]"; ?>" value="<?php echo $v[8]; ?>" />
</td>
<td><input type="file" id="<?php echo 'photo_two_'.$k; ?>" name="<?php echo "photo_two_".$k; ?>" /><br/><?php echo $v[6]; ?>
</td>
<td><input type="file" id="<?php echo 'photo_three_'.$k; ?>" name="<?php echo "photo_three_".$k; ?>"  /><br/><?php echo $v[7]; ?>
</td>
<td><input type="text" id="<?php echo 'username_'.$k; ?>" name="<?php echo "post[$k][username]"; ?>" value="<?php echo $v[9]; ?>" />
<input type="hidden" id="<?php echo 'brand_'.$k; ?>" name="<?php echo "post[$k][brand]"?>" value="<?php echo $v[10]; ?>" />
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
			//alert(v);
			//alert(arr[a]);
			if(v==arr[a]){
				//alert(v);
				//alert('true:'+arr[a]);
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
	
	
	function check(num,str_url){
		
		var back=true;
		//alert(Dd('send['+i+'][career]').value);
		str_alert='csv文件内容错误：'+"\n";
		for(var i=1;i<=num;i++){
			
			var catid_arr=[];
			for(var j=1170;j<1485;j++){
				catid_arr.push(j.toString());
			}
			catid_arr.push('2005');
			catid_arr.push('2006');
			catid_arr.push('1027');
			catid_arr.push('1159');
			catid_arr.push('1132');
			catid_arr.push('1133');
			catid_arr.push('2014');
			catid_arr.push('2015');
			catid_arr.push('2016');
			
			if(!checkInArr(Dd('catid_'+i).value,catid_arr)){
				str_alert+='行'+(i+1)+':"商品分类"错误值'+'\n';
				back=false;
			}
			
			if(Dd('title_'+i).value==''){
				str_alert+='行'+(i+1)+':"商品名称"不能为空'+'\n';
				back=false;
			}
			
			if(!checkInArr(Dd('level_'+i).value,[0,1,2,3,4,5,6,7,8,9])){
				str_alert+='行'+(i+1)+':"级别"错误值'+"\n";
				back=false;
			}
			
			if(Dd('price_'+i).value==''){
				str_alert+='行'+(i+1)+':"商品价格"不能为空'+'\n';
				back=false;
			}
			
			if(Dd('amount_'+i).value==''){
				str_alert+='行'+(i+1)+':"商品库存"错误值'+'\n';
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
		var photo_alert='';
		var photo_state=true;
		var is_default_one=false;
		var is_default_two=false;
		var is_default_three=false;
		if(Dd('default_photo_one').value!=''){
			if(!isPic(Dd('default_photo_one').value)){
				photo_state=false;
				photo_alert+="默认商品图片1格式只能jpg,gif,png"+"\n";
			}else{
				is_default_one=true;        //默认图片1有图片上传
			}
		}
		if(Dd('default_photo_two').value!=''){
			if(!isPic(Dd('default_photo_two').value)){
				photo_state=false;
				photo_alert+="默认商品图片2格式只能jpg,gif,png"+"\n";
			}else{
				is_default_two=true;        //默认图片2有图片上传
			}
		}
		if(Dd('default_photo_three').value!=''){
			if(!isPic(Dd('default_photo_three').value)){
				photo_state=false;
				photo_alert+="默认商品图片3格式只能jpg,gif,png"+"\n";
			}else{
				is_default_three=true;        //默认图片3有图片上传
			}
		}
		for(var i=1;i<=num;i++){
			if(Dd('photo_one_'+i).value==''&&Dd('photo_two_'+i).value==''&&Dd('photo_three_'+i).value==''&&!is_default_one&&!is_default_two&&!is_default_three){
				photo_state=false;
				photo_alert+='商品"'+Dd('title_'+i).value+'"未选择图片'+"\n";
			}else{
				if(Dd('photo_one_'+i).value!=''){
					if(!isPic(Dd('photo_one_'+i).value)){
						photo_state=false;
						photo_alert+='商品"'+Dd('title_'+i).value+'":"商品图片1"格式只能jpg,gif,png'+"\n";
					}
				}
			
				if(Dd('photo_two_'+i).value!=''){
					if(!isPic(Dd('photo_two_'+i).value)){
						back=false;
						photo_alert+='商品"'+Dd('title_'+i).value+'":"商品图片2"格式只能jpg,gif,png'+"\n";
					}
				}
			
				if(Dd('photo_three_'+i).value!=''){
					if(!isPic(Dd('photo_three_'+i).value)){
						back=false;
						photo_alert+='商品"'+Dd('title_'+i).value+'":"商品图片3"格式只能jpg,gif,png'+"\n";
					}
				}
			}
		}
		
		if(!photo_state){
			alert(photo_alert);
			return false;
		}
		
		return back;
		
	}
</script>
<?php
include tpl('footer');

?>
