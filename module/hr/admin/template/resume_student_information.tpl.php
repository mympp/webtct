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
	//添加学生信息
	$(function(){
		 $("#getAtable_2").click(function(){
			var tab='';
			tab+='<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='<tr><td height="80">开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t3_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]"/>&nbsp;<span id="t3_1" style="color:red;">*</span></td></tr>';
			tab+='<tr><td height="40"><select name="post[sn_category][]" id="sn_category"><option value="0">获得奖励</option><option value="1">校内职务</option><option value="2">实践名称</option></select></td><td colspan="3"><input size="25" type="text" id="s_value" name="post[value][]"/><span id="t3_2" style="color:red;">&nbsp;*</span></td></tr>';
			tab+='<tr><td height="100">描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="s_practice" name="post[practice][]"></textarea></td></tr>';
			tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveStudent(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="0" id="isUpdataId"/></td></tr>';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='</table>';
			$("#getAtable_2").attr("disabled",true);
			$("#addtable_2").append(tab); 
		});
	});
	//保存学生信息
	function saveStudent(i){
		var par=$(i).parent().parent().parent().parent();
		//获取表单数据
		var start_time=$(par).find("#mh_date_1").val();
		var stop_time=$(par).find("#mh_date_2").val();
		var sn_category=$(par).find("#sn_category").val();
		var s_value=$(par).find("#s_value").val();
		var s_practice=$(par).find("#s_practice").val();
		var information_id=$("#information_id").val();
		//数据类型判断 0代表获得奖励 1代表校内职务 2代表实践经验
		if(sn_category==0){
			var v_category="获得奖励";
		}else if(sn_category==1){
			var v_category="校内职务";
		}else if(sn_category==2){
			var v_category="实践名称";
		}
		//自增长id,默认为0
		var isUpdataId=$(par).find("#isUpdataId").val();
		if(isUpdataId==0){
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=insert_student_information',
				data:'start_time='+start_time+'&stop_time='+stop_time+'&category='+sn_category+'&value='+s_value+'&practice='+s_practice+'&information_id='+information_id,
				dataType:'text',
				success:function(msg){
						if(msg=='00'){
							
							$(par).find("#t3_0").html("&nbsp;&nbsp;开始时间不能为空！");
							return false;
						}else if(msg=='01'){
							alert(1);
							$(par).find("#t3_0").html("");
							$(par).find("#t3_1").html("&nbsp;&nbsp;结束时间不能为空！");
							return false;
						}else if(msg=='02'){
							
							$(par).find("#t3_0").html("");
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("&nbsp;&nbsp;该项不能为空！");
							return false;
						}else if(msg=='05'){	
							
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("");						
							$(par).find("#t3_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
							return false;
						}else{	
							var information_num=parseInt($("#information_num").val())+1;
							$("#information_num").val(information_num);
							if(information_num<8){
								$("#getAtable_2").attr("disabled",false);
							}else{
								$("#getAtable_2").attr("disabled",true);
							}					
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("");
							$(par).find("#t3_0").html("");
							$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
							$("#tabA_2").css("display","block");
							information_id+=msg;
							$("#information_id").val(information_id);
							var tr="";
							tr+="<tfoot><td>";
							tr+='<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">';
							tr+='<tr align="left"><td width="350" id="t_time">'+start_time+'至'+stop_time+'</td><td align="center" style="border-left:0px;" width="500" id="t_category">'+v_category+'</td><td style="border-left:0px;" width="400" id="t_value">'+s_value+'</td><td style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1" width="160"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" onclick="getAlter(this);">修改</a><input type="hidden" id="insert_id" value="'+msg+'"/><input type="hidden" id="s_action" value="del_student_information"/></td></tr>';
							tr+='</table>';
							tr+="</td></tfoot>";
							$(par).append(tr);
							$(par).find("#isUpdataId").val(msg);
						}
					
				}
			});
		}else{
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=update_student_information',
				data:'id='+isUpdataId+'&start_time='+start_time+'&stop_time='+stop_time+'&category='+sn_category+'&value='+s_value+'&practice='+s_practice,
				dataType:'text',
				success:function(msg){
					if(msg=='00'){
							$(par).find("#t3_0").html("&nbsp;&nbsp;开始时间不能为空！");
							return false;
						}else if(msg=='01'){
							$(par).find("#t3_0").html("");
							$(par).find("#t3_1").html("&nbsp;&nbsp;结束时间不能为空！");
							return false;
						}else if(msg=='02'){
							$(par).find("#t3_0").html("");
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("&nbsp;&nbsp;该项不能为空！");
							return false;
						}else if(msg=='05'){
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("");
							$(par).find("#t3_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
							return false;
						}else{
							$(par).find("#t3_1").html("");
							$(par).find("#t3_2").html("");
							$(par).find("#t3_0").html("");
							Dalert(msg);
							$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
							var tr_1=$(i).parent().parent().parent().parent().find("tfoot");
							$(tr_1).find("#t_time").html(start_time+'至'+stop_time);
							$(tr_1).find("#t_category").html(v_category);
							$(tr_1).find("#t_value").html(s_value);
							$(tr_1).find("#click_event_1").attr("onclick","getAlter(this);");
							$(tr_1).css("display","");
						}			
				}
			});	
		}
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
			var information_id=$("#information_id").val();
			$(par).remove();
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type='+action,
				data:'id='+id+'&itemid='+itemid+'&information_id='+information_id,
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
						var information_num=parseInt($("#information_num").val())-1;
						$("#information_num").val(information_num);
						if(information_num<8){
							$("#getAtable_2").attr("disabled",false);
						}
						var in_id=$("#information_id");
						in_id.val(in_id.val().replace(id,''));
						Dalert("删除成功！");
					}else if(msg=='train'){
						var tr_id=$("#train_id");
						tr_id.val(tr_id.val().replace(id,''));
						alert("删除成功");
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
	//查看,编辑学生信息能力
	//查看，编辑学生信息
	function getAlterStudent(i){
		var par=$(i).parent().parent().parent().parent();
		var start_time=$(par).find("#t_start_time").val();
		var stop_time=$(par).find("#t_stop_time").val();
		var category=$(par).find("#t_category").html();
		if(category=="获得奖励"){
			var o_value=0;
		}else if(category=="校内职务"){
			var o_value=1;
		}else if(category=="实践名称"){
			var o_value=2;
		}
		var value=$(par).find("#t_value").html();
		var practice=$(par).find("#t_practice").val();
		var id=$(par).find("#insert_id").val();
		var tab="";
		tab+="<tbody>";
		tab+='<tr><td>开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]" value="'+start_time+'"/>&nbsp;<span id="t3_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]" value="'+stop_time+'"/>&nbsp;<span id="t3_1" style="color:red;">*</span></td></tr>';
		tab+='<tr><td><select name="post[sn_category][]" id="sn_category"><option value="'+o_value+'">'+category+'</option><option value="0">获得奖励</option><option value="1">校内职务</option><option value="2">实践名称</option></select></td><td colspan="3"><input size="25" type="text" id="s_value" name="post[value][]" value="'+value+'"/><span id="t3_2" style="color:red;">&nbsp;*</span></td></tr>';
		tab+='<tr><td>描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="s_practice" name="post[practice][]">'+practice+'</textarea>&nbsp;<span id="t3_4" style="color:red;">*</span></td></tr>';
		tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveStudent(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="'+id+'" id="isUpdataId"/></td></tr>';
		tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
		tab+="</tbody>";
		$(par).parent().parent().parent().css("display","none");
		$(par).parent().parent().parent().parent().append(tab);
	}
//日历插件
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
<style type="text/css">
	#td_01{
		border:1px solid #639ccc;
		color:#000;
		padding-left:10px;
	}
	#td_01_1,#t_time,#t_school_name,#t_major,#t_education,#t_category,#t_value{
		border-bottom:1px solid #639ccc;
		border-left:1px solid #639ccc;
		color:#000;
		padding-left:10px;
	}
