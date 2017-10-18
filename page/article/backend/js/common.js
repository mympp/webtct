var nav = new Vue({
    el : '#navigation',
    data:{
        navigation :(function(){
            return '<nav class="navbar navbar-default" role="navigation">'+
                '<div class="container-fluid">'+
                '<div class="navbar-header">'+
                '<a class="navbar-brand" href="#">产品文章中心</a>'+
                '</div>'+
                '<div>'+
                '<ul class="nav navbar-nav">'+
                '<li>'+
                '<a href="#" class="dropdown-toggle" data-toggle="dropdown">文章管理<b class="caret"></b></a>'+
                '<ul class="dropdown-menu">'+
                '<li><a href="add.html">添加文章</a></li>'+
                '<li><a href="list.html">文章列表</a></li>'+
                '</ul>'+
                '</li>'+
                '<li><a href="#">产品管理</a></li>'+
                '<li><a href="#">推送设置</a></li>'+
                '</ul>'+
                '</div>'+
                '</div>'+
                '</nav>';
        })(),
    },
});
