<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tc.list.base.css',DT_SKIN.'tc.chanpin.base.css',DT_SKIN.'tc.chanpin.list.css']?>
<?php $footer_js = [DT_PATH.'file/script/jquery.SuperSlide.2.1.1.source.js',DT_PATH.'file/script/mall/tc.chanpin.list.js',DT_PATH.'file/script/internalLink.js'];?>
<?php $link_area_title = !empty($areaid) ? $childarea['areaname'] : '全国';?>
<?php 
if(!empty($catid)){
$link_cat_title = !empty($catid) ? $CATEGORY[$catid] : '医疗器械';
}elseif(!empty($kcatid)){
$link_cat_title = !empty($kcatid) ? $KESHI[$kcatid].'医疗器械' : '医疗器械';
}else{
$link_cat_title = '医疗器械';
} 
$areaname = area_pos($areaid,'-');
if($action == 'keshi'){
$ztitle_keshi = empty($kcatid) ? '科室' : $KESHI[$kcatid];
$ztitle_stype = empty($stype) ? '产品' : $stypes['stype'];
$ztitle = $areaname.$ztitle_keshi.'医疗器械'.$ztitle_stype.'，科室医疗器械大全-医疗器械产品库-天成医疗器械网';
$zkeywords = $areaname.$ztitle_keshi.$stypes[$stype]."，".$ztitle_keshi.$stypes[$stype]."价格,".$ztitle_keshi."医疗器械产品";
$zdescription = $ztitle_keshi.'医疗器械产品，就上天成医疗器械网，为你找到'.$items['c'].'件'.$ztitle_keshi.'医疗器械产品。天成医疗器械网产品库，提供各个科室的医疗器械设备产品报价，图片，批发采购等信息。';
}
if($action == 'search'){
if(!empty($selector)) $ztitle = "$areaname".$CATEGORY[$catid].$stypes[$stype]."-医疗器械产品库-天成医疗器械网";
if(!empty($selector)) $zkeywords = $areaname.$CATEGORY[$catid].$stypes[$stype].",".$CATEGORY[$catid].$stypes[$stype]."价格,".$CATEGORY[$catid]."产品";
if(!empty($selector)) $zdescription = $areaname.$CATEGORY[$catid].$stypes[$stype]."产品,上天成医疗器械网,为您找到".$items[c]."件".$areaname.$CATEGORY[$catid].$stypes[$stype]."的产品参数，报价，供应批发等信息。天成医疗器械网产品库，提供".$areaname."各类医疗器械产品信息。";
}
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
    <!--selector-->
<?php $link_stype_title = !empty($stype) ? $stypes[$stype] : '';?>
    <div class="selector">
    <?php if($action == 'search') { ?>
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>医疗器械分类：</span>
            </div>
            <div class="sl-value">
                <ul class="sl-v-list sl-v-list-row2 sl-v-list-qixie">
                <?php $cat_selector = $selector;?>
                <?php if(!empty($catid)) unset($cat_selector['catid']); ?>
                    <li <?php if(empty($catid)) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo mall_cat_rewrite($cat_selector);?>" target="_self" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>">不限</a></li>
                    <?php if(is_array($first_cat)) { foreach($first_cat as $k => $t) { ?>
                    <?php $cat_selector['catid'] = $t['catid'];?>
                    <li <?php if($catid == $t['catid']) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo mall_cat_rewrite($cat_selector);?>" target="_self" title="<?php echo $link_area_title;?><?php echo $t['catname'];?><?php echo $link_stype_title;?>"><?php echo $t['catname'];?></a></li>
                    <?php } } ?>
                </ul>
                <?php if(!empty($second_cat)) { ?>
                <ul class="sl-v-list sl-v-sub-list">
                <?php if(is_array($second_cat)) { foreach($second_cat as $k => $t) { ?>
                <?php $cat_selector['catid'] = $t['catid'];?>
                    <li <?php if($catid == $t['catid']) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo mall_cat_rewrite($cat_selector);?>" target="_self" title="<?php echo $link_area_title;?><?php echo $t['catname'];?><?php echo $link_stype_title;?>"><?php echo $t['catname'];?></a></li>
                    <?php } } ?>
                </ul>
                <?php } ?>
                <a class="sl-value-more" onclick="slValShowMore(this)" href="javascript:;">更多</a>
            </div>
        </div>
        <?php } ?>