</style>
<?php $information_id=$_SESSION['information_id'];?>
<input type="hidden" id="information_id" value="<?php echo $_SESSION['information_id'];?>"/>
<input type="hidden" id="information_num" value="<?php echo count(explode(',',$information_id))-1;?>"/>
<input type="hidden" id="itemid" value="<?php echo $itemid;?>"/>
<div id="addtable_2" style="color:#7aabd8;width:950px;margin:0 auto;margin-top:40px;">
	<?php if($information_id){$information_id=trim($information_id,',');$arr=explode(',',$information_id);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;">
			<tr align="center"><td id="td_01" width="350" bgcolor="#e4f0fa" style="border-left:1px solid #639ccc;">时间</td><td style="border-left:0px;" width="500" id="td_01" bgcolor="#e4f0fa">类别</td><td style="border-left:0px;" id="td_01" width="400" bgcolor="#e4f0fa">内容</td><td style="border-left:0px;" id="td_01" width="160" bgcolor="#e4f0fa">操作</td></tr>
		</table>
		<?php foreach($arr as $v){$sql="select * from {$db->pre}hr_resume_student_information where information_id=$v";$value=$db->get_one($sql);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left">
			<tfoot>
			<td>
				<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">
					<tr align="left"><td width="350" id="t_time"><?php echo $value['start_time']?>至<?php echo $value['stop_time']?></td><td align="center" style="border-left:0px;" width="500" id="t_category"><?php if($value['sn_category']==0){echo "获得奖励";}else if($value['sn_category']==1){echo "校内职务";}else if($value['sn_category']==2){echo "实践名称";}?></td><td style="border-left:0px;" width="400" id="t_value"><?php echo $value['value']?></td><td style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1" width="160"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a id="click_event_1" style="color:blue;cursor:pointer;" onclick="getAlterStudent(this);">修改</a><input type="hidden" id="insert_id" value="<?php echo $value['information_id']?>,"/><input type="hidden" id="s_action" value="del_student_information"/><input type="hidden" id="t_start_time" value="<?php echo $value['start_time']?>"/><input type="hidden" id="t_stop_time" value="<?php echo $value['stop_time']?>"/><input type="hidden" id="t_practice" value="<?php echo $value['practice']?>"/></td></tr>
				</table>
			</td>
			</tfoot>
		</table>
	<?php }}else{?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;display:none;" id="tabA_2">
			<tr align="center"><td id="td_01" width="350" bgcolor="#e4f0fa" style="border-left:1px solid #329ef9;">时间</td><td style="border-left:0px;" width="500" id="td_01" bgcolor="#e4f0fa">类别</td><td style="border-left:0px;" id="td_01" width="400" bgcolor="#e4f0fa">内容</td><td style="border-left:0px;" id="td_01" width="160" bgcolor="#e4f0fa">操作</td></tr>
		</table>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">
			<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
			<tr><td height="80">开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t3_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]"/>&nbsp;<span id="t3_1" style="color:red;">*</span></td></tr>
			<tr><td height="40"><select name="post[sn_category][]" id="sn_category"><option value="0">获得奖励</option><option value="1">校内职务</option><option value="2">实践名称</option></select><span style="color:red;">*</span></td><td colspan="3"><input size="25" type="text" id="s_value" name="post[value][]"/><span id="t3_2" style="color:red;"></span></td></tr>
			<tr><td height="100">描述</td><td colspan="3"><textarea id="s_practice" name="post[practice][]" style="width:582px;height:50px;"></textarea></td></tr>
			<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick='saveStudent(this)' value="保存"/>&nbsp;&nbsp;&nbsp;<input type='button' class="btn" value='删除' onClick='getDel(this)'/><input type="hidden" value="0" id="isUpdataId"/></td></tr>
			<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
		</table>
	<?php }?>
</div>
<div style="width:90%;text-align:center;float:left;margin-top:20px;"><a href="#bottom_2"><input class="btn" type="button" <?php if(count(explode(',',$information_id))-1<8){echo "";}else{echo "disabled=true";}?> value="+继续添加" id="getAtable_2"/></a><a name="bottom_2" id="bottom_2"></a></div>