//首屏banner轮播图
jQuery(".tp-banner-slide").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    autoPlay: true,
    effect: "fold",
    interTime: 6000,
    autoPage: true,
    trigger: "click"
});

//回到顶部
$(window).scroll(function() {
    if ($(window).scrollTop() > 600) {
        $(".tp-tools-top").show();
    } else {
        $(".tp-tools-top").hide();
    }
});
$(".tp-tools-top").click(function(){
    $('body,html').scrollTop(0);
    return false;
});

//点击查看大图
$("a.fancybox").fancybox();





