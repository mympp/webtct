<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tc.page.header.css',DT_SKIN.'tc.news.detail.css']?>
<?php $footer_js = [DT_PATH.'file/script/article/tc.news.detail.js',DT_PATH.'file/script/internalLink.js']?>
<?php include template('module-header');?>
<!--news-wrap-->
<div class="news-wrap">
    <div class="w1200 box-center">
        <!--crumb-->
        <div class="crumb">
            <a href="<?php echo DT_PATH;?>">天成医疗网首页</a><span>&gt;</span>
            <a href="<?php echo $MODULE['21']['linkurl'];?>">资讯信息</a><span>&gt;</span>
            <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>$catid]);?>"><?php echo $CAT['catname'];?></a><span>&gt;</span>
            <a href="<?php echo $linkurl;?>"><?php echo $title;?></a>
        </div>
        <!--crumb end-->
    </div>
    <div class="post-content clearfix">
        <!--post-content-main-->
        <div class="post-content-main pull-left">
            <h1 class="post-title"><?php echo $title;?></h1>
            <div class="post-info clearfix">
                <p class="pull-left"><i class="n-i n-i-author"></i><em><?php echo $username;?></em></p>
                <p class="pull-left"><i class="n-i n-i-time"></i>发布时间：<em><?php echo date('Y-m-d H:i',$addtime);?></em></p>
                <p class="pull-left"><i class="n-i n-i-source"></i>来源：<em><?php echo $copyfrom;?></em></p>
                <a class="post-type pull-right" href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>$catid]);?>"><?php echo $CAT['catname'];?></a>
                <a href="#postShare" class="post-topshare pull-right"><i class="n-i n-i-share"></i>分享</a>
                <p class="pull-right"><i class="n-i n-i-view"></i><?php echo $hits;?></p>
            </div>
            <div class="post-body clearfix">
                <div class="post-body-main pull-right">
                    <!--导读-->
                    <blockquote class="post-lead"><?php echo $introduce;?></blockquote>
                    <!--导读 end-->
                    <!--正文-->
                    <div class="post-text">
                            <?php echo $content;?>
                    </div>
                    <!--正文 end-->
                    <!--分享-->
                    <div class="post-share" id="postShare">
                        <div class="post-share-title"><span>分享给身边的朋友</span></div>
                        <div class="bdsharebuttonbox">
                            <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a>
                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">微博</a>
                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a>
                            <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ好友</a>
                            <a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网">豆瓣网</a>
                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a>
                        </div>
                    </div>
                    <!--分享 end-->
                    <!--上下篇-->
                    <ul class="post-prev-next clearfix">
                        <li class="post-prev pull-left">
                        <?php if(!empty($font_article)) { ?>
                            <a class="ami" href="<?php echo $MODULE['21']['linkurl'];?><?php echo $font_article['linkurl'];?>" title="<?php echo $font_article['title'];?>"><?php echo $font_article['title'];?></a>
                        <?php } else { ?>
                        暂无
                        <?php } ?>
                        </li>
                        <li class="post-next pull-left">
                        <?php if(!empty($next_article)) { ?>
                            <a class="ami" href="<?php echo $MODULE['21']['linkurl'];?><?php echo $next_article['linkurl'];?>" title="<?php echo $next_article['title'];?>"><?php echo $next_article['title'];?></a>
                        <?php } else { ?>
                        暂无
                        <?php } ?>
                        </li>
                    </ul>
                    <!--上下篇 end-->
                    <!--评论-->
                    <div class="post-comment mt30" id="SOHUCS" sid="<?php echo $itemid;?>"></div>
                    <script charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/changyan.js" ></script>
                    <script type="text/javascript">
                        window.changyan.api.config({
                            appid: 'cysX5wRYI',
                            conf: 'prod_5c734ecb243c7af56b81ad10f66b3139'
                        });
                    </script>
                    <!--评论 end-->
                </div>
                <!--相关文章-->
                <div class="post-relate pull-left">
                    <div id="hm_t_117193"></div>
                    <!-- <script type="text/javascript" id="wumiiRelatedItems"></script>
                    <script type="text/javascript">
                        var wumiiPermaLink = "<?php echo $linkurl;?>"; //请用代码生成文章永久的链接
                        var wumiiTitle = "<?php echo $title;?>"; //请用代码生成文章标题
                        var wumiiTags = "<?php echo $keyword;?>"; //请用代码生成文章标签，以英文逗号分隔，如："标签1,标签2"
                        var wumiiCategories = ["<?php echo $CAT['catname'];?>"]; //请用代码生成文章分类，分类名放在 JSONArray 中，如: ["分类1", "分类2"]
                        var wumiiSitePrefix = "<?php echo $MODULE['21']['linkurl'];?>";
                        var wumiiParams = "&num=7&mode=1&pf=JAVASCRIPT";
                    </script>
                    <script type="text/javascript" src="http://widget.wumii.cn/ext/relatedItemsWidget"></script> -->
                </div>
                <!--相关文章 end-->
            </div>
        </div>
        <!--post-content-main end-->
        <?php include template('side-right',$module);?>
    </div>
</div>
<!--news-wrap end-->
<?php echo $iLink;?>
<?php include template('footer2017');?>