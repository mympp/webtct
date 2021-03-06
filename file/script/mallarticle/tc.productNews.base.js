var sUserAgent = navigator.userAgent.toLowerCase();
var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
var bIsMidp = sUserAgent.match(/midp/i) == "midp";
var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
var bIsAndroid = sUserAgent.match(/android/i) == "android";
var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
    //phone
    var winWidth = $(window).width();
    $(".slider-item").width(winWidth);

    // mobile-menu
    $(".page-header").append("<a href='javascript:;' id='menu' class='mobile-menu-switch iconfont icon-list'></a>");
    $("body").append('<div id="cover"></div>');
    $("#cover").css({width:($(window).width()-135)+'px',height:$(window).height(),position:'fixed',top:'0px',left:'0px',zIndex:'999',display:'none'});
    $(document)[0].onclick = function(e){
        var e = e || window.event;
        var target = e.target || e.srcElement;
        if(target.id == "menu"){
            $(".proNews-wrap,.page-header").css({"-webkit-transform": "translate3d(-135px, 0px, 0px)", "transition": "all 0.25s"});
            $("#cover,.page-nav").css("display","block");
            $("#menu").removeClass("icon-list").addClass("icon-close");
        }
        else{
            $(".proNews-wrap,.page-header").css({"-webkit-transform": "translate3d(0px, 0px, 0px)", "transition": "all 0.25s"});
            $("#cover,.page-nav").css("display","none");
            $("#menu").removeClass("icon-close").addClass("icon-list");
        }
    };
}
else{

}