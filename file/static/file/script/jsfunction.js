function chulai(id){ var id = document.getElementById(id); if(id.style.display == "none"|id.style.display == ""){ id.style.display = "block"; } else { id.style.display = "none"; } }
function guanbi(id){ var id = document.getElementById(id); id.style.display = "none";  }
function dakai(id){ var id = document.getElementById(id); id.style.display = "block";  }
function selecttab(id,css,num,nums){
			for(i=1;i<=nums;i++){
			document.getElementById(id+'tab'+i).className=css+'n'; 
			document.getElementById(id+'div'+i).style.display='none'; 
			if(i==num){document.getElementById(id+'tab'+i).className=css+'y';
			document.getElementById(id+'div'+i).style.display='block'; }
			}
}

function selectlist(id,texts,ids,values){
Dd(id).innerText=texts;
Dd(id+'values').value=texts;
Dd(ids).value=values;
}
function topmenu(){
					document.writeln("<div class=\"webw t400\">");
					document.writeln("	<div class=\'topinfo fl\'  id='destoon_member'><\/div>");
					document.writeln("	<div class=\'topmenu fl\'>");
					document.writeln("			<ul class=\"hlist\">");
					document.writeln("			<li>");
					addFav('加入收藏');
					document.writeln("			<\/li>");
					document.writeln("			<li><a href='http://"+window.location.host+"/chanpin/cart.php'>购物车(<span id='destoon_cart'>0<\/span>)<\/a><\/li>");
					document.writeln("			<li><a href='http://"+window.location.host+"/member/message.php'>站内信(<span id='destoon_message'>0\</span>)<\/a><\/li>");
					document.writeln("			<li><a href='http://"+window.location.host+"/member/chat.php'>对话(<span id='destoon_chat'>0<\/span>)<\/a><\/li>");
					document.writeln("			<li><a href='http://"+window.location.host+"/wap'>手机<span id='tecenetapp'>APP<\/span><\/a><\/li>");
					document.writeln("			<\/ul>");
					document.writeln("	<\/div>");
					document.writeln("<\/div>");
					}
 function msgbox(id,title,href){
				$.dialog({
                id: id,
				fixed: true, 
				drag: true, 
				resize:true, 
				height:150,
				width:880,
				title:title,
				focus:true,
				content:'url:'+href+''
				});
				 }
 function msgdiv(id,title,href){
				$.dialog({
                id: id,
				fixed: false, 
				drag: true,
				resize:true, 
				height:150,
				width:880,
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
function closebox(id){$.dialog({id: id}).time(1);}
function bgcolor(id,color){id=document.getElementById(id);id.style.backgroundColor=color;}
function bgimage(id,image){id=document.getElementById(id);id.style.backgroundImage='url('+image+')';}
document.writeln("<iframe name=\"caozuo\" id=\"caozuo\" scrolling=\"no\" frameborder=\"0\"  width=400 height=400 style=\"display:none\" ><\/iframe>");
function show_resume_comment(u, m, i) 
{document.write('<iframe src="'+u+'resume_comment.php?mid='+m+'&itemid='+i+'" name="destoon_comment" id="des'+'toon_comment" style="width:99%;height:0px;" scrolling="no" frameborder="0"></iframe>');}

function setcontent(EditorName,ContentStr) { 
    var oEditor = FCKeditorAPI.GetInstance(EditorName); 
    oEditor.SetHTML(ContentStr) ; 
}
