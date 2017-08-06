<?php
namespace models\module;

use models\module\baseModule;

//招标模块模型类，封装业务逻辑操作
class buyModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 6;
		$this->modulename = '招标';
		$this->linkurl = $MODULE[6]['linkurl'];
	}
	
	//招标模块伪静态地址重写
	public function searchRewrite($selector){
		if(isset($selector['kw']) || isset($selector['order']) || isset($selector['typeid']))	return 'search.php?'.http_build_query($selector);
		$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0';
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0';
		$page = isset($selector['page']) ? '-'.$selector['page'] : '';
		return 'so'.$catid.$areaid.$typeid.$page.'.html';
	}
}


?>