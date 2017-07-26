<?php
/*
time:2015/10/27
who ：xiaolv
rel : msg.htm
add:新增页面提示跳转信息
*/
require_once '../common.inc.php';
require_once 'wap.inc.php';
$dforward = base64_decode($_GET['dforward']);
if(!isset($dtime)) $dtime=3;
include template('header','touch');
?>
<div class="head_bar">
<table>
<tr>
<td class="head_bar_td_w5">&nbsp;</td>
<td class="head_bar_td_w50"><div class="head_back"><a href="{$back_link}"><span>返回</span></a></div></td>
<td><div class="head_name"><span>提示信息</span></div></td>
<td class="head_bar_td_w55 t_r"><a href="index.php?moduleid={$moduleid}&amp;action=category"><img src="image/sort.png" width="40" height="40" alt="行业分类"/></a></td>
</tr>
</table>
</div>
<div class="head_bar_fix"></div>
<script type="text/javascript">
	var time = <?php echo $dtime;?>;
	function Redirect(u){
	    window.location = u;
	}
	var i = 0;
	function dis(word){
	    document.all.s.innerHTML = word+",自动跳转还剩" + (time - i) + "秒";
	    i++;
	}
	timer=setInterval('dis(\'<?php echo $dmessage;?>\')', 1000); 
	timer=setTimeout('Redirect(\'<?php echo $dforward;?>\')',time * 1000);
</script>
<span id="s"></span>
<?php
include template('footer','touch');
?>