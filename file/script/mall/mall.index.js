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

    // img lazy load
    $(function() {
        $("img.lazy").lazyload();
    });
    //slider
    jQuery(".slider-box").slide({
        titCell:".hd ul",
        mainCell:".bd ul",
        autoPlay: true,
        effect:"fold",
        interTime:6000,
        autoPage:true,
        trigger:"click"
    });
    jQuery(".announce-list").slide({
        titCell:".hd ul",
        mainCell:".bd ul",
        effect:"leftLoop",
        autoPlay:true,
        autoPage:true,
        scroll:2,
        vis:2,
        delayTime:800,
        interTime:6000
    });
    jQuery(".hot-supply").slide({
        titCell:".gy-module-hd>ul",
        mainCell:".gy-module-bd .main>ul",
        effect:"leftLoop",
        autoPlay:true,
        autoPage:true,
        scroll:3,
        vis:3,
        delayTime:800,
        interTime:6000
    });
    jQuery(".focus-slide").slide({
        mainCell:".bd ul",
        titCell:".hd ul",
        effect:"leftLoop",
        autoPlay:true,
        autoPage:true,
        interTime: 5000
    });
    jQuery(".recommend-box").slide({
        mainCell:".bd ul",
        titCell:".hd ul",
        effect:"leftLoop",
        autoPage:true,
        interTime: 5000,
        vis:4,
        switchLoad:"_src",
        autoPlay: false
    });
    jQuery(".cate-tabs").slide({
        mainCell:".cate-tabs-bd",
        titCell:".cate-tabs-hd ul li",
        trigger:"click"
    });
    jQuery(".img-change").slide({
        titCell:".hd ul",
        mainCell:".bd ul",
        autoPlay: true,
        effect:"fold",
        interTime:6000,
        autoPage:true,
        trigger:"click"
    });