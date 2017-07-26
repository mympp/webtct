/*----------------------------- 

Name: public javascript
Design:Mc.ma
Time: 2011-12
-----------------------------*/
// Global button hover、down effects
/**
 * 改为在common/otherJS.html静态页面中引入JS文件，在common/bottom.jsp中引入该静态页面
 */
//document.write("<scri"+"pt type='text/javascript' charset='utf-8' src='http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=466322619'></scr"+"ipt>");
//document.write("<scri"+"pt type='text/javascript' charset='utf-8' src='http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js' data-appid='100294686' data-redirecturi='http://www.deppon.com/help/qc_callback.html' charset='utf-8'></scr"+"ipt>");
var isDifferentSelect=null;
var timer = new Array();


//hjj
$(document).ready(function(){
	LoginFromCookie();
});

//使用的从cookie登陆
function LoginFromCookie(){
	var userName = $.cookie("depponLoginUserName");
	var ifFisKeycustomer=$.cookie("ifFisKeycustomer");
	if(ifFisKeycustomer=="true"){
		if($("#vipIsShow").val()!="yes"){
			$("#ifFisKeycustomert22").before('<img src="../images/user/vip1.png">');
		}
		$("#vipIsShow").val("yes");
	}
	//如果cookie中用户名为空，则未登录，如果不为空，则发送Ajax请求获取相关数据
	if(userName == null || $.trim(userName)=="" ){
		$(".login").hide();
		$(".loginTemp").hide();
		$(".notLogin").show();
		
		$("#accountInfo_error").hide();
		$("#loginInfo").show();
	}else{
		
		var queryajax = function ()
		{
			var show_error = function(){
				$("#loginInfo").hide();
				$("#accountInfo_error").show();
				$(".currentTime").html(currTime);
			};
			$.ajax({
				type:"post",
				url:"../user/queryPayOderTranOder.action",
				dataType:"json",
				success:function(msg)
				{
					if(!msg) {
						show_error();
						return false;
					}
					var user = msg.user;
					if(userName.length > 9){
						user.userName = userName.substr(0,8)+"...";
						$(".userName1").html(user.userName);
						$("#userName").val(user.userName);
					}
					$(".userName1").html(user.userName);
					$("#userName").val(user.userName);
					
					if(msg.message == "TransportingOrder_queryFail")
					{
						$("#transOrder").html("查询失败");
					}else{
						$("#transOrder").html("(" + user.transportingOrder + ")");
					}
					
					if(msg.message == "RefundPaymentOrder_queryFail")
					{
						$("#payOrder").html("查询失败");
					}else{
						$("#payOrder").html("(" + user.refundPaymentOrder + ")");
					}
					
					$("#unreadMessages").html("(" + user.siteMessage + ")");
					$("#unuseCoupon").html("<u>(" + user.unuseCoupon+")</u>");
				},
				error:function(data){
					show_error();
				}
			});
		};
		
		$(".notLogin").hide();
		if($("#isNew").val()=="new"){
			$(".loginTemp").show();
			$(".login").hide();
		}else{
			$(".loginTemp").show();
			$(".login").hide();
		}
		
		var td = new Date();
		var h = td.getHours();
		var currTime = "";
		if(h<8){
			currTime = "早上好 ,";
		}
		if(h>=8&&h<12){
			currTime = "上午好 ,";
		}
		if(h>=12&&h<13){
			currTime = "中午好 ,";
		}
		if(h>=13&&h<18){
			currTime = "下午好 ,";
		}
		if(h>=18){
			currTime = "晚上好 ,";
		}
		$(".currentTime").html(currTime);
		//alert(userName+"+public");
		$("#uname1").html(userName);
		if(userName.length > 10){
		  userName=userName.substr(0,8)+"...";
		  $(".userName1").html(userName);
		}
		$(".userName1").html(userName);
		
		queryajax();
	}
}

//hjj


$(".button-l").hover(
	function(){$(this).addClass("button-l-hover") ; } ,
	function(){$(this).removeClass("button-l-hover") ; }
);
$(".button-l").mousedown(function(){
	$(this).addClass("button-l-down");
	$(this).mouseup(function(){
		$(this).removeClass("button-l-down");		 
	 });
});


//添加页面微信推广取消效果
$(".t_cancel").click(function(){
	$(".t-code").hide();
});


//中图按钮点击 mouserdown效果

$(".tosnmiddle_btn").hover(
	function(){$(this).addClass("tosn_mouseover");},
	function(){$(this).removeClass("tosn_mouseover");}
);
$(".tosnmiddle_btn").mousedown(function(){
	$(this).addClass("tosn_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosn_mousedown");		 
	 });
});

//中图黄色按钮点击 mouserdown效果

$(".tosnmiddle_btn_c").hover(
	function(){$(this).addClass("tosn_mouseover_c");},
	function(){$(this).removeClass("tosn_mouseover_c");}
);
$(".tosnmiddle_btn_c").mousedown(function(){
	$(this).addClass("tosn_mousedown_c");
	$(this).mouseup(function(){
		$(this).removeClass("tosn_mousedown_c");		 
	 });
});

//中图按钮长一点的

$(".tosnmiddle_btnl").hover(
	function(){$(this).addClass("tosnl_mouseover");},
	function(){$(this).removeClass("tosnl_mouseover");}
);
$(".tosnmiddle_btnl").mousedown(function(){
	$(this).addClass("tosnl_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnl_mousedown");		 
	 });
});

//中图灰色按钮
$(".tosnmiddle_btns").hover(
	function(){$(this).addClass("tosns_mouseover");},
	function(){$(this).removeClass("tosns_mouseover");}				 
);
$(".tosnmiddle_btns").mousedown(function(){
	$(this).addClass("tosns_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosns_mousedown");		 
	 });
});
//小图长一点的
$(".new_smallbtnl").hover(
		function(){$(this).addClass("new_smallbtnl_mouseover");},
		function(){$(this).removeClass("new_smallbtnl_mouseover");}				 
	);
$(".new_smallbtnl").mousedown(function(){
		$(this).addClass("new_smallbtnl_mousedown");
		$(this).mouseup(function(){
		$(this).removeClass("new_smallbtnl_mousedown");		 
	 });
});
//小图按钮点击Mouserdown效果

$(".tosnsmall_btn").hover(
	function(){$(this).addClass("tosnsml_mouseover");},
	function(){$(this).removeClass("tosnsml_mouseover");}
);
$(".tosnsmall_btn").mousedown(function(){
	$(this).addClass("tosnsml_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnsml_mousedown");		 
	 });
});
//小图灰色按钮
$(".tosnsmall_btns").delegate("","mouseover",
	function(){$(this).addClass("tosnsmall_btns_mouseover");}
);
$(".tosnsmall_btns").delegate("","mouseout",
		function(){$(this).removeClass("tosnsmall_btns_mouseover");}
	);

$(".tosnsmall_btns").mousedown(function(){
	$(this).addClass("tosnsmall_btns_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnsmall_btns_mousedown");		 
	 });
});

//小图按钮长一点的
$(".tosnsmall_btnl").hover(
	function(){$(this).addClass("tosnsmll_mouseover");},
	function(){$(this).removeClass("tosnsmll_mouseover");}
);
$(".tosnsmall_btnl").mousedown(function(){
	$(this).addClass("tosnsmll_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnsmll_mousedown");		 
	 });
});

//小图灰色长一点
$(".tosnsmalls_btnl").hover(
	function(){$(this).addClass("tosnsmlls_mouseover");},
	function(){$(this).removeClass("tosnsmlls_mouseover");}
);
$(".tosnsmalls_btnl").mousedown(function(){
	$(this).addClass("tosnsmlls_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnsmlls_mousedown");		 
	 });
});

//小图灰色加长按钮
$(".tosnsamll_btnal").hover(
	function(){$(this).addClass("tosnsamll_btnal_mouseover");},
	function(){$(this).removeClass("tosnsamll_btnal_mouseover");}
);
$(".tosnsamll_btnal").mousedown(function(){
	$(this).addClass("tosnsamll_btnal_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnsamll_btnal_mousedown");		 
	 });
});

// 首页网上订单按钮
$(".tosnBig").hover(
	function(){$(this).addClass("tosnBig_mouseover");},
	function(){$(this).removeClass("tosnBig_mouseover");}
);
$(".tosnBig").mousedown(function(){
	$(this).addClass("tosnBig_mousedown");
	$(this).mouseup(function(){
		$(this).removeClass("tosnBig_mousedown");		 
	 });
});

//微信详细地址过滤#
(function(){
	$(".addFilterChar").live("blur",function(){
//		var remObj = $(this);
		var add = $(this).val();
		while(add.indexOf("#")>=0){
			add = add.replace("#","");
		}
		$(this).val(add);
	});
})();

//公用focus blur 效果  (请在需要的控件上  加上 inputFocus 类， 并添加ov="原始的value"即可)
(function(){
	$(function(){
		$.each($(".inputFocus"),function(index,input){
			   if($(input).val()==$(input).attr("ov")){
				   $(input).addClass("iGrays");		
			   }
		});
	});
	$(".inputFocus").live("focus",function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		$(this).removeClass("iGrays");
		if(val==ov){
			$(this).val("");
		}

	});
 	$(".inputFocus").live("blur",function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		if(val==""){
			$(this).val(ov).addClass("iGrays");
		}
	 });
 	
 	/* $(".inputFocus").live("focus",function(){
			var ov=$.trim($(this).attr("ov"));
			var val=$.trim($(this).val());
			if(val==ov){
				$(this).val("");
			}
			$(this).css("color","black");
		});
		
	 	$(".inputFocus").live("blur",function(){
			var ov=$.trim($(this).attr("ov"));
			var val=$.trim($(this).val());
			if(val==""){
				$(this).val(ov);
				$(this).css("color","#ccc");
			}
		 }); */
 	
	})();

