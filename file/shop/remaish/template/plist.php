<?php require '/template/header.php'; ?>


    <!--product-list-->
    <div class="layout container clearfix">
        <div class="main pull-right">
            <!--crumb-->
            <div class="crumb">
                <span>您当前的位置：</span>
                <a href="index.html">首页</a> »
                <?php if($typeid){ ?>
					<a href="plist-<?php echo $typeid; ?>.html"><?php echo $product_cat[0]['typename']; ?></a>
				<?php }else{ ?>
					<a href="plist.html">所有产品</a>
				<?php } ?>
                
          
            <!--crumb end-->

            <!--list-area-->
            <div class="list-area">
                <div class="col">
                	<?php if($kw){ ?>
						<div class="col-hd clearfix">
                       		<h2>搜索：<?php echo $kw; ?></h2>
                    	</div>
                    	<div class="col-bd clearfix">
                    		<?php foreach($product as $v){ ?>
								<div class="item">
                            		<a href="product-<?php echo $v['itemid']; ?>.html" target="_blank">
                            		<img src="<?php echo $v['thumb']; ?>" alt="<?php echo $v['title']; ?>"></a>
                            		<h3><a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><?php echo $v['title']; ?></a></h3>
                        		</div>
							<?php } ?>
                    	</div>
                </div>
					<?php }else{ ?>
					
						<?php foreach($product_cat as $pv){ ?>
							<div class="col">
								<div class="col-hd clearfix">
                        			<h2><?php echo $pv['typename']; ?></h2>
                        			<a class="more" href="plist-<?php echo $pv['typeid']; ?>.html">查看更多</a>
                   				</div>
							</div>
							<div class="col-bd clearfix">
								<?php 
									$condition = ['status'=>3,'username'=>USERNAME,'mycatid'=>$pv['typeid']];
									if(!empty($typeid)){
										$type_product = $mall->where($condition)->all();
									}else{
										$type_product = $mall->where($condition)->limit(0,6)->select();
									}
									foreach($type_product as $v){
								?>
								<div class="item">
                           			<a href="product-<?php echo $v['itemid']; ?>.html" target="_blank">
                           			<img src="<?php echo $v['thumb']; ?>" alt="<?php echo $v['title']; ?>"></a>
                            		<h3><a href="product-<?php echo $v['itemid']; ?>.html" target="_blank"><?php echo $v['title']; ?></a></h3>
                       			</div>
                       			<?php } ?>
							</div>
						<?php } ?>

				<?php } ?>
            </div>
            <!--list-area end-->
        </div>
    </div>
        <?php require '/template/product-left.php'; ?>
    <!--product-list end-->
	</div>

<?php require '/template/contact.php'; ?>

<?php require '/template/footer.php'; ?>