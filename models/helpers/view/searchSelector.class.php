<?php
namespace models\helpers\view;

//搜索页面条件选择框工具
class searchSelector{
	
	private $selectedKey ;	//选择器已选择键值数据
	private $selectedValue; //选择器已选址内容数据
	private $selectedTip;	//选择器被选中标记
	private $linkTemplate;	//A标签title模版
	private $linkSelected;	//A标签已选内容
	private $linkDefault;	//A标签默认显示内容
	private $module;	    //选择器所用module
	
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
	
	//获取标签title内容
	private function getLinkTitle($key = '',$value = ''){
		$template = $this->linkTemplate;
		foreach($this->linkSelected as $k => $v){
			if($k == $key){
				$template = str_replace("{{$key}}",$value,$template);
			}else{
				$template = str_replace("{{$k}}",$v,$template);
			}
		}
		return $template;
	}
	
	//获取A标签地址
	private function getLinkUrl($selector){
		if(!is_array($selector)) return '';
		if(empty($this->module)) return '';
		if(method_exists($this->module,'searchRewrite')){
			return $this->module->searchRewrite($selector);
		}else{
			return 'search.php?'.http_build_query($selector);
		}
	}

	//设置module
	public function setModule($module){
		$this->module = $module;
	}
	
	/**
	* 设置A标签显示内容
	* @param 显示模版 $template
	* @param 默认显示内容 $default
	* @return string
	*/
	public function setLinkTitle($template,$default){
		$this->linkTemplate = $template;
		$this->linkDefault = $default;
		
		$d = [];
		foreach($default as $k => $v){
			if(!empty($this->selectedKey[$k])){
				$d[$k] = $this->selectedValue[$k];
			}else{
				$d[$k] = $v;
			}
		}
		$this->linkSelected = $d;
	}
	
	//设置已被选择数据
	public function setSelectedKey($data){
		$this->selectedKey = $data;
	}
	
	public function setSelectedValue($data){
		$this->selectedValue = $data;
	}
	
	//选中标记
	public function setCurrentTip($tip){
		if(is_array($tip)){
			$this->selectedTip = $this->additions($tip);
		}else{
			$this->selectedTip = $tip;
		}
	}
	
	//选择框开始
	public function begin($additions = []){
		return "<div {$this->additions($additions)}>";
	}
	
	//选择框结束
	public function end(){
		return '</div>';
	}
	
	//选择框选项
	public function item($key,$title,$data,$additions = []){
		$back = '';
		$back .= "<div {$this->additions($additions)}>";
		$back .= $this->title($title);
		$back .= $this->option($key,$data);
		$back .= "</div>";
		return $back;
	}
	
	//选框提示标题
	public function title($title){
		if(!is_array($title)) return '';
		$title_name = '';
		$additions_str = '';
		$i = 0;
		foreach($title as $k => $v){
			if($i == 0){
				$title_name = $v;
			}else{
				$additions_str = $this->additions([$k => $v]);
			}
			$i++; 
		}
		return "<div $additions_str><span>$title_name".'：</span></div>';
	}
	
	//选择框选择条
	public function option($key,$options,$second_options = null){
		
		if(!is_array($options)) return '';
		if(!isset($options['data']) || !is_array($options['data'])) return '';
		$back = '';
		
		$addition_str = '';
		if(isset($options['additions']))	$addition_str = $this->additions($options['additions']);
		$back .= "<div $addition_str>";
		
		$back .= $this->ul($key,$options);
		if(isset($second_options)) $back .= $this->ul($key,$second_options);
		
		$back .= "</div>";
		
		if(isset($options['button'])){
			$value = $options['button']['value'];
			$href = $options['button']['href'];
			$additions = $options['button'][0];
			$back .= "<a href=\"$href\" {$this->additions($additions)}>$value</a>";
		}	
		return $back;
	}
	
	public function ul($key,$options){
		$back = '';
		
		$ul_addition = '';
		if(isset($options['ul']))	$ul_addition = $this->additions($options['ul']);
		$back .= "<ul $ul_addition>";
		
		$li_addition = '';
		if(isset($options['ul']))	$li_addition = $this->additions($options['li']);
		$a_addition = '';
		if(isset($options['a']))	$a_addition = $this->additions($options['a']);
		
		//不限按钮
		if(!isset($options['closeUnlimitButton'] )){
			$selectedTip = empty($this->selectedKey[$key]) ? $this->selectedTip : '';
			$back .= "<li $li_addition $selectedTip>";
			$title = $this->getLinkTitle($key,$this->linkDefault[$key]);
			$selectedKey = $this->selectedKey;
			$selectedKey[$key] = 0;
			$href = $this->getLinkUrl($selectedKey);
			$back .= "<a href=\"$href\" title=\"$title\" $a_addition>不限</a>";
			$back .= "</li>";
		}
		
		foreach($options['data'] as $k => $v){
			$selectedTip =( (!empty($this->selectedKey[$key]) ) && ( $this->selectedKey[$key] == $k) ) ? $this->selectedTip : '';
			$back .= "<li $li_addition $selectedTip>";
			$title = $this->getLinkTitle($key,$v);
			$selectedKey = $this->selectedKey;
			$selectedKey[$key] = $k;
			$href = $this->getLinkUrl($selectedKey);
			$back .= "<a href=\"$href\" title=\"$title\" $a_addition>$v</a>";
			if(isset($options['overlapping'])){	//开启交叉按钮
				$title = $this->getLinkTitle($key,$this->linkDefault[$key]);
				$selectedKey[$key] = 0;
				$href = $this->getLinkUrl($selectedKey);
				$a_addition = $this->additions($options['overlapping']);
				$back .= "<a href=\"$href\" title=\"$title\" {$this->additions($options[overlapping])}>×</a>";
			}
			$back .= "</li>";
		}
		
		$back .= "</ul>";
		return $back;
	}
	
	//二级选择条
	public function secondItem($key,$title,$first_data,$second_data,$additions = []){
		$back = '';
		$back .= "<div {$this->additions($additions)}>";
		$back .= $this->title($title);
		$back .= $this->option($key,$first_data,$second_data);
		$back .= "</div>";
		return $back;
	}
	
	//提交表单
	public function form($key,$form,$from_div){
		$back = '';
		$back .= "<div {$this->additions($from_div)}>";
		$back .= "<form action=\"$form[action]\" method=\"$form[method]\" {$this->additions($form[additions])}>";
		foreach($this->selectedKey as $k => $v){
			if($k != $key)	$back .= "<input type=\"hidden\" name=\"$k\" value=\"{$v}\" />";
		}
		$value = empty($this->selectedKey[$key]) ? '' : $this->selectedKey[$key];
		$back .= "<input type=\"text\" name=\"$key\" value=\"{$value}\" {$this->additions($form[text])} />";
		$back .= "<input type=\"submit\" {$this->additions($form[submit])} />";
		$back .= "</form>";
		$back .= "</div>";
		return $back;
	}
	
	//搜索框
	public function searchInput($key,$title,$form,$form_div = null,$input_dive = null){
		$back = '';
		$back .= "<div {$this->additions($input_dive)}>";
		$back .= $this->title($title);
		$back .= $this->form($key,$form,$form_div);
		$back .= "</div>";
		return $back;
	}
}
?>