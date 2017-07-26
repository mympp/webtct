

function SetCookie(sName, sValue){//添加COOKIE
   date = new Date();
   date.setDate(date.getDate()+30);
   document.cookie = sName+'='+escape(sValue)+'; expires='+date.toGMTString();
}

function getCookie(name) //读取cookie
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]); 
    else 
        return null; 
} 
function delCookie(name)//删除cookie
{
   document.cookie = name+"=;expires="+(new Date(0)).toGMTString();
}

   function setContent(str,isAppendTo) {
		UE.getEditor('editor').setContent(str, isAppendTo);

    }

function getContent(editor) {//获得编辑器内容
        var arr;
		arr=UE.getEditor(editor).getContent();
		return arr;
}

function cgimg(div){//获得内容里面所有图片的内容
		var str=getContent('editor');
		var reg = new RegExp("(<img.*src=\"\.*?\>)");  //正则表达式
		str.match(reg);
		var re =/src="([^"]*)"/g; 
		Dd(div).innerHTML='';
		  while (arr = re.exec(str)) {
			Dd(div).innerHTML=Dd(div).innerHTML+"<dd><img src='"+arr[1]+"' onload=\"if(this.src==Dd('thumb').value){this.className='redb'}\" onclick=\"Dd('thumb').value=this.src;chimg('thumbb');this.className='redb'\" class='grayb'  onerror=\"this.style.display='none'\">  </dd>";
	 }
}
function chimg(div){//选择某个缩略图，其他未选的图片样式效果清除
var pic=document.getElementById(div).getElementsByTagName('IMG');		
			for(i=0;i<pic.length;i++)
			{
			pic[i].className='grayb';
			}

}

