<?php defined('IN_DESTOON') or exit('Access Denied');?>﻿<?php $head_css = [DT_SKIN.'tc.list.base.css',DT_SKIN.'tc.chanpin.base.css',DT_SKIN.'tc.chanpin.list.css']?>
<?php $footer_js = [DT_PATH.'file/script/jquery.SuperSlide.2.1.1.source.js',DT_PATH.'file/script/mall/tc.chanpin.list.js'];?>
<?php
$areaname = area_pos($areaid,'');
$ztitle = "【".$keyword['word']."】".$areaname.$keyword['word']."医疗器械大全-医疗器械产品库-天成医疗器械网";
$zkeywords = $areaname.$keyword['word'].'，'.$areaname.$keyword['word'].'医疗器械价格，'.$areaname.$keyword['word'].'产品';
$zdescription = '天成医疗器械网为你找到'.$items['c'].'件'.$areaname.$keyword['word'].'产品。包含'.$areaname.$keyword['word'].'简介，'.$areaname.$keyword['word'].'参数，报价，供应批发等信息。天成医疗器械网产品库，提供'.$areaname.'各类医疗器械设备产品。'
?>
<?php include template('module-header');?>
<!--container-->
<div class="container">
    <!--crumb-->
    <div class="crumb ">
        <a href="<?php echo DT_PATH;?>">天成医疗网首页</a><span>&gt;</span>
        <a href="<?php echo $MODULE['16']['linkurl'];?>">产品库</a>
    </div>
    <!--crumb end-->
    
    <!--cp-keyword-layout-->
    <div class="cp-keyword-layout clearfix">
        <!--main-->
        <div class="main pull-left">
            <!--keyword-wrap-->
            <div class="keyword-wrap">
                <h2 class="keyword-val"><?php echo $keyword['word'];?></h2>
                <?php if($kcontent) { ?>
                <p class="keyword-intro">
                    <?php echo $kcontent['content'];?>
                </p>
                <?php } ?>
                <div class="keyword-area">
                    <div class="keyword-area-hd">按地区找关键词</div>
                    <ul class="keyword-area-bd">
                    <li <?php if(empty($areaid)) { ?>class="current"<?php } ?>
><a href="<?php echo keyword_rewrite(['kwid'=>$kwid]);?>" >全国</a></li>
                    <?php $mainarea = tag("table=area&fields=areaid,areaname&condition=parentid=0&pagesize=34&template=null&debug=0")?>
                    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $t) { ?>
                    <?php $area_selector = $selector;?>
                    <?php $area_selector['areaid'] = $t['areaid'];?>
                        <li <?php if($areaid == $t['areaid']) { ?>class="current"<?php } ?>
><a href="<?php echo keyword_rewrite($area_selector);?>" title="<?php echo $t['areaname'];?><?php echo $keyowrd['word'];?>"><?php echo $t['areaname'];?></a></li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <!--keyword-wrap end-->
<?php if($malls) { ?>
            <form method="post" id="mallForm" target="_blank" action="<?php echo $MODULE['16']['linkurl'];?>compare.php">
            <?php if(is_array($malls)) { foreach($malls as $k => $t) { ?>
                <div class="cp-card cp-kw-card clearfix">
                    <div class="cp-img pull-left">
                        <a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"></a>
                    </div>
                    <div class="cp-txt pull-left">
                        <h3 class="text-overflow"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h3>
                        <ul class="cp-param clearfix">
                            <li><span class="cp-param-key">产品品牌：</span><em class="cp-param-val"><?php echo $t['brand'];?></em></li>
                            <li><span class="cp-param-key">产品型号：</span><em class="cp-param-val"><?php echo $t['model'];?></em></li>
                            <li><span class="cp-param-key">产品分类：</span><em class="cp-param-val"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo mall_cat_rewrite(['catid'=>$t['catid']]);?>" title="<?php echo $CATEGORY[$t['catid']];?>医疗器械"><?php echo $CATEGORY[$t['catid']];?></a></em></li>
                            <li><span class="cp-param-key">生产厂商：</span><em class="cp-param-val"><?php echo $t['company'];?></em></li>
                            <li><span class="cp-param-key">所在地区：</span><em class="cp-param-val"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo mall_rewrite(['areaid'=>$t['areaid']]);?>" title="<?php echo area_pos($t['areaid'],'');?>医疗器械"><?php echo area_pos($t['areaid'],'/');?></a></em></li>
                            <li><span class="cp-param-key">相关科室：</span>
                            <em class="cp-param-val">
                            <?php if($t['kcatids']) { ?>
                            <?php $kcatid = explode(',',$t['kcatids']);?>
                            <?php if(is_array($kcatid)) { foreach($kcatid as $kt) { ?>
                            <i><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo keshi_rewrite(['kcatid'=>$t]);?>" title="<?php echo $KESHI[$kt];?>医疗器械"><?php echo $KESHI[$kt];?></a></i>
                            <?php } } ?>
                            <?php } ?>
                            </em>
                            </li>
                            <li><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" class="more">更多参数>></a></li>
                        </ul>
                    </div>
                    <div class="cp-btn pull-right">
                        <label class="compare-btn" for="check_<?php echo $t['itemid'];?>"><input type="checkbox" id="check_<?php echo $t['itemid'];?>" name="itemid[]" value="<?php echo $t['itemid'];?>">对比</label>
                        <a class="cheaper-btn" href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank">查看详细</a>
                    </div>
                </div>
                <?php } } ?>
            </form>
            <!--分页-->
            <?php echo pagination($page,$items['c'],$pagesize,$MODULE['16']['linkurl'].$action.'.php',$selector,'keyword_rewrite');?>
            <!--分页 end-->
            <?php } else { ?>
            <?php include template('empty-result','chip');?>
            <?php } ?>
        </div>
        <!--main end-->
        <?php include template('search-side',$module);?>
    </div>
    <!--cp-keyword-layout end-->
</div>
<!--container end-->
<!--对比框-->
<div class="compare-box" style="display: none;">
    <div class="compare-box-hd">
        <span>[<em></em>/4]对比框</span>
        <button class="compare-box-close" type="button" onclick="$(this).parent().parent('.compare-box').hide();">×</button>
    </div>
    <div class="compare-box-bd">
        <ul></ul>
    </div>
    <div class="compare-box-ft">
        <button type="button" class="compare-box-btn">开始对比</button>
    </div>
</div>
<!--对比框 end-->
<?php include template('footer2017');?>