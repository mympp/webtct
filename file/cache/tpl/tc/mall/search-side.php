<?php defined('IN_DESTOON') or exit('Access Denied');?><!--side-->
        <div class="side slide-show pull-right">
            <!--推荐产品-->
            <div class="module">
                <div class="module-hd">
                    <span>推荐产品</span>
                    <a href="javascript:;" class="next refresh pull-right cp-i" title="换一批"></a>
                    <ul class="hidden"></ul>
                </div>
                <div class="module-bd vertical-show clearfix">
                    <ul>
                    <?php if(is_array($rmalls)) { foreach($rmalls as $k => $t) { ?>
                        <li class="vertical-show-item">
                            <div class="vertical-show-img">
                                <a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-4-3.png';"></a>
                            </div>
                            <div class="vertical-show-info">
                                <p class="vertical-show-name text-overflow"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></p>
                                <p class="vertical-show-company text-overflow"><a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank" title="<?php echo $t['company'];?>"><?php echo $t['company'];?></a></p>
                                <p class="vertical-show-cate">
                                <?php if($t['kcatids']) { ?>
                                <?php $kcatid = explode(',',$t['kcatids']);?>
                                <?php if(is_array($kcatid)) { foreach($kcatid as $kk => $kt) { ?>
                                <?php if(empty($kt)) continue; ?>
                                <a href="<?php echo $MODULE['16']['linkurl'];?><?php echo keshi_rewrite(['kcatid'=>$kt]);?>" target="_blank" title="<?php echo $KESHI[$kt];?>医疗器械"><?php echo $KESHI[$kt];?></a>
                                <?php } } ?>
                                <?php } ?>
                                </p>
                            </div>
                        </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <!--推荐产品 end-->
            <!--猜你喜欢-->
            <div class="module mgt-20">
                <div class="module-hd">
                    <span>猜你喜欢</span>
                </div>
                <div class="module-bd keyword-show clearfix">
                <?php if(is_array($lkeyword)) { foreach($lkeyword as $k => $t) { ?>
                    <a href="<?php echo $MODULE['16']['linkurl'];?><?php echo keyword_rewrite(['kwid'=>$t['itemid']]);?>"><?php echo $t['word'];?></a>
                <?php } } ?>
                </div>
            </div>
            <!--猜你喜欢 end-->
            <!--最新产品-->
            <div class="module mgt-20">
                <div class="module-hd">
                    <span>最新产品</span>
                </div>
                <div class="module-bd horizontal-show clearfix">
                <?php if(is_array($nmalls)) { foreach($nmalls as $k => $t) { ?>
                    <div class="horizontal-show-item">
                        <div class="horizontal-show-img pull-left">
                            <a href="<?php echo $MOUDLE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-4-3.png';"></a>
                        </div>
                        <div class="horizontal-show-info pull-right">
                            <p class="horizontal-show-name"><a href="<?php echo $MOUDLE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></p>
                            <p class="horizontal-show-company text-overflow"><a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank"><?php echo $t['company'];?></a></p>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
            <!--最新产品 end-->
            <!--推荐供应商-->
            <div class="module mgt-20">
                <div class="module-hd">
                    <span>推荐供应商</span>
                </div>
                <div class="module-bd company-show clearfix">
                <?php if(is_array($rcompanys)) { foreach($rcompanys as $k => $t) { ?>
                    <a href="<?php echo $t['linkurl'];?>" class="company-show-item" target="_blank">
                        <img class="company-show-img" src="<?php echo $t['thumb'];?>" alt="<?php echo $t['company'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-sm-1-1.png';">
                        <p class="company-show-name"><?php echo $t['company'];?></p>
                    </a>
                <?php } } ?>
                </div>
            </div>
            <!--推荐供应商 end-->
        </div>
        <!--side end-->