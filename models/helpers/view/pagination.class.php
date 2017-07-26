<?php
namespace models\helpers\view;

//新版分页按钮
class pagination{
	
	private $page;
	private $pagesize;
	private $items;
	private $module;
	private $currentTip = '';	//当前页面按钮标记
	private $maxPage;		//最大分页数目
	private $midButtonNum = 5;
	
	/**
	* 构造方法
	* @param 当前页数 $page
	* @param 所有数目 $items
	* @param 每页大小 $pagesize
	* @return
	*/
	function __construct($page,$items,$pagesize){
		$this->page = $page;
		$this->items = $items;
		$this->pagesize = $pagesize;
		$this->maxPage = ($items%$pagesize) > 0 ? ((int)($items/$pagesize) + 1) : ((int)($items/$pagesize));	//最大分页页数
	}
	
	
	//处理附加信息
	private function additions($additions){
		$additions_str = '';
		if(!empty($additions)){
			foreach($additions as $k=>$v){
				$additions_str .= " $k=\"$v\"";
			}
		}
		return $additions_str;
	}
	
	//分页按钮地址
	private function getLinkUrl($page,$params = []){
		if(!empty($this->module) && method_exists($this->module,'searchRewrite')){
			//存在模块下的地址改写方法
			$params['page'] = $page;
			return $this->module->searchRewrite($params);
		}else{
			//返回动态地址
			$params['page'] = $page;
			return http_build_query($params);
		}
	}	
	
	private function getButton($page,$value,$params = null,$additions = null,$current = false){
		$on = $current ? $this->currentTip : '';
		return "<li {$this->additions($additions[li])} ><a href=\"{$this->getLinkUrl($page,$params)}\" {$this->additions($additions[a])} $on >$value</a></li>";
	}
	
	//上一页按钮
	private function getPrevButton($params = null,$additions = null){
		if($this->page == 1) return '';
		$prev_value = empty($additions['prev']['value']) ? '上一页' : $additions['prev']['value'];
		if(!empty($additions['prev'])){
			$a = array_merge($additions['li'],$additions['prev']);
			$additions['li'] = $a;
		}
		return $this->getButton(($this->page - 1),$prev_value,$params,$additions);
	}
	
	//省略按钮
	private function getEllipsisButton($additions = null){
		$value = empty($additions['ellipsis']['value']) ? '...' : $additions['ellipsis']['value'];
		return "<li {$this->additions($additions[li])} {$this->additions(['ellipsis']['additions'])}>$value</li>";
	}
	
	//中间按钮段落
	private function getMiddleButton($params = null,$additions = null){
		$back = '';
		$count = 0;
		$start = $this->page - $this->midButtonNum;
		$font_key = false;	//前省略号标志
		$back_key = false;	//后省略号标志
		
		//首页按钮
		if($this->page > ($this->midButtonNum + 1) ){
			$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) : $linkurl.'?'.http_build_query($params);
			$back .= $this->getButton(1,1,$params,$additions);
			$count++;
		}
		for($start;$start <= $this->maxPage;$start++){
			if($start < 1) continue;
			$on = $this->page == $start ? true : false;
			if(($start + (floor($this->midButtonNum/2))) < $this->page && $start != 1){
				if($font_key) continue;
				$back .= $this->getEllipsisButton($additions);
				$font_key = true;
			}elseif($start == $this->maxPage){
				$back .= $this->getButton($start,$start,$params,$additions,$on);
			}elseif(($start - ceil($this->midButtonNum/2))> $this->page && $count>$this->midButtonNum){
				$back .= $this->getButton($this->maxPage,$this->maxPage,$params,$additions,$on);
			}elseif(($start-(floor($this->midButtonNum / 2)))> $this->page && $count>($this->midButtonNum - 1)){
				if($back_key) continue;
				$back .= $this->getEllipsisButton($additions);
				$back_key = true;
			}else{
				$back .= $this->getButton($start,$start,$params,$additions,$on);
			}
			$count++;
			$limit = $this->page > ($this->midButtonNum - 1) ? ($this->midButtonNum + 3): ($this->midButtonNum + 1);
			if($count > $limit) break;
		}
		
		return $back;
	}
	
	//下一页按钮
	private function getNextButton($params = null, $additions = null){
		if(!($this->page < $this->maxPage)) return '';
		$next_value = empty($additions['next']['value']) ? '下一页' : $additions['next']['value'];
		if(!empty($additions['prev'])){
			$a = array_merge($additions['li'],$additions['next']);
			$additions['li'] = $a;
		}
		return $this->getButton(($this->page + 1),$next_value,$params,$additions);
	}
	
	//跳转按钮
	private function getSubmitButton($params = null,$additions = null){
		$back = '';
		if(!empty($params)){
			foreach($params as $k=>$v){
				$back .= "<input type=\"hidden\" name=\"$k\" value=\"$v\" />";
			}	
		}
		$back .= '<li>转到</li>';
		$page_name = empty($additions['submit']['name']) ? 'page' : $additions['submit']['name'];
		$back .= "<li><input type=\"text\" name=\"$page_name\" /></li>";
		$back .= '<li>页</li>';
		$page_name = empty($additions['submit']['value']) ? '确定' : $additions['submit']['value'];
		$back .= "<li><input type=\"submit\" value=\"$page_name\"></li>";
		return $back;
	}
	
	//设置中间按钮数目
	public function setMiddleButtonNum($num){
		if(is_int($num)) $this->midButtonNum = $num;
	}
	
	//设置模块操作类
	public function setModule($module){
		if(!is_object($module)) return false;
		$this->module = $module;
	}
	
	//设置选中标记
	public function setCurrentTip($tip){
		if(is_array($tip)){
			$this->currentTip = $this->additions($tip);
		}else{
			$this->currentTip = $tip;
		}
	}
	
	/**
	* 显示分页按钮
	* @param string $linkurl,按钮跳转地址
	* @param array $form ,显示html附件内容，可以指定内容有div,form,ul,li,a,prev,next,ellipsis,submit
	* @param array $params,附加参数内容
	* @return string
	*/
	public function show($linkurl,$form,$params){
		if($this->items <= $this->pagesize) return '';	//总数目不足够分页，返回空字符
		$back = '';
		$back .= "<div {$this->additions($form[div])}>";
		$back .= "<form action=\"$linkurl\" {$this->additions($form[form])}>";
		
		$back .= "<ul {$this->additions($form[ul])}>";
		$back .= $this->getPrevButton($params,$form);
		$back .= $this->getMiddleButton($params,$form);
		$back .= $this->getNextButton($params,$form);
		$back .= "</ul>";
		
		$back .= "<ul {$this->additions($form[ul])}>";
		$back .= $this->getSubmitButton($params,$form);
		$back .= "</ul>";
		
		$back .= "</form>";
		$back .= "</div>";
		
		return $back;
	}

}
?>
