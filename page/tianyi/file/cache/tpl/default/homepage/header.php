<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
<title><?php if($seo_title) { ?><?php echo $seo_title;?><?php } else { ?><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
<?php echo $COM['company'];?><?php } ?>
</title>
<?php if($head_keywords) { ?><meta name="keywords" content="<?php echo $head_keywords;?>"/><?php } ?>
<?php if($head_description) { ?><meta name="description" content="<?php echo $head_description;?>"/><?php } ?>
<meta name="generator" content="DESTOON B2B - www.destoon.com"/>
<meta name="template" content="<?php echo $template;?>"/>
<?php if($head_mobile) { ?>
<meta http-equiv="mobile-agent" content="format=html5;url=<?php echo $head_mobile;?>">
<?php } ?>
<?php if($head_canonical) { ?>
<link rel="canonical" href="<?php echo $head_canonical;?>"/>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['4']['moduledir'];?>/skin/common.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $HSPATH;?>style.css"/>
<?php if(!DT_DEBUG) { ?><script type="text/javascript">window.onerror= function(){return true;}</script><?php } ?>
<script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.1.8.0.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/page.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/homepage.js"></script>
<?php if($lazy) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.lazyload.js"></script><?php } ?>
<script type="text/javascript">
<?php if($head_mobile && $EXT['mobile_goto']) { ?>
GoMobile('<?php echo $head_mobile;?>');
<?php } ?>
<?php if($itemid && $DT['anticopy']) { ?>
document.oncontextmenu=function(e){return false;};
document.onselectstart=function(e){return false;};
<?php } ?>
</script>
<?php if($css) { ?><style type="text/css"><?php echo $css;?></style><?php } ?>
</head>
<body>
<div class="m-100">
<div class="com-top" >
<div class="com-header">
<h2 class="m-logo">
<img src="/skin/default/image/com-logo.png"/>
</h2>
<div class="com-menu">
<ul><li<?php if($moduleid<4) { ?> class="menuon"<?php } ?>
><a href="<?php echo $MODULE['1']['linkurl'];?>"><span>返回首页</span></a></li><?php if(is_array($MODULE)) { foreach($MODULE as $m) { ?><?php if($m['moduleid'] != 16) { ?><?php if($m['ismenu']) { ?><li<?php if($m['moduleid']==$moduleid) { ?> class="menuon"<?php } ?>
><a href="<?php echo $m['linkurl'];?>"<?php if($m['isblank']) { ?> target="_blank"<?php } ?>
><span<?php if($m['style']) { ?> style="color:<?php echo $m['style'];?>;"<?php } ?>
><?php echo $m['name'];?></span></a></li><?php } ?>
<?php } ?>
<?php } } ?></ul>
</div>
<div class="com-login">
<ul>
<li><a href="/member/login.php">登陆</a></li>
<li><a href="/member/register.php">注册</a></li>
</ul>
</div>
<div class="com-order">
<ul>
<li class="lir"><a href="">商家入驻</a></li>
<li class="lir"><a href="">我的订单</a></li>
<li class="lir"><a href="">我的关注</a></li>
<li class="lir"><a href="">收藏夹</a></li>
<li class="lir"><a href="">用户中心</a></li>
<li class="lirb"><a href="">网址导航</a></li>
</ul>
</div>
</div>
</div>
<!--<div class="top" id="top">-->
<!--<script type="text/javascript">addFav('收藏本页');</script> | <a href="<?php echo $COM['linkurl'];?>" onclick="javascript:try{this.style.behavior='url(#default#homepage)';this.setHomePage(location.href);}catch(e){}return false;">设为主页</a> | <a href="<?php echo DT_PATH;?>api/shortcut.php?itemid=<?php echo $userid;?>" rel="nofollow">保存桌面</a><?php if($EXT['mobile_enable']) { ?> | <a href="javascript:Go('<?php echo $EXT['mobile_url'];?>index.php?moduleid=4&username=<?php echo $username;?>');">手机版</a><?php } ?>
<?php if($head_mobile) { ?> | <a href="javascript:Dqrcode();">二维码</a><?php } ?>
-->
<!--</div>-->
<div class="c_b"></div>
</div>
<div class="m">
<div class="com-banner">
<div class="com-banner-left">
<img src="<?php echo $COM['thumb'];?>"/>
</div>
<div class="com-banner-right">
<div class="com-name f_l">
<span><?php echo $COM['company'];?></span>
</div>
<div class="com-name-right f_r">
<div class="com-link f_r">
<ul>
<li class="linkbg1"><?php echo $COM['telephone'];?></li>
<li class="linkbg2"><?php echo $COM['address'];?></li>
</ul>
</div>
<div class="com-wx f_r">
<img src="/company/image/wx.png"/>
</div>
<div class="c_b"></div>
</div>
</div>
<div class="com-banner-nav">
<ul>
<a href="<?php echo $COM['linkurl'];?>"><li class="<?php if($file=='homepage') { ?>newback<?php } ?>
"><span>首页</span></li></a>
<?php if(is_array($MENU)) { foreach($MENU as $k => $v) { ?>
<a href="<?php echo $v['linkurl'];?>"><li class="<?php if($file==$menu_file[$k]) { ?>newback<?php } ?>
"><span><?php echo $v['name'];?></span></li></a>
<?php } } ?>
<div class="c_b"></div>
</ul>
</div>
<div class="c_b"></div>
</div>
</div>
<?php if($bannert || $banner) { ?>
<div class="m">
<div class="banner">
<?php if($bannert == 2) { ?>
<div id="slide_banner" style="width:<?php echo $bannerw;?>px;height:<?php echo $bannerh;?>px;background:#FAFAFA;overflow:hidden;">
<a href="###"><img src="<?php echo $banner1;?>" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" alt=""/></a>
<a href="###"><img src="<?php echo $banner2;?>" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" alt=""/></a>
<?php if($banner3) { ?><a href="###"><img src="<?php echo $banner3;?>" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" alt=""/></a><?php } ?>
<?php if($banner4) { ?><a href="###"><img src="<?php echo $banner4;?>" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" alt=""/></a><?php } ?>
<?php if($banner5) { ?><a href="###"><img src="<?php echo $banner5;?>" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" alt=""/></a><?php } ?>
</div>
<?php echo load('slide.js');?>
<script type="text/javascript">new dslide('slide_banner');</script>
<?php } else if($bannert == 1) { ?>
<embed src="<?php echo $bannerf;?>" quality="high" loop="true" extendspage="http://get.adobe.com/flashplayer/" type="application/x-shockwave-flash" width="<?php echo $bannerw;?>" height="<?php echo $bannerh;?>" allowscriptaccess="never"></embed>
<?php } else if($banner) { ?>
<img src="<?php echo $banner;?>" width="100%"/>
<?php } ?>
</div>
</div>
<?php } ?>
