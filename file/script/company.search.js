// 筛选展开更多
function slValShowMore(obj){
    if($(obj).html() == "更多"){
        $(obj).parent().find(".sl-v-list").addClass("sl-v-list-more");
        $(obj).html("收起");
    }else{
        $(obj).parent().find(".sl-v-list").removeClass("sl-v-list-more");
        $(obj).html("更多");
    }
}
// 产品图片轮换
jQuery(".cmp-product").slide({
    mainCell:".bd ul",
    titCell:".hd ul",
    effect:"leftLoop",
    autoPage:true,
    trigger:"click",
    switchLoad:"_src"
});
//img-lazy-load
function imglazyLoad(){
    $("img.lazy").each(function(){
        var imgSrc = $(this).attr("data-original");
        if( imgSrc == "" ){
            $(this).attr("src","http://www.tecenet.com/skin/teceskin/image/tip/nopic-sm-1-1.png")
        }else{
          $(this).lazyload({
            failurelimit : 10
        });   
        }
    });
}
imglazyLoad();