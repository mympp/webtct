var sys_activityID = "";
var sys_config = "";
var game_logo = "";
var game_id = 2333;
var share_title = "";
var share_message = "";
var share_image = "";
var share_href = location.href;
var guide_btn = "更多游戏";
var guide_href = "http://mp.weixin.qq.com/s?__biz=MjM5ODg2MTExMg==&mid=223574755&idx=1&sn=1fcdce2c9c8e4b7a3eb1a998b2aa8e4f#rd";
var is_prize = "";
var sys_is_weixin = true;
var game_max_score = 100;
var oldTitle = "天成医疗";
function is_weixn(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)== "micromessenger") {
        sys_is_weixin = true;
    } else {
        sys_is_weixin = false;
    }
}
is_weixn();
function score_submit(gameScore,gameType){
    console.log(gameScore);
    //ajaxLoad("http://www.wesane.com/admin.php/Gamescore/saveGamescore","gameScore="+gameScore+"&gameId="+game_id+"&gameType="+gameType, scoreResult);
}
function score_share(score_title){
    oldTitle = document.title;
    document.title = score_title + "_天成医疗网";
}
function wechat_score(){
    $(".link-area").show();
    $(".jd-cc").show();
}
function removeLink(){
    $(".link-area").hide();
    $(".jd-cc").hide();
}