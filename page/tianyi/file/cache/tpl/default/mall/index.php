<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $CSS = array('index');?>
<?php include template('header');?>
<div id="ipad_tips" style="display:none;"></div>
<div class="cat_ad">
<div class="full-silde">
<div class="fullbg">
<ul>
<li style="background:url(http://www.tctianyi.com/skin/default/image/banner1.png) center center no-repeat;">
<a target="_blank" href=""></a>
</li>
<li style="background:url(http://www.tctianyi.com/skin/default/image/banner2.png) center center no-repeat;display:none;">
<a target="_blank" href=""></a>
</li>
</ul>
</div>
<div class="hd">
<ul></ul>
</div>
</div>
<div class="left-area">
<ul>
<?php if($DT['page_catalog']) { ?>
<?php $mid = $moduleid;?>
<?php $child = get_maincat(0, $mid, 1);?>
<?php if(is_array($child)) { foreach($child as $i => $c) { ?>
<?php if($i<8 && $c['child']) { ?>
<?php $sub = get_maincat($c['catid'], $mid, 1);?>
<?php if($c['catid'] == 4) { ?>
<?php $licss = 'zx'?>
<?php } else if($c['catid'] == 5) { ?>
<?php $licss = 'tf'?>
<?php } else if($c['catid'] == 6) { ?>
<?php $licss = 'dg'?>
<?php } else if($c['catid'] == 7) { ?>
<?php $licss = 'gc'?>
<?php } else if($c['catid'] == 8) { ?>
<?php $licss = 'jj'?>
<?php } else if($c['catid'] == 9) { ?>
<?php $licss = 'sb'?>
<?php } else if($c['catid'] == 10) { ?>
<?php $licss = 'cr'?>
<?php } else if($c['catid'] == 11) { ?>
<?php $licss = 'fc'?>
<?php } ?>
<li class="left-area-<?php echo $licss;?>">
<div class="cname"><?php echo $c['catname'];?></div>
<div class="mod-cate-bd" style="display: none;">
<div class="hv-show-cat"><?php echo $c['catname'];?></div>
<?php if(is_array($sub)) { foreach($sub as $j => $s) { ?>
<div class="hv-child-cat">
<span><a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $s['linkurl'];?>"><?php echo $s['catname'];?></a></span>
</div>
<?php } } ?>
</div>
</li>
<?php } ?>
<?php } } ?>
<?php } ?>
<script>
$(function(){
$(".left-area ul li").bind("mouseover mouseout", function(e) {
if (e.type == 'mouseover') {
$(this).parent().children('.mod-cate-bd').hide();
var overname = $(this).attr("class");
var newc = overname+'-hover';
$(this).addClass(newc);
$(this).children('.mod-cate-bd').show();
}
if (e.type == 'mouseout') {
var outname = $(this).attr("class");
var outname1 = outname.substr(12,20);
$(this).removeClass(outname1);
$(this).children('.mod-cate-bd').hide();
}
});
});
</script>
</ul>
</div>
<div class="right-area">
<!--member-->
<div class="member">
<div class="user-info">
<span>hi，<span class="wenhou"></span></span>
<br/>
<span>欢迎来到天成医疗网！</span>
</div>
<div class="btn-area clearfix">
<ul>
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>"><li class="btn-area-li li-reg-bg">登 录></li></a>
<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>"><li class="btn-area-li li-reg-bg">立即注册></li></a>
</ul>
</div>
</div>
<script>
now = new Date();
hour = now.getHours();
if(hour >= 6 && hour < 12){
$(".wenhou").html("早上好！");
}else if (hour > 12 && hour <= 14){
$(".wenhou").html("中午好！");
}else if (hour > 14 && hour < 19){
$(".wenhou").html("下午好！");
}else if (hour > 19 && hour <= 24){
$(".wenhou").html("晚上好！");
}else if (hour < 6){
$(".wenhou").html("晚上好！");
}
</script>
<!--member end-->
<div class="btn-hy clearfix">
<span>行业动态</span>
</div>
<div class="btn-gg clearfix">
<ul>
<a href=""><li><div class="gg_title">[公告] 60家媒体集聚黄埔区加速</div></li></a>
<a href=""><li><div class="gg_title">[公告] 60家媒体集聚黄埔区加速</div></li></a>
</ul>
</div>
<div class="btn-zs clearfix">
<ul>
<a href=""><li class="gg-li gg-li-bg1">计算器</li></a>
<a href=""><li class="gg-li gg-li-bg2">金融助手</li></a>
<a href=""><li class="gg-li gg-li-bg3">询价助手</li></a>
<a href=""><li class="gg-li gg-li-bg4">检测助手</li></a>
<a href=""><li class="gg-li gg-li-bg5">推广助手</li></a>
<a href=""><li class="gg-li gg-li-bg6">找合伙人</li></a>
</ul>
</div>
</div>
</div>
<div class="c_b"></div>
<div class="m">
<?php if($DT['page_catalog']) { ?>
<?php $mid = $moduleid;?>
<?php $child = get_maincat(0, $mid, 1);?>
<?php if(is_array($child)) { foreach($child as $i => $c) { ?>
<?php if($i<8 && $c['child']) { ?>
<?php $sub = get_maincat($c['catid'], $mid, 1);?>
<?php if($i == 0) { ?>
<?php $floorid = 'fone'?>
<?php } else if($i == 1) { ?>
<?php $floorid = 'ftwo'?>
<?php } else if($i == 2) { ?>
<?php $floorid = 'fthree'?>
<?php } else if($i == 3) { ?>
<?php $floorid = 'ffour'?>
<?php } else if($i == 4) { ?>
<?php $floorid = 'ffive'?>
<?php } else if($i == 5) { ?>
<?php $floorid = 'fsix'?>
<?php } else if($i == 6) { ?>
<?php $floorid = 'fsev'?>
<?php } else if($i == 7) { ?>
<?php $floorid = 'fei'?>
<?php } ?>
<div class="floor-1" id="<?php echo $floorid;?>">
<div class="floor-title floor-title-bg-<?php echo $i+1;?>">
<div class="bigcat-title">
<span><?php echo $c['catname'];?></span>
</div>
<div class="cat-nav">
<ul>
<?php if(is_array($sub)) { foreach($sub as $j => $s) { ?>
<?php if($j<4) { ?>
<li><a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $s['linkurl'];?>"><?php echo $s['catname'];?></a></li>
<?php } ?>
<?php } } ?>
</ul>
</div>
<div class="good-more">
<a href="<?php echo $MODULE[$mid]['linkurl'];?><?php echo $c['linkurl'];?>" target="_blank">更多></a>
</div>
</div>
<div class="c_b"></div>
<div class="floor-con">
<div class="floor-con-left floor-con-left-bg<?php echo $i+1;?>">
<div class="left-con-mid">
<div class="con-mid-img">
<img src="/skin/default/image/<?php echo $i+1;?>F.png"/>
</div>
<div class="line-nav">
<ul>
<li></li>
<li class="line-nav-hv"></li>
<li></li>
</ul>
</div>
</div>
<div class="c_b"></div>
<div class="con-cat">
<ul>
<li class="li-fenge"><a href="">电源/信号线</a></li>
<li class="li-fenge"><a href="">同轴电缆</a></li>
<li class="li-fenges"><a href="">音箱线</a></li>
<li class="li-fenge"><a href="">控制电缆</a></li>
<li class="li-fenge"><a href="">电力电缆</a></li>
<li class="li-fenges"><a href="">电视电缆</a></li>
</ul>
</div>
</div>
<div class="floor-con-right">
<div class="con-right-list">
<?php if($c['catid'] == 4) { ?>
<?php $str = '4,12,13,14,15'?>
<?php } else if($c['catid'] == 5) { ?>
<?php $str = '5,16,17,18,19'?>
<?php } else if($c['catid'] == 6) { ?>
<?php $str = '6,20,21,22,23'?>
<?php } else if($c['catid'] == 7) { ?>
<?php $str = '7,24,25,26,27'?>
<?php } else if($c['catid'] == 8) { ?>
<?php $str = '8,28,29,30,31'?>
<?php } else if($c['catid'] == 9) { ?>
<?php $str = '9,32,33,34,35'?>
<?php } else if($c['catid'] == 10) { ?>
<?php $str = '10,36,37,38,39'?>
<?php } else if($c['catid'] == 11) { ?>
<?php $str = '11,40,41,42,43'?>
<?php } ?>
<?php $tags=tag ("moduleid=16&length=46&condition=status=3 and catid in($str) and level>0 and elite=0&areaid=$cityid&pagesize=5&order=".$MOD['order']."&template=null&debug=0")?>
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<?php if($i < 2) { ?>
<div class="con-left">
<div class="con-list-title">
<a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><?php echo $t['title'];?></a>
</div>
<div class="con-list-price"><?php echo $t['price'];?></div>
<div class="con-right-list-img">
<a href="<?php echo $t['linkurl'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><img src="<?php echo str_replace('.thumb.', '.middle.', $t['thumb']);?>" alt="<?php echo $t['alt'];?>""/></a>
</div>
</div>
<?php } ?>
<?php } } ?>
</div>
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<?php if($i == 2) { ?>
<div class="con-right-mid">
<div class="con-list-title-m">
<a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><?php echo $t['title'];?></a>
</div>
<div class="con-list-price"><?php echo $t['price'];?></div>
<div class="con-right-list-img-m">
<a href="<?php echo $t['linkurl'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><img src="<?php echo str_replace('.thumb.', '.middle.', $t['thumb']);?>" alt="<?php echo $t['alt'];?>""/></a>
</div>
</div>
<?php } ?>
<?php } } ?>
<div class="con-right-list">
<?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
<?php if($i > 2) { ?>
<div class="con-left">
<div class="con-list-title">
<a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><?php echo $t['title'];?></a>
</div>
<div class="con-list-price"><?php echo $t['price'];?></div>
<div class="con-right-list-img">
<a href="<?php echo $t['linkurl'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><img src="<?php echo str_replace('.thumb.', '.middle.', $t['thumb']);?>" alt="<?php echo $t['alt'];?>""/></a>
</div>
</div>
<?php } ?>
<?php } } ?>
</div>
<div class="con-right-list-right">
<div class="con-right-list-right-title">
<span><b class="dx">热门</b>推荐</span>
</div>
<div class="con-tj">
<ul>
<?php if($c['catid'] == 4) { ?>
<?php $str = '4,12,13,14,15'?>
<?php } else if($c['catid'] == 5) { ?>
<?php $str = '5,16,17,18,19'?>
<?php } else if($c['catid'] == 6) { ?>
<?php $str = '6,20,21,22,23'?>
<?php } else if($c['catid'] == 7) { ?>
<?php $str = '7,24,25,26,27'?>
<?php } else if($c['catid'] == 8) { ?>
<?php $str = '8,28,29,30,31'?>
<?php } else if($c['catid'] == 9) { ?>
<?php $str = '9,32,33,34,35'?>
<?php } else if($c['catid'] == 10) { ?>
<?php $str = '10,36,37,38,39'?>
<?php } else if($c['catid'] == 11) { ?>
<?php $str = '11,40,41,42,43'?>
<?php } ?>
<?php $tags_tj=tag ("moduleid=16&length=46&condition=status=3 and catid in($str) and level>0 and elite=1&areaid=$cityid&pagesize=6&order=".$MOD['order']."&template=null&debug=0")?>
<?php if(is_array($tags_tj)) { foreach($tags_tj as $i => $t1) { ?>
<li>
<div class="con-tj-img">
<a href="<?php echo $t1['linkurl'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><img src="<?php echo str_replace('.thumb.', '.middle.', $t1['thumb']);?>" alt="<?php echo $t1['alt'];?>""/></a>
</div>
<div class="con-tj-title">
<span><a href="<?php echo $t1['linkurl'];?>" title="<?php echo $t1['alt'];?>" <?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>
><?php echo $t1['title'];?></a></span>
<br/>
<span style="line-height: 30px;color:#ff6b33;font-size: 14px;">￥ <?php echo $t1['price'];?></span>
</div>
</li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="c_b"></div>
<?php if($i != 7) { ?>
<div class="con-ad">
</div>
<?php } ?>
<?php } ?>
<?php } } ?>
<?php } ?>
</div>
<script>
$(function(){
$('.con-right-list').hover(function(){
$(this).children('div:first-child').children('a').children('.liimg').stop().animate({left:"-5px"},200);
},function(){
$(this).children('div:first-child').children('a').children('.liimg').stop().animate({left:"0px"},200);
});
});
</script>
<div class="c_b"></div>
<div id="floor-nav">
<ul>
<li class="fone">
<span>1F<br/>装修<br/>主材</span>
</li>
<li class="ftwo">
<span>2F<br/>空调<br/>通风</span>
</li>
<li class="fthree">
<span>3F<br/>电工<br/>电气<br/>安防</span>
</li>
<li class="ffour">
<span>4F<br/>管材<br/>管件</span>
</li>
<li class="ffive">
<span>5F<br/>实验室<br/>家具</span>
</li>
<li class="fsix">
<span>6F<br/>仪器<br/>设备</span>
</li>
<li class="fsev">
<span>7F<br/>采暖<br/>热趸</span>
</li>
<li class="fei">
<span>8F<br/>辅材<br/>工具</span>
</li>
</ul>
<div class="roll2top" onclick="javascript:void(0);">顶部<i class="lift_btn_arrow"><!--&#xe606;--></i></div>
<script>
$(document).ready(function(){
$(window).bind("scroll.roll2top", function() {
var st = $(document).scrollTop(), winh = $(window).height();
//(st > 0) ? $('.roll2top').show() : $('.roll2top').hide();
if(!window.XMLHttpRequest) { $('.roll2top').css("top", st + winh - 166);}//IE6
});
$('.roll2top').click(function() {
$("html, body").animate({scrollTop:0}, 200);
});
$("#floor-nav ul li").click(function(){
var idname = $(this).attr('class');
$("html,body").animate({scrollTop:$("#"+idname).offset().top-40},500);
});
});
</script>
<script>
$(function(){
// @ 给窗口加滚动条事件
$(window).scroll(function(){
// 获得窗口滚动上去的距离
var ling = $(document).scrollTop();
// 在标题栏显示滚动的距离
if(ling>=600){
$("#floor-nav").fadeIn(1000);
}
if(ling<600){
$('#floor-nav').fadeOut(1000);
}
if(ling >= 600 && ling < 1100){
$('#floor-nav ul li').removeClass('changecolor');
$('.fone').addClass("changecolor");
}else if(ling >= 1100 && ling < 1800){
$('#floor-nav ul li').removeClass('changecolor');
$('.ftwo').addClass("changecolor");
}else if(ling >= 1800 && ling < 2400){
$('#floor-nav ul li').removeClass('changecolor');
$('.fthree').addClass("changecolor");
}else if(ling >= 2400 && ling < 3000){
$('#floor-nav ul li').removeClass('changecolor');
$('.ffour').addClass("changecolor");
}else if(ling >= 3000 && ling < 3700){
$('#floor-nav ul li').removeClass('changecolor');
$('.ffive').addClass("changecolor");
}else if(ling >= 3700 && ling < 4400){
$('#floor-nav ul li').removeClass('changecolor');
$('.fsix').addClass("changecolor");
}else if(ling >= 4400 && ling < 5000){
$('#floor-nav ul li').removeClass('changecolor');
$('.fsev').addClass("changecolor");
}else if(ling >= 5000){
$('#floor-nav ul li').removeClass('changecolor');
$('.fei').addClass("changecolor");
}
});
});
</script>
</div>
<?php include template('footer');?>