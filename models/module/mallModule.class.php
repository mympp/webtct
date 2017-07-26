<?php
namespace models\module;

use models\module\baseModule;

//企业模块模型类，封装业务逻辑操作
class mallModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 16;
		$this->modulename = $MODULE[$this->moduleid]['name'];
		$this->linkurl = $MODULE[$this->moduleid]['linkurl'];
	}
	
	//企业模块伪静态地址重写
	public function searchRewrite($selector){
		//存在以下参数的地址使用动态地址
		if(isset($selector['kw'])){
			return 'search.php?'.http_build_query($selector);
		}else{
		//伪静态地址处理 so-catid-stype-areaid-validated-page.html
			$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0' ;
			$stype = isset($selector['stype']) ? '-'.$selector['stype'] : '-0';
			$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
			$validated = isset($selector['validated']) ? '-'.$selector['validated'] : '-0' ;
			$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
			return 'so'.$catid.$stype.$areaid.$validated.$page.'.html';
		}
	}
}
?>