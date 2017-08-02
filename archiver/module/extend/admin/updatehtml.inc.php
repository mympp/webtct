<table>
	<tr>
		<td>文件名</td>
		<td>操作</td>
	</tr>
	<tr>
		<td>产品首页菜单</td>
		<td>
			<a href="?moduleid=3&file=updatehtml&filename=mall_leftmenu&action=update">生成/更新</a> 
			<a href="?moduleid=3&file=updatehtml&filename=mall_leftmenu&action=delete">删除</a>
		</td>
	</tr>
	<tr>
		<td>首页统计</td>
		<td>
			<a href="?moduleid=3&file=updatehtml&filename=index_count&action=update">生成/更新</a> 
			<a href="?moduleid=3&file=updatehtml&filename=index_count&action=delete">删除</a>
		</td>
	</tr>
	<tr>
		<td>服务地区</td>
		<td>
			<a href="?moduleid=3&file=updatehtml&filename=service_area&action=update">生成/更新</a> 
			<a href="?moduleid=3&file=updatehtml&filename=service_area&action=delete">删除</a>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<a href="?moduleid=3&file=updatehtml&action=update_all">一键生成/更新</a> 
			<a href="?moduleid=3&file=updatehtml&action=delete_all">一键删除</a>
		</td>
	</tr>
</table>
<?php
define('DT_SOURCE', DT_ROOT.'/module/source/');
define('DT_UPDATE_HTML', DT_ROOT.'/template/tc/tecenet/html/');
error_reporting(E_ALL);
global $filecontent;
if(isset($filename)&&isset($action)){
	$resource = DT_SOURCE.$filename.'.php';	
	if($filename=='mall_leftmenu'){
		$moduleid = 16;
		$module = 'mall';
		require_once $resource;
		make_file($filename,$action,$filecontent,'16','mall');
	}else{
		require_once $resource;
		make_file($filename,$action,$filecontent);
	}
}else if(isset($action)){
	$file_array = array(
		'mall_leftmenu',
		'index_count',
		'service_area',);
	if($action=="update_all"){
		$action = 'update';
		foreach ($file_array as $key => $file) {
			$resource = DT_SOURCE.$file.'.php';
			require_once $resource; 
			if($file=='mall_leftmenu'){
				make_file($file,$action,$filecontent,'16','mall');
			}else{
				make_file($file,$action,$filecontent);
			}
		}
	}else if($action=="delete_all"){
		$action = 'delete';
		foreach ($file_array as $key => $file) {
			if($file=='mall_leftmenu'){
				make_file($file,$action,'16','mall');
			}else{
				make_file($file,$action);
			}
		}
	}
}

function make_file($filename,$action,$filecontent='',$moduleid='',$module=''){
	$filename = DT_UPDATE_HTML.$filename.'.htm';
	if($action=='update'){
		if(is_file($filename)){
			$str = "更新";
		}else{
			$str = "生成";
		}
		$file = fopen($filename,'w');
		fwrite($file, $filecontent);
		fclose($file);
		echo $filename.$str."成功<br>";
	}else if($action=='delete'){
		if(is_file($filename)){
			$file = fopen($filename, 'w');
			$data = file_get_contents($filename);
			fclose($file);
			if(!$data){
				echo $filename.'删除成功<br>';
			}
		}else{
			echo "没有".$filename.'文件，请生成<br>'; 
		}
	}
}


/*require DT_SOURCE.'index_count.php';
$file = fopen(DT_UPDATE_HTML.'index_count.htm','w');
fwrite($file, $filecontent);
fclose($file);*/

/*require DT_SOURCE.'internal_brand_list.php';
$file = fopen(DT_UPDATE_HTML.'internal_brand_list.htm','w');
fwrite($file, $filecontent);
fclose($file);

require DT_SOURCE.'foreign_brand_list.php';
$file = fopen(DT_UPDATE_HTML.'foreign_brand_list.htm','w');
fwrite($file, $filecontent);
fclose($file);*/

/*require DT_SOURCE.'service_area.php';
$file = fopen(DT_UPDATE_HTML.'service_area.htm','w');
fwrite($file, $filecontent);
fclose($file);*/
?>
