<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tc.page.header.css',DT_SKIN.'tc.news.index.css'];?>
<?php $footer_js = [DT_PATH.'file/script/jquery.SuperSlide.2.1.1.source.js',DT_PATH.'file/script/article/article.index.js']?>
<?php include template('module-header');?>
<!--news-wrap-->
<div class="news-wrap">
    <!-- container -->
    <div class="container">
        <!-- 头条新闻 -->
        <div class="headnews clearfix">
<div class="headnews-slide pull-left">
                <div class="bd pull-left">
                    <ul>
                    <?php if(is_array($top_news)) { foreach($top_news as $k => $v) { ?>
                    <?php if($k > 9) break; ?>
                        <li>
                            <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank"><img src="<?php echo $v['thumb'];?>" title="<?php echo $v['title'];?>" /></a>
                            <p class="text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a></p>
                        </li>
                    <?php } } ?>
                    </ul>
                </div>
                <div class="hd  pull-right">
                    <ul>
                    <?php if(is_array($top_news)) { foreach($top_news as $k => $v) { ?>
                    <?php if($k > 9) break; ?>
                    <li><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>"><img src="<?php echo $v['thumb'];?>" alt="<?php echo $v['title'];?>"></a></li>
                        <?php unset($top_news[$k])?>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <div class="headnews-list pull-left">
                <div class="headnews-top">
                    <h2 class="headnews-top-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $top_news['0']['linkurl'];?>" title="<?php echo $top_news['0']['title'];?>"><?php echo $top_news['0']['title'];?></a></h2>
                    <div class="headnews-top-desc">
                        <?php echo $top_news['0']['introduce'];?>
                        <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $top_news['0']['linkurl'];?>" target="_blank" title="<?php echo $top_news['0']['title'];?>">[详细]</a>
                    </div>
                </div>
                <div class="headnews-top">
                    <h2 class="headnews-top-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $top_news['1']['linkurl'];?>" title="<?php echo $top_news['1']['title'];?>"><?php echo $top_news['1']['title'];?></a></h2>
                    <div class="headnews-top-desc">
                        <?php echo $top_news['1']['introduce'];?>
                        <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $top_news['1']['linkurl'];?>" target="_blank" title="<?php echo $top_news['1']['title'];?>">[详细]</a>
                    </div>
                </div>
<?php unset($top_news['0']);?>
<?php unset($top_news['1']);?>
                <ul class="headnews-txt-list clearfix">
                <?php if(is_array($top_news)) { foreach($top_news as $k => $v) { ?>
                <?php if($k > 5) break; ?>
                    <li class="clearfix">
                        <p class="headnews-txt-list-title pull-left text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                    </li>
                    <?php unset($top_news[$k]);?>
                <?php } } ?>
                </ul>
            </div>
            
            <div class="headnews-wechat pull-right">
                <a href="#" target="_blank" class="hd headnews-wechat__hd">
                    <p class="headnews-wechat__hd__text">全网精彩内容</p>
                    <p class="headnews-wechat__hd__subText">network wonderful article</p>
                </a>
                <div class="bd headnews-wechat__bd">
                    <ul>
                        <li><a href="#" target="_blank">这回，橘子洲头真是“浪遏飞舟”了！连日暴雨，这份安全避险攻略你一定要看！</a></li>
                        <li><a href="#" target="_blank">刘震云北大演讲：远见于我们如大旱之望云霓，如雾霾之望大风</a></li>
                        <li><a href="#" target="_blank">小时候，香港是个熟悉的陌生人</a></li>
                        <li><a href="#" target="_blank">天成医疗被评选为广州市首批优秀民营企业宣传名单</a></li>
                        <li><a href="#" target="_blank">纳和祥藏秘理疗馆进入沿海地区的第一站！浙江温州</a></li>
                        <li><a href="#" target="_blank">鉴定出蛋白Nlrp9b抵抗轮状病毒感染机制</a></li>
                        <li><a href="#" target="_blank">这回，橘子洲头真是“浪遏飞舟”了！连日暴雨，这份安全避险攻略你一定要看！</a></li>
                        <li><a href="#" target="_blank">刘震云北大演讲：远见于我们如大旱之望云霓，如雾霾之望大风</a></li>
                        <li><a href="#" target="_blank">小时候，香港是个熟悉的陌生人</a></li>
                        <li><a href="#" target="_blank">天成医疗被评选为广州市首批优秀民营企业宣传名单</a></li>
                        <li><a href="#" target="_blank">纳和祥藏秘理疗馆进入沿海地区的第一站！浙江温州</a></li>
                        <li><a href="#" target="_blank">鉴定出蛋白Nlrp9b抵抗轮状病毒感染机制</a></li>
                        <li><a href="#" target="_blank">小时候，香港是个熟悉的陌生人</a></li>
                        <li><a href="#" target="_blank">天成医疗被评选为广州市首批优秀民营企业宣传名单</a></li>
                        <li><a href="#" target="_blank">纳和祥藏秘理疗馆进入沿海地区的第一站！浙江温州</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 头条新闻 end-->
<?php $index_floor_cat = [839 => '资讯新闻',840 => '政策法规',844 =>'展会信息',842=>'医院动向',841=>'技术发展',843=>'金融政策'];?>
<?php if(is_array($index_floor_cat)) { foreach($index_floor_cat as $floor_catid => $floor_catname) { ?>
<?php $cat_linkurl = $MODULE['21']['linkurl'].article_rewrite(['catid'=>$floor_catid]);?>
        <!-- <?php echo $floor_catname;?> -->
        <div class="column">
            <div class="column-head clearfix">
                <h2 class="column-name pull-left">
                    <i class="n-i n-i-c1"></i>
                    <a href="<?php echo $cat_linkurl;?>" target="_blank" title="<?php echo $floor_catname;?>"><?php echo $floor_catname;?></a>
                </h2>
                <b class="column-en-name pull-left">news</b>
                <a class="column-head-more pull-right" href="<?php echo $cat_linkurl;?>" target="_blank" title="<?php echo $floor_catname;?>">更多</a>
            </div>
            <?php $new_articles = getNewArticle($floor_catid);?>
            <div class="column-body clearfix">
                <div class="column-main  pull-left">
                    <div class="column-news-list pull-left">
                    <?php if(is_array($new_articles)) { foreach($new_articles as $k => $v) { ?>
                    <?php if($k > 1) break; ?>
                        <div class="column-top-news">
                            <h3 class="column-top-news-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></h3>
                            <div class="column-top-news-desc"><?php echo $v['introduce'];?></div>
                        </div>
                      <?php unset($new_articles[$k]);?>
                        <?php } } ?>
                        
                        <ul class="column-txt-list">
                        <?php if(is_array($new_articles)) { foreach($new_articles as $k => $v) { ?>
                        <?php if($k > 6) break; ?>
                            <li class="clearfix">
                                <p class="column-txt-list-title text-overflow pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                                <span class="column-txt-list-date pull-right"><?php echo date('Y-m-d',$v['addtime']);?></span>
                            </li>
                            <?php unset($new_articles[$k]);?>
                        <?php } } ?>
                        </ul>
                    </div>
                    <div class="column-gallery pull-right">
                    <?php if(is_array($new_articles)) { foreach($new_articles as $k => $v) { ?>
                        <a class="column-gallery-item" href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>">
                            <span class="column-gallery-img"><img src="<?php echo $v['thumb'];?>" alt="<?php echo $v['title'];?>"></span>
                            <p class="column-gallery-txt"><?php echo $v['title'];?></p>
                        </a>
                    <?php } } ?>
                    </div>
                    
                </div>
                <div class="column-side column-rank pull-right">
                    <div class="column-rank-head clearfix">
                        <h3 class="pull-left">排行</h3>
                        <ul class="column-rank-tab pull-right">
                            <li>一周</li>
                            <li>全部</li>
                        </ul>
                    </div>
                    <div class="column-rank-body">
                        <ul>
                        <?php $hit_articles = getTopHitsArticle($floor_catid,7);?>
                        <?php if(is_array($hit_articles)) { foreach($hit_articles as $k => $v) { ?>
                            <li class="column-rank-item">
                                <i class="column-rank-num"><?php echo $k+1;?></i>
                                <p class="column-rank-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                            </li>
                        <?php } } ?>
                        </ul>
                        <ul>
                        <?php $hit_articles = getTopHitsArticle($floor_catid,30);?>
                        <?php if(is_array($hit_articles)) { foreach($hit_articles as $k => $v) { ?>
                            <li class="column-rank-item">
                                <i class="column-rank-num"><?php echo $k+1;?></i>
                                <p class="column-rank-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                            </li>
                        <?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- <?php echo $floor_catname;?> end-->
<?php } } ?>
<?php $index_bottom_cat = [2371=>'天成动态',2165=>'职场信息',2017=>'其他类别',2335=>'科技前沿',2331=>'项目申报',2332=>'注册标准'];?>
<?php $bottom_count = 1;?>
<div class="column-3 clearfix">
<?php if(is_array($index_bottom_cat)) { foreach($index_bottom_cat as $bottom_catid => $bottom_catname) { ?>
<?php if($bottom_count == 4) { ?>
</div>
<div class="column-3 clearfix">
<?php } ?>
<!-- <?php echo $bottom_catname;?> -->
<?php $cat_linkurl = $MODULE['21']['linkurl'].article_rewrite(['catid'=>$bottom_catid]);?>
            <div class="column pull-left">
                <div class="column-head clearfix">
                    <h2 class="column-name pull-left">
                        <i class="n-i n-i-c7"></i>
                        <a href="<?php echo $cat_linkurl;?>" target="_blank" title="<?php echo $bottom_catname;?>"><?php echo $bottom_catname;?></a>
                    </h2>
                    <a class="column-head-more pull-right" href="<?php echo $cat_linkurl;?>" target="_blank">更多</a>
                </div>
                <div class="column-body clearfix">
                <?php $new_articles = getNewArticle($bottom_catid,6);?>
                    <div class="column-gallery">
                        <a class="column-gallery-item" href="<?php echo $MODULE['21']['linkurl'];?><?php echo $new_articles['0']['linkurl'];?>" target="_blank" title="<?php echo $new_articles['0']['title'];?>">
                            <span class="column-gallery-img"><img src="<?php echo $new_articles['0']['thumb'];?>" alt="<?php echo $new_articles['0']['title'];?>"></span>
                            <p class="column-gallery-txt"><?php echo $new_articles['0']['title'];?></p>
                        </a>
                    </div>
                    <?php unset($new_articles['0'])?>
                    <ul class="column-txt-list">
                    <?php if(is_array($new_articles)) { foreach($new_articles as $k => $v) { ?>
                        <li class="clearfix">
                            <p class="column-txt-list-title text-overflow pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                        </li>
                    <?php } } ?>
                    </ul>
                </div>
            </div>
    <!-- <?php echo $bottom_catname;?> end-->
<?php $bottom_count++;?>
<?php } } ?>
</div>
    </div>
    <!-- container end-->
</div>
<!--news-wrap end-->
<!--友情链接-->
<div class="layout links-layout">
    <div class="links-hd">友情链接：</div>
    <div class="links-bd">
        <?php if(is_array($links)) { foreach($links as $k => $t) { ?>
        <a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['title'];?>" target="_blank"><?php echo $t['title'];?></a>
        <?php } } ?>
        <a href="<?php echo DT_PATH;?>link/index-htm-action-reg.html" class="apply-to" rel="nofollow">申请加入&gt;&gt;</a>
    </div>
</div>
<!--友情链接 end-->
<?php include template('footer2017');?>