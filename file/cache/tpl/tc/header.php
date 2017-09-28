<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('title');?>
<body id="webmid<?php echo $moduleid;?>">
<!--[if lte IE 6]>
<div class="pd10 tc gcolor f18">您的浏览器IE6是最低级别的浏览器！为了您更好的体验本站和您电脑/账号安全请尽快升级您的浏览器！<br>强烈建议您立即 <a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">升级IE浏览器</a> 或者用更快更安全的 <a href="https://www.google.com/intl/zh-CN/chrome/browser/?hl=zh-CN" target="_blank">谷歌浏览器Chrome</a></div>
<![endif]-->
<?php if(!$headertp) { ?>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/arrowtree.js"></script> 
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/miniDropdown.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#youcan").click(function(){$("#leftmenu").slideToggle("normal");});
});
</script>
<div class='topmenubg'>
<!--最顶部菜单-->
<script type="text/javascript">topmenu(<?php if($moduleid>2) { ?><?php echo $moduleid;?><?php } else { ?>1<?php } ?>
)</script>
<?php if(!$teceid) { ?>
<script type="text/javascript">Dd('tece<?php echo $moduleid;?>').className='welcomey';</script>
<?php } else { ?>
<div style="display:none;"><a href="http://www.tecenet.com/nindex.php" target="_blank">新版首页</a></div>
<script type="text/javascript">Dd('tece<?php echo $teceid;?>').className='welcomey';</script>
<?php } ?>
</div>
<!--Header-->
<div class='topbg cut'><!--背景和LOGO -->
<div class="webw siteinfo">
<div class="logo fl cut">
<?php if($mlogo) { ?>
<a href="<?php echo $MODULE[$moduleid]['linkurl'];?>" title="回到{<?php echo $MODULE[$moduleid]['title'];?>}"><img src="<?php echo DT_SKIN;?>image/<?php echo $mlogo;?>" onerror="this.src='<?php echo DT_SKIN;?>image/logo.gif'"></a>
<?php } else { ?>
<a href="http://www.tecenet.com" title="回到天成医疗网首页"><img src="<?php echo DT_SKIN;?>image/logo.gif"></a>
<?php } ?>
<h1>天成医疗网<br>www.tecenet.com</h1>
</div>
<div class="topsearch fl">
<?php include template('search-tool','chip');?>
</div>
<div class="T4000 fl">
<?php if(!$tel400&&$moduleid>2) { ?>
<?php $tel400=DT_SKIN.'image/'.$module.'/400.gif';?>
<?php } else { ?>
<?php $tel400=DT_SKIN.'image/'.$tel400;?>
<?php } ?>
<a href="<?php echo DT_PATH;?>about/contact.html"><img src="<?php echo $tel400;?>"  onerror="this.src='<?php echo DT_SKIN;?>image/400.gif'"></a>
</div>
</div>
</div>
<!--//Header-->
<div <?php if($moduleid==1) { ?>class='webbg'<?php } else { ?>class='webbg2'<?php } ?>
 id='modulebg'>
<div class="webw">
<div id="shopcart" class="shopcart"><a href='<?php echo $MODULE['16']['linkurl'];?>cart.php'  rel="nofollow">购物车(<span id='destoon_cart'>0</span>)</a></div>
<?php if(!$sitemenu) { ?><?php include template('menu');?><?php } else { ?><?php include template('menu',$sitemenu);?><?php } ?>
<div class="divline" id="menubgs"></div>
<div class="center autoheight"  id="webbodycontent" >
<?php } else { ?>
<?php include template('header',$headertp);?>
<?php } ?>
