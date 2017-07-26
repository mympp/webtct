$(".bid-new-list").stick_in_parent({
        parent:'.bid-wrap'
    });
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