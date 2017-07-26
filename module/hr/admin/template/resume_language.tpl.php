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
<script type="text/javascript" src="/file/script/manhuaDate.1.0.js"></script>
<script type="text/javascript">
	//添加语言能力
	$(function(){
		 $("#getAtable_4").click(function(){
			var tab='';
			tab+='<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='<tr><td height="80" width="100">语言类别</td><td><select id="s_catetory" name="post[catetory][]"><option>英语</option><option>日语</option><option>俄语</option><option>阿拉伯语</option><option>法语</option><option>德语</option><option>西班牙语</option><option>葡萄牙语</option><option>意大利语</option><option>韩语/朝鲜语</option><option>普通话</option><option>粤语</option><option>闽南语</option><option>上海话</option><option>其它</option></select></td><td width="100">掌握程度</td><td><select id="s_grasp" name="post[grasp][]"><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td></tr>';
			tab+='<tr><td height="40">读写能力</td><td><select id="read_write" name="post[read_write][]"><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td><td>听说能力</td><td><select id="hear_of" name="post[hear_of][]"><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td></tr>';
			tab+='<tr><td  height="60">英语等级</td><td><select id="s_grade" name="post[grade][]"><option>未参加</option><option>四级</option><option>六级</option><option>专业四级</option><option>专业八级</option></select></td></tr>';
			tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveLanguage(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="0" id="isUpdataId"/></td></tr>';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>';
			tab+='</table>';
			$("#addtable_4").append(tab); 
			$("#getAtable_4").attr("disabled",true);
		});
	});
	//保存语言能力
	function saveLanguage(i){
		var par=$(i).parent().parent().parent().parent();
		//获取表单数据
		var catetory=$(par).find("#s_catetory").val();
		var grasp=$(par).find("#s_grasp").val();
		var r_write=$(par).find("#read_write").val();
		var l_say=$(par).find("#hear_of").val();
		var grade=$(par).find("#s_grade").val();
		var language_id=$("#language_id").val();
		//自增长id,默认为0
		var isUpdataId=$(par).find("#isUpdataId").val();
		//判断用户动作(新增还是修改)
		//新增
		if(isUpdataId==0){
			//利用ajaxa进去数据库操作
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=add_language',
				data:'catetory='+catetory+'&grasp='+grasp+'&r_write='+r_write+'&l_say='+l_say+'&grade='+grade+'&language_id='+language_id,
				dataType:'text',
				success:function(msg){
					$("#tabA_4").css("display","block");
					$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
					var language_num=parseInt($("#language_num").val())+1;
					$("#language_num").val(language_num);
					if(language_num<5){
						$("#getAtable_4").attr("disabled",false);
					}else{
						$("#getAtable_4").attr("disabled",true);
					}
					language_id+=msg;
					$("#language_id").val(language_id);
					var tab="";
					tab+="<tfoot><td>";
					tab+='<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">';
					tab+='<tr align="center"><td width="300" id="t_catetory">'+catetory+'</td><td width="300" style="border-left:0px;" id="t_grasp">'+grasp+'</td><td width="300" style="border-left:0px;" id="t_write">'+r_write+'</td><td width="300" style="border-left:0px;" id="t_say">'+l_say+'</td><td width="300" style="border-left:0px;" id="t_grade">'+grade+'</td><td width="300" style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" onclick="getAlter(this);" >修改</a><input type="hidden" id="insert_id" value="'+msg+'"/><input type="hidden" id="s_action" value="del_language"/></td></tr>';
					tab+="</table>";
					tab+="</td></tfoot>";
					$(par).append(tab);
					$(par).find("#isUpdataId").val(msg);
				}
			});
		}else{//修改
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=update_language',
				data:'id='+isUpdataId+'&catetory='+catetory+'&grasp='+grasp+'&r_write='+r_write+'&l_say='+l_say+'&grade='+grade,
				dataType:'text',
				success:function(msg){
					$(i).parent().parent().parent().css("display","none");//隐藏可编辑表单
					Dalert(msg);
					var tr_1=$(i).parent().parent().parent().parent().find("tfoot");
					$(tr_1).find("#t_catetory").html(catetory);
					$(tr_1).find("#t_grasp").html(grasp);
					$(tr_1).find("#t_write").html(r_write);
					$(tr_1).find("#t_say").html(l_say);
					$(tr_1).find("#t_grade").html(grade);
					$(tr_1).find("#click_event_3").attr("onclick","getAlter(this);");
					$(tr_1).css("display","");
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
			var language_id=$("#language_id").val();
			$(par).remove();
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type='+action,
				data:'id='+id+'&itemid='+itemid+'&language_id='+language_id,
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
						var tr_id=$("#train_id");
						tr_id.val(tr_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=="language"){
						var language_num=parseInt($("#language_num").val())-1;
						$("#language_num").val(language_num);
						if(language_num<5){
							$("#getAtable_4").attr("disabled",false);
						}
						var lg_id=$("#language_id");
						lg_id.val(lg_id.val().replace(id,''));
						Dalert("删除成功！");
					}else{
						alert("删除失败");
					}
				}
			});
        } 
		
	}
	//查看,编辑语言能力
	function getAlterLanguage(i){
		var par=$(i).parent().parent().parent().parent();
		var catetory=$(par).find("#t_catetory").html();
		var grasp=$(par).find("#t_grasp").html();
		var r_write=$(par).find("#t_write").html();
		var l_say=$(par).find("#t_say").html();
		var grade=$(par).find("#t_grade").html();
		var id=$(par).find("#insert_id").val();
		var tab="";
		tab+="<tbody>";
		tab+='<tr><td>语言类别</td><td><select id="s_catetory" name="post[catetory][]"><option>'+catetory+'</option><option>英语</option><option>日语</option><option>俄语</option><option>阿拉伯语</option><option>法语</option><option>德语</option><option>西班牙语</option><option>葡萄牙语</option><option>意大利语</option><option>韩语/朝鲜语</option><option>普通话</option><option>粤语</option><option>闽南语</option><option>上海话</option><option>其它</option></select></td><td>掌握程度</td><td><select id="s_grasp" name="post[grasp][]"><option>'+grasp+'</option><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td></tr>';
		tab+='<tr><td>读写能力</td><td><select id="read_write" name="post[read_write][]"><option>'+r_write+'</option><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td><td>听说能力</td><td><select id="hear_of" name="post[hear_of][]"><option>'+l_say+'</option><option>一般</option><option>良好</option><option>熟练</option><option>精通</option></select></td></tr>';
		tab+='<tr><td>英语等级</td><td><select id="s_grade" name="post[grade][]"><option>'+grade+'</option><option>未参加</option><option>四级</option><option>六级</option><option>专业四级</option><option>专业八级</option></select></td></tr>';
		tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveLanguage(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" value="删除" class="btn" onClick="getDel(this)"/><input type="hidden" value="'+id+'" id="isUpdataId"/></td></tr>';
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
	}
	#td_01_1,#t_catetory,#t_grasp,#t_say,#t_grade,#t_write{
		border-bottom:1px solid #639ccc;
		border-left:1px solid #639ccc;
		color:#000;
	}
