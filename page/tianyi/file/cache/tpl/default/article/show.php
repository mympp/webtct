<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<script type="text/javascript">var module_id= <?php echo $moduleid;?>,item_id=<?php echo $itemid;?>,content_id='content',img_max_width=<?php echo $MOD['max_width'];?>;</script>
<div class="m">
<div class="list_left">
<div class="m_toppos"><li><span>我的位置: <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &gt; <a href="<?php echo $MOD['linkurl'];?>"><?php echo $MOD['name'];?></a> &gt; <?php echo cat_pos($CAT, ' &gt; ');?>&gt;正文</span></li></div>
<div class="show_article">
<div class="show_title"><?php echo $title;?></div>
<div class="show_info">
<span><?php echo $adddate;?></span>
<span>浏览次数：<?php echo $hits;?></span>
<span>评论：52</span>
</div>
<div class="show_content">
<div class="show_introduce">核心提示 <?php echo $introduce;?></div>
<div id="content" class="new_content"><?php echo $content;?></div>
</div>
<div class="show_np">
<ul>
<li class="f_l">上一篇：<?php echo tag("moduleid=$moduleid&condition=status=3 and addtime<$addtime&areaid=$cityid&pagesize=1&order=addtime desc&template=list-np", -1);?></li>
<li class="f_r">下一篇：<?php echo tag("moduleid=$moduleid&condition=status=3 and addtime>$addtime&areaid=$cityid&pagesize=1&order=addtime asc&template=list-np", -1);?></li>
</ul>
<div class="c_b"></div>
</div>
<div class="list_title fffbg">
<span class="public_list_title f_l">发布评论</span>
</div>
<div id="comment_div">
<div class="comment_text">
<textarea style="display: none;">
</textarea>
<div>
<span>登录</span>后发表评论
</div>
</div>
<div class="comment_botton">
<ul>
<li class="f_l"><img src="" alt="">Mr.Li</li>
<li class="f_r"><button>发表</button></li>
</ul>
<div class="c_b"></div>
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
<?php if($content) { ?><script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/content.js"></script><?php } ?>
<?php include template('footer');?>