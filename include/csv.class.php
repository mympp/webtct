<?php
/*
date:2015-9-1
who:chentao
what:处理csv文件和数据的类
where:
relation:
*/
defined('IN_DESTOON') or exit('Access Denied');
class csv{

    function export_csv($filename,$data)   {     //下载csv文件
    	//print(chr(0xEF).chr(0xBB).chr(0xBF));
    	header('Content-Type:application/download;charset=UTF-8');
        header("Content-type:text/html");   
        header("Content-Disposition:attachment;filename=".$filename.'.csv');   
        header("Content-Encoding:binary");
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');
        header("Pragma:no-cache");
        echo chr(0xEF).chr(0xBB).chr(0xBF);
        
		//echo chr(239).chr(187).chr(191);// 加上bom头，系统自动默认为UTF-8编码
        //echo chr(239).chr(187).chr(191).$data;  
        echo $data;
 
    }  

	
	function output_csv($title,$sqlresult,$filename){  //导出数据为csv
		$str='';           //标题字符串
		foreach($title as $k=>$v){
			$str.=$v.',';
		}
		$str=substr($str,0,(strlen($str)-1));     //去掉最后的,
		$str.="\n";                 //不可写为'\n'
		//$str=iconv('utf-8','utf-16le',$str);
		$sstr='';          //数据字符串
		foreach($sqlresult as $value){
			foreach($value as $k=>$v){
				//$sstr.=iconv('utf-8','utf-16le',$v).',';
				$sstr.=$v.',';
			}
			$sstr=substr($sstr,0,(strlen($sstr)-1));     //去掉最后的,
			$sstr.="\n";			
		}
		$str.=$sstr;
		$this->export_csv($filename,$str);
	}
	
	function input_csv($files) {   //读取csv内容,$fiels可以为$_FILES['input_name']['tmp_name']
		$handle=fopen($files,'r');
		setlocale(LC_ALL, 'zh_CN');   //linux下解决中文乱码或不全问题
    	$out = array ();
    	$n = 0;
    	while ($data = fgetcsv($handle, 10000)) {
        	$num = count($data);
          	for ($i = 0; $i < $num; $i++) {
          		$out[$n][$i]=iconv('gb2312','utf-8',$data[$i]);
             	//  $out[$n][$i] = $data[$i];
          	}
          $n++;
    	 }
     	return $out;
	}
}
?>