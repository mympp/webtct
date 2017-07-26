<style>
.gq_list {margin:0px 12px;padding-top:12px;}
</style>
<div id="content5" class="<?php if($keyword['moduleid']==5){echo 'showy';}else{echo 'shown';} ?>" onmouseover="show_list(5)">
<?php if($sell_relevant){ ?>
<ul>
<?php foreach($sell_relevant as $k=>$t){ ?>
<li class="autoheight gq_list" style="<?php if($k!=5){ ?>border-bottom:1px solid #ccc;<?php } ?>">
<dl>
<dt><a href="<?php echo $MODULE[5]['linkurl'].$t[linkurl]; ?>" target="_blank" class="bcolor" title="<?php echo $t[title]; ?>"><?php echo dsubstr($t[title],66,".."); ?></a><em class="em">(#<?php echo $t[itemid]; ?>)</em>
<span class="f12 hcolor fr">关注<?php echo $t[hits]; ?>℃&nbsp;&nbsp;</span>
<?php if( $t[validated]==1){ ?><span class='f12 ocolor' title="本站客服已对其真实性进行验证"><img src="<?php echo DT_SKIN; ?>image/shield.gif" class="mid"/>验证</span><?php } ?>&nbsp;&nbsp;
<?php if($t[level]>0){ ?><span class='f12 ml10 fr'>级别<img src="<?php echo DT_SKIN; ?>image/vip_<?php echo $t[level]; ?>.gif" class="mid" alt="推荐<?php echo $t[level]; ?>级"/>&nbsp;&nbsp;</span><?php } ?>
</dt>
<dd style="padding-top:5px;">
<p><?php echo dsubstr($t[introduce],120,'...'); ?></p>
<p><span class="ml10">发布时间 [<?php echo timetodate($t[edittime],2); ?>]&nbsp;&nbsp;</span></p>
</dd>
<br class="clear"/>
</dl>
</li>
<?php } ?>
</ul>
<?php } ?>
<div class="divline"></div>
<div class="more"><a href="<?php echo DT_PATH.'search.php?moduleid=1&from=1&spread=0&action=&kw='.$keyword['word']; ?>" rel="nofollow">查看更多内容</a></div>
</div>