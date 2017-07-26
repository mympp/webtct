/**
 * 网上下单自动匹配和包装填写处理
 * @author 李佳楠
 * @date 2013-09-06
 * 
 */
document.write("<script language='javascript' src=’../validateOrder.js’></script>");
$(function(){
	//发货
	$(".consigorPointByAddress").click(function(){
		var address=$.trim($(".f_city").val())+"-"+$.trim($(".f_address").val());
		
		//发货地址
		if($.trim($(".f_city").val())==""||$.trim($(".f_city").val())== $.trim($(".f_city").attr("ov"))||toFilter.test($.trim($(".f_city").val()))){
			order_wrongMsg($(".f_city"),"请正确选择发货城市。");
			$(".f_city").focus();
			return false;
		}
		if($.trim($(".f_address").val())==""||toFilter.test($.trim($(".f_address").val()))){
			order_wrongMsg($(".f_address"),"请填写您的发货地址，勿包含特殊字符。");
			$(".f_address").focus();
			return false;
		}
		var title=getTitle($.trim($(".f_city").val()));
		
		appendDept($(this),"consignorDept",address,0,title);
	});
	
	//收货
	$(".consigneeInfoPointByAddress").click(function(){
		var address=$("#caddrProCity").val()+"-"+$("#con_adderss").val();
		
		//发货地址
		if($.trim($("#caddrProCity").val())==""||$.trim($("#caddrProCity").val())== $.trim($("#caddrProCity").attr("ov"))||toFilter.test($.trim($("#caddrProCity").val()))){
			order_wrongMsg($("#caddrProCity"),"请正确选择收货城市。");
			$("#caddrProCity").focus();
			return false;
		}
		if($.trim($("#con_adderss").val())==""||toFilter.test($.trim($("#con_adderss").val()))){
			order_wrongMsg($("#con_adderss"),"请填写您的收货地址，勿包含特殊字符。");
			$("#con_adderss").focus();
			return false;
		}
		var title=getTitle($("#caddrProCity").val());
		appendDept($(this),"consigneeInfoDept",address,1,title);
	});
	
	//新增发货人自动匹配网点
	$(".consigorByAddress").bind('input propertychange',function(){
      var address=$.trim($(".f_city").val())+"-"+$.trim($(".f_address").val());
		
		//发货地址
		if($.trim($(".f_city").val())==""||$.trim($(".f_city").val())== $.trim($(".f_city").attr("ov"))||toFilter.test($.trim($(".f_city").val()))){
			order_wrongMsg($(".f_city"),"请正确选择发货城市。");
			$(".f_city").focus();
			return false;
		}
		if($.trim($(".f_address").val())==""||toFilter.test($.trim($(".f_address").val()))){
			order_wrongMsg($(".f_address"),"请填写您的发货地址，勿包含特殊字符。");
			$(".f_address").focus();
			return false;
		}
		var title=getTitle($.trim($(".f_city").val()));
		
		appendDept($(this),"consignorDept",address,0,title);
		$("#consignorDeptgisId").css("left", "730.15px");
	});
	 
	/**
	* 动态匹配网点
	*author 李佳楠
	*date 2013-09-07
	*/
	function appendDept(dpetbtn,id,address,flag,title){
		var flagValue=flag==1?"收货":"发货";
		if($("div .deptInfo").length>0){
			$("div .deptInfo").remove();
		}
		  var position = dpetbtn.position();
		  var height = dpetbtn.height();
		  var css = {
				  "left" : position.left-206, 
				  "top" : position.top+height, 
				  "position": "absolute",
				  "_position":"absolute",
				  "border": "1px solid #AEAEAE",
				  "z-index":"100",
				 "width":"308px",
				 "height":"300px",
				 "border-radius":"4px",
				 "background":"#FFF"
		  }; 
		  dpetbtn.before("<div class='deptInfo' id='"+id+"gisId'></div>");
	      $(".deptInfo").append("<span class='deptInfoHeader' style='color:white;margin-left: 0px;'>目的地："+title+"<div class='img-close'><img onclick='$(\".deptInfo\").remove();'  src='../images/order/btn_close_p.png'></div></span>");
	      $(".deptInfoHeader").append("<ul class='deptlist' style='cursor:pointer'></ul>");
	      $(".deptInfo").css(css);
	    $.ajax({
		      type:"POST",
		      data:{"deptAddress":address,"receiveAndSend":flag},
			  url: '../wangdian/ajaxQueryDeptByAddress.action',
			  dataType: "json",
			  beforeSend:function(XMLHttpRequest){
				  $("ul .deptlist").append("<li><div class='loading'><image src='../theme/default/images/loading.gif' style='margin-top:95px;'/></div></li>");
			  },
			  success: function(json) {
				  $("ul .deptlist li").remove();
			      if(json.deptList!=null&&json.deptList.length>0){
					  $.each(json.deptList,function(i,dept){
						  if(i==0){
							  $("ul .deptlist").append("<li id='deptpoints' class='current' title='"+dept.deptName+"' alt='"+dept.deptName+"'><div class='contexttop'><div class='deptAddress'>"+dept.deptName+"</div><div class='deptLeft'>距离"+dept.deptDistance+"公里</div></div><div class='expand'><div class='expandtel'>电话："+dept.deptTel+"</div><div class='expandaddr'>地址："+dept.deptAddress+"</div></div></li>");  
						  }else{
							  $("ul .deptlist").append("<li id='deptpoints' class='normal' title='"+dept.deptName+"' alt='"+dept.deptName+"'><div class='contexttop'><div class='deptAddress'>"+dept.deptName+"</div><div class='deptLeft'>距离"+dept.deptDistance+"公里</div></div><div class='expand' style='display:none;'><div class='expandtel'>电话："+dept.deptTel+"</div><div class='expandaddr'>地址："+dept.deptAddress+"</div></div></li>"); 
						  }
					  });
			      }else{
			    	  $("ul .deptlist").append("<li><div class='notfound'><p style='color:grey'>对不起，没有找到当前"+flagValue+"地址附近的营业网点</p><p style='color:grey'>可修改地址后重试，或使用<a href='../wangdian/' target='_blank'>网点查询</a></p></div></li>");
			      }
			  },
			  error:function(){
				  $("ul .deptlist").append("<li><div class='notfound'><p style='color:grey'>对不起，没有找到当前"+flagValue+"地址附近的营业网点</p><p style='color:grey'>可修改地址后重试，或使用<a href='../wangdian/' target='_blank'>网点查询</a></p></div></li>");
			  }
		});
	}
	
	
	
	var department;
	/**
	 * 点击事件绑定网点
	 * @author 李佳楠
	 * @date 2013-09-06
	 */
	$("ul .deptlist li[id='deptpoints']").live("click",function(){
		var deptName=$(this).attr("title");
		if(deptName==""){
			return false;
		}
		
		$.ajax({
			type:"POST",
		      data:{"deptName":deptName},
			  url: '../common/ajaxQueryDeptByName.action',
			  dataType: "json",
			  async:false,
			  success: function(json) {
				  department="";
				  department=json.department;
			  }
		});
		//发货人
		if($(this).parents("div #consignorDeptgisId").length>0){
			$("#dot_info").show();
			$(".sdeptInfo").val(department.deptInfo);
			$(".sdeptName").val(department.name);
			$("#dot_info span").text(department.deptInfo);
			$("a.selectmap").attr("dp",department.deptNumber);
			$("#leavedCityId").val(department.newarea);
			//快递模板下单填充隐藏的发货网点id
			$("#hd_sdeptId").val(department.deptId);
			if($(".s_city").val() != "" && $(".s_city").val() != $(".s_city").attr("ov")){
				$(".s_city").trigger("changeMe");
			}
			$(".f_inter").val(department.province+"-"+department.city+"-"+department.newareaName);
			
			changeSendCity(department.newcity,department.newarea,department.deptId);
			
			$(".f_inter").removeClass("iGrays");
			$("#consignorDeptgisId").remove();
		}
		//收货人
		if($(this).parents("div #consigneeInfoDeptgisId").length>0){
//			if($("#transType").val()!="7"){
//				if(department.businessScope.indexOf("提货")>=0&&department.businessScope.indexOf("送货")<0){
//					$("#delieveType option").remove();
//					$("#delieveType").append("<option value='1'>自提</option>");
//					//自提
//				}else if(department.businessScope.indexOf("提货")<0&&department.businessScope.indexOf("送货")>=0){
//					$("#delieveType option").remove();
//					$("#delieveType").append("<option value='15'>送货(不含上楼)</option>");
//					$("#delieveType").append("<option value='16' title='提醒：单件50Kg以上货物，不提供送货上楼服务'>送货上楼</option>");
//					//送货
//				}else if(department.businessScope.indexOf("提货")>=0&&department.businessScope.indexOf("送货")>=0){
//					$("#delieveType option").remove();
//					$("#delieveType").append("<option value='1'>自提</option>");
//					$("#delieveType").append("<option value='15'>送货(不含上楼)</option>");
//					$("#delieveType").append("<option value='16' title='提醒：单件50Kg以上货物，不提供送货上楼服务'>送货上楼</option>");
//				}
//			}
			$("#busScope").val(department.businessScope);
			delieverChange(true,$("#transType").val(),department.businessScope);
			$("#span_lading_deptInfo").text(department.deptInfo);
			$("a.ladingMap").attr("dp",department.deptNumber);
			$("#lading_info").show();
			
			$("#caddrProDept").val(department.province+"-"+department.city+"-"+department.newareaName);
			changeReceiveCity(department.newcity,department.newarea,department.deptId);
			
			$("#consigneeInfoDeptgisId").remove();
			$("#caddrProDept").removeClass("iGrays");
			
		}
		
		//alert($(this).parents("div #consignorDeptgisId").length+"发货人");
		//alert($(this).parents("div #consigneeInfoDeptgisId").length+"收货人");
	});
	/**
	 * 自动匹配网点选择以后填充网点城市和信息
	 */
	function changeSendCity(cityId,areaId,deptId){
		if(cityId==null||cityId==""||areaId==null||areaId==""){
			$("#transType").attr('value','5');
			return false;
		}
		$(".f_cityId").val(cityId);
		$(".change_mode").empty();
		//2012-10-09 邓夫伟 在清除运输方式的时候把运输方式置为汽运偏线
		$("#transType").attr('value','5');
		$.getJSON("../template/queryDepts.action",{"areaId":areaId},function(json){
			$(".dot_select").empty();
			$(".dot_select").append("<option value=''>请选择</option>");
			$.each(json.depts,function(i,dept){
				if(deptId==dept.id){
					$(".dot_select").append("<option value='"+dept.id+"' selected='selected'>"+dept.name+"</option>");
					sendArgus();
					//填充网点之后判断客户在该网点是否月结 add by zhangjianjun
					monthlyChange(deptId);
				}
				else
					$(".dot_select").append("<option value='"+dept.id+"'>"+dept.name+"</option>");
			});
		});
		$("#deptCountyId").attr("value", areaId);
		$(".dot_select").attr("disabled",false);
	}
	
	function sendArgus(){
		//var deptId = obj.options[obj.selectedIndex].value;
		var deptId = $("#consignorDept").val();
		//$("#tempDeptId").setAttribute("value",'');
		//如果选项不是请选择，发送deptid
		if(deptId!="choose"){
			//$("#tempDeptId").setAttribute("value",deptId);
			$("#tempDeptId").attr("value",deptId);
		}
	}
	
	function monthlyChange(sdeptId){
//		var sdeptId = deptId;
		if ($("#payType").val() == 2 && sdeptId != null) {
			$.ajax({
				type : "get",
				url : '../template/monthlyPayUser.action?template.sdeptId='
						+ sdeptId+'&fresh='+(new Date()).getTime(),
				dataType : "json",
				success : function(data) {
					if (data.monthlyPayUser != ""
							&& data.monthlyPayUser != null) {
						var arr = data.monthlyPayUser.split(",");
						if (arr[0] != "" && arr[0] != null) {
							isMonthlyPayUser = true;
						} else {
							isMonthlyPayUser = false;
						}
						if (arr[1] != "" && arr[1] != null) {
							isExPayWay = true;
						} else {
							isExPayWay = false;
						}
					} else {
						isMonthlyPayUser = false;
						isExPayWay = false;
					}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					alert("系统内部故障，请选择其他支付方式。");
				}
			});
		}
	}
	function changeReceiveCity(cityId,areaId,deptId){
		$.getJSON("../template/queryDeptsByDeliver.action",{"areaId":areaId},function(json){
			$(".lading_select").empty();
			$(".lading_select").append("<option value=''>请选择</option>");
			$.each(json.depts,function(i,dept){
				if(deptId==dept.id)
					$(".lading_select").append("<option value='"+dept.id+"' selected='selected'>"+dept.name+"</option>");
				else
					$(".lading_select").append("<option value='"+dept.id+"'>"+dept.name+"</option>");
			});
		});
		$(".lading_select").attr("disabled",false);
	}
	
	/**
	 * 鼠标移动事件
	 * @author 李佳楠
	 * @date 2013-09-06
	 */
	$("ul .deptlist li[id='deptpoints']").live("mouseover",function(){
		$("div .deptInfo ul li").removeClass("current").addClass("normal");
		$(this).addClass("current").removeClass("normal");
		
		$("div .deptInfo ul li .expand").hide();
		
		$(this).find(".expand").show();
	});
	
	
	/**
	 * 获取到TITLE
	 * @author 李佳楠
	 * @date 2013-09-07
	 */
	function getTitle(inputCityName){
		var title="";
		if (inputCityName.indexOf("-") > 0) {
			if(inputCityName.split("-").length == 3){
				title = inputCityName.split("-")[2];
			} else if(inputCityName.split("-").length == 2){
				title = inputCityName.split("-")[1];
			}
		}else
			title=inputCityName;
		return title;
	}
	
	/***************包装信息弹出******************/
	/**
	 * 货物包装
	 * @author 李佳南
	 * @date 2013-09-08
	 */
	$("#cargoPackLayer").bind("click",function(){
		if($(this).hasClass("noNeed")){
			return false;
		}
		var position=$(this).position();
		var height=$(this).height();
		if($("div .packlay").length>0)
			$("div .packlay").remove();
		var css={
				 "left" : position.left-206, 
				  "top" : position.top+height, 
				  "position": "absolute",
				  "_position":"absolute",
				  "border": "1px solid #3F3B67",
				  "z-index":"100",
				 "width":"400px",
				 "height":"170px",
				 "border-radius":"4px",
				 "background":"#FFF"
		};
		$(this).before("<div class='packlay'></div>");
		$(".packlay").append("<h3 class='title'>设置包装</h3><a href='javascript:' title='关闭' class='pop'></a>");
		$(".packlay").append("<div class='context'></div>");
		$(".packlay .context").append("<div class='contop'><div><input type='text' class='packNum' id='paper' maxlength='4' />纸<input type='text' class='packNum' id='fine' maxlength='4'/>纤<input type='text' class='packNum' id='palm' maxlength='4'/>托<input type='text' class='packNum' id='membrane' maxlength='4'/>膜<input type='text' class='packNum' id='wood' maxlength='4'/>木</div><div style='margin-top:5px;'>其他：<input type='text' id='otherpack' maxlength='10' class='packNum' style='width:150px;'/>例：2桶，2包</div></div>");
		$(".packlay .context").append("<div class='conbtn'><input type='button' value='确定' class='zt_floatnone tosnsmll_mouseover channegButn' id='packConfirm' /><input type='button' value='取消' class='zt_floatnone tosnsmall_btnl channegButn' id='packcancel' /></div>");
		$(".packlay .context").append("<div class='errortip'><p><b id='packerror'></b></p></div>");
		$(".packlay").css(css);
		var packValue=$(this).val();
		var paper="",fine="",palm="",membrane="",wood="",otherpack="";
		if(packValue!=""){
			if(packValue.indexOf(" ")>=0){
				otherpack=packValue.substring(packValue.indexOf(" ")+1,packValue.length);
				packValue=packValue.substring(0,packValue.indexOf(" "));
			}
			
			var k="纸纤托膜木";
			var str="";
			for(var i=0;i<packValue.length;i++){
				if(k.indexOf(packValue.charAt(i))>=0){
					if(packValue.charAt(i)=="纸")
						paper=str;
					else if(packValue.charAt(i)=="纤")
						fine=str;
					else if(packValue.charAt(i)=="托")
						palm=str;
					else if(packValue.charAt(i)=="膜")
						membrane=str;
					else if(packValue.charAt(i)=="木")
						wood=str;
					str="";
				}else
					str+=packValue.charAt(i);
			}
		}
		
		$("#paper").val(paper);
		$("#fine").val(fine);
		$("#palm").val(palm);
		$("#membrane").val(membrane);
		$("#wood").val(wood);
		$("#otherpack").val(otherpack);
		
	});
	/**
	 * 将包装信息填充到文本框
	 */
	function bindPackValue(object){
		$("#packerror").text("");
		var reg =/^[0-9]*[1-9][0-9]*$/;
		var paper=$("#paper").val();
		var fine=$("#fine").val();
		var palm=$("#palm").val();
		var membrane=$("#membrane").val();
		var wood=$("#wood").val();
		var otherpack=$("#otherpack").val();
		var isPrintUser=$("#isPrintUser").val();
		var transtype=$("#transType").val();
		if(transtype==7|| transtype==8||isPrintUser==""||isPrintUser=="false"||paper!=""||fine!=""||palm!=""||membrane!=""||wood!=""||otherpack!=""){
			var paperTrue=true,fineTure=true,palmTrue=true,membraneTrue=true,woodTrue=true;
			if(paper!=""){
				paperTrue=reg.test(paper);
				paper=paper.replace(/^[\s*|0]+\s*/g,'');
			}
			if(fine!=""){
				fineTure=reg.test(fine);
				fine=fine.replace(/^[\s*|0]+\s*/g,'');
			}
			if(palm!=""){
				palmTrue=reg.test(palm);
				palm=palm.replace(/^[\s*|0]+\s*/g,'');
			}
			if(membrane!=""){
				membraneTrue=reg.test(membrane);
				membrane=membrane.replace(/^[\s*|0]+\s*/g,'');
			}
			if(wood!=""){
				woodTrue=reg.test(wood);
				wood=wood.replace(/^[\s*|0]+\s*/g,'');
			}
			if(!paperTrue||!fineTure||!palmTrue||!membraneTrue||!woodTrue){
				$("#packerror").text("对不起，包装数量必须输入大于0的整数");
				return false;
			}
			var total=$("#totalSize").val();
			if(total)
				total=parseInt(total);
			var baozhuang=0;
			if(paper)
				baozhuang+=parseInt(paper);
			if(fine)
				baozhuang+=parseInt(fine);
			if(palm)
				baozhuang+=parseInt(palm);
			if(membrane)
				baozhuang+=parseInt(membrane);
			if(wood)
				baozhuang+=parseInt(wood);
			if(baozhuang>total){
				$("#packerror").text("货物包装总件数不允许大于货物总件数");
				return false;
			}
			paper=paper!=""?paper+"纸":"";
			fine=fine!=""?fine+"纤":"";
			palm=palm!=""?palm+"托":"";
			membrane=membrane!=""?membrane+"膜":"";
			wood=wood!=""?wood+"木":"";
			otherpack=otherpack!=""?otherpack:"";
			var cargoPack=paper+fine+palm+membrane+wood+" "+otherpack;
			object.val(cargoPack);
		}else{
			$("#packerror").text("对不起，至少需设置一项包装数量");
			return false;
		}
		$("div .packlay").remove();
	}
	
	/**
	 * 包装信息填充
	 */
	$("#packConfirm").live("click",function(){
		bindPackValue($("#cargoPackLayer"));
	});
	
	/**
	 * 关闭包装层
	 */
	$("div .pop").live("click",function(){
		$("div .packlay").remove();
	});
	$("#packcancel").live("click",function(){
		$("div .packlay").remove();
	});
});

