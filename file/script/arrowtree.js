$(document).ready(function(){
var tree1;var tree2;
    $('.sidelist').mousemove(
	function(){
	var _div=$(this).find('.i-list');
	var _divh3=$(this).find('h3');
	_div.show();
	_divh3.removeClass('treeout');_divh3.addClass('treehover');
	//tree1=window.setTimeout(function(){_div.show();
	//_divh3.removeClass('treeout');_divh3.addClass('treehover');
	//},80);
		}
	);

	$('.sidelist').mouseleave(
		   
	function(){
	var _div=$(this).find('.i-list');
	var _divh3=$(this).find('h3');	 
	_div.hide();
	_divh3.removeClass('treehover');_divh3.addClass('treeout');
	//tree2=window.setTimeout(function(){_div.hide();
	//_divh3.removeClass('treehover');_divh3.addClass('treeout');
	//},80);
	}
	);
});
//开发者:93645493 欢迎咨询网站技术问题//