//公用tab切换 (请注意dom结构)
function  tabEffect(t,c){
	var e=$(t).children();
	var s=e.size();
	var c=$(c).children();
	e.find("a").click(function(){
		e.find("a").removeClass("current");
		$(this).addClass("current");
		var index=$(this).parent().index();
		c.hide().eq(index).show();
	});
}
	//去除链接，按钮虚线框 
	$("a").bind("focus",function() {
	if(this.blur) {this.blur();};
	});
	$(":submit").bind("focus",function() {
	if(this.blur) {this.blur();};
	});
	$(":button").bind("focus",function() {
	if(this.blur) {this.blur();};
	});
//左右点击切换文字
(function(){
	$(".ts-next").click(function(){
		    clearInterval(tftimes);			 
			$("#ad").find("ul:first").animate({
			    marginLeft:"-570px"
		    },200,function(){
			    $(this).css({marginLeft:"0px"}).find("li:first").appendTo(this);
		  });					 
	});
	$(".ts-preave").click(function(){
           clearInterval(tftimes);			 					   
			$("#ad").find("ul:first").animate({
			    marginLeft:"-570px"
		  },200,function(){
			    $(this).css({marginLeft:"0px"}).find("li:first").appendTo(this);
		  });					 
	});

})();
// 自动切换广告
	function preavepic(){
		  $("#ad").find("ul:first").animate({
			    marginBottom:"-35px"
		  },200,function(){
			    $(this).css({marginBottom:"0px"}).find("li:first").appendTo(this);
		  });	
	}
	
// var tftimes = setInterval("preavepic()", 5000);  
	
//省市选择
(function(){
	$(".proCitySel").click(function(event){
		if($("body").data("allExistCitys") == null){
			sendCitiesAjax();
		}
	
		$(this).select();
		$(".provinceCityAll").hide();
		$(".provinceCity").hide();
		$("#dimCityQuery").hide();
		var o=$(this).offset();
		var l=o.left;
		var t=o.top;
		var h=$(this).height();
		$(".provinceCity").css("top",t+h-1).css("left",l).toggle();
		//增加ifname遮罩select
	    $(".backifname").css("top",t+h-1).css("left",l).show();
		$(".provinceCity").click(function(event){
			event.stopPropagation();
		});
		
		event.stopPropagation();
		$("html").click(function(){
			$(".provinceCity").hide();
			//判断是否有弹出层
			if($(".popupframe:visible").size() == 0){
				$(".backifname").hide();
			}else{
				$(".backifname").show();
			}
		});

    	$("input.proCitySel").removeClass("current1");

	    $(this).addClass("current1");
	    
//	    var tb=$(".provinceCity .tabs .current").attr("tb");
//	    $(".provinceCity").find(".tabs").find("a[tb="+tb+"]").addClass("current");
	    $(".provinceCity").find(".tabs").find("a").removeClass("current");
	    $(".provinceCity").find(".tabs").find("a[tb=hotCity]").addClass("current");
		$(".provinceCity").find(".con").children().hide();
//		$(".provinceCity").find(".con").find("."+tb).show();
		$(".provinceCity").find(".con").find(".hotCity").show();
		
		if($("body").data("allExistProvinces") == null){
			sendProvinceAjax();
		}
		//2012-09-28 邓夫伟 存在网点的区县改为点击城市后根据城市ID获取
//		if($("body").data("allExistCountys") == null){
//			sendCountiesAjax();
//		}
		
	});
	//tab切换
	$(".provinceCity").find(".tabs").find("a").click(function(){
		//如果当前省份未选择且点击的是城市或者区县页，则点击无效
		if($(this).attr("tb")=="city" && $(".province .list .current").val() == null){
			return;
		};
		//如果当前城市未选择且点击的是区县页，则点击无效
		if($(this).attr("tb")=="county" && $(".city .list .current").val() == null && $(".hotCity .list .current").val() ==null){
			return;
		};
		$(".provinceCity").find(".tabs").find("a").removeClass("current");
		$(this).addClass("current");
		var tb=$(this).attr("tb");
		$(".provinceCity").find(".con").children().hide();
		$(".provinceCity").find(".con").find("."+tb).show();
	});
})();
//省市选择
(function(){
	$(".proCitySel_Img").click(function(event){
		event.stopPropagation();
		$(this).prev().trigger("click");	
	});
})();

//省市选择--All
(function(){
	isDifferentSelect =$(".proCitySelAll").hasClass('noArea2'); 
	$(".proCitySelAll").click(function(event){
		if($("body").data("CitysAll") == null){
			if(isDifferentSelect==true){
				sendAllCitiesAjax2();
			}else{
				sendAllCitiesAjax();
			}
		}
		
		$(this).select();
		$(".provinceCity").hide();
		$(".provinceCityAll").hide();
		$("#dimCityQuery").hide();
		var o2=$(this).offset();
		var l2=o2.left;
		var t2=o2.top;
		var h2=$(this).height();
		$(".provinceCityAll").css("top",t2+h2-1).css("left",l2).toggle();
		
		//增加ifname遮罩select
		$(".backifname").css("top",t2+h2-1).css("left",l2).show();
		$(".provinceCityAll").click(function(event){
			event.stopPropagation();
		});
		
		event.stopPropagation();
		$("html").click(function(){
			if($("#arrivedCityId").val() == null || $("#arrivedCityId").val() == ""){
				$(".s_city").trigger("changeMe");
			}
				$(".provinceCityAll").hide();
				/*在省市（所有）控件选择，然后弹出其他层，随处点击一下，这句将执行，遮挡层消失 2012-4-11 邓夫伟*/
//				$(".backifname").hide();
				if($(".popupframe:visible").size() == 0){
					$(".backifname").hide();
				}else{
					$(".backifname").show();
				}
				// add by zhangjianjun
				var inputStr = $(".noArea2").val();
				if(inputStr!=null && inputStr!="" && inputStr!="请选择/输入城市名称"){
					var arr = inputStr.split("-");
					if(arr[1]==null){
						$(".noArea2").val("");
					}
				}
				
		});
		$("input.proCitySelAll").removeClass("current2");

		$(this).addClass("current2");
//		var tb=$(".provinceCityAll .tabs .current").attr("tb");
		// 显示当前面板
//		$(".provinceCityAll").find(".tabs").find("a[tb="+tb+"]").addClass("current");
		// 初始化面板，显示热门城市
		$(".provinceCityAll").find(".tabs").find("a").removeClass("current");
		$(".provinceCityAll").find(".tabs").find("a[tb=hotCityAll]").addClass("current");
		$(".provinceCityAll").find(".con").children().hide();
//		$(".provinceCityAll").find(".con").find("."+tb).show();
		$(".provinceCityAll").find(".con").find(".hotCityAll").show();
		
		if($("body").data("allProvinces") == null){
//			sendAllProvinceAjax();
			if(isDifferentSelect==true){
				sendConSendProvinceAjax();
			}else{
				sendAllProvinceAjax();
			}
		}
		//2012-09-28 邓夫伟 区县改为选择城市后根据城市ID请求数据
//		if($("body").data("allCountys") == null){
//			sendAllCountiesAjax();
//		}
		
		//tab切换
		$(".provinceCityAll").find(".tabs").find("a").click(function(){
			//如果当前省份未选择且点击的是城市页，则点击无效
			if($(this).attr("tb")=="cityAll"&& $(".provinceAll .list .current").val() == null){
				return;
			};
			//如果当前城市未选择且点击的是区县页，则点击无效
			if($(this).attr("tb")=="countyAll" && $(".cityAll .list .current").val() == null && $(".hotCityAll .list .current").val() ==null){
				return;
			};
			$(".provinceCityAll").find(".tabs").find("a").removeClass("current");
			$(this).addClass("current");
			var tb=$(this).attr("tb");
			$(".provinceCityAll").find(".con").children().hide();
			$(".provinceCityAll").find(".con").find("."+tb).show();
		});
		
	});
})();
// 省市图片点击选择
(function(){
	$(".proCitySelAll_Img").click(function(event){
		event.stopPropagation();
		$(this).prev().trigger("click");
	});
	
})();

//公用focus blur 效果  (请在需要的控件上  加上 inputFocus 类， 并添加ov="原始的value"即可)
(function(){
	$(function(){
			$.each($(".inputFocus"),function(index,input){
				   if($(input).val()==$(input).attr("ov")){
					   $(input).addClass("iGrays");		
				   }
			});
	});

	$(".inputFocus").focus(function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		$(this).removeClass("iGrays");
		if(val==ov){
			$(this).val("");
		}

	});
 	$(".inputFocus").blur(function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		if(val==""){
			$(this).val(ov).addClass("iGrays");
		}
	 });
	}
)();
	
	// 幻灯广告
(function(){
			var picNum=$("div.flashPic img").size(); 
			var isNum=0; 
			var str=[];
			var imgDiv=$("div.flashPic");
			var $div=$("div.picNum");//数字容器
			imgDiv.find("img").hide().eq(0).show();
			for(var i=0;i<picNum;i++){
				str[i]="<a href='#'>"+(i+1)+"</a>";
			}
			$div.html(str.join("")); 
			$div.find("a:eq(0)").addClass("on");
			function MovePic(){
				if((isNum+1)>=picNum){
					isNum=0;
				}
				else{
					isNum=isNum+1;	
				}					
				imgDiv.find("img").hide().eq(isNum).fadeIn(500); 
				$div.find("a").removeClass("on").eq(isNum).addClass("on"); //  
			}
			var setFn=setInterval(MovePic,4000);
			// 执行点击数字 显示图片
			$div.find("a").click(function(){   //点击方法 遍历 连接标签
			    clearInterval(setFn);  //结束自动播放功能
				var j=$(this).index(); // 定义索引
				$div.find("a").removeClass("on").siblings().stop(true,true).eq(j).addClass("on"); 
				imgDiv.find("img").hide();
				imgDiv.find("img").eq(j).fadeIn(500);
				isNum=j;
				setFn=setInterval(MovePic,4000);//调用自动播放功能
			});		
			
})();
	

//错误提示信息
function wrongMsg(object,msg){
	  $(".wrongMsg").text(msg);
	  object.addClass("wrong");
	}


/*
 * 订单页面的错误提示层
 * 
 * @author 欧阳明睿
 * @date 2012-06-14
 */
