<style>
.list_nopic{margin:5px 12px;padding:8px 0px;}
</style>
<div id="content2" class="<?php if($keyword['moduleid']==9){echo 'showy';}else{echo 'shown';} ?>" onmouseover="show_list(2)">
<?php foreach($fuwu_relevant as $k=>$v){ ?>
<div class="list_nopic" style="<?php if($k!=8){ ?>border-bottom:1px solid #ccc;<?php } ?>" >
<a href="<?php echo $v['linkurl']; ?>"><font style="font-size:16px;font-weight:bold;"><?php echo $v['title']; ?></font></a>
<div class="divline"></div>
<span style="font-size:12px;"><?php echo dsubstr($v['introduce'],180,'...'); ?></span>
</div>
<?php } ?>
<div class="divline"></div>
<div class="more"><a href="<?php echo DT_PATH.'search.php?moduleid=1&from=1&spread=0&action=&kw='.$keyword['word']; ?>" rel="nofollow">查看更多内容</a></div>
</div>