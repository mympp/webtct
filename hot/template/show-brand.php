<style>
#content6 ul{margin-right: 8px;margin-left: 8px;height: auto;overflow: hidden;}
#content6 ul li{float: left;text-align: center;width: 145px;padding: 8px;}
#content6 ul li img{width:100px;height:100px !important;}
</style>
<div id="content6" class="<?php if($keyword['moduleid']==13){echo 'showy';}else{echo 'shown';} ?>" onmouseover="show_list(6)">
<ul >
<?php 
$brand_db = new tcdb('brand_13');
foreach($brand_relevant as $k=>$t){ ?>
<li style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;
<?php if($k<4){echo 'border-top:1px solid #ccc;';}
	if($k==0||$k%4==0){echo 'border-left:1px solid #ccc;';}
 ?>
"><a href="<?php echo $t[linkurl]; ?>" title="<?php echo $t['title']; ?>" target='_blank'><img src='<?php echo $t[thumb]; ?>' alt='<?php echo $t['title']; ?>' onerror="this.src='<?php echo DT_SKIN; ?>image/nopic.gif'" align="center">
<div style="font-weight:bold;"><?php echo dsubstr($t[title],22,'...'); ?></div>
</a>
<div class="pnum"><font>产品数 
<?php 
	$pnum = $brand_db->field('pnum')->where(['itemid'=>$t['itemid']])->one();
	echo $pnum[pnum]; 
?>
</font></div></a>
</li>
<?php } ?>
</ul>
<div class="divline"></div>
<div class="more"><a href="<?php echo DT_PATH.'search.php?moduleid=1&from=1&spread=0&action=&kw='.$keyword['word']; ?>" rel="nofollow">查看更多内容</a></div>
</div>