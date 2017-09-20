<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if(is_array($lists)) { foreach($lists as $k => $t) { ?>
                        <?php if($k==0) { ?>
                        <li class="goods-item goods-item-first">
                            <div class="goods-item-img"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="lazy" src="<?php echo DT_PATH;?>skin/teceskin/image/blank.gif" data-original="<?php echo imgurl(str_replace('.thumb.','.middle.',$t['thumb']), 1);?>" alt=""></a></div>
                            <div class="goods-item-name"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></div>
                            <div class="goods-item-price">参考报价：
                                <?php if($price>0) { ?>
                                    <span>￥<?php echo $t['price'];?></span>
                                <?php } else { ?>
                                    <span>￥面议</span>
                                <?php } ?>
                            </div>
                            <div class="goods-item-btn">
                                <!--<a class="btn-primary" href="<?php echo $MOUDLE['16']['linkurl'];?><?php echo $t['linkurl'];?>">立即询价</a>-->
                                <a class="btn-default" href="<?php echo $MOUDLE['16']['linkurl'];?><?php echo $t['linkurl'];?>">了解更多</a>
                            </div>
                            <div class="goods-item-company"><a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank" title="<?php echo $t['company'];?>"><i class="cp-i"></i><?php echo $t['company'];?></a></div>
                        </li>
                        <?php } else { ?>
                        <li class="goods-item">
                            <div class="goods-item-img"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="lazy" src="<?php echo DT_PATH;?>skin/teceskin/image/blank.gif" data-original="<?php echo imgurl(str_replace('.thumb.','.middle.',$t['thumb']), 1);?>" alt=""></a></div>
                            <div class="goods-item-name"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></div>
                            <div class="goods-item-price">参考报价：
                                <?php if($price>0) { ?>
                                    <span>￥<?php echo $t['price'];?></span>
                                <?php } else { ?>
                                    <span>￥面议</span>
                                <?php } ?>
                            </div>
                        </li>
                        <?php } ?>
                    <?php } } ?>