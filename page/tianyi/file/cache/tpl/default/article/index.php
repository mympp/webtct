<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m">
<div class="m-930">
<div>
<div class="artimg">
<img src="/skin/default/image/artimg.png"/>
</div>
<div id="point-left"></div>
<div id="point-right"></div>
</div>
<div class="c_b"></div>
<div class="artcon" style="margin-top: -120px;">
<div class="artcatname">
<div class="artcatname-t">
<span>行业资讯</span>
</div>
<div class="artcatname-m">
<a href="<?php echo $MOD['linkurl'];?>list.php?catid=52"><span>更多>></span></a>
</div>
<div class="c_b"></div>
</div>
<div class="artlist">
<div class="artlist-l">
<?php $top_picture=tag("moduleid=$moduleid&catid=52&offset=0&pagesize=1&condition=level=1&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=52&offset=0&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=52&offset=0&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=52&offset=1&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=52&offset=5&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="artcon">
<div class="artcatname">
<div class="artcatname-t">
<span>展会信息</span>
</div>
<div class="artcatname-m">
<a href="<?php echo $MOD['linkurl'];?>list.php?catid=53"><span>更多>></span></a>
</div>
<div class="c_b"></div>
</div>
<div class="artlist">
<div class="artlist-l">
<?php $top_picture=tag("moduleid=$moduleid&catid=53&offset=0&pagesize=1&condition=level=1&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=53&offset=0&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=53&offset=0&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=53&offset=1&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=53&offset=5&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="artcon">
<div class="artcatname">
<div class="artcatname-t">
<span>最新活动</span>
</div>
<div class="artcatname-m">
<a href="<?php echo $MOD['linkurl'];?>list.php?catid=54"><span>更多>></span></a>
</div>
<div class="c_b"></div>
</div>
<div class="artlist">
<div class="artlist-l">
<?php $top_picture=tag("moduleid=$moduleid&catid=54&offset=0&pagesize=1&condition=level=1&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=54&offset=0&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=54&offset=0&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<div class="artlist-m">
<div class="artlist-m-img">
<?php $top_picture=tag("moduleid=$moduleid&catid=54&offset=1&pagesize=1&condition=level=2&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=54&offset=5&condition=level!=2 and level!=1&pagesize=5&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="artcon">
<div class="artcatname">
<div class="artcatname-t">
<span>技术文库</span>
</div>
<div class="artcatname-m">
<a href="<?php echo $MOD['linkurl'];?>list.php?catid=55"><span>更多>></span></a>
</div>
<div class="c_b"></div>
</div>
<div class="artlist">
<div class="artlist-l">
<?php $top_picture=tag("moduleid=$moduleid&catid=55&offset=0&pagesize=1&condition=level=1&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m">
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=55&offset=0&condition=level!=2 and level!=1&pagesize=10&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<div class="artlist-m">
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=55&offset=10&condition=level!=2 and level!=1&pagesize=10&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="artcon">
<div class="artcatname">
<div class="artcatname-t">
<span>政策法规</span>
</div>
<div class="artcatname-m">
<a href="<?php echo $MOD['linkurl'];?>list.php?catid=56"><span>更多>></span></a>
</div>
<div class="c_b"></div>
</div>
<div class="artlist">
<div class="artlist-l">
<?php $top_picture=tag("moduleid=$moduleid&catid=56&offset=0&pagesize=1&condition=level=1&template=null")?>
<a href="<?php echo $top_picture['0']['linkurl'];?>">
<img src="<?php echo $top_picture['0']['thumb'];?>" title="<?php echo $top_picture['0']['title'];?>"/>
<span class="artlist-l-title"><?php echo $top_picture['0']['title'];?></span>
</a>
</div>
<div class="artlist-m">
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=56&offset=0&condition=level!=2 and level!=1&pagesize=10&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<div class="artlist-m">
<div class="artlist-m-li">
<ul>
<?php $loop=tag("moduleid=$moduleid&catid=56&offset=10&condition=level!=2 and level!=1&pagesize=10&template=null")?>
<?php if(is_array($loop)) { foreach($loop as $i => $v) { ?>
<li><a href="<?php echo $v['linkurl'];?>"><?php echo $v['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="engcon">
<div class="artcatname">
<div class="artcatname-t">
<span>招标信息</span>
</div>
<div class="engin-cat">
<ul>
<li class="sel-engin">全部</li>
<li>工程</li>
<li>货物</li>
<li>全部</li>
</ul>
</div>
<div class="c_b"></div>
</div>
<div class="englist">
<div class="engheader">
<ul>
<li class="liwid_1">项目名称</li>
<li class="liwid_2">招标区域</li>
<li class="liwid_3">招标时间</li>
<li class="liwid_4">剩余时间</li>
</ul>
</div>
<div class="c_b"></div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">安徽饭店安徽饭店服装采购及服务公告（二次）</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">办公楼内装饰设计与施工两阶段（第一阶段：方......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">安徽江淮汽车股份有限公司高端及纯电动轻卡建......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">华能巢湖发电有限责任公司氯酸钠采购招标公告......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">安徽民航机场集团有限公司新桥机场航站楼鲜榨......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">皖能铜陵发电有限公司3号机组超低排放改造脱......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">安徽民航机场集团有限公司新桥机场航站楼卫生......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="enginfo">
<ul>
<li class="engtitle"><a href="">安徽江淮汽车股份有限公司年产10万辆高端新能......</a></li>
<li class="engaddr">广州</li>
<li class="engtime">2017/04/13</li>
<li class="engsy">还剩15天</li>
</ul>
</div>
<div class="engmore">
<span><a href="">查看更多>></a></span>
</div>
</div>
</div>
</div>
<div class="m-250">
<div class="tab-zs">
<ul>
<li class="zs-ds-1">计算器</li>
<li class="jrzs-bg">金融助手</li>
</ul>
<div class="c_b"></div>
<ul>
<li class="xjzs-bg">询价助手</li>
<li class="zs-ds-3">检测助手</li>
</ul>
<div class="c_b"></div>
<ul>
<li class="zs-ds-5">推广助手</li>
<li class="hhr-bg">找合伙人</li>
</ul>
</div>
<div class="hot-news">
<div class="hot-news-title">
<span>热门资讯</span>
</div>
<ul>
<?php echo tag("moduleid=$moduleid&condition=status=3 and addtime>$today_endtime-30*86400&areaid=$cityid&order=hits desc&pagesize=".$MOD['page_ihits']."&target=_blank");?>
<div class="c_b"></div>
</ul>
</div>
<div class="hot-goods-list">
<div class="hot-news-title">
<span>热门商品</span>
</div>
<?php if(is_array($hot_list)) { foreach($hot_list as $t) { ?>
<div class="hot-goods">
<a href="<?php echo $t['linkurl'];?>">
<div class="hot-goods-img">
<img src="<?php echo $t['thumb'];?>"/>
</div>
<div class="hot-goods-title">
<span><?php echo $t['title'];?></span>
</div>
</a>
</div>
<?php } } ?>
</div>
<div class="c_b"></div>
<div class="art_adlist">
<img src="/skin/default/image/artadimg1.jpg"/>
</div>
<div class="art_adlist">
<img src="/skin/default/image/artadimg2.jpg"/>
</div>
<div class="art_adlist">
<img src="/skin/default/image/artadimg.jpg"/>
</div>
</div>
</div>
<?php include template('footer');?>