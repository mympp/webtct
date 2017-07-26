function chulai(id){ var id = document.getElementById(id); if(id.style.display == "none"|id.style.display == ""){ id.style.display = "block"; } else { id.style.display = "none"; } }
function guanbi(id){ var id = document.getElementById(id); id.style.display = "none";  }
function dakai(id){ var id = document.getElementById(id); id.style.display = "block";  }
function selecttab(id,nums,num){
			for(i=1;i<=nums;i++){
			var s=Dd(id+'tab'+i).className;var idy=id+'y';var idn=id+'n';
			Dd(id+'tab'+i).className=s.replace(idy,idn); 
			Dd(id+'div'+i).style.display='none'; 
			if(i==num){Dd(id+'tab'+i).className=s.replace(idn,idy); 
			Dd(id+'div'+i).style.display='block'; }
			}
}

function selectlist(id,texts,ids,values){
	if(ids == "so_tecenet"){
		$("#topkeyword").css("background","");
		$("#topkeyword").attr("name","keyword");
		$("#destoon_search").attr("action","http://so.tecenet.com/search.php");
		Dd(id).innerText=texts;
	}else{
		$("#topkeyword").css("background-image","none");
		$("#topkeyword").attr("name","kw");
		$("#destoon_search").attr("action","http://www.tecenet.com/search.php");
		Dd(id).innerText=texts;
		Dd(ids).value=values;
	}
}
function topmenu(menus){
					document.writeln("<div class=\"webw t400\">");
					document.writeln("			<div class=\'fl topmenu welcome\'>");
					document.writeln("<div class=\"w400 cut lenstr\"  id=\"siteinfos\" onmouseover=\"this.className=''\" onmouseout=\"this.className='w400 cut lenstr'\">");
					if(menus==1){
					document.writeln("欢迎来到国内专业医疗产业服务平台,提供：技术服务  产品配送  采购招标  工程装修  人才培训  进出口  品牌推广 等等一站式服务");
					}
					else{
                    document.writeln("<a href='http://www.tecenet.com' id='tece1'>天成首页</a><a href='http://www.tecenet.com/fuwu' id='tece9'>技术服务</a><a href='http://www.tecenet.com/chanpin'  id='tece16'>产品销售</a><a href='http://www.tecenet.com/zhaobiao' id='tece6'>招标采购</a><a href='http://www.tecenet.com/zizhi' id='tece7'>资质服务</a><a href='http://www.tecenet.com/gongying' id='tece5'>供求行情</a><a href='http://www.tecenet.com/pinpai'  id='tece13'>品牌</a><a href='http://www.tecenet.com/gongsi'  id='tece13'>厂家</a><a href='http://www.tecenet.com/zixun' id='tece21'>资讯</a><a href='http://www.tecenet.com/gongxiang'  id='tece15'>共享</a><a href='http://www.tecenet.com/wenda'  id='tece10'>问答</a><a href='http://www.tecenet.com/taoxinxi' id='tecetao'>群信息</a>");
					}
					document.writeln("			<\/div>");
					document.writeln("			<\/div>");
					document.writeln("	<div class=\'topmenu fr\'>");
					document.writeln("			<ul>");
					if($moduleid=16){
					}else{
					document.writeln("			<li style='margin-right:0px;'>");
					addFav('加入收藏');
					document.writeln("			<\/li>");
					}
					document.writeln("	<li   id='destoon_member'><\/li>");
					document.writeln("			<\/ul>");
					document.writeln("	<\/div>");
					document.writeln("<\/div>");

					}
 function msgbox(id,title,href){
var width= arguments[3] || 880; 
var height= arguments[4] || 150; 
				$.dialog({
                id: id,
				fixed: true, 
				drag: true, 
				resize:true, 
				height:height,
				width:width,
				title:title,
				focus:true,
				content:'url:'+href+''
				});
				 }
 function msgdiv(id,title,href){
var width= arguments[3] || 880; 
var height= arguments[4] || 150; 
				$.dialog({
                id: id,
				fixed: false, 
				drag: true,
				resize:true, 
				height:height,
				width:width,
				title:title,
				top:'50%',
				focus:true,
				content:'url:'+href+''
				});
				 }
function msgtip(title,content){
	$.dialog({
    lock: true,
	title:title,
    content: content,
    icon: 'face-smile.png'
});
}
function msghtml(id,title,content,height){
	$.dialog({
	id: id,
    lock: true,
	title:title,
	height:height,
    content: content
});
}
function closebox(id){$.dialog({id: id}).time(0.1);}
function bgcolor(id,color){id=document.getElementById(id);id.style.backgroundColor=color;}
function bgimage(id,image){id=document.getElementById(id);id.style.backgroundImage='url('+image+')';}
document.writeln("<iframe name=\"caozuo\" id=\"caozuo\" scrolling=\"no\" frameborder=\"0\"  width=400 height=400 style=\"display:none\" ><\/iframe>");
function show_resume_comment(u, m, i) 
{document.write('<iframe src="'+u+'resume_comment.php?mid='+m+'&itemid='+i+'" name="destoon_comment" id="des'+'toon_comment" style="width:99%;height:0px;" scrolling="no" frameborder="0"></iframe>');}

function setcontent(EditorName,ContentStr) { 
    var oEditor = FCKeditorAPI.GetInstance(EditorName); 
    oEditor.SetHTML(ContentStr) ; 
}
function icos(id){
var strs='ico';
for (i=1;i<6 ;i++ )
{Dd(strs+i).className='';}
if(id>0){Dd(strs+id).className=strs+id+'y';}
if(id>1){Dd(strs+'1').className=strs+'1sy';}
}
function seltab(strs,id,k){
for(i=1;i<=k;i++){Dd(strs+i).style.display='none';}
Dd(strs+id).style.display='block';}

function geturlfilename(urls){
            var url = urls;
            while (url.indexOf("/") > -1) {
                url = url.substring(url.indexOf("/") + 1, url.length);
            }
            return url;
}
function getcookie(objname){//获取指定名称的cookie的值
var arrstr = document.cookie.split("; ");
for(var i = 0;i < arrstr.length;i ++){
var temp = arrstr[i].split("=");
if(temp[0] == objname) return unescape(temp[1]);
}
}