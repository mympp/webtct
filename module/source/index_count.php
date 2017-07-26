<?php
$job = $db->count($DT_PRE.'job', "status=3", 60);
$resume = $db->count($DT_PRE.'resume', "status=3", 60);
$art = $db->count($DT_PRE.'article_21', "status=3", 60);
$down = $db->count($DT_PRE.'down_15', "status=3", 60);
$num=$job+$resume;
$job_resume_num=number_format($num,0,'.',',');

$buy = $db->count($DT_PRE.'buy_6', "status=3", 60);
$sell = $db->count($DT_PRE.'sell_5', "status=3", 60);
$num=$buy+$sell;
$buy_sell_num=number_format($num,0,'.',',');

$brand = $db->count($DT_PRE.'brand_13', "status=3", 60);
$company = $db->count($DT_PRE.'company', "username!='gztc' and groupid>5 ", 60);
$keshi = $db->count($DT_PRE.'category', "moduleid=12", 60);
$brand_num=number_format($brand,0,'.',',');

$mall = $db->count($DT_PRE.'mall', "status=3", 60);
$mall_num=number_format($mall,0,'.',',');
$memb = $db->count($DT_PRE.'member', "groupid>4 and edittime<>'1399513082'", 60);
$memb =$memb+ 10000;
$memb_num= number_format($memb,0,'.',',');

$filecontent = '<ul class="counts">';
$filecontent .= '<li>关注次数 <font class="ocolor f16"><script type="text/javascript" src="http://www.tecenet.com/module/count.php"></script></font></li>';
$filecontent .= '<li>技术服务信息 <font class="ocolor f16">';
$filecontent .= $job_resume_num.'</font></li>';
$filecontent .= '<li>供求买卖信息 <font class="ocolor f16">';
$filecontent .= $buy_sell_num.'</font></li>';
$filecontent .= '<li>厂商品牌信息 <font class="ocolor f16">';
$filecontent .= $brand_num.'</font></li>';
$filecontent .= '<li>产品配件信息 <font class="ocolor f16">';
$filecontent .= $mall_num.'</font></li>';
$filecontent .= '<li>会员总数<font class="ocolor f16">';
$filecontent .= $memb_num.'</font></li>';
$filecontent .= '</ul>';
?>