    jQuery(".shared-slider").slide({
        mainCell:".bd ul",
        titCell:".hd ul",
        effect:"leftLoop",
        autoPlay:true,
        autoPage:true,
        interTime: 5000
    });

    jQuery(".new-list").slide({
        mainCell: ".new-list-bd ul",
        titCell:".new-list-hd ul",
        autoPlay: true,
        effect: "topMarquee",
        vis: 5,
        interTime: 80,
        trigger: "click"
    });