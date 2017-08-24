<?php
namespace models\helpers\widget\nlp;

defined('IN_DESTOON') or exit('Access Denied');
//scws分词处理工具，使用需要开启scws拓展
class scws {
	protected $scws;
	public $word;
	
	function __construct($str='',$charset='utf8'){
		if(!function_exists('scws_new'))	return false;  //scws扩展未开启
		$this->scws = scws_new();
		$this->scws->set_charset($charset);
		$this->word = $str;
	}
	
	public function checkScwsExist(){
		return is_null($this->scws) ? false : true;
	}
	
	public function setWord($str = ''){
		$this->word = $str;
	}
	
	public function getSeg(){
		$this->scws->send_text($this->word);
		$arr = array();
		while($temp = $this->scws->get_result()){
			foreach($temp as $k => $v){
				//$length = mb_strlen($v['word'],$charset);
				//if($length < 2) continue;
				$arr[] = $v['word'];
			}
		}
		if(empty($arr)) $arr[] = $str;
		return $arr;
	}
	
	//只获取指定词性的分词
	public function getSegByAttr($attr = ''){
		if(empty($attr)) return $this->getSeg();
		
		$this->scws->send_text($this->word);
		$arr = array();
		while($temp = $this->scws->get_result()){
			foreach($temp as $k=>$v){
				if($v['attr'] == $attr) $arr[] = $v['word'];
			}
		}
		return $arr;
	}
	
	function __destruct(){
		if(!empty($this->scws)) $this->scws->close();
	}

}
?>