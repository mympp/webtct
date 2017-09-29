<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<div class="m">
<div class="left_box">
<div class="pos"><span class="f_r"><a href="<?php echo $MODULE['2']['linkurl'];?>ad.php">[我的广告]</a></span>当前位置: <a href="<?php echo $MODULE['1']['linkurl'];?>">首页</a> &raquo; <a href="<?php echo $EXT['ad_url'];?>">广告中心</a> &raquo; 广告预览</div>
<br/><br/>
<table cellpadding="10" cellspacing="0" align="center">
<tr>
<td>
<?php if($ad_moduleid) { ?>
<?php echo ad($ad_moduleid,$ad_catid,$ad_kw,$typeid);?>
<?php } else if($pid) { ?>
<?php echo ad($pid);?>
<?php } ?>

</td>
</tr>
<tr>
<td><span class="f_gray">以上为广告效果预览，如未看到任何内容，表明此广告为空或不可预览</span></td>
</tr>
</table>
<br/><br/>
</div>
</div>
<?php include template('footer');?>