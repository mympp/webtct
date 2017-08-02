<?php 
defined('IN_DESTOON') or exit('Access Denied');
if(!$MOD['sitemaps']) {
//	file_del(DT_ROOT.'/sitemaps.xml');
//	return false;
}
if(!$_REQUEST['tn']){
file_del(DT_ROOT.'/sitemaps.xml');
$today = timetodate($DT_TIME, 3);
$mods = explode(',', $MOD['sitemaps_module']);
$nums =300;
$data = '<?xml version="1.0" encoding="UTF-8"?>';
$data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$data .= '<url>';
$data .= '<loc>'.DT_PATH.'</loc>';
$data .= '<lastmod>'.$today.'</lastmod>';
$data .= '<changefreq>always</changefreq>';
$data .= '<priority>1.0</priority>';
$data .= '</url>';
$item = '';
foreach($mods as $mid) {
	if(isset($MODULE[$mid]) && !$MODULE[$mid]['islink'] && !$MODULE[$mid]['domain']) {
		if($mid == 4 && $CFG['com_domain']) continue;
		$url = $MODULE[$mid]['linkurl'];
		$data .= '<url>';
		$data .= '<loc>'.$url.'</loc>';
		$data .= '<lastmod>'.$today.'</lastmod>';
		$data .= '<changefreq>hourly</changefreq>';
		$data .= '<priority>0.9</priority>';
		$data .= '</url>';
		if($nums) {
			$fields = $mid == 4 ? 'linkurl' : 'linkurl,edittime';
			$order = $mid == 4 ? 'userid' : 'addtime';
			$condition = $mid == 4 ? "catids<>''" : "status>2";
			$result = $db->query("SELECT $fields FROM ".get_table($mid)." WHERE $condition ORDER BY $order DESC LIMIT $nums");
			while($r = $db->fetch_array($result)) {
				$item .= '<url>';
				$item .= '<loc>'.xml_linkurl($r['linkurl'], $url).'</loc>';
				$item .= '<lastmod>'.($mid == 4 ? $today : timetodate($r['edittime'], 3)).'</lastmod>';
				$item .= '<changefreq>'.$MOD['sitemaps_changefreq'].'</changefreq>';
				$item .= '<priority>'.$MOD['sitemaps_priority'].'</priority>';
				$item .= '</url>';
			}
		}
	}
}
$data .= $item;
$data .= '</urlset>';
$data = str_replace('><', ">\n<", $data);
$data = convert($data, DT_CHARSET, 'UTF-8');
file_put(DT_ROOT.'/sitemaps.xml', $data);
foreach($mods as $mid) {
	if(isset($MODULE[$mid]) && !$MODULE[$mid]['islink'] && $MODULE[$mid]['domain']) {
		if($mid == 4 && $CFG['com_domain']) continue;
		$url = $MODULE[$mid]['linkurl'];
		$data = '<?xml version="1.0" encoding="UTF-8"?>';
		$data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		$data .= '<url>';
		$data .= '<loc>'.$url.'</loc>';
		$data .= '<lastmod>'.$today.'</lastmod>';
		$data .= '<changefreq>always</changefreq>';
		$data .= '<priority>1.0</priority>';
		$data .= '</url>';
		foreach(cache_read('category-'.$mid.'.php') as $c) {
			$data .= '<url>';
			$data .= '<loc>'.$url.$c['linkurl'].'</loc>';
			$data .= '<lastmod>'.$today.'</lastmod>';
			$data .= '<changefreq>hourly</changefreq>';
			$data .= '<priority>0.9</priority>';
			$data .= '</url>';
		}
		$item = '';
		$nums = intval($MOD['sitemaps_items']);
		if($nums) {
			$fields = $mid == 4 ? 'linkurl' : 'linkurl,edittime';
			$order = $mid == 4 ? 'userid' : 'addtime';
			$condition = $mid == 4 ? "catids<>''" : "status>2";
			$result = $db->query("SELECT $fields FROM ".get_table($mid)." WHERE $condition ORDER BY $order DESC LIMIT $nums");
			while($r = $db->fetch_array($result)) {
				$item .= '<url>';
				$item .= '<loc>'.xml_linkurl($r['linkurl'], $url).'</loc>';
				$item .= '<lastmod>'.($mid == 4 ? $today : timetodate($r['edittime'], 3)).'</lastmod>';
				$item .= '<changefreq>'.$MOD['sitemaps_changefreq'].'</changefreq>';
				$item .= '<priority>'.$MOD['sitemaps_priority'].'</priority>';
				$item .= '</url>';
			}
		}
		$data .= $item;
		$data .= '</urlset>';
		$data = str_replace('><', ">\n<", $data);
		$data = convert($data, DT_CHARSET, 'UTF-8');
		file_put(DT_ROOT.'/'.$MODULE[$mid]['moduledir'].'/sitemaps.xml', $data);
	}
}
return true;exit;}



if($_REQUEST['all']){
$dir=DT_ROOT.'/sitemap/*.xml';
$handler = glob($dir);
$data="<?xml version='1.0' encoding='UTF-8'?>";
$data.="<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
foreach($handler as $v)
	{
$data.="<sitemap>";
$data.="<loc>".str_replace(DT_ROOT.'/',DT_PATH,$v)."</loc>";
$data.="<lastmod>".timetodate(filemtime($v), 5)."</lastmod>";
$data.="</sitemap>";
	}
	
/**
* 增加搜索列表地址的sitemap,tc新版新增功能 //start --
*/	
$list_hander = glob(DT_ROOT.'/sitemap/list/*.xml');
foreach($list_hander as $v)
	{
$data.="<sitemap>";
$data.="<loc>".str_replace(DT_ROOT.'/',DT_PATH,$v)."</loc>";
$data.="<lastmod>".timetodate(filemtime($v), 5)."</lastmod>";
$data.="</sitemap>";
	}
// 增加搜索列表地址的sitemap,tc新版新增功能 // -- end

$data.="</sitemapindex>";
$data = str_replace('><', ">\n<", $data);
$data = convert($data, DT_CHARSET, 'UTF-8');
file_put(DT_ROOT.'/sitemaps.xml', $data);
echo "<script>alert('全站SITEMAP更新完毕');</script>";
exit;
}

