<?php
namespace models\module;

use models\module\baseModule;

//科室模块模型类，封装业务逻辑操作
class keshiModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 12;
		$this->modulename = '科室';
		$this->linkurl = $MODULE[16]['linkurl'];
	}
	
	//科室模块伪静态地址重写
	public function searchRewrite($selector){
		//存在以下参数的地址使用动态地址
		if(isset($selector['kw'])){
			return 'keshi.php?'.http_build_query($selector);
		}else{
			//伪静态地址处理 so-catid-stype-areaid-validated-page.html
			$kcatid = '-0';
			if(isset($selector['kcatid'])){
				$kcatid = '-'.$selector['kcatid'];
			}elseif(isset($selector['catid'])){
				$kcatid = '-'.$selector['catid'];
			}

			$stype = isset($selector['stype']) ? '-'.$selector['stype'] : '-0';
			$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
			$validated = isset($selector['validated']) ? '-'.$selector['validated'] : '-0' ;
			$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
			return 'ks'.$kcatid.$stype.$areaid.$validated.$page.'.html';
		}
	}
}


?>