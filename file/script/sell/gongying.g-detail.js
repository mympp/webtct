    // 产品图片轮换
    jQuery(".slide-box").slide({
        mainCell:".bd ul",
        effect:"leftLoop",
        autoPlay:true
    });
    // 点击查看大图
    $(function(){
        $('.fancybox').fancybox({
            padding:5,
            showNavArrows:true
        });
    });