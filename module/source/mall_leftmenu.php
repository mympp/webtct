<?php
$filecontent = '<div id="'.$module.'sidebar" class="hd"> ';
$child = get_maincat(0, $moduleid, 1);
foreach ($child as $i => $c) {
	$filecontent .= '<dl class="sidelist"> ';
	$filecontent .= '<dt> <span> <h3 class="treeout lenstr"> ';
	$filecontent .= '<a href="'.$MODULE[$moduleid]['linkurl'].$c['linkurl'].'" title="'.$c['catname'].'\n数量共:'.$c['item'].'条" > ';
	$filecontent .= set_style($c['catname'], $c['style']);
	$filecontent .= '</a> ';
	$filecontent .= '</h3></span></dt> ';
	if($c['child']){
		$filecontent .= '<dd class="i-list autoheight"> ';
		$filecontent .= '<ul> ';
		$sub = get_maincat($c['catid'], $moduleid, 1);
		foreach ($sub as $j => $s) {
			$filecontent .= '<li class="lenstr"> ';
			$filecontent .= '<a href="'.$MODULE[$moduleid]['linkurl'].$s['linkurl'].'" title="'.$s['catname'].'">· '.set_style($s['catname'], $s['style']).'</a> ';
			$filecontent .= '<i class="ocolor">共['.$s['item'].']个</i> ';
			$filecontent .= '</li> ';
		}
		$filecontent .= '</ul> ';
		$filecontent .= '<br class="clear"> ';
		$filecontent .= ad(144, 0, '', 0, true);
		$filecontent .= '</dd> ';
	}


	$filecontent .= '</dl> ';
}
$filecontent .= '</div> ';
?>

		

           
	         
						
							
							
						
			
	




