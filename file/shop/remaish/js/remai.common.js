// anchor.js
(function($){window.anchor={settings:{transitionDuration:2000,transitionTimingFunction:"swing",labels:{error:"Couldn't find any section"}},init:function(options){$(this).data("settings",$.extend(anchor.settings,options));return this.each(function(){var $this=$(this);$this.unbind("click").click(function(event){event.preventDefault();anchor.jumpTo(anchor.getTopOffsetPosition($this),$this.data("settings"))})})},getTopOffsetPosition:function($object){var href=$object.attr("href"),$section=$($(href).get(0)),documentHeight=$(document).height(),browserHeight=$(window).height();if(!$section||$section.length<1){throw new ReferenceError(anchor.settings.labels.error)}if(($section.offset().top+browserHeight)>documentHeight){return documentHeight-browserHeight}else{return $section.offset().top}},jumpTo:function(topOffsetPosition,settings){var $viewport=$("html, body");$viewport.animate({scrollTop:topOffsetPosition},settings.transitionDuration,settings.transitionTimingFunction);$viewport.bind("scroll mousedown DOMMouseScroll mousewheel keyup",function(event){if(event.which>0||event.type==="mousedown"||event.type==="mousewheel"){$viewport.stop().unbind("scroll mousedown DOMMouseScroll mousewheel keyup")}})}};$.fn.anchor=function(method){if(anchor[method]){return anchor[method].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof method==="object"||!method){return anchor.init.apply(this,arguments)}else{return $.error("Method "+method+" does not exist on jQuery.anchor")}}}})(jQuery);
$('.nav-bar a[href*=#],.action-btn').anchor({
    transitionDuration : 500
});

// 首屏轮播大图
jQuery(".banner").slide({
    titCell:".hd ul",
    mainCell:".bd ul",
    autoPlay: true,
    effect:"fold",
    interTime:6000,
    autoPage:true,
    trigger:"click"
});


$(function(){
    $("input[name='qc']").change(function(){
        var result="";
        $("input[name='qc']:checked").each(function(){
            result+=$(this).val()+',';
        });
        if(result!=""){
            result=result.substring(0,result.lastIndexOf(','));
        }
        $("#title").val(result);
    });
})











