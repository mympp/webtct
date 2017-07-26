<?php
namespace models\module;

use models\module\baseModule;

//企业模块模型类，封装业务逻辑操作
class companyModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 4;
		$this->modulename = $MODULE[$this->moduleid]['name'];
		$this->linkurl = $MODULE[$this->moduleid]['linkurl'];
	}
	
	//企业模块伪静态地址重写
	public function searchRewrite($selector){
		//存在这两个参数的地址使用动态地址
		if(isset($selector['kw']) || isset($selector['vip'])){
			return 'search.php?'.http_build_query($selector);
		}else{
		//伪静态地址处理 so-catid-areaid-mode-type-page.html
			$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0' ;
			$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
			$mode = isset($selector['mode']) ? '-'.$selector['mode'] : '-0' ;
			$type = isset($selector['type']) ? '-'.$selector['type'] : '-0' ;
			$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
			return 'so'.$catid.$areaid.$mode.$type.$page.'.html';
		}
	}
}
?>