var setOrderFn;
function order_wrongMsg(object,msg){
	  clearInterval(setOrderFn); 
	  object.addClass("wrong");
	  $(".wrongMsg").text(msg);
	  $(".wrongInfo").remove();
	  //若使用offset将导致城市控件定位有问题
	  var position = object.position();
	  var height = object.height();
	  var css = {
			  "left" : position.left, 
			  "top" : position.top+height, 
			  "position": "absolute",
			  "_position":"absolute",
			  "border": "1px solid #FFE690",
			  "z-index":"99",
			  "background-color": "#FFFEDF",
			 " text-align": "center"
	  };
	  
    object.before("<div class='wrongInfo'>"+msg+"</div>");
    $(".wrongInfo").css(css);
    //5秒后自动消失
    setOrderFn=setInterval(MovePic,5000);
    function MovePic(){
    	$(".wrongInfo").fadeOut();
    	clearInterval(setOrderFn); 
    }
    //点击消失
	  $(".wrongInfo").click(function(){
		   clearInterval(setOrderFn);  
	    	$(".wrongInfo").fadeOut();
	  });
}
/**
 * 错误提示层，不自动消失
 */
function wrongMsg_notOut(object,msg){
	  object.addClass("wrong");
	  $(".wrongInfo"+$(object).attr("id")).remove();
	  //若使用offset将导致城市控件定位有问题
	  var position = object.position();
	  var height = object.height();
	  var css = {
			  "left" : position.left, 
			  "top" : position.top+height, 
			  "position": "absolute",
			  "_position":"absolute",
			  "border": "1px solid #FFE690",
			  "z-index":"99",
			  "background-color": "#FFFEDF",
			 " text-align": "center"
	  };
	  
  object.before("<div class='wrongInfo"+$(object).attr("id")+"'>"+msg+"</div>");
  $(".wrongInfo"+$(object).attr("id")).css(css);
  //点击消失
  $(".wrongInfo"+$(object).attr("id")).click(function(){
	   clearInterval(setOrderFn);  
    	$(".wrongInfo"+$(object).attr("id")).fadeOut();
  });
}
function wrongMsg_hide(object){
	object.removeClass("wrong");
	 $(".wrongInfo"+$(object).attr("id")).fadeOut();
}
/*
 * 订单页面的提示层
 * 框不变红
 * @author zenghong
 * @date 2013-7-19
 */
var setOrderFn1;
function order_Msg(object,msg){
	  clearInterval(setOrderFn1); 
//	  object.addClass("wrong");
//	  $(".wrongMsg").text(msg);
	  $(".orderInfo").remove();
	  //若使用offset将导致城市控件定位有问题
	  var position = object.position();
	  var height = object.height();
	  var css = {
			  "left" : position.left-100, 
			  "top" : position.top+height+50, 
			  "position": "absolute",
			  "_position":"absolute",
			  "border": "1px solid #FFE690",
			  "z-index":"99",
			  "background-color": "#FFFEDF",
			 " text-align": "center"
	  };
	  
  object.before("<div class='orderInfo'>"+msg+"</div>");
  $(".orderInfo").css(css);
  //5秒后自动消失
  setOrderFn1=setInterval(MovePic,5000);
  function MovePic(){
  	$(".orderInfo").fadeOut();
  	clearInterval(setOrderFn1); 
  }
  //点击消失
	  $(".orderInfo").click(function(){
		   clearInterval(setOrderFn1);  
	    	$(".orderInfo").fadeOut();
	  });
}
function map_wrongMsg(object,msg){
	  $(".map_wrongMsg").text(msg);
	  object.removeClass("city");
	  object.addClass("city_wrong");
	}
function cargo_wrongMsg(object,msg){
	  $(".cargowrong").text(msg);
	  object.addClass("wrong");
	}

//菜单收缩
(function(){
		   var menu = $(".ts-padding");
		   menu.click(function(){
			$(this).next(".ts-updown").toggle();
			if($(this).find("span").hasClass("ts-left")){
			   $(this).find(".ts-left").removeClass("ts-left").addClass("ts-up");
				}
			else
			{
			   $(this).find(".ts-up").removeClass("ts-up").addClass("ts-left");
				}				 
		  });
		 
		  })();

/**
 * 导航栏
 * 
 * @author 欧阳明睿
 */
$(function(){
		var li = $(".navigation ul").find(".cname");
		var currentValue = $.trim($(".header").attr("cv"));
		if(currentValue=='首页')
		{
		  //  li.eq(1).addClass("tf_count");
		}
		if(currentValue=='我的德邦')
		{
			li.eq(0).addClass("tf_count").css({"color":"#fff"});
			$("#div-mydeppon").show();
		}
		if(currentValue=='网上托运')
		{   
			li.eq(1).addClass("tf_count").css({"color":"#fff"});
			$("#div-trans-online").show();
		}
		if(currentValue=='货物追踪')
		{
			li.eq(2).addClass("tf_count").css({"color":"#fff"});
			$("#div-track-receive").show();
		}
		if(currentValue=='业务介绍')
		{
			li.eq(3).addClass("tf_count").css({"color":"#fff"});
		}
		if(currentValue=='帮助与支持')
		{
			li.eq(4).addClass("tf_count").css({"color":"#fff"});
		}
		if(currentValue=='关于德邦')
		{
			li.eq(5).addClass("tf_count").css({"color":"#fff"});
		}
		if(currentValue=='合伙人申请')
		{
			li.eq(6).addClass("tf_count").css({"color":"#fff"});
			$("#div-partner-apply").show();
		}
		if(currentValue=='区域负责人')
		{
			li.eq(7).addClass("tf_count").css({"color":"#fff"});
			$("#div-partner-apply").show();
		}
	});

/**
 * 侧边栏
 * 
 * @author 欧阳明睿
 */
$(function(){
	//我的德邦侧边栏
	var tv_div = $("div.bcm div.ts-padding");
	var cv_li = $("div.bcm ul").find("li a");
	//网上托运侧边栏
	var trans_li = $("div.bcm ul.pngOpacity").find("li");
	//事业合伙人侧边栏
	var partner_div = $("div.bcm li.ts-partnerModule");
	var partner_li = $("div.bcm ul.partner").find("li a");
	//当前值
	var tv = $.trim($(".siderBar").attr("tv"));
	var cv = $.trim($(".siderBar").attr("cv"));
	

	//追踪与收获 END
	
	// 我的德邦 START
	if(tv=="我的订单")
	{
		var currentClass=$(".ts-padding");
		currentClass.eq(0).next(".ts-updown").toggle(true);
		currentClass.eq(1).next(".ts-updown").toggle(false);
		currentClass.eq(2).next(".ts-updown").toggle(false);
		currentClass.eq(3).next(".ts-updown").toggle(false);
		//tv_div.eq(0).next(".ts-updown").show();
	}
	
	if(tv=="更改管理")
	{
		var currentClass=$(".ts-padding");
		currentClass.eq(0).next(".ts-updown").toggle(false);
		$(this).find(".ts-left").removeClass("ts-left").addClass("ts-up");
		currentClass.eq(1).next(".ts-updown").toggle(true);
		$("#span_dgif2").removeClass("ts-up").addClass("ts-left");
		currentClass.eq(2).next(".ts-updown").toggle(false);
		//tv_div.eq(1).next(".ts-updown").show();
	}
	
	if(tv=="我的账单")
	{
		var currentClass=$(".ts-padding");
		currentClass.eq(0).next(".ts-updown").toggle(false);
		currentClass.eq(1).next(".ts-updown").toggle(false);
		currentClass.eq(2).next(".ts-updown").toggle(true);
		$("#span_dgif").removeClass("ts-left").addClass("ts-up");
		$("#span_dgif2").removeClass("ts-left").addClass("ts-up");
		$("#span_zgif3").removeClass("ts-up").addClass("ts-left");
		//tv_div.eq(1).next(".ts-updown").show();

	}
	if(tv=="收发货人管理")
	{
		var currentClass=$(".ts-padding");
		currentClass.eq(0).next(".ts-updown").toggle(false);
		currentClass.eq(1).next(".ts-updown").toggle(false);
		currentClass.eq(2).next(".ts-updown").toggle(false);
		currentClass.eq(3).next(".ts-updown").toggle(true);
		$("#span_dgif").removeClass("ts-left").addClass("ts-up");
		$("#span_dgif2").removeClass("ts-left").addClass("ts-up");
		$("#span_zgif3").removeClass("ts-left").addClass("ts-up");
		$("#span_dgif4").removeClass("ts-up").addClass("ts-left");


	}
	if(tv=="在线理赔")
	{
		tv_div.eq(4).addClass("ts-current");


	}
	if(tv=="站内消息")
	{
		tv_div.eq(5).addClass("ts-current");
	}
	if(tv=="个人资料设置")
	{
		tv_div.eq(6).addClass("ts-current");

	}
	if(tv=="我的优惠券"){
		tv_div.eq(7).addClass("ts-current");
	
	}
	
	if(tv=="我要贷款"){
		tv_div.eq(8).addClass("ts-current");
		tv_div.eq(8).children("a").removeClass("ts-dpng1");
		tv_div.eq(8).children("a").addClass("ts-dpng");
	}
	
	if(tv=="电子发票"){
		tv_div.eq(9).addClass("ts-current");
	}
	
	if(cv=="我的发货单")
	{
		cv_li.eq(0).addClass("current");

	}
	if(cv=="我的收货单")
	{
		cv_li.eq(1).addClass("current");

	}
	if(cv=="原始订单")
	{
		cv_li.eq(2).addClass("current");

	}
	if(cv=="模板管理")
	{
		cv_li.eq(3).addClass("current");

	}
	if(cv=="查询打印电子运单")
	{
		cv_li.eq(4).addClass("current");

	}
	
	if(cv=="更改申请")
	{
		cv_li.eq(5).addClass("current");

	}
	if(cv=="更改查询")
	{
		cv_li.eq(6).addClass("current");

	}
	
	
	if(cv=="我要支付")
	{
		cv_li.eq(7).addClass("current");

	}
	if(cv=="已有账单")
	{
		cv_li.eq(8).addClass("current");

	}
	
	if(cv=="代收货款")
	{
		cv_li.eq(9).addClass("current");
		
	} 
	if(cv=="发货人管理")
	{
		cv_li.eq(10).addClass("current");

	}
	if(cv=="收货人管理")
	{
		cv_li.eq(11).addClass("current");

	}
	// 我的德邦 END
	
	// 网上托运 START
	if(cv=="新版网上下单")
	{
		trans_li.eq(0).find("a").addClass("current");
	}
	else if(cv=="网上下单")
	{
		trans_li.eq(1).find("a").addClass("current");
	}
	else if(cv=="批量下单")
	{
		trans_li.eq(2).find("a").addClass("current");
	}
	else if(cv=="价格/时效查询")
	{
		trans_li.eq(3).find("a").addClass("current");

	}
	else if(cv=="网点查询")
	{
		trans_li.eq(4).find("a").addClass("current");

	}
	else if(cv=="快递收送货范围")
	{
		trans_li.eq(5).find("a").addClass("current");

	}
	else if(cv=="禁运品")
	{
		trans_li.eq(6).find("a").addClass("current");
	}// 网上托运 END
	
	//追踪与收获 START
	if(cv=="货物追踪")
	{
		trans_li.eq(7).find("a").addClass("current");

	}
	if(cv=="我的收货单")
	{
		trans_li.eq(8).find("a").addClass("current");

	}//追踪与收获 END
	//合伙人申请 START
	if(cv=="合伙人申请"){
		partner_div.eq(2).find("a").addClass("current");
	}
	if(cv=="区域负责人"){
		partner_div.eq(1).find("a").addClass("current");
	}
});


