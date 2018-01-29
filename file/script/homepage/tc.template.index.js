//产品轮换
jQuery(".tp-product-slider").slide({
    titCell: ".hd ul",
    mainCell: ".bd ul",
    autoPage: true,
    effect: "leftLoop",
    scroll: 2,
    vis: 3,
    delayTime: 700,
    trigger: "click"
});
