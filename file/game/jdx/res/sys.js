var sys_activityID = "";
var sys_config = "";
var game_logo = "";
var game_id = "";

var share_title = "";
var share_message = "";
var share_image = "";
var share_href = location.href;

var guide_btn = "更多游戏";
var guide_href = "//h5.woaiyx.com";
var is_prize = "";
var sys_is_weixin = false;
var game_max_score = 100;

var oldTitle = "我爱游戏";
var openid = null;

function is_weixn() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        sys_is_weixin = true;
    }

    var url = document.URL;
    var config_info = "";
    var para = "";
}

is_weixn();


function score_submit(gameScore, gameType) {

}

function scoreResult() {

}


function score_share(score_title) {
    oldTitle = document.title;
    document.title = score_title;
    var a = new Date,
        b = location.pathname + "?" + a.getDate() + "01" + Math.floor(a.getMinutes() / 15 + 17) + "0" + a.getHours() + Math.floor(a.getMinutes() / 15);
    window.history.pushState(null, '', b);
}

function initTitle() {
    //document.title = oldTitle;
}
