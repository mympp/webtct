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
    // 文字垂直无缝滚动
    jQuery(".txt-marquee").slide({
        mainCell:"ul",
        autoPlay:true,
        effect:"topMarquee",
        vis:10,
        interTime:60,
        trigger:"click"
    });