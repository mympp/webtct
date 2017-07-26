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
	//添加工作经历
	$(function(){   
	    $("#getAtable_1").click(function(){
			var tab='';
			tab+='<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;margin-top:20px;">';
			tab+='<tr><td>开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t2_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true" name="post[stop_time][]"/>&nbsp;<span id="t2_1" style="color:red;">*</span></td></tr>';
			tab+='<tr><td>行业</td><td><input size="22" type="text" id="s_industry" name="post[industry][]"/>&nbsp;<span id="t2_2" style="color:red;">*</span></td><td>公司名称</td><td><input size="22" id="company_name" type="text" name="post[company_name][]"/>&nbsp;<span id="t2_3" style="color:red;">*</span></td></tr>';
			tab+='<tr><td>公司规模</td><td><select id="s_scale" name="post[scale][]"><option>少于50</option><option>50-150</option><option>150-500</option><option>500-1000</option><option>1000以上</option></select></td><td>公司性质</td><td><select id="company_nature" name="post[company_nature][]"><option>外资</option><option>合资</option><option>国企</option><option>民营公司</option><option>上市公司</option><option>创业公司</option><option>政府机关</option><option>事业单位</option></select></td></tr>';
			tab+='<tr><td>职位</td><td class="tr"><input size="25" type="text" id="s_position" name="post[position][]"/><span id="t2_5" style="color:red;">*</span></td><td>薪资</td><td class="tr"><input size="25" type="text" id="s_pay" name="post[pay][]"/><span id="t2_6" style="color:red;">*</span></td></tr>';
			tab+='<tr><td>工作性质</td><td><select id="work_nature" name="post[work_nature][]"><option>全职</option><option>兼职</option><option>实习</option></select></td>	</tr>';
			tab+='<tr><td>工作描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="s_describe" name="post[describe][]"></textarea>&nbsp;<span id="t2_4" style="color:red;">*</span></td></tr>';
			tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveWork(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="0" id="isUpdataId"/></td></tr>';
			tab+='<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr></table>';
			$("#getAtable_1").attr("disabled",true);
			$("#addtable_1").append(tab);    
		});
	});
	//保存工作经历
	function saveWork(i){
		var par=$(i).parent().parent().parent().parent();
		//获取表单数据
		var start_time=$(par).find("#mh_date_1").val();
		var stop_time=$(par).find("#mh_date_2").val();
		var s_industry=$(par).find("#s_industry").val();
		var company_name=$(par).find("#company_name").val();
		var s_scale=$(par).find("#s_scale").val();
		var company_nature=$(par).find("#company_nature").val();
		var position=$(par).find("#s_position").val();
		var pay=$(par).find("#s_pay").val();
		var work_nature=$(par).find("#work_nature").val();
		var s_describe=$(par).find("#s_describe").val();
		var experience_id=$("#experience_id").val();
		//自增长id,默认为0
		var isUpdataId=$(par).find("#isUpdataId").val();
		//判断用户进行的是新增动作还是修改动作
		//新增
		if(isUpdataId==0){
			//使用ajax进行数据库操作,并将可编辑表单的数据显示为不可编辑的表格数据
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=insert_experience',
				data:'start_time='+start_time+'&stop_time='+stop_time+'&industry='+s_industry+'&company_name='+company_name+'&s_scale='+s_scale+'&company_nature='+company_nature+'&work_nature='+work_nature+'&describe='+s_describe+'&experience_id='+experience_id+'&position='+position+'&pay='+pay,
				dataType:'text',
				success:function(msg){
					if(msg=='00'){
						$(par).find("#t2_0").html("&nbsp;&nbsp;开始时间不能为空！");
						return false;
					}else if(msg=='01'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("&nbsp;&nbsp;结束时间不能为空！");
						return false;
					}else if(msg=='02'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("&nbsp;&nbsp;行业不能为空！");
						return false;
					}else if(msg=='03'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("&nbsp;&nbsp;公司名称不能为空！");
						return false;
					}else if(msg=='06'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("&nbsp;&nbsp;职位不能为空！");
						return false;
					}else if(msg=='07'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("");
						$(par).find("#t2_6").html("&nbsp;&nbsp;薪资不能为空！");
						return false;
					}else if(msg=='04'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("&nbsp;&nbsp;描述不能为空！");
						return false;
					}else if(msg=='05'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
						return false;
					}else{
						var experience_num=parseInt($("#experience_num").val())+1;
						$("#experience_num").val(experience_num);
						if(experience_num<5){
							$("#getAtable_1").attr("disabled",false);
						}else{
							$("#getAtable_1").attr("disabled",true);
						}
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("");
						$(par).find("#t2_6").html("");
						//隐藏可编辑表单
						$(i).parent().parent().parent().css("display","none");
						experience_id+=msg;
						$("#experience_id").val(experience_id);
						var tr="";
						tr+="<tfoot><td>";
						tr+='<table align="center" style="margin-top:20px;float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">';
						tr+='<tr align="center" ><td style="width:200px;border-bottom:0px;" id="t_time">'+start_time+'到'+stop_time+'：</td><td style="padding-left:10px;" align="left" id="t_company_name">'+company_name+'</td></tr>';
						tr+='<tr align="center" ><td id="td_01_1" style="border-bottom:0px;">公司性质：</td><td style="padding-left:10px;" align="left" id="t_company_nature">'+company_nature+'</td></tr>';
						tr+='<tr align="center"><td id="td_01_1" style="border-bottom:0px;">公司规模：</td><td style="padding-left:10px;" align="left" id="t_scale" style="color:#000;">'+s_scale+'</td></tr>';
						tr+='<tr align="center" ><td id="td_01_1" style="border-bottom:0px;">行业：</td><td style="padding-left:10px;" align="left" id="t_industry">'+s_industry+'</td></tr>';
						tr+='<tr align="center"><td id="td_01_1" style="border-bottom:0px;">职位：</td><td style="padding-left:10px;" id="t_position" align="left">'+position+'</td></tr>';
						tr+='<tr align="center"><td id="td_01_1" style="border-bottom:0px;">薪资：</td><td style="padding-left:10px;" id="t_pay" align="left">'+pay+'</td></tr>';
						tr+='<tr align="center" ><td id="td_01_1" style="border-bottom:0px;">工作性质：</td><td style="padding-left:10px;" align="left" id="t_work_nature">'+work_nature+'</td></tr>';
						tr+='<tr align="center" ><td id="td_01_1" style="border-bottom:0px;">工作描述:</td><td style="padding-left:10px;" align="left" id="t_describe"  style="padding:0 10px 0 10px;">'+s_describe+'</td></tr>';
						tr+='<tr align="center" ><td colspan="2" id="td_01_1" align="center"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" onclick="getAlter(this);">修改</a><input type="hidden" id="insert_id" value="'+msg+'"/><input type="hidden" id="s_action" value="del_experience"/></td></tr></table>';
						tr+="</td></tfoot>"
						$(par).append(tr);
						$(par).find("#isUpdataId").val(msg);
					}
				}
			});
		}else{//修改
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type=update_experience',
				data:'id='+isUpdataId+'&start_time='+start_time+'&stop_time='+stop_time+'&industry='+s_industry+'&company_name='+company_name+'&s_scale='+s_scale+'&company_nature='+company_nature+'&work_nature='+work_nature+'&describe='+s_describe+'&position='+position+'&pay='+pay,
				dataType:'text',
				success:function(msg){
					if(msg=='00'){
						$(par).find("#t2_0").html("&nbsp;&nbsp;开始时间不能为空！");
						return false;
					}else if(msg=='01'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("&nbsp;&nbsp;结束时间不能为空！");
						return false;
					}else if(msg=='02'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("&nbsp;&nbsp;行业不能为空！");
						return false;
					}else if(msg=='03'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("&nbsp;&nbsp;公司名称不能为空！");
						return false;
					}else if(msg=='06'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("&nbsp;&nbsp;职位不能为空！");
						return false;
					}else if(msg=='07'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("");
						$(par).find("#t2_6").html("&nbsp;&nbsp;薪资不能为空！");
						return false;
					}else if(msg=='04'){
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("&nbsp;&nbsp;描述不能为空！");
						return false;
					}else if(msg=='05'){
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_0").html("&nbsp;&nbsp;开始时间不能大于结束时间！");
						return false;
					}else{
						$(par).find("#t2_0").html("");
						$(par).find("#t2_1").html("");
						$(par).find("#t2_2").html("");
						$(par).find("#t2_3").html("");
						$(par).find("#t2_4").html("");
						$(par).find("#t2_5").html("");
						$(par).find("#t2_6").html("");
						//隐藏可编辑表单
						$(i).parent().parent().parent().css("display","none");
						Dalert(msg);
						var tr_1=$(i).parent().parent().parent().parent().find("tfoot");
						$(tr_1).find("#t_time").html(start_time+'至'+stop_time);
						$(tr_1).find("#t_company_name").html(company_name);
						$(tr_1).find("#t_company_nature").html(company_nature);
						$(tr_1).find("#t_industry").html(s_industry);
						$(tr_1).find("#t_work_nature").html(work_nature);
						$(tr_1).find("#t_describe").html(s_describe);
						$(tr_1).find("#t_scale").html(s_scale);
						$(tr_1).find("#t_position").html(position);
						$(tr_1).find("#t_pay").html(pay);
						$(tr_1).find("#click_event_4").attr("onclick","getAlter(this);");
						$(tr_1).css("display","");
					}
				}
			});	
		}
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
			var experience_id=$("#experience_id").val();
			$(par).remove();
			$.ajax({
				type:'post',
				url:'?moduleid=28&file=resume&action=add_all&type='+action,
				data:'id='+id+'&itemid='+itemid+'&experience_id='+experience_id,
				success:function(msg){
					//判断删除的数据(为教育经历,还是为工作经历等等)
					if(msg=='education'){
						var ed_id=$("#education_id");
						ed_id.val(ed_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=='experience'){
						var experience_num=parseInt($("#experience_num").val())-1;
						$("#experience_num").val(experience_num);
						if(experience_num<5){
							$("#getAtable_1").attr("disabled",false);
						}
						var ex_id=$("#experience_id");
						ex_id.val(ex_id.val().replace(id,''));
						Dalert("删除成功！");
					}else if(msg=="student_information"){
						var in_id=$("#information_id");
						in_id.val(in_id.val().replace(id,''));
						alert("删除成功");
					}else if(msg=='train'){
						var tr_id=$("#train_id");
						tr_id.val(tr_id.val().replace(id,''));
						alert("删除成功111");
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
	//查看，编辑工作经历
	function getAlterWork(i){
		var par=$(i).parent().parent().parent().parent();
		var start_time=$(par).find("#t_start_time").val();
		var stop_time=$(par).find("#t_stop_time").val();
		var company_name=$(par).find("#t_company_name").html();
		var company_nature=$(par).find("#t_company_nature").html();
		var industry=$(par).find("#t_industry").html();
		var position=$(par).find("#t_position").html();
		var pay=$(par).find("#t_pay").html();
		var work_nature=$(par).find("#t_work_nature").html();
		var describe=$(par).find("#t_describe").html();
		var scale=$(par).find("#t_scale").html();
		var id=$(par).find("#insert_id").val();
		var tab="";
		tab+="<tbody>";
		tab+='<tr><td>开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time_1][]" value="'+start_time+'"/>&nbsp;<span id="t2_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true" name="post[stop_time][]" value="'+stop_time+'"/>&nbsp;<span id="t2_1" style="color:red;">*</span></td></tr>';
		tab+='<tr><td>行业</td><td><input size="22" type="text" id="s_industry" name="post[industry][]" value="'+industry+'"/>&nbsp;<span id="t2_2" style="color:red;">*</span></td><td>公司名称</td><td><input size="22" id="company_name" type="text" name="post[company_name][]" value="'+company_name+'"/>&nbsp;<span id="t2_3" style="color:red;">*</span></td></tr>';
		tab+='<tr><td>公司规模</td><td><select id="s_scale" name="post[scale][]"><option>'+scale+'</option><option>少于50</option><option>50-150</option><option>150-500</option><option>500-1000</option><option>1000以上</option></select></td><td>公司性质</td><td><select id="company_nature" name="post[company_nature][]"><option>'+company_nature+'</option><option>外资</option><option>合资</option><option>国企</option><option>民营公司</option><option>上市公司</option><option>创业公司</option><option>政府机关</option><option>事业单位</option></select></td></tr>';
		tab+='<tr><td>职位</td><td><input size="25" type="text" id="s_position" name="post[position][]" value="'+position+'"/></td><td>薪资</td><td><input size="25" type="text" id="s_pay" name="post[pay][]" value="'+pay+'"/></td></tr>';
		tab+='<tr><td>工作性质</td><td><select id="work_nature" name="post[work_nature][]"><option>'+work_nature+'</option><option>全职</option><option>兼职</option><option>实习</option></select></td></tr>';
		tab+='<tr><td>工作描述</td><td colspan="3"><textarea style="width:582px;height:50px;" id="s_describe" name="post[describe][]">'+describe+'</textarea>&nbsp;<span id="t2_4" style="color:red;">*</span></td></tr>';
		tab+='<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick="saveWork(this)" value="保存"/>&nbsp;&nbsp;&nbsp;<input type="button" class="btn" value="删除" onClick="getDel(this)"/><input type="hidden" value="'+id+'" id="isUpdataId"/></td></tr>';
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
	#t_company_name,#t_company_nature,#t_industry,#t_work_nature,#t_describe,#t_position,#t_scale,#t_pay{
		border:1px solid #7aabd8;
		border-left:0px;
		border-bottom:0px;
		color:#000;
	}
	#td_01_1,#t_time{
		border:1px solid #7aabd8;
	}
</style>
<?php $experience_id=$_SESSION['experience_id'];?>
<input type="hidden" id="experience_id" value="<?php echo $_SESSION['experience_id'];?>"/>
<input type="hidden" id="experience_num" value="<?php echo count(explode(',',$experience_id))-1;?>"/>
<input type="hidden" id="itemid" value="<?php echo $itemid;?>"/>
<div id="addtable_1" style="color:#7aabd8;width:800px;margin:0 auto;">
	<?php if($experience_id){$experience_id=trim($experience_id,',');$arr=explode(',',$experience_id);foreach($arr as $v){$sql="select * from {$db->pre}hr_resume_experience where experience_id=$v";$value=$db->get_one($sql);?>
		<table align="center" cellpadding="0" cellspacing="0" width="100%" id="tabA" style="float:left;margin-top:20px;">
			<tfoot>
			<td>
				<table align="center" style="margin-top:20px;float:left;" cellpadding="0" cellspacing="0" width="100%" id="tabB">
					<tr align="center"><td style="width:200px;border-bottom:0px;" id="t_time"><?php echo $value['start_time'];?>至<?php echo $value['stop_time']?></td><td align="left" style="padding-left:10px;" id="t_company_name"><?php echo $value['company_name']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">公司性质：</td><td align="left" style="padding-left:10px;" id="t_company_nature"><?php echo $value['company_nature']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">公司规模：</td><td align="left" style="padding-left:10px;" id="t_scale"><?php echo $value['scale']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">行业：</td><td align="left" style="padding-left:10px;" id="t_industry"><?php echo $value['industry']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">职位：</td><td id="t_position" style="padding-left:10px;" align="left"><?php echo $value['position']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">薪资：</td><td id="t_pay" style="padding-left:10px;" align="left"><?php echo $value['pay']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">工作性质：</td><td align="left" style="padding-left:10px;" id="t_work_nature"><?php echo $value['work_nature']?></td></tr>
					<tr align="center"><td id="td_01_1" style="border-bottom:0px;">工作描述:</td><td align="left" style="padding:0 10px 0 10px;" id="t_describe"><?php echo $value['ex_describe']?></td></tr>
					<tr align="center"><td id="td_01_1" align="center" colspan="2"><a style="color:blue;cursor:pointer;" onclick="getDel_1(this);">删除</a>&nbsp;|&nbsp;<a style="color:blue;cursor:pointer;" id="click_event_4" onclick="getAlterWork(this);">修改</a><input type="hidden" id="insert_id" value="<?php echo $value['experience_id']?>,"/><input type="hidden" id="s_action" value="del_experience"/><input type="hidden" id="t_start_time" value="<?php echo $value['start_time']?>"/><input type="hidden" id="t_stop_time" value="<?php echo $value['stop_time']?>"/></td></tr>
				</table>
			</td>
			</tfoot>
		</table>
	<?php }}else{?>
		<table align="center" cellpadding="0" cellspacing="0" width="90%" id="tabA" style="float:left;margin-top:20px;">
			<tr><td>开始时间</td><td><input type="text" id="mh_date_1"  readonly="true" name="post[start_time][]"/>&nbsp;<span id="t2_0" style="color:red;">*</span></td><td>结束时间</td><td><input type="text" id="mh_date_2" readonly="true"  name="post[stop_time][]"/>&nbsp;<span id="t2_1" style="color:red;">*</span></td></tr>
			<tr><td>行业</td><td><input size="23" type="text" id="s_industry" name="post[industry][]"/>&nbsp;<span id="t2_2" style="color:red;">*</span></td><td>公司名称</td><td><input size="22" id='company_name' type="text" name="post[company_name][]"/>&nbsp;<span id="t2_3" style="color:red;">*</span></td></tr>
			<tr>
				<td>公司规模</td>
				<td>
					<select id="s_scale" name="post[scale][]">
						<option>少于50</option>
						<option>50-150</option>
						<option>150-500</option>					
						<option>500-1000</option>
						<option>1000以上</option>
					</select>
				</td>
				<td>公司性质</td>
				<td>
					<select id="company_nature" name="post[company_nature][]"><option>外资</option><option>合资</option><option>国企</option><option>民营公司</option><option>上市公司</option><option>创业公司</option><option>政府机关</option><option>事业单位</option></select>
				</td>
			</tr>
			<tr>
				<td>职位</td>
				<td class="tr"><input size="25" type="text" id="s_position" name="post[position][]"/><span id="t2_5" style="color:red;">*</span></td>
				<td>薪资</td>
				<td class="tr"><input size="25" type="text" id="s_pay" name="post[pay][]"/><span id="t2_6" style="color:red;">*</span></td>
			</tr>
			<tr>
				<td>工作性质</td>
				<td>
					<select id="work_nature" name="post[work_nature][]">
						<option>全职</option>
						<option>兼职</option>
						<option>实习</option>
					</select>
				</td>	
			</tr>
			<tr>
				<td>工作描述</td>
				<td colspan="3"><textarea style="width:582px;height:50px;" id="s_describe" name="post[describe][]"></textarea>&nbsp;<span id="t2_4" style="color:red;">*</span></td>
			</tr>
			<tr align="center"><td colspan="4" ><input class="btn" type="button" id="submit_save" onClick='saveWork(this)' value="保存"/>&nbsp;&nbsp;&nbsp;<input type='button' class="btn" value='删除' onClick='getDel(this)'/><input type="hidden" value="0" id="isUpdataId"/></td></tr>
			<tr><td colspan="4"><hr style="color:#83a7d3;"/></td></tr>
		</table>
	<?php }?>
</div>
<div style="width:90%;text-align:center;float:left;margin-top:20px;"><a href="#bottom_1"><input type="button" <?php if(count(explode(',',$experience_id))-1<4){echo "";}else{echo "disabled=true";}?> class="btn" value="+继续添加" id="getAtable_1"/></a><a name="bottom_1" id="bottom_1"></a></div>
