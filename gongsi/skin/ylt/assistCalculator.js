/**
 * 创建人：邓夫伟
 * 创建时间：2012-07-24
 * 网上下单（已登录和未登录）、修改订单草稿、新增修改模板页面的辅助计算器
 * 相关文件：
 * JSP：
 * transonline/orderAlreadyLogin.jsp、orderHaveNotLogin.jsp
 * template/template.jsp
 * order/updateOrder.jsp
 */
$(".tf_addbtn").hide();
//关闭辅助计算器
$("#closeCounter").live("click",function(){
	var text=$.trim($(this).text());
	if(text=="关闭辅助计算器"){
		$(".zt_totalnum").hide();
		$(".tf_addbtn").hide();
		$(this).text("打开辅助计算器").addClass("aDown");
	}else{
		$(".zt_totalnum").show();
		$(".tf_addbtn").show();
		$(this).text("关闭辅助计算器").removeClass("aDown");
	}
});

//初始加载clone单条
var intiSingle=$(".zt_totalnum").eq(0).html();

//开启关闭单项修改
$(".singleUpdate").live("click",function(){
	$(this).parents(".zt_totalnum").eq(0).find(".laction").toggle();	
	var t=$(this).text();
	t=="修改" ? $(this).text("收起") : $(this).text("修改")
});
//单项删除
$(".singleDel").live("click",function(){
	$(this).parents(".zt_totalnum").eq(0).remove();
	var countResult = countSingle();
	//调用外部方法计算全部
	$("#totalWeight").val(countResult[0]);
	$("#totalVolume").val(countResult[1]);
	$("#totalSize").val(countResult[2]);
});

//单项添加
$(".singleAdd").click(function(){
		$(this).parent().before("<div class='zt_totalnum' style='display:block'>"+intiSingle+"</div>");
});

//单项修改确认
$(".editConfirm").live("click",function(){
	var ck=$(this).parents(".laction").find("input");
// 				var patrn=/^(\d*)?(\.)?\d+$/;
	ck.removeClass("wrong");
	$(".wrongMsg").remove();
	for(i=0;i<ck.size();i++){
		var val=$.trim(ck.eq(i).val());
		if(val==""){
			order_wrongMsg(ck.eq(i),"请填写数字！");
			ck.eq(i).focus().addClass("wrong");
			return false;
			break;
		}
		if(!numberReg.test(val)){
			order_wrongMsg(ck.eq(i),"请填写数字！");
			ck.eq(i).focus().addClass("wrong");
			return false;
			break;
		}
	};
	
	var singleVolume=$(this).parents(".laction").eq(0).find(".singleVolume").text();
	var singleWeight=parseFloat($(this).parents(".laction").find(".singleWeight").val());
	var singleSize=parseFloat($(this).parents(".laction").find(".singleSize").val());
	
	/*
	 *添加校验单件货物最大重量和体积
	 *2012-4-25 邓夫伟
	 */
	if(singleWeight > 500){
		order_wrongMsg($(this).parents(".laction").find(".singleWeight"),"单件货物重量不能超过500kg！");
		$(this).parents(".laction").find(".singleWeight").focus().addClass("wrong");
		return false;
	}
	if(singleVolume > 3){
		order_wrongMsg($(this).parents(".laction").find(".chang"),"单件货物体积不能大于3立方米！");
		$(this).parents(".laction").find(".chang").focus().addClass("wrong");
		return false;
	}
	
	$(this).parents(".tosn_middlebg").eq(0).find(".dataTitle").find(".kg").text(singleWeight*singleSize);
	$(this).parents(".tosn_middlebg").eq(0).find(".dataTitle").find(".m3").text((singleVolume*singleSize).toFixed(2));
	$(this).parents(".tosn_middlebg").eq(0).find(".dataTitle").find(".sz").text(singleSize);
	var countResult = countSingle();
	if(countResult[0]>=999999.9)
	{
		alert("货物重量不能大于999999.9千克！");
		return false;
	}
	if(countResult[1]>=999.9)
	{
		alert("货物体积不能大于999.9立方米！");
		return false;
	}
	
	//调用外部方法计算全部
	$("#totalWeight").val(countResult[0]);
	$("#totalVolume").val(countResult[1]);
	$("#totalSize").val(countResult[2]);
	
	$(this).parents(".zt_totalnum").eq(0).find(".dataTitle .singleUpdate").trigger("click");
});

//计算全部单体之和
function countSingle(){
	var s=$(".zt_totalnum");
	var w=0,v=0,n=0;
	for(i=0;i<s.size();i++){
		var sw=parseFloat(s.eq(i).find(".singleWeight").val());
		var sv=parseFloat(s.eq(i).find(".singleVolume").text());
		var sn=parseFloat(s.eq(i).find(".singleSize").val());
		if(s.eq(i).find(".singleWeight").val()==""){sw=0};
		if(s.eq(i).find(".singleVolume").text()==""){sv=0};
		if(s.eq(i).find(".singleSize").val()==""){sn=0}
		w=w+sw*sn;
		v=v+sv*sn;
		n=n+sn;
	};
	/**
	 * 2012-10-10 邓夫伟
	 * 添加货物总体积提示
	 */
	if(v < 0.01){
		order_wrongMsg($("#totalVolume"),"小于0.01立方米体积按0.01立方米计费");
		v = 0.01;
	}else if(v < 999.9){
		order_wrongMsg($("#totalVolume"),"大于0.01立方米体积四舍五入保留两位小数");
	}
	return [w,v.toFixed(2),n];
}
/**
 * 计算单位体积
 * @author 欧阳明睿
 * @date 2012-1-11
 */
$(".laction .org input").live("blur",function(){
	// 获得长宽高
	var chang=parseFloat($(this).parents(".laction").find(".chang").val());
	var kuan=parseFloat($(this).parents(".laction").find(".kuan").val());
	var gao=parseFloat($(this).parents(".laction").find(".gao").val());
	if(!numReg.test(chang)||!numReg.test(kuan)||!numReg.test(gao))
	{
		return false;
	}
	// 体积
	var singleVolume=chang*kuan*gao*0.01;
	$(this).parents(".laction").eq(0).find(".singleVolume").text(singleVolume.toFixed(3));
});