<?php 
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(1);</script>
<div class="tt">添加网站</div>
<form action="?" method="post" onsubmit="return check();">
<input type="hidden" value="1" name="submit" />
<input type="hidden" value="<?php echo $action; ?>" name="action" />
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<input type="hidden" value="<?php echo $itemid; ?>" name="mid" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td class="tl"><span class="f_red">*</span> 网站名</td>
	<td><input type="text" id="name" value="<?php echo $name; ?>" name="post[name]" />&nbsp;<span id="dname" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 域名</td>
	<td><input id="url" type="text" name="post[url]" value="<?php echo $url; ?>" />&nbsp;<span id="durl" class="f_red"></span> &nbsp;&nbsp;&nbsp;<input type="button" onclick="get_data()" value="获取该网站的评分参数" /> </td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 网站性质</td>
	<td><input type="radio" name="post[type]" value="4" <?php if($type == 4) echo 'checked="checked"'; ?> />政府网站&nbsp;&nbsp;
	<input type="radio" name="post[type]" value="3" <?php if($type == 3) echo 'checked="checked"'; ?> />企业网站&nbsp;&nbsp;
	<input type="radio" name="post[type]" value="2" <?php if($type == 2) echo 'checked="checked"'; ?> />门户网站&nbsp;&nbsp;
	<input type="radio" name="post[type]" value="1" <?php if($type == 1) echo 'checked="checked"'; ?> />其他&nbsp;&nbsp;
	<span id="dtype" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 百度流量预计</td>
	<td><input type="text" id="traffic_forecast" name="post[traffic_forecast]" value="<?php echo $traffic_forecast; ?>" />
	&nbsp;<span id="dtraffic_forecast" class="f_red"></span>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 关键词库</td>
	<td><input type="text" id="keywords_num" name="post[keywords_num]" value="<?php echo $keywords_num; ?>" />
	&nbsp;<span id="dkeywords_num" class="f_red"></span>
	<?php if($url) { ?>&nbsp;&nbsp;<a href="http://seo.chinaz.com/?m=&host=<?php echo $website->host; ?>" target="_blank">数据不完整？前去查找</a> <?php } ?></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 日均ip</td>
	<td><input type="text" name="post[ipavg]" id="ipavg" value="<?php echo $ipavg; ?>" />&nbsp;<span id="dipavg" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 日均pv</td>
	<td><input type="text" name="post[pvavg]" id="pvavg" value="<?php echo $pvavg; ?>" />&nbsp;<span id="dpvavg" class="f_red"></span>
	<?php if($url) { ?>&nbsp;&nbsp;<a href="http://www.aizhan.com/cha/<?php echo $website->host; ?>" target="_blank">数据不完整？前去查找</a> <?php } ?>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 百度收录量</td>
	<td><input type="text" name="post[baidu_site]" id="baidu_site" value="<?php echo $baidu_site; ?>" />&nbsp;<span id="dbaidu_site" class="f_red"></span>
	<?php if($url) { ?>&nbsp;&nbsp;<a href="http://www.baidu.com/s?wd=site:<?php echo $website->host; ?>" target="_blank">数据不完整？前去查找</a> <?php } ?>
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 天成收录量</td>
	<td><input type="text" name="post[tc_site]" id="tc_site" value="<?php echo $tc_site; ?>" />&nbsp;<span id="dtc_site" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 客观评分</td>
	<td><input type="text" name="post[star]" id="star" value="<?php echo $star; ?>" readonly="readonly" />&nbsp;<span id="dstar" class="f_red"></span> &nbsp;&nbsp;&nbsp;<input type="button" onclick="get_score()" value="计算该网站的评分" /> </td>
