
<?php
function iframe($url){
	$domain=array();
	$domain[0]='eqxiu.';$domain[1]='liveapp.';
	foreach($domain as $d){
		if(strpos($url,$d))return true;
	}
}

//获取头条文章
function toutiao($content){
	$title=getbetween($content,'<h1 class="article-title">','</h1>');
	$content=getbetween($content,'<div class="article-content">','</div>');
	$content=clear_link($content);
	preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
	foreach ($match[1] as $v => $key) {

 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
	 }
	 $content .="</div>";

	 if(!$content)$content=' 部分头条文章，请自行复制内容到此处粘贴！';
	 $toutiao = array($title,$content);
	 return $toutiao;
}


	//获取虎嗅网文章
function huxiu($content){
	$title=getbetween($content,'<h1 class="t-h1">','</h1>');

	$content=getbetween($content,'<div class="article-manage-bar"></div>','<div class="Qr-code">');
	$content=clear_link($content);

	//preg_match_all('/<img.*?src="(.*?)">/', $content, $match);
	preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
	foreach ($match[1] as $v => $key) {
 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
	 }
	 $content .="</div>";
	 if(!$content)$content=' 非虎嗅网文章，请自行复制内容到此处粘贴！';
	 $huxiu = array($title,$content);
	 return $huxiu;
}

	//获取凤凰网文章
function ifeng($content){
	$title=getbetween($content,'<h1 itemprop="headline" id="artical_topic">','</h1>');
	$logo = getbetween($content,'<span class="ifengLogo">','</span>');

	$content=getbetween($content,'<!--mainContent begin-->','<!--mainContent end-->');
	$content=str_replace($logo,' ',$content);
	$content=clear_link($content);

	preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
	foreach ($match[1] as $v => $key) {
 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
	 }

	 if(!$content)$content=' 非凤凰网文章，请自行复制内容到此处粘贴！';
	 $ifeng = array($title,$content);
	 return $ifeng;
}
	//获取移动凤凰网文章
function m_ifeng($content){
	$title=getbetween($content,'<h3 class="n-title">','</h3>');

	$content=getbetween($content,'<div class="zw-real">','<style>.er_desc p{min-width: 10px; min-height: 16px;}</style>');
	$content=clear_link($content);

	preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
	foreach ($match[1] as $v => $key) {
 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
	 }

	 if(!$content)$content=' 非移动端凤凰网文章，请自行复制内容到此处粘贴！';
	 $m_ifeng = array($title,$content);
	 return $m_ifeng;
}

	//获取腾讯网文章