/* 
 * 
 * 省市模糊查询
 * 
 * @author 欧阳明睿
 */
(function(){
	//省市模糊查询
	var clkIndex = null;
	var currentClass = null;
	var allCitys = null;
	var allProvinces = null;
	var allCountys = null;
	var thisObj = null;
	isDifferentSelect =$(".proCitySelAll").hasClass('noArea2'); 
	var dimCityDiv="<div id='dimCityQuery'><ul></ul></div>";
	$("body").append(dimCityDiv);
	$("body").delegate(".proCityQuery,.proCityQueryAll" , ($.browser.opera ? "keypress" : "keyup") , function(event){
		if($("#dimCityQuery:visible").size()==0){
			$(".backifname").hide();
		}
		$(".provinceCity").hide();
		$(".provinceCityAll").hide();
		if($(this).attr("id")!="caddrProDept"){
			$(".change_mode").empty();
			$("#transType").attr('value','5');
		}
		//将网点下拉框变为可用状态 zenghong 2013-8-20
		//如果发货网点是香港，则不变成可用状态 zenghong 2013-10-10
		if($(".f_inter").length>0){
			var arr =$(".f_inter").val().split('-');
			var pname = arr[0];
			if('香港特别行政区'!=pname && "香港"!=pname){
				$(".dot_select").attr('disabled', false);
			}
		}
		if($("#transType").val()==7 || $("#transType").val()==8 || $("#transType").val()==14)
			$(".dot_select").attr('disabled', true);

		//2012-10-09 邓夫伟 在清除运输方式的时候把运输方式置为汽运偏线
		
		//当省市文本框发生按钮事件时，清空出发城市和到达城市，防止用户手动输入时也可以以之前的CODE查询公布价
		//区分是出发城市还是到达城市，清空对应的就行
		if($(this).attr("name") == "leavedCity" || $(this).hasClass("f_inter")){
			$("#leavedCityId").val("");
		} else if($(this).attr("name") == "arrivedCity" || $(this).hasClass("s_city")){
			$("#arrivedCityId").val("");
		} else if($(this).hasClass("f_city")){
			//zenghong 2013-8-1 地址城市控件有输入时，把隐藏域leaveadCityIdPG清空
			$("#leavedCityIdPG").val("");
		}
		

		if($(this).hasClass("proCityQueryAll"))
		{
			if($("body").data("allProvinces") == null){
				if(isDifferentSelect==true){
					sendConSendProvinceAjax();
				}else{
					sendAllProvinceAjax();
				}
			}
			if($("body").data("CitysAll") == null){
//				sendAllCitiesAjax();
				if(isDifferentSelect==true){
					sendAllCitiesAjax2();
				}else{
					sendAllCitiesAjax();
				}
			}
			if($("body").data("allCountys") == null){
				sendAllCountiesAjax();
			}
			currentClass="proCityQueryAll";
			clkIndex=$("body").find(".proCityQueryAll").index(this);
			allCitys=$("body").data("CitysAll");
			allProvinces=$("body").data("allProvinces");
			allCountys=$("body").data("allCountys");
			thisObj = $(this);
		}
		if($(this).hasClass("proCityQuery"))
		{
			if($("body").data("allExistProvinces") == null){
				sendProvinceAjax();
			}
			if($("body").data("allExistCitys") == null){
				sendCitiesAjax();
			}
			if($("body").data("allExistCountys") == null){
				sendCountiesAjax();
			}
			currentClass="proCityQuery";
			clkIndex=$("body").find(".proCityQuery").index(this);
			allCitys=$("body").data("allExistCitys");
			allProvinces=$("body").data("allExistProvinces");
			allCountys=$("body").data("allExistCountys");
			thisObj = $(this);
		}
		
		lastKeyPressCode = event.keyCode;//获取键盘值
		switch(lastKeyPressCode) {
			case 40:  //方向键下
				$("#dimCityQuery").trigger("selNext");
				return false;
				break;
			case 38: //方向键上
				$("#dimCityQuery").trigger("selPrev");
				return false;
				break;
			case 13: //确定键
				$("#dimCityQuery").trigger("enter");
				return false;
				break;
		}
		v=$.trim($(this).val());
		if (v=="" || v==null) {return false;}
		
		$(".provinceCity").hide();
		var o=$(this).offset();
		var l=o.left;
		var t=o.top;
//		var w=$(this).width();
		var h=$(this).height();
		//定义弹出层dom结构
		var htmlArr=[];
		var autoWidth;
		/**
		 add by zhangjianjun
		 收送货范围查询处不需要查询出区县信息
		*/
		var isNeedCountys = $(this).hasClass("noArea2");
		if(!isNeedCountys){
		//查询匹配的区县
		for( i = 0 ; i < allCountys.length;i++){
			if(! allCountys[i].pinYinChar || !allCountys[i].pinYin) continue;
			if(v.toUpperCase() === allCountys[i].pinYinChar.substring(0, v.length)){
				htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCountys[i].provinceId+" cityId="+allCountys[i].cityId+" countyId="+allCountys[i].id+">"+allCountys[i].cityName+"-"+allCountys[i].areaName+" (<span style='color:red'>"+v.toUpperCase()+"</span>"+allCountys[i].pinYinChar.substring(v.length, allCountys[i].pinYinChar.length)+")</a></li>";
				if(htmlArr.length>9){
					break;
					return false;
				}
				autoWidth = autoWidth < (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYinChar).length ? (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYinChar).length : autoWidth;
				continue;
			};
			if(!allCountys[i].areaName){
				continue;
			}
			if(v === allCountys[i].areaName.substring(0, v.length)){
				htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCountys[i].provinceId+" cityId="+allCountys[i].cityId+" countyId="+allCountys[i].id+">"+allCountys[i].cityName+"-"+"<span style='color:red'>"+v+"</span>"+allCountys[i].areaName.substring(v.length,allCountys[i].areaName.length)+" ("+allCountys[i].pinYinChar+")</a></li>";
				if(htmlArr.length>9){
					break;
					return false;
				}
				autoWidth = autoWidth < (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYinChar).length ? (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYinChar).length : autoWidth;
				continue;
			};
			if(!allCountys[i].pinYin){
				continue;
			}
			if(v.toLowerCase() === allCountys[i].pinYin.substring(0, v.length)){
				htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCountys[i].provinceId+" cityId="+allCountys[i].cityId+" countyId="+allCountys[i].id+">"+allCountys[i].cityName+"-"+allCountys[i].areaName+" (<span style='color:red'>"+v.toLowerCase()+"</span>"+allCountys[i].pinYin.substring(v.length, allCountys[i].pinYin.length)+")</a></li>";

				if(htmlArr.length>9){
					break;
					return false;
				}
				autoWidth = autoWidth < (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYin).length ? (allCountys[i].cityName+allCountys[i].areaName+allCountys[i].pinYin).length : autoWidth;
				continue;
				};
			}
		}
		//如果是匹配有营业网点的城市
//		if($(this).hasClass("proCityQuery"))
//		{
			for (var i=0;i<allCitys.cities.length;i++){
				if(!allCitys.cities[i].cityShortPY){
					continue;
				}
				if(! allCitys.cities[i].cityShortPY || ! allCitys.cities[i].cityPinyin) continue;
				
				if(v.toUpperCase() === allCitys.cities[i].cityShortPY.substring(0, v.length)){
					htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCitys.cities[i].provinceId+" cityId="+allCitys.cities[i].id+">"+allCitys.cities[i].name+" (<span style='color:red'>"+v.toUpperCase()+"</span>"+allCitys.cities[i].cityShortPY.substring(v.length, allCitys.cities[i].cityShortPY.length)+")</a></li>";
					if(htmlArr.length>9){
						break;
						return false;
					}
					autoWidth = autoWidth < (allCitys.cities[i].name+allCitys.cities[i].cityShortPY).length ? (allCitys.cities[i].name+allCitys.cities[i].cityShortPY).length : autoWidth;
					continue;
				};
				if(!allCitys.cities[i].name){
					continue;
				}
				if(v === allCitys.cities[i].name.substring(0, v.length)){
					htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCitys.cities[i].provinceId+" cityId="+allCitys.cities[i].id+"><span style='color:red'>"+v+"</span>"+allCitys.cities[i].name.substring(v.length,allCitys.cities[i].name.length)+" ("+allCitys.cities[i].cityShortPY+")</a></li>";
					if(htmlArr.length>9){
						break;
						return false;
					}
					autoWidth = autoWidth < (allCitys.cities[i].name+allCitys.cities[i].cityShortPY).length ? (allCitys.cities[i].name+allCitys.cities[i].cityShortPY).length : autoWidth;
					continue;
				};
				if(!allCitys.cities[i].cityPinyin){
					continue;
				}
				if(v.toLowerCase() === allCitys.cities[i].cityPinyin.substring(0, v.length)){
					htmlArr[htmlArr.length]="<li><a class='allcityClass' href='javascript:' provinceId="+allCitys.cities[i].provinceId+" cityId="+allCitys.cities[i].id+">"+allCitys.cities[i].name+" (<span style='color:red'>"+v.toLowerCase()+"</span>"+allCitys.cities[i].cityPinyin.substring(v.length, allCitys.cities[i].cityPinyin.length)+")</a></li>";
	
					if(htmlArr.length>9){
						break;
						return false;
					}
					autoWidth = autoWidth < (allCitys.cities[i].name+allCitys.cities[i].cityPinyin).length ? (allCitys.cities[i].name+allCitys.cities[i].cityPinyin).length : autoWidth;
					continue;
				};
			};
//		}
		
		/**
		 * 修改：2012-3-28 邓夫伟 显示遮层
		 */
		if(htmlArr=="" || htmlArr==null){
			//如果没有数据
			$("#dimCityQuery ul").html("<li class='none'>对不起,没有找到该城市</li>");
//			$(".backifname").show();
			return false;
		}else{
			$("#dimCityQuery ul").html(htmlArr.join("")).find("li:first").addClass("current");
			//将当前选择值填入文本框
//			var vm=$("#dimCityQuery ul").find("li.current a").text();
//			vm=vm.split("(");
//			if(currentClass=="proCityQueryAll")
//			{
//				$("body").find(".proCityQueryAll").eq( clkIndex ).val($.trim(vm[0]));
//			}
//			if(currentClass=="proCityQuery")
//			{
//				$("body").find(".proCityQuery").eq( clkIndex ).val( $.trim(vm[0]) );
//			}
		};
		//定位弹出层
		if(autoWidth<200) {autoWidth = 200;}
		$("#dimCityQuery").css("width",autoWidth).css("top",t+h-1).css("left",l).show();
		$(".backifname").show();
		/**
		 * 修改：2012-3-28 邓夫伟 隐藏遮层
		 */
		$("html").click(function(){
			// add by zhangjianjun
			var inputStr = $(".noArea2").val();
			if(inputStr!=null && inputStr!=""){
				var arr = inputStr.split("-");
				if(arr[1]==null){
					$(".noArea2").val("");
				}
			}
	 		$("#dimCityQuery").hide(); 
	 		$(".backifname").hide();
	 	});
	});
	
	//当前选择项样式
	$("body").delegate("#dimCityQuery li" , "hover" , function(){ // 类似于 Live 方法  delegate("选择要操作的对象","操作类型及方法名称","执行的方法函数可以多个方法并用")
		$(this).addClass("current").siblings().removeClass("current");
	},function(){$(this).removeClass("current");});
	
	//点击方向键下
	$("#dimCityQuery").delegate("" , "selNext" , function(){
				var next=$(this).find("li.current").next();
				if(next.size()>0)  { 
				next.addClass("current").siblings().removeClass("current");
				}
				else{
					$("#dimCityQuery li").removeClass("current").first().addClass("current");
			    };
			  /* //将当前选择值填入文本框
				var vm=$(this).find("li.current a").text();
				vm=vm.split("(");
				var provinceId = $(this).find("li.current a").attr("provinceId");
				var provinceName = null;
				for (i=0;i<allProvinces.length;i++){
					if(allProvinces[i].id==provinceId){
						provinceName=allProvinces[i].provinceName;
					};
				}
				if(currentClass=="proCityQueryAll")
				{
					$("body").find(".proCityQueryAll").eq( clkIndex ).val(provinceName+"-"+$.trim(vm[0]));
				}
				if(currentClass=="proCityQuery")
				{
					$("body").find(".proCityQuery").eq( clkIndex ).val( provinceName+"-"+$.trim(vm[0]) );
				}*/
				
	});
	//点击方向键上
	$("#dimCityQuery").delegate("" , "selPrev" , function(){
			var prev=$(this).find("li.current").prev();
				if(prev.size()>0)  { prev.addClass("current").siblings().removeClass("current"); }
				else{ $("#dimCityQuery li").removeClass("current").last().addClass("current");};
				/*//将当前选择值填入文本框
				var vm=$(this).find("li.current a").text();
				vm=vm.split("(");
				var provinceId = $(this).find("li.current a").attr("provinceId");
				var provinceName = null;
				for (i=0;i<allProvinces.length;i++){
					if(allProvinces[i].id==provinceId){
						provinceName=allProvinces[i].provinceName;
					};
				}
				if(currentClass=="proCityQueryAll")
				{
					$("body").find(".proCityQueryAll").eq( clkIndex ).val(provinceName+"-"+$.trim(vm[0]));
				}
				if(currentClass=="proCityQuery")
				{
					$("body").find(".proCityQuery").eq( clkIndex ).val( provinceName+"-"+$.trim(vm[0]) );
				}*/
				
	});
	
	//点击确定键
	$("#dimCityQuery").delegate("" , "enter" , function(event){
			var cur=$(this).find("li.current");
				if(cur.size()>0)  { 
					cur.find("a").trigger("click");
				};
			return false;
	});
	/**
	 * 修改：2012-3-28 邓夫伟 隐藏遮层
	 */
	//点击城市
	$("body").delegate("#dimCityQuery li a.allcityClass" , "click" , function(){
		var vm=$(this).text();
		var provinceId=$(this).attr("provinceId");
		var cityId=$(this).attr("cityId");
		var countyId = $(this).attr("countyId");
		var provinceName = null;
		var cityName = null;
		var rtn ;
		isClickDimCity = true;
		
		for (var i=0;i<allProvinces.length;i++){
			if(allProvinces[i].id==provinceId){
				provinceName=allProvinces[i].provinceName;
			};
		}
		
		for(var i=0;i<allCitys.cities.length;i++) {
			if(allCitys.cities[i].id==cityId)	{
				cityName = allCitys.cities[i].name;
			}
		}
		
		//当前省份、城市、区县 id 缓存
		if(currentClass=="proCityQueryAll"){
			$("body").data("pAllId",provinceId);
			$("body").data("cAllId",cityId);
			$("body").data("aAllId",countyId);
			$("body").data("pAllName",provinceName);
			$("body").data("nameOfCityAll",cityName);
		}
	    if(currentClass=="proCityQuery"){
			$("body").data("pId",provinceId);
			$("body").data("cId",cityId);
			$("body").data("aId",countyId);
			$("body").data("pName",provinceName);
			$("body").data("nameOfCity",cityName);
		}
		
		vm=vm.split("(");
		countyName = $.trim(vm[0]);
		
		if(countyId==null || countyName==cityName)
		{
			if(currentClass=="proCityQuery")
			{
				thisObj.trigger("click");
				counties=[];
				var j=0;
			    $.each(allCountys,function(i,county){
			    	if(county.cityId==cityId){
			    		counties[j++]=county;
			    	}
			    });
			    countyTotalPage = Math.ceil(counties.length/p_pageSize);
				//控件导航栏切换样式
				$(".provinceCity").find(".tabs").find("a").removeClass("current");
				$(".provinceCity .tabs").find("#county").addClass("current");
				//当前城市显示样式
				$(".con .city .list a").removeClass("current");
				//选择了城市之后切换到区县
				$(".provinceCity").find(".con").children().hide();
				$(".provinceCity").find(".con").find(".county").show();
				
				 $(".con .provinceAll .list a").removeClass("current");
				    
			    countyPage(1);
			}
			else if(currentClass=="proCityQueryAll")
			{
				//如果是收送货范围查询处的城市空间则不需要查询区县 直接向文本框赋值选择省市值
				//add by zhangjianjun
				if($('input.current2').hasClass('noArea2')){
					rtn = provinceName  + "-" + countyName;
						$("body").find(".proCityQueryAll").eq( clkIndex ).val(rtn);
						$("#cityCode").val(cityId);
						$("#proCode").val(provinceId);
						if($('input.current2').hasClass('f_city')){
//							$(".inputFocus").removeClass("iGrays");
							$(".f_city").removeClass("iGrays");
						}
						$("body").find(".proCityQueryAll").eq( clkIndex ).trigger("changeMe");
						$(".provinceCityAll").find(".tabs").find("a").removeClass("current");
						$(".provinceCityAll").find(".tabs").find("a[tb=hotCityAll]").addClass("current");
						$(".provinceCityAll .con .list a").removeClass("current");
						$(".provinceCityAll .con .list a input").removeClass("current");
					
				}else{
					thisObj.trigger("click");
					countiesAll=[];
				    var j=0;
				    $.each(allCountys,function(i,county){
				    	//zenghong 去掉了county.areaName != cityName的判断
				    	if(county.cityId==cityId){
				    		countiesAll[j++]=county;
				    	}
				    });
				    countyTotalPageAll = Math.ceil(countiesAll.length/pa_pageSize);
					//控件导航栏切换样式
					$(".provinceCityAll").find(".tabs").find("a").removeClass("current");
					$(".provinceCityAll .tabs").find("#countyAll").addClass("current");
					//当前城市显示样式
					$(".con .cityAll .list a").removeClass("current");
					//选择了城市之后切换到区县
					$(".provinceCityAll").find(".con").children().hide();
					$(".provinceCityAll").find(".con").find(".countyAll").show();
					
				    $(".con .provinceAll .list a").removeClass("current");
				    
					//显示区县
					allCountyPage(1);
				}
			}	
		}
		else
		{
			//返回字符串
			rtn = provinceName  + "-" + countyName;
			if(currentClass=="proCityQueryAll")
			{
				$("body").find(".proCityQueryAll").eq( clkIndex ).val(rtn);
				
				
//				$("body").find(".proCityQueryAll").eq( clkIndex ).nextAll("input").val(oldCityId);
				//设置到达区县编码
				//zenghong 2013-8-1 增加标准快递的隐藏域赋值判断
				//如果当前文本框是到达城市，设置到达城市的编码
				if($('input.current2').hasClass('s_city')){
					$("#arrivedCityId").val(countyId);
				}
				//标准快递：如果当前文本框是出发地址控件，给leavedCityIdPG赋值,zenghong 2013-8-1
				//如果当前操作框是发货地址城市控件，则级联给网点控件赋值 zenghong 2013-8-4
				if($('input.current2').hasClass('f_city')){
//					$(".inputFocus").removeClass("iGrays");
					$(".f_city").removeClass("iGrays");
					$("#leavedCityIdPG").val(cityId);			
					$(".f_inter").val(rtn);
					//触发发货网点change事件，以刷新网点列表信息
					
					$("#deptCityId").val(cityIdAll);
					$("input[name='order.sdeptProCity']").trigger("change",[cityId,countyId]);
					$("input[name='consignor.deptProCity']").trigger("change",[cityId,countyId]);
					
				}
				
				if($("input.current2").hasClass("s_city")){
//					$(".inputFocus").removeClass("iGrays");
					$(".s_city").removeClass("iGrays");
					$("#caddrProDept").removeClass("iGrays");
					$("#caddrProDept").val(rtn);
					$("#caddrProDept").trigger("change",[cityIdAll,countyId]);
				}
//				$("#arrivedCityId").val(countyId);
				$("body").find(".proCityQueryAll").eq( clkIndex ).trigger("changeMe");
				$(".provinceCityAll").find(".tabs").find("a").removeClass("current");
				$(".provinceCityAll").find(".tabs").find("a[tb=hotCityAll]").addClass("current");
				$(".provinceCityAll .con .list a").removeClass("current");
				$(".provinceCityAll .con .list a input").removeClass("current");
			}
			if(currentClass=="proCityQuery")
			{
				$("body").find(".proCityQuery").eq( clkIndex ).val(rtn);
//				$("body").find(".proCityQuery").eq( clkIndex ).nextAll("input").val(oldCityId);
				$("body").find(".proCityQuery").eq( clkIndex ).trigger("change",[cityId,countyId]);
				$(".provinceCity").find(".tabs").find("a").removeClass("current");
				$(".provinceCity").find(".tabs").find("a[tb=hotCity]").addClass("current");
				$(".provinceCity .con .list a").removeClass("current");
				$(".provinceCity .con .list a input").removeClass("current");
			}
		}
	
		$("#dimCityQuery").hide();
		$(".backifname").hide();
		return false;
	});

  	$(".nomarl").live("focus",function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		$(this).css({"color":"#000"});

		if(val==ov){
			$(this).val("");
		}

	});
 	$(".nomarl").live("blur",function(){
		var ov=$.trim($(this).attr("ov"));
		var val=$.trim($(this).val());
		if(val==""||val==ov){
			$(this).val(ov).css({"color":"#aaa"});
		}
	 });
 	
})();

