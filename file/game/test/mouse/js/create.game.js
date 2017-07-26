// 加载loading
var _LoadingHtml = '<div id="loadingDiv"><img src="http://tc08.tecenet.com/game/2048/images/top-bar.png" alt=""><div class="loader-inner pacman"><div></div><div></div><div></div><div></div><div></div></div><p>游戏加载中....</p></div>';  
//监听加载状态改变  
document.onreadystatechange = completeLoading;  
document.write(_LoadingHtml); 
//加载状态为complete时移除loading效果  
function completeLoading() {  
    if (document.readyState == "complete") {  
        setTimeout(function(){
        loadingMask = document.getElementById('loadingDiv');  
            document.getElementById('loadingDiv').parentNode.removeChild(loadingMask);
            $(".page-groups,.remodal").show();
        },3000);
    }
}  
// 加载js脚本文件
function loadScript(url) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    document.body.appendChild(script);
}
// 加载css文件
function loadStyles(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}
loadStyles("http://188.188.8.121/tecenet/game/mouse/css/mouse.css");
loadStyles("http://tc08.tecenet.com/lib/animate/3.5.1/animate.min.css");
loadScript("http://tc08.tecenet.com/game/2048/js/remodal.min.js");
loadScript("http://188.188.8.121/tecenet/game/mouse/js/jsrsasign-all-min.js");
loadScript("http://188.188.8.121/tecenet/game/mouse/js/game.core.js");
loadScript("http://188.188.8.121/tecenet/game/mouse/js/slider.min.js");

