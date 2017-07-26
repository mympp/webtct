function addFavorite(){		//页面收藏方法
	if(document.all){
		window.external.addFavorite('http://so.tecenet.com/','天成医搜');
	}else if(window.sidebar){
		window.sidebar.addPanel('天成医搜','http://so.tecenet.com/');
	}else{
		alert('您的浏览器不支持系统进行页面收藏,请按 Ctrl+D 将页面收藏！');	
	}
}


