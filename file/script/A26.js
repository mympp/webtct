var config = '5|0xFFFFFF|0x333333|80|0xFAFAFA|0x333333|0x000000';
var files = "http://127.0.0.1/file/upload/201302/21/01-59-01-71-2.jpg|http://127.0.0.1/file/upload/201302/25/03-06-45-45-1.jpg";
var links = "http://127.0.0.1/extend/redirect-htm-aid-12.html|";
var texts = '';
document.write('<embed src="http://127.0.0.1/file/flash/slide.swf" wmode="opaque" FlashVars="config='+config+'&bcastr_flie='+files+'&bcastr_link='+links+'&bcastr_title='+texts+'&menu="false" quality="high" width="480" height="240" type="application/x-shockwave-flash" extendspage="http://get.adobe.com/flashplayer/"></embed>');