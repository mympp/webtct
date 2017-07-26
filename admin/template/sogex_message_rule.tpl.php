<?php 
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(3);</script>
<div class="tt">评分规则</div>
<form action="?" method="post" onsubmit="return check()">
<input name="action" value="update_rule" type="hidden" />
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<input type="hidden" value="1" name="submit" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td colspan="2">--百度流量预计和关键词库的数据来源于seo.chinaz.com</td>
</tr>
<tr>
<td colspan="2">--日均ip和日均pv值来源于www.aizhan.com</td>
</tr>
<tr>
<td colspan="2">--百度收录量值来源于www.baidu.com</td>
</tr>
<tr>
<td colspan="2">--天成收录量来源于天成数据库统计</td>
</tr>
<tr>
	<td>评分公式:</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td>1.网站性质总分值1分，政府网站分数为1，企业网站分数为0.75，门户网站分数为0.5，其他网站分数为0.25</td>
</tr>
<tr>
	<td></td>
	<td>2.流量预计:&nbsp;&nbsp;0.5 * ( 流量预计值 / 流量预计阈值 : <input type="text" id="traffic_forecast" name="traffic_forecast" value="<?php echo $traffic_forecast; ?>" /> <span id="dtraffic_forecast" class="f_red"></span>),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>3.关键词库:&nbsp;&nbsp;0.5 * ( 关键词库值 / 关键词库阈值 : <input type="text" id="keywords_num" name="keywords_num" value="<?php echo 
	$keywords_num; ?>"/> <span id="dkeywords_num" class="f_red"></span> ),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>4.日均ip:&nbsp;&nbsp;0.5 * ( 日均ip值 / 日均ip阈值 : <input type="text" id="ipavg" name="ipavg"  value="<?php echo $ipavg; ?>"/> <span id="dipavg" class="f_red"></span> ),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>5.日均pv:&nbsp;&nbsp;0.5 * ( 日均pv值 / 日均pv阈值 : <input type="text" id="pvavg" name="pvavg" value="<?php echo $pvavg; ?>"/> <span id="dpvavg" class="f_red"></span> ),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>6.日均pv和日均ip比:&nbsp;&nbsp;0.5 * ( 日均pv值 / 日均ip值 / 比例阈值 : <input type="text" id="pv_ip_ratio" name="pv_ip_ratio" value="<?php echo $pv_ip_ratio; ?>" /> <span id="dpv_ip_ratio" class="f_red"></span> ),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>7.百度收录量:&nbsp;&nbsp;0.5 * ( 百度收录量值 / 百度收录量阈值 : <input type="text" id="baidu_site" name="baidu_site" value="<?php echo $baidu_site; ?>"/> <span id="dbaidu_site" class="f_red"></span> ),最高分数为0.5</td>
</tr>
<tr>
	<td></td>
	<td>8.天成收录量:&nbsp;&nbsp;1 * ( 天成收录量值 / 天成收录量阈值 : <input type="text" id="tc_site" name="tc_site" value="<?php echo $tc_site; ?>" /> <span id="dtc_site" class="f_red"></span> ),最高分数为1</td>
</tr>
<tr>
	<td></td>
	<td>9.八项评分总和为网站评分，总分数为5</td>
</tr>
</table>
<div class="btns">
<input type="submit" value="修改" class="btn" />
</div>
</form>
<script>
	function check(){
		
		var id_arr = Array('traffic_forecast','keywords_num','ipavg','pvavg','pv_ip_ratio','baidu_site','tc_site');
		
		for(i in id_arr){
			var f = id_arr[i];
			var v = Dd(f).value;
			if(isNaN(v)){
				Dmsg('值只能为数字',f);
				return false;
			}
		
			if(v<1){
				Dmsg('值必须大于1',f);
				return false;
			}
			
		}
		return true;
	}
</script>
<?php include tpl('footer'); ?>