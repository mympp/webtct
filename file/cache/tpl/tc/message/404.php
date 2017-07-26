<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('module-header');?>
<?php include template('menu2017');?>
<style>
.page-404{width: 990px;margin: 40px auto;}
.page-404-title{font-size: 20px;color: #e56639;margin-bottom: 8px;}
.page-404-link{font-size: 12px;color:#888;}
.page-404-msg{margin-top: 20px;}
.page-404-msg__li{line-height: 1.8;font-size: 14px;}
.page-404-msg__li:first-child{font-weight: bold;font-size: 16px;}
</style>
<div class="page-404">
<div style="background:url(<?php echo DT_SKIN;?>image/404.jpg) center center no-repeat;height:400px;"> 
<dl style="margin-left:430px;padding-top:150px;">
<dt class="page-404-title">您要找的页面它、它、它跑丢了！</dt>
<dd class="page-404-link"><?php echo $url;?></dd>
<dd class='page-404-msg'>
<ul class="page-404-msg__ul">
<li class="page-404-msg__li" >现象出现的情况原因：</li>
<li class="page-404-msg__li">1.页面有数据丢失/被删除。</li>
<li class="page-404-msg__li">2.相关数据未审核/或审核不通过！</li>
<li class="page-404-msg__li">3.数据涉嫌一些法律问题。</li>
<li class="page-404-msg__li">4.整个页面被外星人偷走！</li>
</ul>
</dd>
</dl>
<div></div>
</div>
</div>
<?php include template('footer2017');?>