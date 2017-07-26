<?php defined('IN_DESTOON') or exit('Access Denied');?><ul id="brand_nr">
    <?php $num_a=1; ?>
    <?php if(is_array($tags)) { foreach($tags as $k => $v) { ?>
    <?php $v['image'] = str_replace('.thumb.'.file_ext($v['thumb']), '', $v['thumb']);?>
    <li class="f_l
                <?php if($num_a<3) { ?>
                    <?php if($num_a==2) { ?>brand_li_2<?php } ?>
                    <?php $num_a++;?>
                <?php } else { ?>
                    <?php $num_a=1;?>
                <?php } ?>
">
        <div class="brand_img">
            <img src="<?php echo $v['image'];?>" data-title="<?php echo $v['title'];?>"  data-content="<?php echo $v['content'];?>"/>
            <div class="brand_title"></div>
            <span><?php echo $v['title'];?></span>
        </div>
    </li>
    <?php } } ?>
    <div class="c_b"></div>
</ul>
<?php if($showpage && $pages) { ?><div class="pages"><?php echo $pages;?></div><?php } ?>
