<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tc.list.base.css',DT_SKIN.'gongying.list.css']?>
<?php $footer_js = [DT_PATH.'file/script/jquery.SuperSlide.2.1.1.source.js',DT_PATH.'file/script/sell/gongying.search.js',DT_PATH.'file/script/internalLink.js'];?>
<?php include template('module-header');?>
<!--container-->
<div class="container">
    <!--crumb-->
    <div class="crumb container">
        <a href="<?php echo DT_PATH;?>">天成医疗网首页</a><span>&gt;</span>
        <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['typeid'=>$typeid]);?>"><?php echo $TYPE[$typeid];?>信息</a>
        <?php if($catid) { ?><span>&gt;</span><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['typeid'=>$typeid,'catid'=>$catid]);?>"><?php echo $CATEGORY[$catid];?></a><?php } ?>
    </div>
    <!--crumb end-->
    <!--selector-->
    <div class="selector">
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>行情分类：</span>
            </div>
            <?php $link_cat_title = empty($catid) ? '医疗器械' : $CATEGORY[$catid];?>
            <?php $link_areaid_title = empty($areaid) ? '全国' : $childarea['areaname'];?>
            <?php if($typeid == 0) { ?>
            <?php $link_typeid_title = '供应';?>
            <?php } else if($typeid == 1) { ?>
            <?php $link_typeid_title = '需求';?>
            <?php } else { ?>
            <?php $link_typeid_title = '其他';?>
            <?php } ?>
            <div class="sl-value">
                <ul class="sl-v-list">
                <?php $catid_selector = $selector;?>
                <?php $catid_selector['catid'] = 0;?>
                    <li <?php if(empty($catid)) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($catid_selector);?>" target="_self" title="<?php echo $link_areaid_title;?>医疗器械<?php echo $link_typeid_title;?>">不限</a></li>
                    <?php if(is_array($CAT)) { foreach($CAT as $k => $t) { ?>
                    <?php $catid_selector['catid'] = $t['catid'];?>
                    <li <?php if($catid == $t['catid']) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($catid_selector);?>" title="<?php echo $link_areaid_title;?><?php echo $t['catname'];?><?php echo $link_typeid_title;?>" target="_self"><?php echo $t['catname'];?></a></li>
                    <?php } } ?>
                </ul>
            </div>
        </div>
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
                    <li><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" title="全国<?php echo $link_cat_title;?><?php echo $link_typeid_title;?>">不限</a></li>
                    <?php $areaid_selector['areaid'] = $area_parentid;?>
                    <li class="current"><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" title="<?php echo $link_areaid_title;?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>"><?php echo area_pos($area_parentid);?></a>
                    <?php unset($areaid_selector['areaid']);?>
                    <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" class="clear-option" title="<?php echo $link_areaid_title;?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>">×</a></li>
                </ul>
                <?php $secondarea = tag("table=area&fields=areaid,areaname&condition=parentid=$area_parentid&pagesize=34&template=null&debug=0")?>
                <?php if($secondarea) { ?>
                <ul class="sl-v-list sl-v-sub-list">
                <?php $areaid_selector = $selector;?>
                <?php if(is_array($secondarea)) { foreach($secondarea as $sk => $sv) { ?>
                <?php $areaid_selector['areaid'] = $sv['areaid'];?>
                    <li <?php if($areaid == $sv['areaid']) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" title="<?php echo $sv['areaname'];?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>"><?php echo $sv['areaname'];?></a></li>
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
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" title="<?php echo $link_areaid_title;?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>">不限</a></li>
                    <?php $mainarea = tag("table=area&fields=areaid,areaname&condition=parentid=0&pagesize=34&template=null&debug=0")?>
                    <?php if(is_array($mainarea)) { foreach($mainarea as $k => $t) { ?>
                    <?php $areaid_selector['areaid'] = $t['areaid'];?>
                    <li <?php if($areaid == $t['areaid']) { ?> class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($areaid_selector);?>" title="<?php echo $t['areaname'];?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>"><?php echo $t['areaname'];?></a></li>
                    <?php } } ?>
                </ul>
            </div>
            <a class="sl-value-more" onclick="slValShowMore(this)" href="javascript:;">更多</a>
            <?php } ?>
        </div>
<!--
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>发布时间：</span>
            </div>
            <div class="sl-value">
                <ul class="sl-v-list">
                <?php $day_selector = $selector;?>
                <?php $day_selecotr['day'] = 0;?>
                    <li <?php if(empty($day)) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($day_selector);?>" target="_self">不限</a></li>
                    <li>
                    <?php $day_selector['day'] = 7;?>
                    <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($day_selector);?>" target="_self">最近一周</a>
                    </li>
                    <li>
                    <?php $day_selector['day'] = 3;?>
                    <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($day_selector);?>" target="_self">最近三天</a>
                    </li>
                    <li>
                    <?php $day_selector['day'] = 1;?>
                    <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($day_selector);?>" target="_self">最近一天</a>
                    </li>
                </ul>
            </div>
        </div>
-->
        <div class="sl-wrap">
            <div class="sl-key pull-left">
                <span>精准搜索：</span>
            </div>
            <div class="sl-value">
                <form class="search-frm" action="search.php">
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
    <!--sort-->
    <div class="sort clearfix">
        <div class="sort-item sort-item-down <?php if(empty($order)) { ?>current<?php } ?>
">
        <?php $order_selector = $selector;?>
<?php unset($order_selector['order']);?>
        <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($order_selector);?>" target="_self" title="title="<?php echo $link_areaid_title;?><?php echo $link_cat_title;?><?php echo $link_typeid_title;?>"">发布时间<i class="tc-list-i"></i></a>
        </div>
        <div class="sort-item sort-item-down <?php if(!empty($order)) { ?>current<?php } ?>
">
        <?php $order_selector['order'] = 'totime';?>
        <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($order_selector);?>" target="_self" rel="nofollow">截止时间<i class="tc-list-i"></i></a>
        </div>
        <ul class="sort-tags-list pull-right">
        <?php $validated_selector = $selector;?>
        <?php $validated_selector['validated'] = $validated==1 ? 0 : 1; ?>
            <li <?php if($validated) { ?>class="current"<?php } ?>
><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite($validated_selector);?>"><i class="tc-list-i sort-check"></i>认证推荐厂商</a></li>
        </ul>
    </div>
    <!--sort end-->
    <div class="default-layout gy-layout  mgt-10 mgb-20 clearfix">
    <div class="main pull-left">
    <?php if($lists) { ?>
<div class="card-list clearfix">
       <?php if($typeid == 1) { ?>
        <?php include template('list-xuqiu',$module);?>
        <?php } else { ?>
        <?php include template('list-gong',$module);?>
        <?php } ?>
        </div>
<?php echo pagination($page,$items['c'],$pagesize,$MODULE['5']['linkurl'].'search.php',$selector,'sell_rewrite');?>
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
            <?php $expand = $sell->where($condition)->where($inCondition,'in')->where($gtCondition,'>')->where($neqCondition,'<>')->likeWhere($likeCondition)->limit(0,$epagesize)->select();?>
            
            <?php if($expand) { ?>
                <div class="search-no-result-ft">
                    猜你喜欢
                </div>
                <?php } ?>
            
            <?php if($expand) { ?>
<?php $lists = $expand;?>
            <?php if($typeid == 1) { ?>
        <?php include template('list-xuqiu',$module);?>
        <?php } else { ?>
        <?php include template('list-gong',$module);?>
        <?php } ?>
            <?php } ?>
<?php } ?>
</div>
        
        <div class="side pull-right mgt-20">
            <div class="side-btn">
            <?php if($typeid) { ?>
            <a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=5&typeid=1" class="go-btn">发布我的需求信息</a>
            <?php } else { ?>
                <a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=5&typeid=0" class="go-btn">发布我的供应信息</a>
                <?php } ?>
            </div>
            <ul class="count mgt-10">
            <?php if($typeid == 1) { ?>
            <?php $count_type1 = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>1])->one();?>
            <?php $hits_type1 = $sell->field('sum(hits) as s')->where(['status'=>3,'typeid'=>1])->one();?>
                <li><p>总入库<i><?php echo $count_type1['c'];?></i>条需求信息<br>已被浏览<i><?php echo $hits_type1['s'];?></i>人次</p></li>
                <?php $count_today_type1 = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>1])->where(['addtime'=>$nowtime],'>')->one();?>
                <?php $hits_today_type1 = $sell->field('sum(hits) as s')->where(['status'=>3,'typeid'=>1])->where(['addtime'=>$nowtime],'>')->one();?>
                <li><p>今日新增<i><?php echo $count_today_type1['c'];?></i>条需求信息<br>
                已被浏览<i><?php if(isset($hits_today_type1['s'])){ echo $hits_today_type1['s'];}else{ echo '0';} ?></i>人次</p></li>
                <?php } else { ?>
                <?php $count_type0 = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>0])->one();?>
                <?php $hits_type0 = $sell->field('sum(hits) as s')->where(['status'=>3,'typeid'=>0])->one();?>
                <li><p>总入库<i><?php echo $count_type0['c'];?></i>条供应信息<br>已被浏览<i><?php echo $hits_type0['s'];?></i>人次</p></li>
                <?php $count_today_type0 = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>0])->where(['edittime'=>$nowtime],'>')->one();?>
                <?php $hits_today_type0 = $sell->field('sum(hits) as s')->where(['status'=>3,'typeid'=>0])->where(['edittime'=>$nowtime],'>')->one();?>
                <li><p>今日更新<i><?php echo $count_today_type0['c'];?></i>条供应信息<br>
                已被浏览<i><?php if(isset($hits_today_type0['s'])){ echo $hits_today_type0['s'];}else{ echo '0';} ?></i>人次</p></li>
                <?php } ?>
            </ul>
            <div class="side-box mgt-10">
                <div class="side-box-hd">
                    <?php if($typeid) { ?><span>求购排行版</span><?php } else { ?><span>供应排行版</span><?php } ?>
                </div>
                <div class="side-box-bd rank-list">
                <?php 
                if($typeid){
                $hot = $sell->field('itemid,title,linkurl,catid,areaid')->where(['typeid'=>1,'status'=>3])->limit(0,10)->order('itemid desc')->select();
                }else{
                $hot = $sell->field('itemid,title,linkurl,catid,areaid')->where(['typeid'=>0,'status'=>3])->limit(0,10)->order('hits desc')->select();
                }
                ?>
                <?php if(is_array($hot)) { foreach($hot as $k => $t) { ?>
                    <div class="rank-item clearfix">
                        <div class="num pull-left"><?php echo $k+1;?></div>
                        <div class="info pull-right">
                            <h4 class="text-overflow"><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></h4>
                            <p><span><a href="<?php echo sell_rewrite(['catid'=>$t['catid'],'typeid'=>$typeid]);?>" title="全国<?php echo $CATEGORY[$t['catid']];?><?php if($typeid) { ?>求购<?php } else { ?>需求<?php } ?>
"><?php echo $CATEGORY[$t['catid']];?></a></span><span><a href="<?php echo sell_rewrite(['areaid'=>$t['areaid'],'typeid'=>$typeid]);?>" title="<?php echo $AREA[$t['areaid']]['areaname'];?>医疗器械<?php if($typeid) { ?>求购<?php } else { ?>需求<?php } ?>
"><?php echo $AREA[$t['areaid']]['areaname'];?></a></span></p>
                        </div>
                    </div>
                 <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--container end-->
<!--channel-class-->
<?php echo $iLink;?>
<!--channel-class end -->
<?php include template('footer2017');?>