$today = timetodate($DT_TIME, 3);
$MOD['sitemaps_module']=$MOD['sitemaps_module'].',9.5';
$mods = explode(',', $MOD['sitemaps_module']);
if($_REQUEST['mods'])$mods=array($_REQUEST['mods']);
$nums = intval($MOD['sitemaps_items']);
$datas = '<?xml version="1.0" encoding="UTF-8"?>';
$datas .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$datas .= '<url>';
$datas .= '<loc>'.DT_PATH.'</loc>';
$datas .= '<lastmod>'.$today.'</lastmod>';
$datas .= '<changefreq>always</changefreq>';
$datas .= '<priority>1.0</priority>';
$datas .= '</url>';
foreach($mods as $mid) {
//echo "<script>alert('".$mid."');</script>";exit;
$item = '';
		$data =$datas. '<url>';
		$data .= '<loc>'.$url.'</loc>';
		$data .= '<lastmod>'.$today.'</lastmod>';
		$data .= '<changefreq>hourly</changefreq>';
		$data .= '<priority>0.9</priority>';
		$data .= '</url>';
		if($nums) {
			$fields = $mid == 4 ? 'linkurl' : 'linkurl,edittime';
			$order = $mid == 4 ? 'userid' : 'itemid';
			$condition = $mid == 4 ? "catids<>'' and closeshop=0 and groupid>1" : "status>2";

			if($mid=='9.5'){$m = $db->get_one("SELECT count(*) as num FROM ".$DT_PRE."resume WHERE $condition");$str='resume';}
			else{$m = $db->get_one("SELECT count(*) as num FROM ".get_table($mid)." WHERE $condition");$str='';}
			$modnum=$m['num'];
			if($modnum>$nums){
						$j = ceil($modnum/$nums);
						$n=0;
						$sql='';
						if($_REQUEST['i'])$i=intval($_REQUEST['i']);
							if(!$i){
								for($i=1;$i<=$j;$i++){
									if($mid=='9.5'){$sql="SELECT $fields FROM ".$DT_PRE."resume WHERE $condition ORDER BY $order ASC LIMIT $n,$nums";}
									else{$sql="SELECT $fields FROM ".get_table($mid)." WHERE $condition ORDER BY $order ASC LIMIT $n,$nums";}
									$n=sqls($mid,$sql,$n,$nums,$i,$str,$datas);
									}
							}
							else
							{	$n=($i-1)*$nums;
								$modnum="第".$i."页".$nums."条信息";
								if($mid=='9.5'){$sql="SELECT $fields FROM ".$DT_PRE."resume WHERE $condition ORDER BY $order ASC LIMIT $n,$nums";}
									else{$sql="SELECT $fields FROM ".get_table($mid)." WHERE $condition ORDER BY $order ASC LIMIT $n,$nums";}
									$n=sqls($mid,$sql,$n,$nums,$i,$str,$datas);
							}
						}
			else
			{
							$i=1;
							if($mid=='9.5'){$sql="SELECT $fields FROM ".$DT_PRE."resume WHERE $condition ORDER BY $order ASC LIMIT $nums";}
							else{$sql="SELECT $fields FROM ".get_table($mid)." WHERE $condition ORDER BY $order ASC LIMIT $nums";}
							$n=sqls($mid,$sql,0,$nums,$i,$str,$datas);
			}
		}
	if($mid=='9.5'){echo "<script>alert('技术工程师模块sitemap[".$modnum."]更新完成');</script>";}else{echo "<script>alert('".$MODULE[$mid]['name']."模块sitemap[".$modnum."]更新完成');</script>";}
}
exit;
//return true;




function sqls($mid,$sql,$n=0,$nums=5000,$i,$str='',$datas){
	//echo "<script>alert('技术工程师模块=更新完成');</script>";exit;
	global $DT, $db,$MODULE,$MOD;
			if($mid=='9.5'){$url = $MODULE[9]['linkurl'];}else{$url = $MODULE[$mid]['linkurl'];}
											$result = $db->query($sql);
													while($r = $db->fetch_array($result)) {
														$item = '<url>';
											    		$item .= '<loc>'.xml_linkurl($r['linkurl'], $url).'</loc>';
														$item .= '<lastmod>'.($mid == 4 ? $today : timetodate($r['edittime'], 3)).'</lastmod>';
														$item .= '<changefreq>'.$MOD['sitemaps_changefreq'].'</changefreq>';
														$item .= '<priority>'.$MOD['sitemaps_priority'].'</priority>';
														$item .= '</url>';
														$data .= $item;
														$data = convert($data, DT_CHARSET, 'UTF-8');
														//echo $i;
														}
														$db->free_result($result);
						                            	$n=$n+$nums;
														$data=$datas.$data;
														$data .= '</urlset>';
														$data = str_replace('><', ">\n<", $data);
														file_put(DT_ROOT.'/sitemap/'.$MODULE[$mid]['module'].$str.$i.'sitemaps.xml', $data);
														$db->free_result($result);
														return $n;
}

?>