<?php
function downloadImageFromQzone($url,$filename)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);

    curl_close($ch);
    $imageAll = array_merge(array('imgBody' => $package), $httpinfo);

    $imageExt = (0 < preg_match('{image/(\w+)}i', $imageAll["content_type"], $extmatches))? $extmatches[1]: "jpeg";
	if (preg_match('{(jpg|jpeg|png|gif|webp)$}i', $imageExt) == 0){ //非jpg,jpeg,png格式
	    $imageExt = "不支持类型";
	}else{
		//本地操作
		$filename = '/var/www/html/file/upload/weixin/image/'.$filename.'.'.$imageExt;
		$local_file = fopen($filename,'w');
		if (false !== $local_file){
		    if (false !== fwrite($local_file, $imageAll["imgBody"])) {
		        fclose($local_file);
		    }
		}
	}
    return $imageExt;
}
//返回服务器图片地址
function downloadAndImage($url,$filename)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);

    curl_close($ch);
    $imageAll = array_merge(array('imgBody' => $package), $httpinfo);

    $imageExt = (0 < preg_match('{image/(\w+)}i', $imageAll["content_type"], $extmatches))? $extmatches[1]: "jpeg";
    if (preg_match('{(jpg|jpeg|png|gif|webp)$}i', $imageExt) == 0){ //非jpg,jpeg,png格式
        $imageExt = "不支持类型";
    }else{
        // 新的服务器图片地址
        $imageURL = 'www.tecenet.com/file/upload/weixin/image/'.$filename.'.'.$imageExt;
        //本地操作
        //$filename = '/var/www/html/file/upload/weixin/image/'.$filename.'.'.$imageExt;
        $filename = '/data/tcsftp/www/html/file/upload/weixin/image/'.$filename.'.'.$imageExt;
        $local_file = fopen($filename,'w');
        if (false !== $local_file){
            if (false !== fwrite($local_file, $imageAll["imgBody"])) {
                fclose($local_file);
            }
        }
    }
    return $imageURL;
}

?>
