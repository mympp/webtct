<?php

class ProductController {
	private $cat;
	
	function __construct(){

	}
	
	private function template(){
		$header_css = ['./css/remai.other.css'];
		$footer_js = ['./js/remai.other.js'];
		
		$type = new tcdb('type');
		$cat = $type->field('typeid,typename')->where(['item'=>'mall-'.USERID])->all();		//产品分类
		$mall = new tcdb('mall');
		$recom_prodcut = $mall->where(['username'=>USERNAME,'status'=>3])->order('itemid desc')->limit(0,4)->select();		//推荐产品
		
		$args = func_get_args();
		foreach($args as $k=>$v){
			foreach($v as $sk=>$sv){
				$name = $sk;
				$$name = $sv;		//以键值名申请变量
			}
		}
		unset($args);
		if(empty($product_cat)) $product_cat = $cat;
		if(!empty($template)) require $template;
	}
	
	public function plist(){
		$mall = new tcdb('mall');
		$product = $mall->field('itemid,title,thumb')->where(['status'=>3,'username'=>USERNAME])->limit(0,8)->order('itemid asc')->all();
		
		$this->template(['template'=>'/template/plist.php'],['product'=>$product]);

	}
	
	public function keyword($request, $response, $args){
		$kw = $request->getParsedBodyParam('kw');
		if(empty($kw)){
			$this->plist();
		}else{
			$mall = new tcdb('mall');
			$product = $mall->where(['status'=>3,'username'=>USERNAME])->likeWhere(['keyword'=>$kw])->all();
			
			$this->template(['template'=>'/template/plist.php'],['product'=>$product],['kw'=>$kw]);
		}
	}
	
	public function type($request, $response, $args){
		$typeid = $request->getAttribute('typeid');
		$typeid = (int)$typeid;
		if(empty($typeid) || !is_int($typeid)){
			$this->plist();
		}else{
			$mall = new tcdb('mall');
			$product = $mall->where(['status'=>3,'username'=>USERNAME,'mycatid'=>$typeid])->likeWhere(['keyword'=>$kw])->all();
			$type = new tcdb('type');
			$product_cat = $type->where(['typeid'=>$typeid])->one();
			
			$this->template(['template'=>'/template/plist.php'],['product'=>$product],['typeid'=>$typeid],['product_cat'=>[$product_cat]]);
		}
	}
	
	public function product($request,$response,$args){
		$itemid = $request->getAttribute('itemid');
		$itemid = (int)$itemid;
		if(empty($itemid)){
			$this->plist();
		}else{
			$mall = new tcdb('mall');
			$title = $mall->field('title')->where(['itemid'=>$itemid])->one();
			$mall_data = new tcdb('mall_data');
			$content = $mall_data->field('content')->where(['itemid'=>$itemid])->one();
			
			$this->template(['template'=>'/template/product.php'],$title,$content);
		}
	}

}

?>