</tr>
</table>
<div class="btns">
<input type="submit" value="确定" class="btn" />
</div>
</form>
<script type="text/javascript">
function check(){
		var radioObj = document.getElementsByName('post[type]');
		var type = '' ;
		for(var i = 0 ; i<radioObj.length; i++){
			if(radioObj[i].checked) type = radioObj[i].value;
		}

		if(type == '' ){
			Dmsg('请选择类型','type');
			return false;
		}
		
		var check_arr = ['name','url','traffic_forecast','keywords_num','ipavg','pvavg','baidu_site','tc_site','star'];
		for(var i = 0;i<check_arr.length;i++){
			if(Dd(check_arr[i]).value == ''){
				Dmsg('不可为空',check_arr[i]);
				return false;
			}
			
			if(check_arr[i] != 'name' && check_arr[i] != 'url'){
				if(isNaN(Dd(check_arr[i]).value)){
					Dmsg('只能为数字',check_arr[i]);
					return false;
				}
			}
		}
		
		return true;
}

function get_data(){
		var url = Dd('url').value;
		var name = Dd('name').value;
		if(url == ''){
			Dmsg('先填写域名','url');
			return false;
		}
		window.location.href="?file=sogex_message&action=<?php echo $action; ?>&url="+url+"&name="+name<?php if($action == 'edit'){echo '+"&itemid='.$itemid.'&get_data=1"';} ?>;
}

function get_score(){
		var radioObj = document.getElementsByName('post[type]');
		var type = '' ;
		for(var i = 0 ; i<radioObj.length; i++){
			if(radioObj[i].checked) type = radioObj[i].value;
		}
		if(type == ''){
			Dmsg('请选择类型','type');
			return false;
		}
		var traffic_forecast_limit = <?php echo $limit['traffic_forecast']; ?>;
		var keywords_num_limit = <?php echo $limit['keywords_num']; ?>;
		var ipavg_limit = <?php echo $limit['ipavg']; ?>;
		var pvavg_limit = <?php echo $limit['pvavg']; ?>;
		var baidu_site_limit = <?php echo $limit['baidu_site']; ?>;
		var tc_site_limit = <?php echo $limit['tc_site']; ?>;
		var ratio_limit = <?php echo $limit['pv_ip_ratio']; ?>;
		
		var star = type*0.25;		//网站类型得分
		var traffic_forecast_star = (Dd('traffic_forecast').value) / traffic_forecast_limit ;
		traffic_forecast_star = traffic_forecast_star>1 ? 0.5 : 0.5*traffic_forecast_star;		//流量预计得分
		
		var keywords_num_star = (Dd('keywords_num').value) / keywords_num_limit;
		keywords_num_star = keywords_num_star > 1 ? 0.5 : 0.5*keywords_num_star;	//关键词库得分
		
		var ipavg_star = (Dd('ipavg').value) / ipavg_limit;
		ipavg_star = ipavg_star > 1 ? 0.5 :0.5 * ipavg_star;			//日均ip得分
		
		var pvavg_star = (Dd('pvavg').value) / pvavg_limit;
		pvavg_star = pvavg_star > 1 ? 0.5 : 0.5 * pvavg_star;			//日均pv得分
		
		
		if(Dd('pvavg').value == '0' || Dd('ipavg').value == '0'){
			ratio_star = 0 ;
		}else{
			var ratio_star = (Dd('pvavg').value) / (Dd('ipavg').value) / ratio_limit;
			ratio_star = ratio_star > 1 ? 0.5 : 0.5 * ratio_star;		//pv与ip比例得分
		}
		
		var baidu_site_star = (Dd('baidu_site').value) / baidu_site_limit;
		baidu_site_star = baidu_site_star > 1 ? 0.5 : 0.5 * baidu_site_star ;		//百度收录得分
		
		var tc_site_star = (Dd('tc_site').value) / tc_site_limit;
		tc_site_star = tc_site_star > 1 ? 1 : 1* tc_site_star;			//天成收录得分
		
		star = star+traffic_forecast_star+keywords_num_star+ipavg_star+pvavg_star+ratio_star+baidu_site_star+tc_site_star;
		Dd('star').value = star.toFixed(2);		
}
</script>
<?php include tpl('footer'); ?>