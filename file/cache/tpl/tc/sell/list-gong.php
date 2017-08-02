<?php defined('IN_DESTOON') or exit('Access Denied');?>
<?php if(is_array($lists)) { foreach($lists as $k => $t) { ?>
    <div class="gy-card">
        <div class="card-img">
            <a href="<?php echo $MODULE['5']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-4-3.png';"></a>
            </div>
        <div class="card-name">
            <h3 class="text-overflow"><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h3>
        </div>
            <div class="card-info clearfix">
                <div class="price pull-left"><em><?php if($price) { ?><?php echo $t['price'];?><?php echo $DT['money_unit'];?>/<?php echo $t['unit'];?><?php } else { ?>价格 面议<?php } ?>
</em><span><?php if($t['amount']) { ?><?php echo $t['amount'];?><?php echo $t['unit'];?>起订<?php } else { ?>暂无起订条件<?php } ?>
</span></div>
                <span class="mark-num pull-right"><?php echo $t['hits'];?>人已关注</span>
            </div>
            <div class="card-ft clearfix">
                <div class="local pull-left"><a href="<?php echo sell_rewrite(['areaid'=>$t['areaid']]);?>" title="<?php echo $AREA[$t['areaid']]['areaname'];?>医疗器械供应"><?php echo $AREA[$t['areaid']]['areaname'];?></a></div>
                <div class="q-a pull-right">
                <?php if($t['validated'] > 0) { ?><i class="p-i v-company" title="通过工商认证"></i><?php } ?>
                    <?php if($t['vip'] > 0) { ?><i class="p-i v-recommend" title="天成推荐"></i><?php } ?>
                    <?php if($t['email']) { ?><i class="p-i v-email" title="留有电子邮箱"></i><?php } ?>
                    <?php if($t['mobile']) { ?><i class="p-i v-tel" title="留有手机号码"></i><?php } ?>
                </div>
            </div>
        </div>
     <?php } } ?>
