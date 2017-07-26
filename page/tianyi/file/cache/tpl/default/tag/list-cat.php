<?php defined('IN_DESTOON') or exit('Access Denied');?><ul>
    <?php if(is_array($tags)) { foreach($tags as $i => $t) { ?>
    <div class="article_div">
        <a class="" href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['alt'];?>">
            <div class="article_title"><?php echo $t['title'];?></div>
            <div class="article_introduce"><?php echo $t['introduce'];?></div>
            <div class="article_bottom"><span id="adddate"><?php echo $t['adddate'];?> &nbsp; &nbsp; &nbsp;浏览次数<?php echo $t['hits'];?></span></div>
        </a>
    </div>
    <?php } } ?>
</ul>
<?php if($showpage && $pages) { ?><div class="pages"><?php echo $pages;?></div><?php } ?>
