$(function(id){
var navH = $(id).offset().top;
$(window).scroll(function(){
var scroH = $(this).scrollTop();
if(scroH>=navH){
$(id).css({"position":"fixed","top":0});
}else if(scroH<navH){
$(id).css({"position":"static"});
}
})
}) 