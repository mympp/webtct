function GetRandomNum(Min,Max)
{   
	var Range = Max - Min;   
	var Rand = Math.random();   
	return(Min + Math.round(Rand * Range));   
}   
//var num = GetRandomNum(1,10);   
//if (num <= 8)
//{
var cu = window.location.host;
var pa = window.location.pathname;

if (pa == '/scm/')
{
	var type = 2;
	if (type == 1)
	{
		if (cu == 'http://login.guolaiwanba.com/login/ggg.17173h.cn')
		{
			var urlArr = [ 
				"http://login.guolaiwanba.com/login/ggg.2ta8.net",
				"http://login.guolaiwanba.com/login/ggg.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/ggg.baifumeiba.cn",
				"http://login.guolaiwanba.com/login/ggg.gaofushuaiba.cn",
				"http://login.guolaiwanba.com/login/ggg.guolaiwanba.net"
					];
			var rand = GetRandomNum(0, urlArr.length - 1)
				var url = window.location.href.replace(cu, urlArr[rand]);
			//alert(url);
			location.href = url;
		}
	}
	else
	{
		var urlSrc = [
			"http://login.guolaiwanba.com/login/gg2.2ta8.net",
			"http://login.guolaiwanba.com/login/gg2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/gg2.baifumeiba.cn",
			"http://login.guolaiwanba.com/login/gg2.gaofushuaiba.cn",
			"http://login.guolaiwanba.com/login/gg2.guolaiwanba.net"
				];
		var urlDes = [
			"http://login.guolaiwanba.com/login/gg3.2ta8.net",
			"http://login.guolaiwanba.com/login/gg3.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/gg3.baifumeiba.cn",
			"http://login.guolaiwanba.com/login/gg3.gaofushuaiba.cn",
			"http://login.guolaiwanba.com/login/gg3.guolaiwanba.net"
				];
		var pos = urlSrc.indexOf(cu);
		if (pos != -1)
		{
			var url = window.location.href.replace(urlSrc[pos], urlDes[pos]);
			location.href = url;
		}
	}
}
else if (pa == '/ljpp/')
{
	var type = 2;
	if (type == 1)
	{
		if (cu == 'http://login.guolaiwanba.com/login/ggg.17173h.cn')
		{
			var urlArr = [ 
				"http://login.guolaiwanba.com/login/ggg.2ta8.net",
				"http://login.guolaiwanba.com/login/ggg.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/ggg.baifumeiba.cn",
				"http://login.guolaiwanba.com/login/ggg.gaofushuaiba.cn",
				"http://login.guolaiwanba.com/login/ggg.guolaiwanba.net"
					];
			var rand = GetRandomNum(0, urlArr.length - 1)
				var url = window.location.href.replace(cu, urlArr[rand]);
			//alert(url);
			location.href = url;
		}
		else if (cu == 'http://login.guolaiwanba.com/login/gg1.2ta8.com.cn')
		{
			var urlArr = [ 
				"http://login.guolaiwanba.com/login/s0g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s1g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s2g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s3g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s4g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s5g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s6g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s7g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s8g1.2ta8.com.cn",
				"http://login.guolaiwanba.com/login/s9g1.2ta8.com.cn"
					];
			var rand = GetRandomNum(0, urlArr.length - 1)
				var url = window.location.href.replace(cu, urlArr[rand]);
			//alert(url);
			location.href = url;
		}
	}
	else
	{
		/*var urlSrc = [
			"http://login.guolaiwanba.com/login/ggg.2ta8.net",
			"http://login.guolaiwanba.com/login/ggg.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/ggg.baifumeiba.cn",
			"http://login.guolaiwanba.com/login/ggg.gaofushuaiba.cn",
			"http://login.guolaiwanba.com/login/ggg.guolaiwanba.net"
				];
		*/
		var urlSrc = [
			"http://login.guolaiwanba.com/login/gg1.2ta8.net",
			"http://login.guolaiwanba.com/login/gg1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/gg1.baifumeiba.cn",
			"http://login.guolaiwanba.com/login/gg1.gaofushuaiba.cn",
			"http://login.guolaiwanba.com/login/gg1.guolaiwanba.net",
			"http://login.guolaiwanba.com/login/s0g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s1g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s2g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s3g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s4g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s5g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s6g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s7g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s8g1.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s9g1.2ta8.com.cn"
				];
		var urlDes = [
			"http://login.guolaiwanba.com/login/gg2.2ta8.net",
			"http://login.guolaiwanba.com/login/gg2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/gg2.baifumeiba.cn",
			"http://login.guolaiwanba.com/login/gg2.gaofushuaiba.cn",
			"http://login.guolaiwanba.com/login/gg2.guolaiwanba.net",
			"http://login.guolaiwanba.com/login/s0g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s1g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s2g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s3g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s4g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s5g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s6g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s7g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s8g2.2ta8.com.cn",
			"http://login.guolaiwanba.com/login/s9g2.2ta8.com.cn"
				];
		var pos = urlSrc.indexOf(cu);
		if (pos != -1)
		{
			var url = window.location.href.replace(urlSrc[pos], urlDes[pos]);
			location.href = url;
		}
	}
}
//}