function tengxun($content){
	$images = '';
	preg_match_all('/"url":"http:\/\/zxpic.gtimg.com(.*?)(\/800"})/', $content, $match);

	$title=getbetween($content,'<title>','</title>');
	$content=getbetween($content,'"content":["','"],"logic_channel"');

	foreach ($match[1] as $v => $key) {
		$images .='<br/><img src="http://zxpic.gtimg.com'.$key.'/320"/><br/>(图'.($v+1).'/'.count($match[1]).')<br/>';
 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://zxpic.gtimg.com'.$key.'/320',$filename);
 		$images=str_replace('zxpic.gtimg.com'.$key.'/320','www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$images);
	 }

	$content = $images.$content;
	$content=str_replace('\u201d','”',$content);
	$content=str_replace('\u201c','“',$content);
	$content=str_replace('\u2018','‘',$content);
	$content=str_replace('\u2019','’',$content);
	$content=str_replace('","','',$content);
	$content=str_replace('\u2014\u2014\u2014','———',$content);
	$content=clear_link($content);

	 if(!$content)$content=' 非腾讯网文章，请自行复制内容到此处粘贴！';
	 $tengxun = array($title,$content);
	 return $tengxun;
}

	//获取新闻哥文章
function inews($content){
	$title=getbetween($content,'<p class="title" align="left">','</p>');
	$rep = getbetween($content,'<div class="src">','</div>');
	$rep2 = getbetween($content,'<div class="summary" style="margin-top:10px;">','</div>');

	$content=getbetween($content,'<div id="content" class="main fontSize2">','<div class="baikeBox">');
	$content=str_replace($rep,' ',$content);
	$content=str_replace($rep2,' ',$content);
	$content=str_replace($title,'',$content);
	$content=clear_link($content);

	preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
	foreach ($match[1] as $v => $key) {
 		$filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
 		//www.tecenet.com/file/upload/weixin/image/
	 }

	 if(!$content)$content=' 非腾讯新闻网文章，请自行复制内容到此处粘贴！';
	 $content = '<div>'.$content;

	 $inews = array($title,$content);
	 return $inews;
}

	//获取微信文章
function weixin($content){
	$title=getbetween($content,"<title>","</title>");
	$content=getbetween($content,'<div class="rich_media_content " id="js_content">','<script type="text/javascript">');
	$content=clear_link($content);
	$content=str_replace('data-src','src',$content);
	if (strpos($content,'iframe')) {
		$content=str_replace('width="670"',' width="320"',$content);
		$content=str_replace('width=670',' width=320',$content);
		$content=str_replace('width: 670px !important','width: 320px !important',$content);
	}else{
		$content=str_replace('width=',' width="320" widthd=',$content);
		$content=str_replace('width:','width:_',$content);
		$content=str_replace('height=',' height="auto" heightd=',$content);
	}

	preg_match_all('/http:\/\/(.*?)("|\);)/', $content, $match);

	for ($i=0; $i < count($match[1]); $i++) {
		// 微信图片地址
		$wx_image = $match[1][$i];
		//判断图片地址
		$findme   = 'mmbiz.qpic.cn/mmbiz/';
		$pos 	  = strpos($wx_image, $findme);
		$findme2  = 'mmbiz.qpic.cn/mmbiz_';
		$pos2 	  = strpos($wx_image, $findme2);
		//判断是否jpg地址
		$findmeJpg   = 'mmbiz.qpic.cn/mmbiz_jpg';
		$posJpg 	 = strpos($wx_image, $findmeJpg);
		//判断是否Gif地址
		$findmeGif   = 'mmbiz.qpic.cn/mmbiz_gif';
		$posGif 	 = strpos($wx_image, $findmeGif);
		//判断是否jpg地址
		$findmePng   = 'mmbiz.qpic.cn/mmbiz_png';
		$posPng 	 = strpos($wx_image, $findmePng);

		if ($pos !== false && $pos2 == false) {
			// 获取中间字符串 filename
			$filename = getbetween($wx_image,'mmbiz.qpic.cn/mmbiz/','/');
			// 拼接下载地址，下载图片，并返回图片本地地址
 			$imageURL = downloadAndImage('http://mmbiz.qpic.cn/mmbiz/'.$filename.'/',$filename);
			if(!$imageURL) $imageUrl = downloadAndImage('https://mmbiz.qpic.cn/mmbiz/'.$filename.'/',$filename);
		} elseif ($posJpg !== false) {
			$filenameJpg 		= getbetween($wx_image,'mmbiz.qpic.cn/mmbiz_jpg/','/');
 			$imageURL 	= downloadAndImage('http://mmbiz.qpic.cn/mmbiz_jpg/'.$filenameJpg.'/',$filenameJpg);
			if(!$imageURL) $imageURL = downloadAndImage('https://mmbiz.qpic.cn/mmbiz_jpg/'.$filenameJpg.'/',$filenameJpg);
		} elseif ($posGif !== false) {
			$filenameGif 		= getbetween($wx_image,'mmbiz.qpic.cn/mmbiz_gif/','/');
 			$imageURL 	= downloadAndImage('http://mmbiz.qpic.cn/mmbiz_gif/'.$filenameGif.'/',$filenameGif);
			if(!$imageURL) $imageURL = downloadAndImage('https://mmbiz.qpic.cn/mmbiz_gif/'.$filenameGif.'/',$filenameGif);
		} elseif ($posPng !== false) {
			$filenamePng 	= getbetween($wx_image,'mmbiz.qpic.cn/mmbiz_png/','/');
 			$imageURL 	= downloadAndImage('http://mmbiz.qpic.cn/mmbiz_png/'.$filenamePng.'/',$filenamePng);
			if(!$imageURL) $imageURL = downloadAndImage('https://mmbiz.qpic.cn/mmbiz_png/'.$filenamePng.'/',$filenamePng);
		}
		$content = str_replace($wx_image, $imageURL, $content);
	}

	if(!$content)$content=' 非微信公众号文章，请自行复制内容到此处粘贴！';
	$weixin = array($title,$content);
	return $weixin;
}

function tencent($content)
{
    $title=getbetween($content, '<h1 class="title">', '</h1>');
    $content=getbetween($content,'<!-- content/S -->','<!-- content/E -->');

    $content=str_replace($title,'',$content);
    $content=clear_link($content);

    preg_match_all('/http:\/\/(.*?)("|\);|">)/', $content, $match);
    foreach ($match[1] as $v => $key) {
        $filename = time().$v;
 		$content_type = downloadImageFromQzone('http://'.$key,$filename);
 		$content=str_replace($key,'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$content_type,$content);
     }

     if (!$content) {
        $content=' 非腾讯新闻网文章，请自行复制内容到此处粘贴！';
    }

     $inews = array($title,$content);
     return $inews;
}

?>
