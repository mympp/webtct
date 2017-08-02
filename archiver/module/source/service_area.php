<?php
$job = $db->count($DT_PRE.'job', "status=3", 60);
$resume = $db->count($DT_PRE.'resume', "status=3", 60);
$area1 = tag("table=area&condition=parentid=0&pagesize=34&template=null&debug=0");
$area2 = tag("table=area&condition=parentid=0&pagesize=34&template=null&debug=0");

$filecontent = '
<dt>
	<a href="javascript:void(0)" onclick="selecttab(\'areasel\',2,1)" id="areaseltab1" class="lenstr areasely">
		各地技术需求<i class="f12">({$job})</i>
	</a>
	<a href="javascript:void(0)"  onclick="selecttab(\'areasel\',2,2)"  id="areaseltab2"  class="lenstr areaseln">
		各地技术供应<i class="f12">({$resume})</i>
	</a>
</dt>';
$filecontent .= '<dd id="areaseldiv1" class="provice" onmouseover="Dd(\'themeleft\').className=\'themeleft h555 p_ab\'"  onmouseout="Dd(\'themeleft\').className=\'themeleft h450 p_st cut fl\'">';
$filecontent .= '<ul>';
foreach ($area1 as $z => $v) {
	$filecontent .= '
	<li>
		<a href="'.$MODULE[9]['linkurl'].rewrite('search.php?areaid='.$v['areaid'].'&action=job').'" title="'.$v['areaname'].'地区有'.$v['jobcount'].'条维修/安装等等技术服务信息">
		'.$v['areaname'].'
		</a>
		<i>('.$v['jobcount'].')</i>
	</li>';
}
$filecontent .= '</ul></dd>';
$filecontent .= '<dd id="areaseldiv2"class="hd provice"  onmouseover="Dd(\'themeleft\').className=\'themeleft h555 p_ab\'"  onmouseout="Dd(\'themeleft\').className=\'themeleft h450 p_st cut fl\'">';
$filecontent .= '<ul>';
foreach ($area2 as $z => $v) {
	$filecontent .= '
	<li>
		<a href="'.$MODULE[9]['linkurl'].rewrite('search.php?areaid='.$v['areaid'].'&action=resume').'" title="'.$v['areaname'].'地区有'.$v['resumecount'].'条维修工程师/公司信息">
		'.$v['areaname'].'
		</a>
		<i>('.$v['resumecount'].')</i>
	</li>';
}
$filecontent .= '</ul></dd>';
?>