</style>
<?php $language_id=$_SESSION['language_id'];?>
<input type="hidden" id="language_id" value="<?php echo $_SESSION['language_id'];?>"/>
<input type="hidden" id="language_num" value="<?php echo count(explode(',',$language_id))-1;?>"/>
<input type="hidden" id="itemid" value="<?php echo $itemid;?>"/>
<div id="addtable_4" style="color:#7aabd8;width:950px;margin:0 auto;margin-top:30px;">
		<?php if($language_id){$language_id=trim($language_id,',');$arr=explode(',',$language_id);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;">
			<tr align="center"><td width="300" id="td_01" bgcolor="#e4f0fa" style="border-left:1px solid #639ccc;">语言类别</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">掌握程度</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">读写能力</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">听说能力</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">英语等级</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">操作</td></tr>
		</table>
		<?php foreach($arr as $v){$sql="select * from {$db->pre}hr_resume_language where language_id=$v";$value=$db->get_one($sql);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;">
			<tfoot>
				<td>
					<table align="center" style="float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">			
					<tr align="center"><td width="300" id="t_catetory"><?php echo $value['catetory']?></td><td width="300" style="border-left:0px;" id="t_grasp"><?php echo $value['grasp']?></td><td width="300" style="border-left:0px;" id="t_write"><?php echo $value['r_write']?></td><td width="300" style="border-left:0px;" id="t_say"><?php echo $value['l_say']?></td><td width="300" style="border-left:0px;" id="t_grade"><?php echo $value['grade']?></td><td width="300" style="border-left:0px;border-right:1px solid #639ccc;" id="td_01_1"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" id="click_event_3" onclick="getAlterLanguage(this);">修改</a><input type="hidden" id="insert_id" value="<?php echo $value['language_id']?>,"/><input type="hidden" id="s_action" value="del_language"/></td></tr>
					</table>
				</td>
			</tfoot>
		</table>
		<?php }}else{?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" style="float:left;display:none;" id="tabA_4">
			<tr align="center"><td width="300" id="td_01" bgcolor="#e4f0fa" style="border-left:1px solid #639ccc;">语言类别</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">掌握程度</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">读写能力</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">听说能力</td><td width="300" style="border-left:0px;" id="td_01" bgcolor="#e4f0fa">英语等级</td><td style="border-left:0px;" id="td_01" width="300" bgcolor="#e4f0fa">操作</td></tr>
		</table>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left">
			<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
			<tr>
				<td height="80" width="100">语言类别</td>
				<td>
					<select id="s_catetory" name="post[catetory][]">
						<option>英语</option>
						<option>日语</option>
						<option>俄语</option>
						<option>阿拉伯语</option>
						<option>法语</option>
						<option>德语</option>
						<option>西班牙语</option>
						<option>葡萄牙语</option>
						<option>意大利语</option>
						<option>韩语/朝鲜语</option>
						<option>普通话</option>
						<option>粤语</option>
						<option>闽南语</option>
						<option>上海话</option>
						<option>其它</option>
					</select>
				</td>
				<td width="100">掌握程度</td>
				<td>
					<select id="s_grasp" name="post[grasp][]">
						<option>一般</option>
						<option>良好</option>
						<option>熟练</option>
						<option>精通</option>
					</select>
				</td>
			</tr>
			<tr>
				<td height="40">读写能力</td>
				<td>
					<select id="read_write" name="post[read_write][]">
						<option>一般</option>
						<option>良好</option>
						<option>熟练</option>
						<option>精通</option>
					</select>
				</td>
				<td>听说能力</td>
				<td>
					<select id="hear_of" name="post[hear_of][]">
						<option>一般</option>
						<option>良好</option>
						<option>熟练</option>
						<option>精通</option>
					</select>
				</td>
			</tr>
			<tr>
				<td height="60">英语等级</td>
				<td>
					<select id="s_grade" name="post[grade][]">
						<option>未参加</option>
						<option>四级</option>
						<option>六级</option>
						<option>专业四级</option>
						<option>专业八级</option>
					</select>
				</td>
			</tr>
			<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick='saveLanguage(this)' value="保存"/>&nbsp;&nbsp;&nbsp;<input type='button' class="btn" value='删除' onClick='getDel(this)'/><input type="hidden" value="0" id="isUpdataId"/></td></tr>
			<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
		</table>
	<?php }?>
</div>
<div style="width:90%;text-align:center;float:left;margin-top:20px;"><a href="#bottom_4"><input class="btn" <?php if(count(explode(',',$language_id))-1<4){echo "";}else{echo "disabled=true";}?> type="button" value="+继续添加" id="getAtable_4"/></a><a name="bottom_4" id="bottom_4"></a></div>
