
<style>
#content1 ul li{float:left;width:167px;text-align:center;margin-bottom:12px;margin-top:12px;}
#content1 ul li img{width:110px;height:110px !important;border:1px solid #ccc;padding:5px;}
#content1 ul li font{font-size:12px;margin:5px 0px;}
</style>
<div id="content1" class="<?php if($keyword['moduleid']==16){echo 'showy';}else{echo 'shown';} ?>" onmouseover="show_list(1)">
	<ul>
	<?php foreach($mall_relevant as $k=>$v){ ?>
	<li>
	<a href="<?php echo $v['linkurl']; ?>" ><img src="<?php echo $v['thumb'] ?>" onerror="javascript:this.src='<?php echo DT_SKIN; ?>image/no-pic.png';" title="<?php echo $v['title']; ?>"></a>
	<div style="clear:both;"></div>
	<a href="<?php echo $v['linkurl']; ?>" title="<?php echo $v['title']; ?>" ><font><?php echo dsubstr($v['title'],22,'...'); ?></font></a>
	</li>
	<?php if(($k+1)%4==0 &&$k!=15){ echo '</ul><ul>';} ?>
	<?php } ?>
	</ul>
<div class="divline"></div>
<div class="more"><a href="<?php echo DT_PATH.'search.php?moduleid=1&from=1&spread=0&action=&kw='.$keyword['word']; ?>" rel="nofollow">查看更多内容</a></div>
</div>