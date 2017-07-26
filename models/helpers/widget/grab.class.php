<?php
namespace models\helpers\widget;

use models\helpers\widget\curl;

class grab extends curl{
	
	protected $fontpre = '';
	protected $backpre = '';
	
	public function setFontPre($str){
		$this->fontpre = $str;
	}
	
	public function setBackPre($str){
		$this->backpre = $str;
	}
	
	public function setGrabPre($fontPre,$backPre){
		$this->setFontPre($fontPre);
		$this->setBackPre($backPre);
	}
	
	public function getGrab($url,$data = []){
		$result = $this->curl_https($url,$data);
		if(empty($this->fontpre) || empty($this->backpre)) return $result;
		$fontstart = strpos($result,$this->fontpre);	//前缀开始位置
		if($fontstart === false) return '';
		$fontend = strlen($this->fontpre) + $fontstart;
		$backstart = strpos($result,$this->backpre);
		if($backstart === false) return '';
		return trim(strip_tags(substr($result,$fontend,($backstart-$fontend))));
	}
	
}
?>