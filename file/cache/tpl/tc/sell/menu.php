<?php defined('IN_DESTOON') or exit('Access Denied');?><!--page-nav-->
<div class="page-nav">
    <div class="w1200 box-center">
        <ul class="page-nav-main clearfix">
            <li class="page-sub-nav current">
                <a href="<?php echo $MODULE['5']['linkurl'];?>">供求信息平台首页</a>
            </li>
            <li class="page-sub-nav page-sub-nav-lg">
                <a href="<?php echo $MOD['linkurl'];?><?php echo sell_rewrite(['typeid'=>0]);?>">供应信息分类<i class="arrow"></i></a>
                <ul>
                <?php $tagss = tag("moduleid=$moduleid&table=category&fields=catid,catname,style,item&condition=moduleid=$moduleid and parentid=0&pagesize=30&order=listorder ASC&template=null")?>
                <?php if(is_array($tagss)) { foreach($tagss as $k => $t) { ?>
                <li><a href="<?php echo $MODULE[$moduleid]['linkurl'];?><?php echo sell_rewrite(['catid'=>$t['catid'],'typeid'=>0]);?>">  <?php echo $t['catname'];?>  </a></li>
                <?php } } ?>
                </ul>
            </li>
            <li class="page-sub-nav page-sub-nav-lg">
                <a href="<?php echo $MOD['linkurl'];?><?php echo sell_rewrite(['typeid'=>1]);?>">求购信息分类<i class="arrow"></i></a>
                <ul>
                <?php if(is_array($tagss)) { foreach($tagss as $k => $t) { ?>
                <li><a href="<?php echo $MODULE[$moduleid]['linkurl'];?><?php echo sell_rewrite(['catid'=>$t['catid'],'typeid'=>1]);?>">  <?php echo $t['catname'];?>  </a></li>
                <?php } } ?>
                </ul>
            </li>
            <li class="page-sub-nav"><a href="<?php echo $MOD['linkurl'];?><?php echo sell_rewrite(['typeid'=>2]);?>">其他相关信息</a></li>
            <li class="page-sub-nav"><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=<?php echo $moduleid;?>" rel="nofollow">发布供求信息</a></li>
        </ul>
    </div>
</div>
<!--page-nav end-->