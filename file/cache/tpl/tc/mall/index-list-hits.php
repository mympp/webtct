<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if(is_array($lists)) { foreach($lists as $k => $t) { ?>
                        <li class="rank-item clearfix">
                            <i class="rank-num"><?php echo $k+1;?></i>
                            <div class="rank-item-img"><a href="<?php echo $MOUDLE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="lazy" src="<?php echo DT_PATH;?>skin/teceskin/image/blank.gif" data-original="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"></a></div>
                            <div class="rank-item-name"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></div>
                            <div class="rank-item-num"><i class="cp-i"></i><?php echo $t['hits'];?></div>
                        </li>
<?php } } ?>