<?php
namespace models\module;

use models\module\baseModule;

//科室模块模型类，封装业务逻辑操作
class keywordModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 16;
		$this->modulename = '热词';
		$this->linkurl = $MODULE[16]['linkurl'];
	}
	
	//科室模块伪静态地址重写
	public function searchRewrite($selector){
		//伪静态地址处理 so-catid-typeid-areaid-validated-page.html
		$kwid = isset($selector['kwid']) ? '-'.$selector['kwid'] : '-0' ;
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'kw'.$kwid.$areaid.$page.'.html';
	}
}


?>