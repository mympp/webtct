	$(function(){
		$(".pro_show").mouseover(function(){
			$(this).find("img.back").attr("style","position:absolute;left:0;top:0px;opacity:0.8;display:block;");
			$(this).find("span").attr("style","position: relative; top: 0; left: 0;");
			$(this).find("span").css("color","white");
		});
		$(".pro_show").mouseout(function(){
			$(this).find("span").css("color","#555555");
			$(this).find("img.back").attr("style","display:none;");
		});

		/*����ƹ������Ұ�ť��ʾ*/
		$(".content_show").hover(function(){
			$(this).find(".prev,.next").fadeTo("show",0.5);
		},function(){
			$(this).find(".prev,.next").hide();
		})
		/*����ƹ�ĳ����ť ������ʾ*/
		$(".prev,.next").hover(function(){
			$(this).fadeTo("show",0.7);
		},function(){
			$(this).fadeTo("show",0.1);
		})
		$(".content_show").slide({ titCell:".num ul" , mainCell:".show" , effect:"fold", autoPlay:true, delayTime:400 , autoPage:true });
	});

	