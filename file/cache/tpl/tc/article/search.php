<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tc.page.header.css',DT_SKIN.'tc.list.base.css',DT_SKIN.'tc.news.list.css']?>
<?php $footer_js = [DT_PATH.'file/script/article/tc.news.list.js',DT_PATH.'file/script/internalLink.js']?>
<?php include template('module-header');?>
<!--news-wrap-->
<div class="news-wrap">
    <div class="post-content clearfix">
        <!--post-content-main-->
        <div class="post-content-main pull-left">
            <div class="post-col-name clearfix">
                <h2 class="pull-left"><?php echo $catname;?></h2>
                <div class="post-show-switch pull-right">
                    <a href="javascript:;" id="listSwitch" class="current"><i class="n-i pull-left"></i><span class="pull-left">列表</span></a>
                    <a href="javascript:;" id="cardSwitch"><i class="n-i pull-left"></i><span class="pull-left">卡片</span></a>
                </div>
            </div>
            <ul class="post-card-list clearfix">
            <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
                <li class="post-card clearfix">
                    <div class="post-card-img pull-left">
                        <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank"><img onerror="this.src='<?php echo DT_SKIN;?>image/nopic.gif'" src="<?php echo $v['thumb'];?>"></a>
                    </div>
                    <div class="post-card-txt pull-right">
                        <h3 class="post-card-title text-overflow"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" class="em"><?php echo $v['title'];?></a></h3>
                        <div class="post-card-desc">
                            <?php echo $v['introduce'];?>
                        </div>
                        <div class="post-card-info clearfix">
                            <span class="post-card-date pull-left"><i class="n-i n-i-time"></i><?php echo date('Y-m-d',$v['addtime']);?></span>
                            <span class="post-card-source pull-left"><i class="n-i n-i-source"></i><?php echo $v['copyfrom'];?></span>
                            <span class="post-card-view pull-right"><i class="n-i n-i-view"></i><?php echo $v['hits'];?></span>
                        </div>
                    </div>
                </li>
           <?php } } ?>
            </ul>
             <?php echo pagination($page,$items['c'],$pagesize,$MODULE['21']['linkurl'].'search.php',$selector,'article_rewrite',$MODULE['21']['linkurl']);?>
        </div>
        <!--post-content-main end-->
        <?php include template('side-right',$module);?>
    </div>
</div>
<!--news-wrap end-->
<?php echo $iLink;?>
<?php include template('footer2017');?>