<?php if($action == 'keshi') { ?>
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>医院科室分类：</span>
            </div>
            <div class="sl-value">
                <ul class="sl-v-list sl-v-list-row2 sl-v-list-keshi">
                <?php $kcatid_selector = $selector;?>
                <?php unset($kcatid_selector['kcatid']);?>
                    <li <?php if(empty($kcatid)) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo keshi_rewrite($kcatid_selector);?>" target="_self" title="<?php echo $link_area_title;?><?php echo $link_stype_title;?>">不限</a></li>
                    <?php if(is_array($first_keshi)) { foreach($first_keshi as $k => $t) { ?>
                    <?php $kcatid_selector['kcatid'] = $k;?>
                    <li <?php if($kcatid == $k) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo keshi_rewrite($kcatid_selector);?>" title="<?php echo $link_area_title;?><?php echo $t;?><?php echo $link_stype_title;?>"><?php echo $t;?></a></li>
                    <?php } } ?>
                </ul>
                <a class="sl-value-more" onclick="slValShowMore(this)" href="javascript:;">更多</a>
            </div>
        </div>
<?php } ?>
         <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>所在地区：</span>
            </div>
            <?php if($areaid) { ?>
            <div class="sl-value">
                <ul class="sl-v-list">
                <?php $areaid_selector = $selector;?>
                <?php $area_parentid = $childarea['parentid'] == 0 ? $areaid : $childarea['parentid'];?>
                <?php unset($areaid_selector['areaid']);?>
                    <li><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" title="全国<?php echo $link_cat_title;?><?php echo $link_stype_title;?>">不限</a></li>
                    <?php $areaid_selector['areaid'] = $area_parentid;?>
                    <li class="current"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>"><?php echo area_pos($area_parentid);?></a>
                    <?php unset($areaid_selector['areaid']);?>
                    <a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" class="clear-option" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>">×</a></li>
                </ul>
                <?php $secondarea = tag("table=area&fields=areaid,areaname&condition=parentid=$area_parentid&pagesize=34&template=null&debug=0")?>
                <?php if($secondarea) { ?>
                <ul class="sl-v-list sl-v-sub-list">
                <?php $areaid_selector = $selector;?>
                <?php if(is_array($secondarea)) { foreach($secondarea as $sk => $sv) { ?>
                <?php $areaid_selector['areaid'] = $sv['areaid'];?>
                    <li <?php if($areaid == $sv['areaid']) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" title="<?php echo $sv['areaname'];?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>"><?php echo $sv['areaname'];?></a></li>
                    <?php } } ?>
                </ul>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="sl-value">
                <ul class="sl-v-list">
                <?php $areaid_selector = $selector;?>
                <?php if(isset($areaid_selector['areaid'])) unset($areaid_selector['areaid']); ?>
                    <li <?php if($areaid == 0) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>">不限</a></li>
                    <?php $mainarea = tag("table=area&fields=areaid,areaname&condition=parentid=0&pagesize=34&template=null&debug=0")?>
                    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $t) { ?>
                    <?php $areaid_selector['areaid'] = $t['areaid'];?>
                    <li <?php if($areaid == $t['areaid']) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($areaid_selector);?>" title="<?php echo $t['areaname'];?><?php echo $link_cat_title;?><?php echo $link_stype_title;?>"><?php echo $t['areaname'];?></a></li>
                    <?php } } ?>
                </ul>
            </div>
            <a class="sl-value-more" onclick="slValShowMore(this)" href="javascript:;">更多</a>
            <?php } ?>
        </div>
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>属性分类：</span>
            </div>
            <div class="sl-value">
                <ul class="sl-v-list">
                <?php $stype_selector = $selector;?>
                <?php unset($stype_selector['stype'])?>
                    <li  <?php if(empty($stype)) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($stype_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?>" target="_self">不限</a></li>
                    <?php $stype_selector['stype'] = 1;?>
                    <li <?php if($stype == 1) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($stype_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?>整机" target="_self">整机</a></li>
                    <?php $stype_selector['stype'] = 2;?>
                    <li <?php if($stype == 2) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($stype_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?>配件" target="_self">配件</a></li>
                    <?php $stype_selector['stype'] = 3;?>
                    <li <?php if($stype == 3) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite($stype_selector);?>" title="<?php echo $link_area_title;?><?php echo $link_cat_title;?>耗材" target="_self">耗材</a></li>
                </ul>
            </div>
        </div>
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>精准搜索：</span>
            </div>
            <div class="sl-value">
                <form class="search-frm" action="<?php echo $MODULE['16']['linkurl'];?><?php echo $action;?>.php">
                <?php if(is_array($selector)) { foreach($selector as $k => $t) { ?>
                <input type="hidden" name="<?php echo $k;?>" value="<?php echo $t;?>" />
                <?php } } ?>
                    <input type="text" class="s-frm-input" name="kw" value="<?php echo $kw;?>">
                    <input type="submit" class="s-frm-submit tc-list-i" value="搜索">
                </form>
            </div>
        </div>
    </div>
    <!--selector end-->
    <!--sort-tags-->
    <div class="sort-tags clearfix">
        <div class="sort-item sort-item-down current pull-left"><a href="javascript:;" target="_self">发布时间<i class="tc-list-i"></i></a></div>
        <ul class="sort-tags-list clearfix pull-right">
        <?php $vip_selector = $selector;?>
        <?php $vip_selector['validated'] = empty($validated) ? 1 : 0 ;?>
            <li><a href="<?php echo link_rewrite($vip_selector);?>"><i class="tc-list-i sort-check"></i>认证推荐厂商</a></li>
        </ul>
    </div>
    <!--sort-tags end-->
    <!--cp-list-layout-->
    <div class="cp-list-layout clearfix">
        <!--main-->
        <div class="main pull-left">
        <?php if($malls) { ?>
            <form method="post" id="mallForm" class="clearfix" target="_blank" action="<?php echo $MODULE['16']['linkurl'];?>compare.php">
            <?php if(is_array($malls)) { foreach($malls as $k => $t) { ?>
                <div class="cp-card cp-img-card">
                    <div class="cp-img"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-4-3.png';"></a></div>
                    <div class="cp-txt">
                        <h3 class="text-overflow"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h3>
                        <p class="cp-cmp text-overflow"><a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank"><?php echo $t['company'];?></a></p>
                        <p class="cp-area"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite(['areaid'=>$t['areaid']]);?>" title="<?php echo area_pos($t['areaid'],'');?>医疗器械"><?php echo area_pos($t['areaid'],'/');?></a></p>
                    </div>
                    <div class="cp-btn">
                        <label class="compare-btn" for="check_<?php echo $t['itemid'];?>"><input type="checkbox" id="check_<?php echo $t['itemid'];?>" name="itemid[]" value="<?php echo $t['itemid'];?>">对比</label>
                        <a class="cheaper-btn" href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank">详细</a>
                    </div>
                </div>
                <?php } } ?>
            </form>
            <?php echo pagination($page,$items['c'],$pagesize,$MODULE['16']['linkurl'].$action.'.php',$selector,$pagination_func,$MODULE['16']['linkurl']);?>
        <?php } else { ?>
        <?php include template('empty-result','chip');?>
        <?php $parentid = $area->field('arrchildid')->where(['areaid'=>$childarea['parentid']])->one();?>
           <?php if(!empty($parentid)){
           $inCondition['areaid'] = $parentid['arrchildid'];
           }else{
           $inCondition = [];
           }
           $epagesize = $typeid == 1 ? 4 : 8;
           ?>
            <?php $expand = $mall_db->where($condition)->where($inCondition,'in')->where($gtCondition,'>')->where($neqCondition,'<>')->likeWhere($likeCondition)->limit(0,$epagesize)->select();?>
            
            <?php if($expand) { ?>
                <div class="search-no-result-ft">
                    猜你喜欢
                </div>
                <?php } ?>
            
            <?php if($expand) { ?>
            <?php if(is_array($expand)) { foreach($expand as $k => $t) { ?>
                <div class="cp-card cp-img-card">
                    <div class="cp-img"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-4-3.png';"></a></div>
                    <div class="cp-txt">
                        <h3 class="text-overflow"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h3>
                        <p class="cp-cmp text-overflow"><a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank"><?php echo $t['company'];?></a></p>
                        <p class="cp-area"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo link_rewrite(['areaid'=>$t['areaid']]);?>" title="<?php echo area_pos($t['areaid'],'');?>医疗器械"><?php echo area_pos($t['areaid'],'/');?></a></p>
                    </div>
                </div>
                <?php } } ?>
            <?php } ?>
        <?php } ?>
        </div>
        <!--main end-->
        <?php include template('search-side',$module);?>
    </div>
    <!--cp-list-layout end-->
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
<?php echo $iLink;?>
<?php include template('footer2017');?>