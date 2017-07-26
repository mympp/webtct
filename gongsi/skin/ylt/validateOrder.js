
function showEditInfo(isShow){
	if(isShow){
		$(".editInfo").show();
		$(".defaultInfo").hide();
	}
}

var fm=$("#checkMbForm");
$(".validateOrder").bind("click",function(){
	//标识当前点击的按钮的ID值
	var currentButton = $(this).attr("id");
	
	//点击提交按钮之后的样式控制
	$(".wrongMsg").remove();
	$(".wrong").removeClass("wrong");
	$(this).parent().before("<div class='wrongMsg'></div>")	;
	
	//发货人电话（手机固话至少填写一个）
	var mobilPhone1=fm.find(".mobilPhone");
	var mobilPhone2=fm.find(".mobiletwo");
	var vt1 = $.trim(mobilPhone1.val());
	var vt2 = $.trim(mobilPhone2.val());
	var quhao1 = $.trim($("#quhao").val());
	var quhao2 = $.trim($("#quhao_input").val());
	var number1 = $.trim($("#fixedPhone").val());
	var number2 = $.trim($("#con_telphone").val());
	var isPrintUser=$("#isPrintUser").val();
	var isShow = false;
	if((currentButton == "loginedNewOrder" || currentButton == "loginedSaveDraft")){
		isShow = true;
	}
		//发货人姓名
		if($.trim($(".consignor_input").val())==""||toFilter.test($.trim($(".consignor_input").val()))){
			showEditInfo(isShow);
			order_wrongMsg($(".consignor_input"),"请填写发货人，勿包含特殊字符。");
		    $(".consignor_input").focus();
			return false;
		}
		if(vt1==""&&quhao1==""&&number1==""){
			showEditInfo(isShow);
		    order_wrongMsg(mobilPhone1,"发货人手机和固定电话须至少填写一个。");
			mobilPhone1.focus();
			return false;
		}
		if($.trim(mobilPhone1.val())!=''&&!par.test($.trim(mobilPhone1.val()))){
			showEditInfo(isShow);
			order_wrongMsg(mobilPhone1,"发货人手机号码格式填写不正确。");
			mobilPhone1.focus().select().val("");
			return false;
		}
		if (quhao1 == "" && number1 != "") {
			showEditInfo(isShow);
			order_wrongMsg($("#quhao"),"请输入发货人固话区号。");
			$("#quhao").focus();
			return false;
		}
		if (quhao1 != "" && !nv1.test(quhao1)) {
			showEditInfo(isShow);
			order_wrongMsg($("#quhao"),"请正确输入发货人的固话区号。");
			$("#quhao").focus().select();
			return false;
		}
		if (quhao1 != "" && number1 == "") {
			showEditInfo(isShow);
			order_wrongMsg($("#fixedPhone"),"请输入发货人固定电话。");
			$("#fixedPhone").focus();
			return false;
		}
		if (quhao1 != "" && !nv2.test(number1)) {
			showEditInfo(isShow);
			order_wrongMsg($("#fixedPhone"),"请正确输入发货人的电话号码。");
			$("#fixedPhone").focus().select();
			return false;
		}

		//发货地址
		if($.trim($(".f_city").val())==""||$.trim($(".f_city").val())== $.trim($(".f_city").attr("ov"))||toFilter.test($.trim($(".f_city").val()))){
			showEditInfo(isShow);
			order_wrongMsg($(".f_city"),"请正确选择发货城市。");
			$(".f_city").focus();
			return false;
		}

	
	//收货人
	if($.trim($(".consignee_input").val())==""||toFilter.test($.trim($(".consignee_input").val()))){
		order_wrongMsg($(".consignee_input"),"请填写收货人，勿包含特殊字符。");
		$(".consignee_input").focus();
		return false;
	}
	//收货人手机或固话（必须至少填写一个）
	if(vt2==""&&quhao2==""&&number2==""){
		order_wrongMsg(mobilPhone2,"收货人手机和固定电话必选填写一个。");
		mobilPhone2.focus();
		return false;
	}
	if($.trim(mobilPhone2.val())!=''&&!par.test($.trim(mobilPhone2.val()))){
		order_wrongMsg(mobilPhone2,"请录入正确的手机号码。");
		mobilPhone2.focus().val("");
		return false;
	}
	if (quhao2 == "" && number2 != "") {
		order_wrongMsg($("#quhao_input"),"请输入区号。");
		$("#quhao_input").focus();
		return false;
	}
	if (quhao2 != "" && !nv1.test(quhao2)) {
		order_wrongMsg($("#quhao_input"),"请输入正确的区号。");
		$("#quhao_input").focus();
		return false;
	}
	if (quhao2 != "" && number2 == "") {
		order_wrongMsg($("#con_telphone"),"请输入固定电话。");
		$("#con_telphone").focus();
		return false;
	}
	if (quhao2 != "" && !nv2.test(number2)) {
		order_wrongMsg($("#con_telphone"),"请输入正确的固定电话号码。");
		$("#con_telphone").focus();
		return false;
	}
	if($("#transType").val()!='' && $("#transType").val()!='15'){
		//货物名称
		if($.trim($(".product_input").val())==""||toFilter.test($.trim($(".product_input").val()))){
			order_wrongMsg($(".product_input"),"请填写货物名称，勿包含特殊字符。");
			$(".product_input").focus();
			return false;
		}
	}
	if($(".agreeTk").val()!=''){
		order_wrongMsg($(".agreeTk"),"须同意服务条款方可提交。");
		$(".agreeTk").focus();
		return false;
	}


	
	
	
});



