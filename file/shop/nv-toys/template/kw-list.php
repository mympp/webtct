<!--list-area-->
                <div class="list-area">
                    <div class="col">
                        <div class="col-hd clearfix">
                            <span>关键词：<?php echo $kw; ?></span>
                        </div>
                        <div class="col-bd clearfix">
                        <?php $product = $mall->field(['itemid,title,thumb'])->likeWhere(['keyword'=>$kw])->where(['username'=>USERNAME,'status'=>3])->all(); ?>
                            <?php foreach($product as $k=>$v){ ?>
								<div class="item">
                                	<a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><img src="<?php echo $v['thumb']; ?>" alt="<?php echo $v['title']; ?> "></a>
                                	<p><a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><?php echo $v['title']; ?></a></p>
                           		</div>
							<?php } ?>
                        </div>
                    </div>
                 </div>
<!--list-area end-->