//二级导航栏
(function(){
		 $(".navigation ul").find(".menua").hover(
		  function(){
			var index = $(this).index();
			var o = $(this).offset().right;
	        $(this).find(".menuSenc").css({"right":o});
			$(this).find(".menuSenc").show();
			var s = $(this).find(".menuSenc").height();
	        $(this).find(".subMenuifname").css({"right":o,"height":s});
          $(this).find(".subMenuifname").show();
		  },
		  function(){
			  $(this).find(".subMenuifname").hide();
			$(this).find(".menuSenc").hide();
			}
		);
})();




//协议弹出层
(function(){
	//查看地图
	$(".xieyi").click(function(){
		popPosition("#selectxieyi");
		$("#selectxieyi").show();
		function popPosition(dom){
			var width = $(dom).width();
			var height = $(dom).height();
			var css = {
				"width" : width + "px", 
				"left" : "50%", 
				"margin-left" : -width / 2 + "px", 
				"top" : "50%", 
				"margin-top" : -height / 2 + "px",
				"position": "fixed"
			};
			$(dom).css(css);
		};
		   //关闭
		$(".popupClo").click(function(){
			    $(this).parents(".optional_xieyi").hide();							  
		});
	});	
	
})();


/**
 * 创建人：赵本兵
 * 创建日期：2012-03-17
 * ajax 登出
 * 网上托运登出到网上托运首页
 * 我的德邦登出到我的德邦首页
 * 首页登出到首页
 * 其它界面登出到本页
 */
 $(".Safetyexit").live("click",function(){
	$.ajax({
		type:"post",
		url:"../user/ajaxLogout.action",
		data:{"logoutBefActionName":$("input[name=logoutBefActionName]").val()},
		dataType:"json",
		async:false,
		cache:false,
		timeout:1000,
		success:function(msg){
  			var urlpath = msg.logoutBefActionName;
 			if(!urlpath){
 				location.replace(".."+$("input[name=logoutBefActionName]").val());
				return false;
 			}
			//网上托运 
			if(urlpath.indexOf("transonline")>0){
				location.replace("../transonline/browse.action");
				return false;
			}
			//跳转到我的德邦
			if(urlpath.indexOf("user")>0){
				location.replace("../order/");
				return false;
			}
			if(urlpath.indexOf("consignee")>0){
				location.replace("../order/");
				return false;
			}
			
			if(urlpath.indexOf("waybillchange")>0){
				location.replace("../order/");
				return false;
			}
			
			if(urlpath.indexOf("finance")>0){
				location.replace("../order/");
				return false;
			}
			if(urlpath.indexOf("insurance")>0){
				location.replace("../order/");
				return false;
			}
			if(urlpath.indexOf("template")>0){
				location.replace("../order/");
				return false;
			}
			if(urlpath.indexOf("consignor")>0){
				location.replace("../order/");
				return false;
			}
			if(urlpath.indexOf("order")>0){
				location.replace("../order/");
				return false;
			}
			//网点列表伪静态 
			if(urlpath.indexOf("queryDeptsByCityPinyin")>0){
				location.replace("../deptlist/");
				return false;
			} 
			if(urlpath.indexOf("home")>0){
				location.replace("../deptlist/");
				return false;
			} 
			//网点地图伪静态
			if(urlpath.indexOf("mapHome")>0){
				location.replace("../wangdian/");
				return false;
			}
			//价格伪静态
			if(urlpath.indexOf("jiage")>0){
				location.replace("../jiage/");
				return false;
			}
			//跟踪伪静态 
			if(urlpath.indexOf("zhuizong")>0){
				javascript:location.href="../zhuizong/";
				location.replace("../zhuizong/");
				return false;
			}
			else{
				var path = urlpath.split(".");
				if(path[0]!=""){
					location.replace(".."+path[0]+".action");
				}else{
					location.replace(".."+msg.logoutBefActionName);
				}
				return false;
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			location.replace("../user/toregist.action");
			return false;
		}
	});
}); 

 $(".Safetyexit_Temp").live("click",function(){
		$.ajax({
			type:"post",
			url:"../user/ajaxLogoutTemp.action",
			data:{"logoutBefActionName":$("input[name=logoutBefActionName]").val()},
			dataType:"json",
			async:false,
			cache:false,
			timeout:1000,
			success:function(msg){
	  			var urlpath = msg.logoutBefActionName;
	 			if(!urlpath){
	 				location.replace(".."+$("input[name=logoutBefActionName]").val());
					return false;
	 			}
				//网上托运 
				if(urlpath.indexOf("transonline")>0){
					location.replace("../transonline/browse.action");
					return false;
				}
				//跳转到我的德邦
				if(urlpath.indexOf("user")>0){
					location.replace("../order/");
					return false;
				}
				if(urlpath.indexOf("consignee")>0){
					location.replace("../order/");
					return false;
				}
				
				if(urlpath.indexOf("waybillchange")>0){
					location.replace("../order/");
					return false;
				}
				
				if(urlpath.indexOf("finance")>0){
					location.replace("../order/");
					return false;
				}
				if(urlpath.indexOf("insurance")>0){
					location.replace("../order/");
					return false;
				}
				if(urlpath.indexOf("template")>0){
					location.replace("../order/");
					return false;
				}
				if(urlpath.indexOf("consignor")>0){
					location.replace("../order/");
					return false;
				}
				if(urlpath.indexOf("order")>0){
					location.replace("../order/");
					return false;
				}
				//网点列表伪静态 
				if(urlpath.indexOf("queryDeptsByCityPinyin")>0){
					location.replace("../deptlist/");
					return false;
				} 
				if(urlpath.indexOf("home")>0){
					location.replace("../deptlist/");
					return false;
				} 
				//网点地图伪静态
				if(urlpath.indexOf("mapHome")>0){
					location.replace("../wangdian/");
					return false;
				}
				//价格伪静态
				if(urlpath.indexOf("jiage")>0){
					location.replace("../jiage/");
					return false;
				}
				//跟踪伪静态 
				if(urlpath.indexOf("zhuizong")>0){
					javascript:location.href="../zhuizong/";
					location.replace("../zhuizong/");
					return false;
				}
				else{
					var path = urlpath.split(".");
					if(path[0]!=""){
						location.replace(".."+path[0]+".action");
					}else{
						location.replace(".."+msg.logoutBefActionName);
					}
					return false;
				}
			},
			error:function(XMLHttpRequest, textStatus, errorThrown){
				location.replace("../user/toregist.action");
				return false;
			}
		});
	});
 
 
 
 
function queryData(){
	var username= $.cookie("depponLoginUserName");
	var a = $(".userName1").html();
	if(username!=null){
		username=a.substr(0,9)+"...";
		$(".userName1").html(username);
	}
	else{
		$(".Safetyexit").trigger("click");
	}
	var obj1 = $(".ts-usermessage").find(".ac_transportingOrder");
	var obj2 = $(".ts-usermessage").find(".ac_refundPaymentOrder");
	var obj3 = $(".ts-usermessage").find(".ac_siteMessages");
	var obj4 = $(".ts-usermessage").find(".ac_unuseCoupon");
	//post请求
	$.ajax({
		type:"post",
		url:"../user/queryPayOderTranOder.action",
		data:{"isRefush":1},
		dataType:"json",
		beforeSend:function(XMLHttpRequest){
			obj1.html("<img src='../theme/default/images/loading.gif' height=20 width=20/>");
			obj2.html("<img src='../theme/default/images/loading.gif' height=20 width=20/>");
			obj3.html("<img src='../theme/default/images/loading.gif' height=20 width=20/>");
			obj4.html("<img src='../theme/default/images/loading.gif' height=20 width=20/>");
		},
		success:function(msg){
			if(msg.user!=null){
				//运输中订单
				obj1.html("("+msg.user.transportingOrder+")");
				//待付款订单
				obj2.html("("+msg.user.refundPaymentOrder+")");
				//未读站内信
				obj3.html("("+msg.user.siteMessage+")");
				//未使用优惠券
				obj4.html("("+msg.user.unuseCoupon+""+")");
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown)
		{
			//异步加载账户信息，有时会执行error里面的（随机性），这样就会直接跳转到我的德邦首页
//			location.replace("../user/toregist.action");
			return false;
		}
	});
}
//刷新账户信息
$(".a_refush_info").click(function(){
	queryData();
});

 function addFavorite() 
 { 
	 var sURL="http://www.deppon.com";
	 var sTitle="德邦物流官方网站";
     try 
     { 
         window.external.addFavorite(sURL, sTitle); 
     } 
     catch (e) 
     { 
         try 
         { 
             window.sidebar.addPanel(sTitle, sURL, ""); 
         } 
         catch (e) 
         { 
             alert("加入收藏失败，请使用Ctrl+D进行添加"); 
         } 
     } 
 }
 
/* ‘调查问卷’，‘回到顶部’，‘調查問卷’，‘回到頂部’通过引入survey-show.js来控制 */
(function() {
	document.write('<script type="text/javascript" src="/r/cms/cms/default/js/survey-show.js" > <\/script>');
})();

function setCookie(c_name,value,expiredays) {
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
   }
   function getCookie(c_name) {
    if (document.cookie.length>0)
    {
     c_start=document.cookie.indexOf(c_name + "=");
     if (c_start!=-1)
     { 
      c_start=c_start + c_name.length+1 ;
      c_end=document.cookie.indexOf(";",c_start);
      if (c_end==-1) c_end=document.cookie.length;
      return unescape(document.cookie.substring(c_start,c_end));
     } 
    }
    return "";
 }
   
/*
 *jQuery操作cookie插件源码
 *创建人：邓夫伟
 *时间：2012-3-19
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    if(cookieValue) break;
                }
            }
        }
        return cookieValue;
    }
};


if($(".loginusername:visible").size() >= 1){
	var td = new Date();
	var h = td.getHours();
	var currTime = "";
	if(h<8){
		currTime = "早上好 ,";
	}
	if(h>=8&&h<12){
		currTime = "上午好 ,";
	}
	if(h>=12&&h<13){
		currTime = "中午好 ,";
	}
	if(h>=13&&h<18){
		currTime = "下午好 ,";
	}
	if(h>=18){
		currTime = "晚上好 ,";
	}
	$(".currentTime").html(currTime);
}

function intToCH(num){
	switch (num) {
		case 1: return "一";
		case 2: return "二";
		case 3: return "三";
		case 4: return "四";
		case 5: return "五";
		case 6: return "六";
		case 7: return "七";
		case 8: return "八";
		case 9: return "九";
		case 10: return "十";
		case 11: return "十一";
		case 12: return "十二";
		case 13: return "十三";
		case 14: return "十四";
		case 15: return "十五";
		case 16: return "十六";
		case 17: return "十七";
		case 18: return "十八";
		case 19: return "十九";
		case 20: return "二十";
		default:"";
	}
}

//如果是IE6，则提示是否升级
$(document).ready(function(){
	var browser=$.browser.msie;
	var b_version=$.browser.version;
	if(browser && b_version=="6.0")
	{
	    $(".container ").before("<div class='Ieinfo'><a href='http://windows.microsoft.com/zh-CN/internet-explorer/downloads/ie-8'>是否升级浏览器的版本，以更好的体验德邦物流提供的服务?</a><a  class='ico m_close' href='javascript:void(0)'>X</a></div>");
	}
	$(".m_close").click(function(){
		$(".Ieinfo").remove();
	});
});


//呼叫中心添加点击统计代码
$('#live800icon').attr("onclick","_gaq.push(['_trackEvent', 'Service', 'Click', 'onlineservice']);");
//首页小窗口注册方式选择
$(".commonReMini").click(function(){
	$(".commonMini-regist").show();
	$(".scan-regist").hide();
	$(".commonReMini").css({		
		"background": "url(../images/bg-commonQ1.png)",
		"color":"white",
		"border-bottom":"2px solid #373c64"
	});
	$(".scanRe").css({
		"background": "url()",
		"border-bottom":"2px solid #373c64",
	    "margin-left": "0px",
		"color":"#858585"
	});
	for(var i=0;i<timer.length;i++){
		window.clearInterval(timer[i]);
	}
	
	
}
);
$(".scanRe").click(function(){
	$(".commonMini-regist").hide();
	$(".scan-regist").show();
	$(".commonReMini").css({
		"background": "url()",
		"border-bottom":"2px solid #373c64",
		"color":"#858585"
	});
	$(".scanRe").css({
		"background": "url(../images/bg-commonQ1.png)",
		"color":"white",
		"border-bottom":"2px solid #373c64",
		"margin-left": "0px"
	});
	setTimeout(lose, 180000);
	var timer1 = setInterval(qrLogin,3000);
	timer.push(timer1);
	
}
);
function qrLogin(){
	$.ajax({
		type:"post",
		url:"../user/QrLogin.action",
		dataType:"json",
		success:function(data){
			if(data.message=="loginSuccess"){
				if($("#tijiao").val()=="dingwei"){
					clearInterval(timer);
					$("#txt_username").val(data.user.userName);
 					$("#txt_userEmail").val(data.user.email);
 					$("input[name=operation]").val("login");
 					$("#checkWrong").hide();
 					$("#checkMbForm").attr("action","../transonline/tranonlinesubmitOrder.action");
 					//登录成功以后如果是标签打印用户停留在原来的页面
 					if((data.isPrintUser||data.isPrintUser=="true")&&$("#transType").val()!="7"&& $("#transType").val()!="8"&&$("#isNew").val()=="old"){
 						//显示标签用户必填信息
 						$("#noLoginWaybill").show();
 						$("#noLoginCount").show();
 						$("#noLoginPack").show();
 						$("#noLoginPointInfo").show();
 						$("#noLoginPoint").show();
 						$("#noLoginConsigneeInfoId").show();
 						$("#noLoginConsigneeInfoId").show();
 						$("#isPrintUser").val(data.isPrintUser);
 						$("#newOrder").attr("id","loginedNewOrder");
 						//关闭登录窗口
					    $(".Internetshipping1").eq(0).hide();							  
					    $(".filebg").hide();
				        $(".Internetshippingiframe").hide();
				        
				        //登录成功后状态处理
				        $("#loginBeforestatus").hide();
				        $("#loginAfterstatus").show();
				        $(".ts-username").find(".userName1").html(data.user.userName);
				        
				        var obj1 = $(".ts-usermessage").find(".ac_transportingOrder");
				    	var obj2 = $(".ts-usermessage").find(".ac_refundPaymentOrder");
				    	var obj3 = $(".ts-usermessage").find(".ac_siteMessages");
				    	var obj4 = $(".ts-usermessage").find(".ac_unuseCoupon");
				    	//post请求
				    	$.ajax({
				    		type:"post",
				    		url:"../user/queryPayOderTranOder.action",
				    		dataType:"json",
				    		async:false,
				    		success:function(msg){
				    			if(msg.user!=null){
				    				//运输中订单
				    				obj1.html("("+msg.user.transportingOrder+""+")");
				    				//待付款订单
				    				obj2.html("("+msg.user.refundPaymentOrder+""+")");
				    				//未读站内信
				    				obj3.html("("+msg.user.siteMessage+""+")");
				    				//未使用优惠券
				    				obj4.html("("+msg.user.unuseCoupon+""+")");
				    			}
				    		},
				    		error:function(XMLHttpRequest, textStatus, errorThrown)
				    		{
				    			//异步加载账户信息，有时会执行error里面的（随机性），这样就会直接跳转到我的德邦首页
//				     			location.replace("../user/toregist.action");
				    			return false;
				    		}
				    	});
				    	 $("#tijiao").val("weidingwei");
 					}else{
 						 $("#tijiao").val("weidingwei");
 						$("#checkMbForm").submit();
 					}
				}else{
					clearInterval(timer);
					 if(data.loginBefActionName==null||data.loginBefActionName==""){
						   javascript:location.href="../user/olduserloginpage.action";
					  }else{
							javascript:location.href=".."+msg.loginBefActionName;
					 }
				}
				
			}else{
				//
			}
		},
	error:function(XMLHttpRequest, textStatus, errorThrown)
	{
		//alert("抱歉，内部服务器故障，请稍后重试");
		$("#sp_login_loading").html("");
		$("#LoginSubmit").show();
	}
	
		
		
	});
}
//注册方式选择
$(".mobileRe").click(function(){
	$(".common-regist").hide();
	$(".mobile-regist").show();
	$(".mobileRe").css({"border-bottom":"1px solid white",
						"background":"url() repeat-x"	
						});
	$(".commonRe").css({"border-bottom":"1px solid #D9D9D9",
						"background":"url(../images/tab.png) repeat-x"
					});
	if($("#authCode_mr"))
		refreshImg("authCode_mr");
});
$(".commonRe").click(function(){
	$(".mobile-regist").hide();
	$(".common-regist").show();
	$(".commonRe").css({"border-bottom":"1px solid white",
						"background":"url() repeat-x"
	});
	$(".mobileRe").css({"border-bottom":"1px solid #D9D9D9",
						"background":"url(../images/tab.png) repeat-x"
					});
	changeImg();
	registImg();
});
//登陆方式选择
$(".scanLo").click(function(){
	$(".common-login").hide();
	$(".scan-login").show();
	$(".scanLo").css({"border-bottom":"1px solid white",
						"background":"url() repeat-x"	
						});
	$(".commonLo").css({"border-bottom":"1px solid #D9D9D9",
						"background":"url(../images/tab.png) repeat-x"
					});
	setTimeout(lose, 180000);
	var timer2 = setInterval(qrLogin,3000);
	timer.push(timer2);
   	
});
//二维码失效
function lose(){
	 $('.qrCreate').css({
	        "position": "absolute",	      
	        "filter": "alpha(opacity=30)",
	        "opacity": "0.3",
	        "z-index": "2"
	    });
	 	$(".lose").css({"background-color": "#000000","z-index":"1","filter": "","opacity": ""}); 
	 	$(".loseShow").show();
	    $(".loseShow").css({    	
	    	"position":"absolute",
	    	"z-index": "3",
	    	"width":"120px",
	    	"height":"120px",
	    	"text-align":"center",
	    	"color":"white"
	    });
	    for(var i=0;i<timer.length;i++){
			window.clearInterval(timer[i]);
		}
	    
}

/* e即为事件，target即为绑定事件的节点 */
function contains(p,c){  
    return p.contains ? 
           p != c && p.contains(c) :
           !!(p.compareDocumentPosition(c) & 16);  
}
function fixedMouse(e,target){  
        var related,
            type=e.type.toLowerCase();//这里获取事件名字
        if(type=='mouseover'){
            related=e.relatedTarget||e.fromElement;
        }else if(type='mouseout'){
            related=e.relatedTarget||e.toElement;
        }else return true;
        return related && related.prefix!='xul' && !contains(target,related) && related!==target;
}


var a = 1;
function func1(){
	if(a==1){
		$(".qrCreate").animate({"left":"-50px"},800);
		$(".show").fadeIn("slow");	
		a = 0;
	}	
}
function func2(){
	if(a ==0){
		$(".qrCreate").animate({"left":"0"},800);
		$(".show").fadeOut("slow");	
		a = 1;
	}
	
}
function funcpopoin(){
	var explorer = window.navigator.userAgent ;
	if(a==1){
		if (explorer.indexOf("MSIE") >= 0) {
			$(".qrCreate").animate({"margin-left":"-130px"},800);
			$(".show").fadeIn("slow");	
		}else{
			$(".qrCreate").animate({"left":"-50px"},800);
			$(".show").fadeIn("slow");	
		}		
		a = 0;
	}	
}
function funcpopout(){
	var explorer = window.navigator.userAgent ;
	if(a ==0){
		if (explorer.indexOf("MSIE") >= 0) {
			$(".qrCreate").animate({"margin-left":"-60px"},800);
			$(".show").fadeOut("slow");	
		}else{
			$(".qrCreate").animate({"left":"0"},800);
			$(".show").fadeOut("slow");	
		}		
		a = 1;
	}
	
}




//二维码失效，点击刷新事件
$(".loseShow").click(function(){
	$('.loseShow').hide();
	$(".lose").css({"background-color": "white","z-index":"100", "filter": "alpha(opacity=10)","opacity": "0.1"}); 
	$('.qrCreate').css({"filter": "","opacity": ""});	
    $("#qrmark").attr({"value":"false"});
	$(".qrCreate").attr("src",
			"../user/QrCode.action?d=" + new Date().valueOf());
	setTimeout(lose, 180000);
	var timer3 = setInterval(qrLogin,3000);
	timer.push(timer3);
});		

$(".commonLo").click(function(){
	$(".scan-login").hide();
	$(".common-login").show();
	$(".commonLo").css({"border-bottom":"1px solid white",
						"background":"url() repeat-x"
	});
	$(".scanLo").css({"border-bottom":"1px solid #D9D9D9",
						"background":"url(../images/tab.png) repeat-x"
					});
	for(var i=0;i<timer.length;i++){
		window.clearInterval(timer[i]);
	}
});


/**
 * 2012-10-08 邓夫伟 除网上托运首页之外的网上下单、修改订单、新增修改模板页的查看地图
 */
// 查看地图
$(".selectmap").click(function() {
	popPosition("#selectmap");
	var val = $(".selectmap").attr("dp");
	$("#iframe-map").attr("src","http://map.deppon.com/dpbaidumap/deptquery/pages/showMap.html?deptId="+val);// 192.168.13.206
	$("#selectmap").show();
	// 弹出层定位
	function popPosition(dom) {
		var width = $(dom).width();
		/*var height = $(window).height()/2;*/
		
		var h=$(window).height();
		var w=$(window).width();
		var st=$(window).scrollTop();
		var sl=$(window).scrollLeft();
		
		var css = {
			"width" : width + "px",
			"left" : (((w-420)/2)+sl)-100,
//			"margin-left" : -width / 2 + "px",
			"top" : ((h-400)/2)+st,
//			"margin-top" : height + "px",
			"position": "absolute"
		};
		$(dom).css(css);
	}
	;
	// 关闭
	$(".postBack").click(function() {
		$("#selectmap").hide();
	});
	$(".popupClo").click(function() {
		$(this).parents(".optional_map").eq(0).hide();
	});
});

//toFixed方法bug修复
Number.prototype.toFixed = function(s) {
	changenum = (parseInt(this * Math.pow(10, s) + 0.5) / Math.pow(10, s))
			.toString();
	index = changenum.indexOf(".");
	if (index < 0 && s > 0) {
		changenum = changenum + ".";
		for (i = 0; i < s; i++) {
			changenum = changenum + "0";
		}

	} else {
		index = changenum.length - index;
		for (i = 0; i < (s - index) + 1; i++) {
			changenum = changenum + "0";
		}

	}

	return changenum;
}
//客服电话校验
var service=/^[0-9]{2,16}$/;
//匹配非负整数
var num=/^[0-9]*$/;
//特殊字符和空格校验
var toFilter=new RegExp("\script");
//固话区号校验
var nv1=/^0[0-9]{2,3}$/;
//固话格式校验
var nv2=/^[1-9]{1}[0-9]{6,7}(\-\d+)?$/;
//固定电话（区号+号码）
var TelReg = /^\d{3,4}-?\d{7,8}$/;
var TelReg2 = /^0[0-9]{2,3}-?\d{7,8}$/;
//手机号码校验
//***modify by mujun add '|\d{8}' 支持8位的号码****///
var par=/^(1[2-9]{1}[0-9]{9}|\d{8})$/;
//货物体积、重量校验
var reg=/^[0-9]+(\.[0-9]+)?$/;
var cargoCount=/^\d{1,4}$/;
var insurance=/^\d{1,7}$/;
//用户名(没用到)
var usernameReg = /^[\da-zA-Z_]{4,20}$/;
//注册用户名
//var regUserNameReg = /^[a-zA-Z0-9\u4E00-\u9FFF]{4,20}$/;
//普通注册以字母开头
var regUserNameReg = /^[a-zA-z]{1}[a-zA-Z0-9\u4E00-\u9FFF]{3,19}$/;
//注册密码
var unpa = /^[\da-zA-Z_]{6,16}$/;
//邮箱
var emailReg=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
//特殊字符过滤 2012-09-25 邓夫伟  txt与toFilter相同，全部改为使用toFilter
//var txt=new RegExp("\script");  
//索赔金额格式 insurance/insuranceEnter.jsp--L167
var amountReg=/^\d+(\.\d{0,1})$|^\d*$/; 
//索赔人 
var feeNameReg = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/; 
//身份证号 insurance/insuranceEnter.jsp--L209
var cardIdReg=/(^\d{15}$)|(^\d{17}([0-9]|X|x)$)/;
//银行帐号 insurance/insuranceEnter.jsp--L218
var bankNumReg=/^[0-9]{5,30}$/;
//开户名 insurance/insuranceEnter.jsp--L244
var bankNameReg = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/;
//支行名 insurance/insuranceEnter.jsp--L263
var bankBranckNameBReg = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/;
//可有可无的数字
//var numberReg = /^(\d*)?(\.)?\d+$/;
var numberReg = /^\d*(\.\d+)?$/;
//必须有的数字
var numReg = /^\d+(\.\d+)?$/;
//姓名悬停账号
var dpName = /^[\u4e00-\u9fa5]+$/;
//跳转页数
var forNumber = /^[1-9][0-9]{0,8}$/;
//收货人 finance/queryBillList.js
var conNameReg = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/;
//货物名称 finance/queryBillList.js
var cargoNameReg = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/;
//user/userHome.jsp的姓名、发货城市、发货地址
var userHomeFilter=new RegExp("[ ,\\`,\\~,\\!,\\@,\#,\\$,\\%,\\^,\\+,\\*,\\&,\\\\,\\/,\\?,\\|,\\:,\\.,\\<,\\>,\\{,\\},\\(,\\),\\'',\\;,\\=,\"]"); 
var usernameReg=/^[\u4e00-\u9fa5]{2,6}$/;
var registrationReg=/^\d{15}$/;
var ds = new City_ds({
	autoinit : true,
	host_path : '',
	provinces_url : '../common/queryAllProvinces.action',
	dept_url:'../common/queryAreasExistsBusinessDept.action',
	cities_url : '../common/queryCities.action',
	areas_url : '../common/queryAllAreas.action',
	areabycity_url : '../common/queryAreasByCityId.action?cityId=',
	dpcity_ds : 0
	//过滤香港
//	data_filter:function(data){
//		if(data["provinceName"]  && data.provinceName.indexOf("香港")>=0) return null;
//		else return data;
//	}
});

var ds2 = new City_ds({
	autoinit : true,
	host_path : '',
	provinces_url : '../common/queryProvincesExistsBusinessDept.action',
	cities_url : '../common/queryAllCities.action',
	areas_url : '../common/queryAreasExistsBusinessDept.action',
	areabycity_url : '../common/queryAreasExistsBusinessDeptByCityId.action?cityId=',
	dpcity_ds : 2
});
