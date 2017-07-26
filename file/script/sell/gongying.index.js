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