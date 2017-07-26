jQuery(".display").slide({
    titCell:".layout-hd ul",
    mainCell:".layout-bd ul",
    autoPage:true,
    effect:"leftLoop",
    vis:4,
    scrool:3,
    autoPlay: true,
    interTime: 4000
});
//新闻动态轮换
jQuery(".news-list").slide({
    titCell:".news-list-hd ul",
    mainCell:".news-list-bd .ulWrap",
    autoPage:true,
    effect:"topLoop",
    autoPlay:true,
    interTime: 6000
});
//加盟轮换
jQuery(".already-txt-list").slide({
    mainCell:"ul",
    autoPlay:true,
    effect:"topMarquee",
    vis:8,
    interTime:60,
    trigger:"click"
});
// 产品简介
jQuery(".product-tab-1").slide({});
jQuery(".product-tab-2").slide({});
//map
function mapHover(){
    var self = "";
    $(".city").hover(
        function(){
            self = $(this);
            self.addClass("hover").children("div").show();
        },
        function(){
            self = $(this);
            self.children("div").hide();
            self.removeClass("hover");
        }
    );
    $(".city").click(
        function(){
            self = $(this);
            self.addClass("hover").children("div").show();
        },
        function(){
            self = $(this);
            self.children("div").hide();
            self.removeClass("hover");
        }
    );
}
mapHover();