<!--list-area-->
                <div class="list-area">
                <?php if($usertype['parentid'] == 0 || $typeid == 0){ ?>
					
					<?php foreach($childtype as $k => $v){ ?>
					<div class="col">
                        <div class="col-hd clearfix">
                            <span><?php echo $v['typename']; ?></span>
                            <a class="more" href="plist-<?php echo $v['typeid']; ?>.html">更多</a>
                        </div>
                        <div class="col-bd clearfix">
                        	<?php
                        		$condition = ['username'=>USERNAME,'status'=>3];
                        		if($typeid){
                        			$condition['mycatid'] = $v['typeid']; 
									$product = $mall->field('itemid,title,thumb')->where($condition)->order('itemid desc')->limit(0,4)->select(); 
								}else{
									$nexttype = $type->field('typeid')->where(['parentid'=>$v['typeid']])->all();
									$nexttype_str = '';
									foreach($nexttype as $n){
										$nexttype_str .= $n['typeid'].',';
									}
									$inCondition['mycatid'] = substr($nexttype_str,0,'-1');
									$product = $mall->field('itemid,title,thumb')->where($condition)->where($inCondition,'in')->order('itemid desc')->limit(0,8)->select();
								}
                     
                        	?>	
                        	<?php foreach($product as $pk=>$pv){ ?>
								<div class="item">
                                	<a href="product-<?php echo $pv['itemid']; ?>.html" target="_blank"><img src="<?php echo $pv['thumb']; ?>" alt="<?php echo $pv['title']; ?> "></a>
                                	<p><a href="product-<?php echo $pv['itemid']; ?>.html" target="_blank"><?php echo $pv['title']; ?></a></p>
                           		</div>
							<?php } ?>
                        </div>
                    </div>
					<?php } ?>
				<?php }else{ ?>
				
					<?php $product = $mall->field('itemid,title,thumb')->where(['username'=>USERNAME,'mycatid'=>$typeid,'status'=>3])->order('itemid desc')->all(); ?>
					<div class="col">
                        <div class="col-hd clearfix">
                            <span><?php echo $usertype['typename']; ?></span>
                        </div>
                        <div class="col-bd clearfix">
                        	<?php foreach($product as $k=>$v){ ?>
								<div class="item">
                                	<a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><img src="<?php echo $v['thumb']; ?>" alt="<?php echo $v['title']; ?> "></a>
                                	<p><a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><?php echo $v['title']; ?></a></p>
                           		</div>
							<?php } ?>
                        </div>
                    </div>
                    
				<?php } ?>
                    
                </div>
                <!--list-area end-->