<?php
namespace models\module;

use models\module\baseModule;

//共享模块模型类，封装业务逻辑操作
class downModule extends baseModule{
	
	function __construct(){
		global $MODULE;
		$this->moduleid = 15;
		$this->modulename = $MODULE[$this->moduleid]['name'];
		$this->linkurl = $MODULE[$this->moduleid]['linkurl'];
	}
	
	//供需模块伪静态地址重写
	public function searchRewrite($selector){
		if(!empty($selector['kw']) || !empty($selector['order']))	return 'search.php?'.http_build_query($selector);
		$catid = empty($selector['catid']) ? '0' : $selector['catid'];
		$fileext = empty($selector['fileext']) ? '' : '-'.$selector['fileext'];
		$page = empty($selector['page']) ? '-1' : '-'.$selector['page'];
		if($page == '-1' && empty($fileext)) $page = '';
		return 'so-'.$catid.$page.$fileext.'.html';
	}
}


?>