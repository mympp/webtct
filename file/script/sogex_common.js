function addFavorite(){		//页面收藏方法
	if(document.all){
		window.external.addFavorite('http://'+window.location.host+'/search','天成医搜');
	}else if(window.sidebar){
		window.sidebar.addPanel('天成医搜','http://+'+window.location.host+'/search');
	}else{
		alert('您的浏览器不支持系统进行页面收藏,请手动将页面收藏！');	
	}
}


