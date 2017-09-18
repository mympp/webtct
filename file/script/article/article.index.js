jQuery(".column-rank").slide({
    titCell:".column-rank-head ul li",
    mainCell:".column-rank-body"
});
jQuery(".headnews-slide").slide({
    mainCell:".bd ul",
    effect:"left",
    autoPlay: true,
    interTime:6000,
});
jQuery(".headnews-wechat").slide({
    mainCell:".bd ul",
    autoPlay:true,
    effect:"topMarquee",
    vis:5,
    interTime:50,
    trigger:"click"
});