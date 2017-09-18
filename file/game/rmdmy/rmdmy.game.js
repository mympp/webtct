var shareTitle = "在《人民的名义》中，你最可能是哪个角色_天成医疗网";
//swiper
var mySwiper = new Swiper('.swiper-container', {
    direction: 'vertical',
    onlyExternal: true,
    onInit: function (swiper) {
        swiperAnimateCache(swiper);
        swiperAnimate(swiper);
    },
    onSetTranslate: function (swiper) {
        swiperAnimate(swiper);
        if (mySwiper.realIndex > 16) {
            var r_name = $(".swiper-slide-active .result-name").text();
            var r_title = $(".swiper-slide-active .result-title").text();
            shareTitle = "在《人民的名义》剧中，我居然像" + r_title + r_name + "！来试试看你像谁？";
            wechatShare();
        }
    }
});

//itemhover
$(".page-option").on("touchstart", ".page-option-item", function () {
    $(this).addClass("page-option-item-hover");
});
$(".page-option").on("touchend", ".page-option-item", function () {
    $(this).removeClass("page-option-item-hover");
});

// getRandom
var gameTicket = Math.random().toString(36).substr(2);
var localUrl = encodeURIComponent(window.location.href.split("#")[0]);
var index_file = new Array("rmdmy.index.r1.html", "rmdmy.index.r2.html", "rmdmy.index.r3.html", "rmdmy.index.r4.html", "rmdmy.index.r5.html", "rmdmy.index.r6.html");
var index_file_i = getRandom(0, 5);
var r_file = index_file[index_file_i];
var LastNum = 0;
//记录上一次产生的随机值
function getRandom(x, y) {
    var r = Math.round(Math.random() * (y - x)) + x;
    if (r == LastNum) getRandom(x, y);
    LastNum = r;
    return r;
}

//addMoreGameLink
$(".result").append("<a class='more-game-link' href='http://tc08.tecenet.com/game/index.html?open=g_rmdmy'>更多游戏</a>")

// wechat-share
var wechatShareDialogClose = function () {
    $(".wechat-share-guide").hide()
};
var wechatShareDialogOpen = function () {
    $(".wechat-share-guide").show()
};
function wechatShare() {
    $.ajax({
        url: 'http://www.tecenet.com/api/weixin/jssdk.php?callback=cb&url=' + localUrl,
        dataType: 'jsonp',
        error: function () {
            console.log("weixinAPI error");
        },
        success: function (cb) {
            // console.log(shareTitle);
            if (typeof cb.timestamp != 'undefined' && typeof cb.nonceStr != 'undefined' && typeof cb.signature != 'undefined') {
                wx.config({
                    debug: false,
                    appId: cb.appId,
                    timestamp: cb.timestamp,
                    nonceStr: cb.nonceStr,
                    signature: cb.signature,
                    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo']
                });
                wx.ready(function () {
                    wx.onMenuShareTimeline({
                        title: shareTitle,
                        link: "http://tc08.tecenet.com/game/rmdmy/" + r_file + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/rmdmy/images/wechat-share-icon.jpg"
                    });
                    wx.onMenuShareAppMessage({
                        title: shareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/rmdmy/" + r_file + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/rmdmy/images/wechat-share-icon.jpg",
                        type: '',
                        dataUrl: ''
                    });
                    wx.onMenuShareQQ({
                        title: shareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/rmdmy/" + r_file + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/rmdmy/images/wechat-share-icon.jpg"
                    });
                    wx.onMenuShareWeibo({
                        title: shareTitle,
                        desc: $("[name=description]").attr("content"),
                        link: "http://tc08.tecenet.com/game/rmdmy/" + r_file + "?gameTicket=" + gameTicket + "",
                        imgUrl: "http://tc08.tecenet.com/game/rmdmy/images/wechat-share-icon.jpg"
                    });
                });
            }
        }
    });
}
wechatShare();





