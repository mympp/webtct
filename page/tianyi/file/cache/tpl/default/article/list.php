<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<script type="text/javascript">var sh = '<?php echo $MOD['linkurl'];?>search.php?catid=<?php echo $catid;?>';</script>
<div class="m">
<div class="list_left">
<div class="m_toppos"><li><span>我的位置: <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &gt; <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a> &gt; <?php echo cat_pos($CAT, ' &gt; ');?></span></li></div>
<div class="list_title">
<span class="public_list_title f_l"><?php echo $catname;?></span>
</div>
<div class="article_nr">
<?php if($tags) { ?><?php include template('list-cat', 'tag');?><?php } ?>
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