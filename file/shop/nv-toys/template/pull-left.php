<?php

?>
<div class="side pull-left">
                <div class="side-box pro-cate">
                    <div class="side-box-hd">
                        <span>产品分类</span>
                        <a class="more" href="plist.html">更多</a>
                    </div>
                    <div class="side-box-bd">
                        <ul>
                            <li><a href="plist.html">全部分类</a></li>
                            <?php 
                            	$type = new tcdb('type');
                            	$usertype = $type->field('typeid,typename')->where(['item'=>'mall-'.USERID,'parentid'=>0])->limit(0,40)->select();
                            	
                            ?>
                            <?php foreach($usertype as $k=>$v){ ?>
                            	<li><a href="plist-<?php echo $v['typeid']; ?>.html"><?php echo $v['typename']; ?></a></li>
							<?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="side-box pro-search">
                    <div class="side-box-hd">
                        <span>站内搜索</span>
                    </div>
                    <div class="side-box-bd">
                        <form action="plist.php" onsubmit="return check_kw();">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="homepage" value="tiancheng">
                            <input class="a" type="text" name="kw" placeholder="输入关键词" value="<?php echo $kw; ?>">
                            <input class="b" type="button" value="搜索">
                        </form>
                    </div>
                </div>
                
                <div class="pro-rec">
                    <div class="side-box ">
                        <div class="side-box-hd">
                            <span>店长推荐</span>
                        </div>
                        <div class="side-box-bd clearfix">
                        	<?php
                        		$hot_mall = $mall->field('itemid,thumb,title')->where(['username'=>USERNAME,'status'=>3])->limit(0,6)->order('level asc')->select(); 
                        	?>
                        	<?php foreach($hot_mall as $k=>$v){ ?>
								<a href="product-<?php echo $v['itemid']; ?>.html" target="_blank" class="item">
                                	<img src="<?php echo $v['thumb']; ?>" alt="<?php echo $v['title']; ?>">
                               		<p class="text-overflow" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></p>
                            	</a>
							<?php } ?>
                        </div>
                        <div class="side-box-ft">
                            <a href="plist.html" class="more" >查看更多</a>
                        </div>
                    </div>
                </div>
            </div>