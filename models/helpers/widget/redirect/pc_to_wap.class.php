<?php
namespace models\helpers\widget\redirect;

//处理从PC端主动验证使用设备，如果符合移动设备判断，主动跳转到wap网站对应页面
class pc_to_wap extends baseRedirect{
	
	//指定地址直接跳转
	public static function forword($url){
		$self = new self();
		
		$forword = '';
		if(strpos($url,'http://')!== false || strpos($url,'https://')!== false ){
			$forword = $url;
		}else{
			$forword = $self->wap_host.$url;
		}
		
		if(!$self->isMobile()){
			return $forword;
		}else{
			header('Location:'.$forword);
			exit;
		}
	}
	
	//根据参数由模块器处理跳转
	public static function forwordByParms(){
		
	}
}


?>