<?php

class IndexController {
	
	public function index(){
		$mall = new tcdb('mall');
		$product = $mall->field('itemid,title,thumb')->where(['status'=>3,'username'=>USERNAME])->limit(0,8)->order('itemid asc')->all();
		
		$header_css = ['./css/remai.index.css'];
		$footer_js = ['./js/remai.index.js'];
		
		require '/template/index.php';
	}

/*
   public function index($request, $response, $args){
		var_dump($request->getAttribute('name'));
   }
   */
}

?>