// 筛选展开更多
function slValShowMore(obj){
    if($(obj).html() == "更多"){
        $(obj).parent().find(".sl-v-list").css("height","auto");
        $(obj).html("收起");
    }else{
        $(obj).parent().find(".sl-v-list").css("height","30px");
        $(obj).html("更多");
    }
}
// 产品图片轮换
function previewSlider(){
    if($(".preview-slider .bd ul li").length > 1){
        $(".preview-slider").addClass("preview-slider-act");
        jQuery(".preview-slider").slide({
            mainCell:".bd ul",
            effect:"leftLoop"
        });
    }
}
previewSlider();
// 产品图片点击查看大图
$(function(){
    $('.fancybox').fancybox({
        padding:5,
        showNavArrows:true
    });
});
jQuery(".slide-show").slide({
    titCell:".module-hd ul",
    mainCell:".module-bd ul",
    effect:"topLoop",
    autoPage: true,
    autoPlay: false,
    scroll:3,
    vis:3,
    delayTime:0
});

window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];