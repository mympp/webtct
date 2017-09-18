/**
 * Created by teague on 2017/4/26.
 */
var sortTime = function () {
    $(".game-sort button").removeClass("current");
    $(".game-sort-time").addClass("current");
    var sortEle = $(".game-list-item");
    var timeArr = [];
    for (var i = 0; i < sortEle.length; i++) {
        timeArr.push(sortEle[i]);  //sortEle是元素的集合，并不是数组，所以不能直接用数组的sort进行排序。
    }
    timeArr.sort(function (a, b) {
        return a.getAttribute('data-timeRank') - b.getAttribute('data-timeRank')
    });
    for (var i = 0; i < timeArr.length; i++) {
        $(".game-list").append(timeArr[i]); //将排好序的元素，重新塞到body里面显示。
    }
};
var sortHot = function () {
    $(".game-sort button").removeClass("current");
    $(".game-sort-hot").addClass("current");
    var sortEle = $(".game-list-item");
    var hotArr = [];
    for (var i = 0; i < sortEle.length; i++) {
        hotArr.push(sortEle[i]);  //sortEle是元素的集合，并不是数组，所以不能直接用数组的sort进行排序。
    }
    hotArr.sort(function (a, b) {
        return a.getAttribute('data-hotRank') - b.getAttribute('data-hotRank')
    });
    for (var i = 0; i < hotArr.length; i++) {
        $(".game-list").append(hotArr[i]); //将排好序的元素，重新塞到body里面显示。
    }
};

// gameTicket
var gameTicket = Math.random().toString(36).substr(2);
$(".game-list-item").each(function (i, obj) {
    var url = $(obj).find("a").attr("href");
    $(obj).find("a").attr("href", url + "?from=tecenetGameList&gameTicket=" + gameTicket);
});


// tab
$(".game-tab__item").on("click", function () {
    var tabIndex = $(this).index();
    $(this).addClass("current").siblings().removeClass("current");
    $(".tabs-content").css({
        "visibility":"hidden",
        "position":"absolute",
        "left":"-99999em",
        "top":"-99990em"
    });
    $(".tabs-content").eq(tabIndex).css({
        "visibility":"visible",
        "position":"relative",
        "left":"0",
        "top":"0"
    });
});


//wechat-share
var localUrl = encodeURIComponent(window.location.href.split("#")[0]);
$.ajax({
    url: 'http://www.tecenet.com/api/weixin/jssdk.php?callback=cb&url=' + localUrl,
    dataType: 'jsonp',
    error: function () {
        console.log("weixinAPI error");
    },
    success: function (cb) {
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
                    title: "指尖小游戏_天成医疗网",
                    link: "http://tc08.tecenet.com/game/index.html",
                    imgUrl: "http://tc08.tecenet.com/game/images/wechat-share-icon.jpg"
                });
                wx.onMenuShareAppMessage({
                    title: "指尖小游戏_天成医疗网",
                    desc: "天成医疗网游戏平台，随时随地与身边好友一起玩游戏，玩出智慧，玩出快乐，玩出健康。",
                    link: "http://tc08.tecenet.com/game/index.html",
                    imgUrl: "http://tc08.tecenet.com/game/images/wechat-share-icon.jpg",
                    type: '',
                    dataUrl: ''
                });
                wx.onMenuShareQQ({
                    title: "指尖小游戏_天成医疗网",
                    desc: "天成医疗网游戏平台，随时随地与身边好友一起玩游戏，玩出智慧，玩出快乐，玩出健康。",
                    link: "http://tc08.tecenet.com/game/index.html",
                    imgUrl: "http://tc08.tecenet.com/game/images/wechat-share-icon.jpg"
                });
                wx.onMenuShareWeibo({
                    title: "指尖小游戏_天成医疗网",
                    desc: "天成医疗网游戏平台，随时随地与身边好友一起玩游戏，玩出智慧，玩出快乐，玩出健康。",
                    link: "http://tc08.tecenet.com/game/index.html",
                    imgUrl: "http://tc08.tecenet.com/game/images/wechat-share-icon.jpg"
                });
            });
        }
    }
});



var _hmt = _hmt || [];
(function () {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?2b363fb3d03ff9991c4971afddf8731d";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();

var _mtac = {};
(function () {
    var mta = document.createElement("script");
    mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.4";
    mta.setAttribute("name", "MTAH5");
    mta.setAttribute("sid", "500421174");

    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(mta, s);
})();