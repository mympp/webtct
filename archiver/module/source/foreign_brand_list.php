<?php
$brand = $db->count($DT_PRE.'brand_13', "status=3 and catid=859", 60);
$thumb_brands = tag("moduleid=13&condition=status=3 and catid=859 &pagesize=12&order=level desc,pnum desc&template=null&debug=0&showcat=0");
$companys =  tag("moduleid=4&condition=groupid>5 and groupid<8 and ( stype=2 or stype=1 ) and business<>''&pagesize=8&order=level desc,pnum desc&template=null&debug=0&showcat=1");


$filecontent = '<dl class="brandlist">';
$filecontent .= '<dt style="background:#3d73af"><span class="fr mr5">';
$filecontent .= '<a href="'.$MODULE[13]['linkurl'].'list-htm-catid-859-typeid-99.html" class="wcolor f14">';
$filecontent .= '更多>></a></span>>国外厂商品牌信息(共'.$brand.'个)</dt>';
$filecontent .= '<dd class="fl brands "><ul>';
foreach ($thumb_brands as $k => $t) {
	$filecontent .= '
	<li>
		<a href="'.$t['linkurl'].'" title="'.$t['alt'].'" target="_blank">
			<img src="'.$t['thumb'].'"" alt="'.$t['alt'].'"" onerror="this.src=\''.DT_SKIN.'image/nopic.gif\'" align="center">
			<div class="pnum ocolor"><font>产品数 '.$t['pnum'].'</font></div>
			<div class="lenstr">'.$t['title'].'</div>
		</a>
	</li>';
}
$filecontent .= '</ul></dd>';
$filecontent .= '<dd class="fl companys" style="background:#b5cce6">';
$filecontent .= '<ul >';
foreach ($companys as $z => $t) {
	$catname = $db->get_one("SELECT catname FROM ".$DT_PRE."category WHERE catid='".$t['catid']."'");
	$t['catname'] = $catname['catname'];
	$filecontent .= '
	<li>
		<a href="'.$t['linkurl'].'" title="'.$t['catname'].'-'.$t['company'].'" target="_blank">
			<div class="ddtitle" >
			<p class="lenstr w310">&nbsp;'.$t['company'].'</p>
			<div class="lenstr">
				<span class="lenstr w220">&nbsp;'.$t['business'].'</span>
				<span class="lenstr w80 ml10">'.$t['pnum'].'个产品</span>
			</div>
			</div>
		</a>
	</li>';
}
$filecontent .= '</ul></dd></dl>';
?>