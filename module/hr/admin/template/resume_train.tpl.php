<?php
/*
time:2016-1-8
who:周创杰
where:人才网新增模块
relation:module\hr\admin\template\resume_education.tpl.php,module\hr\admin\template\resume_experience.tpl.php,module\hr\admin\template\resume_language.tpl.php,module\hr\admin\template\resume_student_information.tpl.php,module\hr\admin\template\resume_train.tpl.php,
*/
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<style type="text/css">
.calender{ width:255px; margin:50px auto; top:0; left:0; border:4px #D6D6D6 solid; background:#EBEBEB; position:absolute; display:none; z-index:999;}
.calendertb{width:100%;}
.calendertb td{width:35px; height:35px;border:1px #CCCCCC solid; text-align:center; vertical-align:middle; cursor:pointer; font-size:14px; font-weight:bold;}
.calendertb td.hover,.calendertb td.weekendhover{background:#D6D6D6;}
.calendertb th{width:35px; height:30px;border:1px #CCCCCC solid; text-align:center; vertical-align:middle; cursor:pointer; color:#979797; }
.tdtoday{ background:#0080FF;color:#fff;width:35px; height:35px;border:1px #CCCCCC solid; text-align:center; vertical-align:middle; cursor:pointer; font-size:14px; font-weight:bold;}
.getyear{ height:35px; line-height:35px; width:100%; text-align:center;}
.preMonth{ font-size:14px; font-weight:bold; cursor:pointer; margin-right:18px;color:#0080FF;}
.nextMonth{ font-size:14px; font-weight:bold; cursor:pointer; margin-left:18px;color:#0080FF;}
#mh_date_1{width:165px; height:12px; line-height:20px; padding:5px; border:1px #abadb3 solid; cursor:pointer; background:url("/file/image/dateIco.png") no-repeat right center;}
#mh_date_2{width:165px; height:12px; line-height:20px; padding:5px; border:1px #abadb3 solid; cursor:pointer; background:url("/file/image/dateIco.png") no-repeat right center;}
.zhezhao{width:100%; height:100%; position:fixed; z-index:998;	background:#fff;filter:alpha(opacity=10);opacity:0.1; display:none; }
table{line-height:30px;}
</style>
<script type="text/javascript" src="/file/script/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="file/script/manhuaDate.1.0.js"></script>
<script type="text/javascript">
	//添加培训经历
	$(function(){
		 $("#getAtable_3").click(function(){
			var tab='';
			tab+='<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='<tr><td height="80">开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t4_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]"/>&nbsp;<span id="t4_1" style="color:red;">*</span></td></tr>';
			tab+='<tr><td height="50">机构名称</td><td><input size="22" type="text" id="school_name" name="post[school_name][]"/>&nbsp;<span id="t4_2" style="color:red;">*</span></td><td>课程</td><td><input size="22" id="s_major" type="text" name="post[s_major][]"/>&nbsp;<span id="t4_3" style="color:red;">*</span></td></tr>';
			tab+='<tr><td height="50">证书</td><td><input size="22" type="text" id="s_education" name="post[s_education][]"/>&nbsp;<span id="t4_4" style="color:red;">*</span></td><td>地址</td><td><input type="text" size="22" id="s_address" name="post[s_address][]"/></td></tr>';
			tab+='<tr><td height="100">描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="ed_describe" name="post[ed_describe][]"></textarea></td></tr>';
			tab+='<tr align="center"><td colspan="4" ><input type="button" class="btn" id="submit_save" onClick="saveTrain(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="0" id="isUpdataId"/></td></tr>';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='</table>';
			$("#addtable_3").append(tab); 
			$("#getAtable_3").attr("disabled",true);
		});
	});
	//保存培训经历
	function saveTrain(i){
		var par=$(i).parent().parent().parent().parent();
		//获取表单数据
		var start_time=$(par).find("#mh_date_1").val();
		var stop_time=$(par).find("#mh_date_2").val();
		var school_name=$(par).find("#school_name").val();
		var s_major=$(par).find("#s_major").val();
		var s_education=$(par).find("#s_education").val();
		var s_address=$(par).find("#s_address").val();
		var ed_describe=$(par).find("#ed_describe").val();
		var train_id=$("#train_id").val();
		//自增长id,默认为0
		var isUpdataId=$(par).find("#isUpdataId").val();
		//判断用户动作(新增还是修改)
		//新增
		if(isUpdataId==0){
			//利用ajaxa进去数据库操作
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=add_train',
				data:'start_time='+start_time+'&stop_time='+stop_time+'&school_name='+school_name+'&s_major='+s_major+'&s_education='+s_education+'&s_address='+s_address+'&ed_describe='+ed_describe+'&train_id='+train_id,
				dataType:'text',
				success:function(msg){
					if(msg=='00'){
						$(par).find("#t4_0").html("&nbsp;&nbsp;开始时间不能为空！");
						return false;
					}else if(msg=='01'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("&nbsp;&nbsp;结束时间不能为空！");
						return false;
					}else if(msg=='02'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("&nbsp;&nbsp;机构名称不能为空！");
						return false;
					}else if(msg=='03'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("&nbsp;&nbsp;课程不能为空！");
						return false;
					}else if(msg=='04'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_4").html("&nbsp;&nbsp;证书不能为空！");
						return false;
					}else if(msg=='05'){
						$(par).find("#t4_4").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
						return false;
					}else{
						var train_num=parseInt($("#train_num").val())+1;
						$("#train_num").val(train_num);
						if(train_num<5){
							$("#getAtable_3").attr("disabled",false);
						}else{
							$("#getAtable_3").attr("disabled",true);
						}
						$(par).find("#t4_4").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_0").html("");
						$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
						$("#tabA_3").css("display","block");
						train_id+=msg;
						$("#train_id").val(train_id);
						var tab="";
						tab+="<tfoot><td>";
						tab+='<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">';
						tab+='<tr align="left"><td width="310" id="t_time">'+start_time+'至'+stop_time+'</td><td style="border-left:0px;" width="400" id="t_school_name">'+school_name+'</td><td style="border-left:0px;" width="400" id="t_major">'+s_major+'</td><td style="border-left:0px;" width="300" id="t_education">'+s_education+'</td><td style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1" width="160"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" onclick="getAlter(this);">修改</a><input type="hidden" id="insert_id" value="'+msg+'"/><input type="hidden" id="s_action" value="del_train"/></td></tr>';
						tab+="</table>";
						tab+='</table>';
						tab+="</td></tfoot>"
						$(par).append(tab);
						$(par).find("#isUpdataId").val(msg);
					}
				}
			});
		}else{//修改
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=update_train',
				data:'id='+isUpdataId+'&start_time='+start_time+'&stop_time='+stop_time+'&school_name='+school_name+'&s_major='+s_major+'&s_education='+s_education+'&s_address='+s_address+'&ed_describe='+ed_describe,
				dataType:'text',
				success:function(msg){
					if(msg=='00'){
						$(par).find("#t4_0").html("&nbsp;&nbsp;开始时间不能为空！");
						return false;
					}else if(msg=='01'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("&nbsp;&nbsp;结束时间不能为空！");
						return false;
					}else if(msg=='02'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("&nbsp;&nbsp;机构名称不能为空！");
						return false;
					}else if(msg=='03'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("&nbsp;&nbsp;课程不能为空！");
						return false;
					}else if(msg=='04'){
						$(par).find("#t4_0").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_4").html("&nbsp;&nbsp;证书不能为空！");
						return false;
					}else if(msg=='05'){
						$(par).find("#t4_4").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
						return false;
					}else{
						$(par).find("#t4_4").html("");
						$(par).find("#t4_1").html("");
						$(par).find("#t4_2").html("");
						$(par).find("#t4_3").html("");
						$(par).find("#t4_0").html("");
						Dalert(msg);
						$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
						var tr_1=$(i).parent().parent().parent().parent().find("tfoot");
						$(tr_1).find("#t_time").html(start_time+'至'+stop_time);
						$(tr_1).find("#t_school_name").html(school_name);
						$(tr_1).find("#t_major").html(s_major);
						$(tr_1).find("#t_education").html(s_education);
						$(tr_1).find("#click_event_2").attr("onclick","getAlter(this);");
						$(tr_1).css("display","");
					}
				}
			});	
		}
	}
	//查看,编辑培训经历
	function getAlterTrain(i){
		var par=$(i).parent().parent().parent().parent();
		var start_time=$(par).find("#t_start_time").val();
		var stop_time=$(par).find("#t_stop_time").val();
		var school_name=$(par).find("#t_school_name").html();
		var major=$(par).find("#t_major").html();
		var education=$(par).find("#t_education").html();
		var address=$(par).find("#t_address").val();
		var ed_describe=$(par).find("#ed_describe").val();
		var id=$(par).find("#insert_id").val();
		var tab="";
		tab+="<tbody>";
		tab+='<tr><td>开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]" value="'+start_time+'"/>&nbsp;<span id="t4_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]" value="'+stop_time+'"/>&nbsp;<span id="t4_1" style="color:red;">*</span></td></tr>';
		tab+='<tr><td>机构名称</td><td><input size="22" type="text" id="school_name" name="post[school_name][]" value="'+school_name+'"/>&nbsp;<span id="t4_2" style="color:red;">*</span></td><td>课程</td><td><input size="22" id="s_major" type="text" name="post[s_major][]" value="'+major+'"/>&nbsp;<span id="t4_3" style="color:red;">*</span></td></tr>';
		tab+='<tr><td>证书</td><td><input size="22" type="text" id="s_education" name="post[s_education][]" value="'+education+'"/>&nbsp;<span id="t4_4" style="color:red;">*</span></td><td>地址</td><td><input type="text" size="22" id="s_address" name="post[s_address][]" value="'+address+'"/></td></tr>';
		tab+='<tr><td>描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="ed_describe" name="post[ed_describe][]">'+ed_describe+'</textarea></td></tr>';
		tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveTrain(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="'+id+'" id="isUpdataId"/></td></tr>';
		tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
		tab+="</tbody>";
		$(par).parent().parent().parent().css("display","none");
		$(par).parent().parent().parent().parent().append(tab);
	}
	//修改
	function getAlter(i){
		var par=$(i).parent().parent().parent().parent().parent().parent().parent().parent();
		$(par).find("tfoot").css("display","none");
		$(par).find("tbody").css("display","");
	}
	//删除可编辑表单(此时尚未进行数据库操作)
	function getDel(k){
		$(k).parent().parent().parent().parent().remove();
	}
	//删除表格(此时表单中的数据已录入数据库),删除的同时，将数据库中的数据也删除
	function getDel_1(k){
		if (confirm("确认要删除？此操作将不可撤销")) { 
           var par=$(k).parent().parent().parent().parent().parent().parent().parent();
			//获取要删除的数据的id
			var id=$(par).find("#insert_id").val();
			//要操作的数据库
			var action=$(par).find("#s_action").val();
			var itemid=$("#itemid").val();
			var train_id=$("#train_id").val();
			$(par).remove();
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type='+action,
				data:'id='+id+'&itemid='+itemid+'&train_id='+train_id,
				success:function(msg){
					//判断删除的数据(为教育经历,还是为工作经历等等)
					if(msg=='education'){
						var ed_id=$("#education_id");
						ed_id.val(ed_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=='experience'){
						var ex_id=$("#experience_id");
						ex_id.val(ex_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=="student_information"){
						var in_id=$("#information_id");
						in_id.val(in_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=='train'){
						var train_num=parseInt($("#train_num").val())-1;
						$("#train_num").val(train_num);
						if(train_num<5){
							$("#getAtable_3").attr("disabled",false);
						}
						var tr_id=$("#train_id");
						tr_id.val(tr_id.val().replace(id,''));
						Dalert("删除成功！");
					}else if(msg=="language"){
						var lg_id=$("#language_id");
						lg_id.val(lg_id.val().replace(id,''));
						alert("删除成功");
					}else{
						alert("删除失败");
					}
				}
			});
        } 
		
	}
	$(function (){
		$("input#mh_date_1").manhuaDate({					       
			Event : "click",//可选				       
			Left : 0,//弹出时间停靠的左边位置
			Top : -16,//弹出时间停靠的顶部边位置
			fuhao : "-",//日期连接符默认为-
			isTime : false,//是否开启时间值默认为false
			//beginY : 2000,//年份的开始默认为1949
			//endY :2045//年份的结束默认为2049
		});	
		$("input#mh_date_2").manhuaDate({					       
			Event : "click",//可选				       
			Left : 0,//弹出时间停靠的左边位置
			Top : -16,//弹出时间停靠的顶部边位置
			fuhao : "-",//日期连接符默认为-
			isTime : false,//是否开启时间值默认为false
			//beginY : 2000,//年份的开始默认为1949
			//endY :2045//年份的结束默认为2049
		});	
	});
</script>
<!--教育经历-->
<style type="text/css">
	#td_01{
		border:1px solid #639ccc;
		color:#000;
		padding-left:10px;
	}
	#td_01_1,#t_time,#t_school_name,#t_major,#t_education,#t_rewards,#t_position{
		border-bottom:1px solid #639ccc;
		border-left:1px solid #639ccc;
		color:#000;
		padding-left:10px;
	}
</style>

<?php $train_id=$_SESSION['train_id'];?>
<input type="hidden" id="train_id" value="<?php echo $_SESSION['train_id'];?>"/>
<input type="hidden" id="train_num" value="<?php echo count(explode(',',$train_id))-1;?>"/>
<input type="hidden" id="itemid" value="<?php echo $itemid;?>"/>
<div id="addtable_3" style="color:#7aabd8;width:950px;margin:0 auto;margin-top:30px;">
	<?php if($train_id){$train_id=trim($train_id,',');$arr=explode(',',$train_id);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;">
			<tr align="center"><td id="td_01" width="310" bgcolor="#e4f0fa" style="border-left:1px solid #639ccc;">时间</td><td style="border-left:0px;" width="400" id="td_01" bgcolor="#e4f0fa">机构名称</td><td width="400" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">课程</td><td style="border-left:0px;" width="300" id="td_01" bgcolor="#e4f0fa">证书</td><td width="160" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">操作</td></tr>
		</table>
	<?php foreach($arr as $v){$sql="select * from {$db->pre}hr_resume_education where education_id=$v";$value=$db->get_one($sql);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">
			<tfoot>
				<td>
					<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">
						<tr align="left"><td width="310" id="t_time"><?php echo $value['start_time']?>至<?php echo $value['stop_time']?></td><td style="border-left:0px;" width="400" id="t_school_name"><?php echo $value['school_name']?></td><td style="border-left:0px;" width="400" id="t_major"><?php echo $value['major']?></td><td style="border-left:0px;" width="300" id="t_education"><?php echo $value['education']?></td><td style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1" width="160"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<input type="hidden" value="<?php echo $value['address']?>" id="t_address"/><input type="hidden" value="<?php echo $value['start_time']?>" id="t_start_time"/><input type="hidden" value="<?php echo $value['stop_time']?>" id="t_stop_time"/><input type="hidden" value="<?php echo $value['ed_describe']?>" id="ed_describe"/><a style="color:blue;cursor:pointer;" id="click_event_2" onclick="getAlterTrain(this);">修改</a><input type="hidden" id="insert_id" value="<?php echo $value['education_id']?>,"/><input type="hidden" id="s_action" value="del_train"/></td></tr>
					</table>
				</td>
			</tfoot>
		</table>
		<?php }}else{?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;display:none;" id="tabA_3">
			<tr align="center"><td id="td_01" align="center" width="310" bgcolor="#e4f0fa" style="border-left:1px solid #639ccc;">时间</td><td style="border-left:0px;" width="400" id="td_01" bgcolor="#e4f0fa" align="center">机构名称</td><td width="400" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa" align="center">课程</td><td style="border-left:0px;" width="300" id="td_01" bgcolor="#e4f0fa" align="center">证书</td><td width="160" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa" align="center">操作</td></tr>
		</table>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">
				<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
				<tr><td height="80">开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t4_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]"/>&nbsp;<span id="t4_1" style="color:red;">*</span></td></tr>
				<tr><td height="50">机构名称</td><td><input size="22" type="text" id="school_name" name="post[school_name][]"/>&nbsp;<span id="t4_2" style="color:red;">*</span></td><td>课程</td><td><input size="22" id='s_major' type="text" name="post[s_major][]"/>&nbsp;<span id="t4_3" style="color:red;">*</span></td></tr>
				<tr>
					<td height="50">证书</td><td><input size="22" type="text" id="s_education" name="post[s_education][]"/>&nbsp;<span id="t4_4" style="color:red;">*</span></td>
					<td>地址</td>
					<td><input type="text" size="22" id="s_address" name="post[s_address][]"/></td>
				</tr>
				<tr>
					<td height="100">描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="ed_describe" name="post[ed_describe][]"></textarea></td>
				</tr>
				<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick='saveTrain(this)' value="保存"/>&nbsp;&nbsp;&nbsp;<input type='button' class="btn" value='删除' onClick='getDel(this)'/><input type="hidden" value="0" id="isUpdataId"/></td></tr>
				<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
		</table>
	<?php }?>
</div>
<div style="width:90%;text-align:center;float:left;margin-top:20px;"><a href="#bottom_3"><input class="btn" <?php if(count(explode(',',$train_id))-1<4){echo "";}else{echo "disabled=true";}?> type="button" value="+继续添加" id="getAtable_3"/></a><a name="bottom_3" id="bottom_3"></a></div>