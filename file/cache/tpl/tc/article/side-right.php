<?php defined('IN_DESTOON') or exit('Access Denied');?><!--post-content-side-->
        <div class="post-content-side pull-right">
            <!--资讯推荐-->
            <div class="post-side-module">
                <div class="post-side-module-hd">资讯推荐</div>
                <div class="post-side-module-bd">
                <?php if(is_array($recommendArticles)) { foreach($recommendArticles as $k => $v) { ?>
                    <a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" class="post-recommend-card clearfix" title="<?php echo $v['title'];?>">
                        <img class="post-recommend-card-img pull-left" src="<?php echo $v['thumb'];?>" alt="<?php echo $v['title'];?>" />
                        <p class="post-recommend-card-txt"><?php echo $v['title'];?></p>
                    </a>
                <?php } } ?>
                </div>
            </div>
            <!--资讯推荐 end-->
            <!--谷歌广告-->
            <div class="post-gg-ad mt30">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- pc_zixun_300x250 -->
                <ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px;" data-ad-client="ca-pub-3506468552102874" data-ad-slot="5633158347"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <!--谷歌广告 end-->
            <!--资讯排行-->
            <div class="post-side-module mt30">
                <div class="post-side-module-hd">资讯排行</div>
                <div class="post-side-module-bd">
                    <ul class="post-rank-list">
                    <?php if(is_array($hitsArticles)) { foreach($hitsArticles as $k => $v) { ?>
                        <li class="post-rank-list-li clearfix">
                            <i class="post-rank-num pull-left"><?php echo $k+1;?></i>
                            <p class="post-rank-txt pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo $v['linkurl'];?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></p>
                        </li>
                    <?php } } ?>
                    </ul>
                </div>
            </div>
            <!--资讯排行 end-->
            <!--京东橱窗广告-->
            <div class="post-jd-ad mt30">
                <script type="text/javascript">
                    var jd_union_unid="1000105161",jd_ad_ids="513:6",jd_union_pid="COeRyam4KxDJyfHcAxoAIIjWgOwCKgA=";
                    var jd_width=300;
                    var jd_height=250;
                    var jd_union_euid="";
                    var p="BBUFVx1eFwcQNwpfBkgyTUMIRmtKRk9aZV8ETVxNNwpfBkgyVHFUWkFDVUliFkcpdmthfgJvG1xERAtZK18QBxIAVh5cFjISBlQaWxQGEgBVK2tKRk9aZVA1FDJNQwhGaxUHGgRRElIXAhUPVB5rFDIiNw%3D%3D";</script>
                <script type="text/javascript" charset="utf-8" src="//u-x.jd.com/static/js/auto.js"></script>
            </div>
            <!--京东橱窗广告 end-->
        </div>
        <!--post-content-side end-->