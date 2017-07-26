
    	$(document).ready(function(){
    		//新闻tab固定显示
			$(".sidebar").posfixed({
				distance:70,
				pos:"top",
				type:"while",
				hide:false
			});	
    		//顶部出现搜索框
			window.onscroll = function(){
			    var t = document.documentElement.scrollTop || document.body.scrollTop;
			    var top_div = document.getElementById( "topSearch" );
			    if( t >= 300 ) {
			        top_div.style.display = "block";
			    } else {
			        top_div.style.display = "none";
			    }
			}

    		//清除输入内容
			if($("input[name='keyWords']").val().length > 0){
				$(".ipt_del").show();
			}
			//显示清除input按钮
			$("input[name='keyWords']").keydown(function(){
				if($("input[name='keyWords']").val().length > 0){
					$(".ipt_del").show();
				}else{
					$(".ipt_del").hide();
				}
			});
			//清除文本框该内容
			$(".ipt_del").click(function(){
				$("input[name='keyWords']").val("");
				$(".ipt_del").hide();
			});
			//鼠标移入
			$(".ipt_del").mouseover(function(){
				$(this).css('background-position','-22px 0px');
			});
			//移除鼠标
			$(".ipt_del").mouseout(function(){
				$(this).css('background-position','0px 0px');
			});



    		//检测滚轮事件
			$(function () {
				var i = 4;
				$(window).bind("scroll", function (event){
					//滚动条到网页头部的 高度，兼容ie,ff,chrome
					var top = document.documentElement.scrollTop + document.body.scrollTop;
					//网页的高度
					var textheight = $(document).height();
					// 网页高度-top-当前窗口高度
					if (textheight - top - $(window).height() <= 0) {
						$(".Contentbox").removeClass("overHidden");
						 if (i >= 100) { return;
						//控制最大只能加载到100
						}
						i++;
						//可以根据实际情况，获取动态数据加载 到 div1中
						addData();
					}
				});

			});

    		//添加数据函数
			function addData(){							
				//判断当前显示的Tab
				var boxdata = $(".Contentbox div").not(":hidden").attr("data");
				var boxid = $(".Contentbox div").not(":hidden").attr("id");
				//alert('#'+boxid + " .span8");
				//根据不同的data值，请求不同
				$('#'+boxid + " .span8").append('<div class="itemCol2"><a href="" title="" target="_black"><div class="itemImg"><img src="images/211.jpeg" alt=""></div></a><div class="itemCol2C"><h4>针头式细菌过滤器</h4><p class="h40">·厂商：河南博恩医疗新技术有限公司厂商：河南博恩医疗新技术有限公司厂商：河南博恩医疗新技术有限公司 ·厂商：河南博恩医疗新技术有限公司</p><ul><li>来源：阿里健康</li><li>浏览次数：1026</li><li>发表于：2016-06-07</li></ul></div></div>');
			}

    	});

    	//自动切换tab
		function setTab(name,cursel,n){
			for(i=1;i<=n;i++){
				var menu=document.getElementById(name+i);
				var con=document.getElementById("con_"+name+"_"+i);
				menu.className=i==cursel?"hover":"";
				con.style.display=i==cursel?"block":"none";
			}
		}
