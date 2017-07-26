<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_DESTOON') or exit('Access Denied');
class scws {
	protected $scws;
	public $word;
	
	function __construct($str='',$charset='utf8'){
		if(!function_exists('scws_new'))	return false;  //scws扩展未开启
		$this->scws = scws_new();
		$this->scws->set_charset($charset);
		$this->word = $str;
	}
	
	public function getSeg(){
		$this->scws->send_text($this->word);
		$arr = array();
		while($temp = $this->scws->get_result()){
			$count = count($temp);
			foreach($temp as $k => $v){
				$length = mb_strlen($v['word'],$charset);
				//if($length < 2) continue;
				$arr[] = $v['word'];
			}
		}
		if(empty($arr)) $arr[] = $str;
		return $arr;
	}
	
	public function close(){
		$this->scws->close();
	}
	
	public function setWord($str = ''){
		$this->word = $str;
	}
}
?>