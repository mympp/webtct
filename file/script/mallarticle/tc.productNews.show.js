var commentFlag = true;
function send_comment(star,ele){
    var num = parseInt($(ele).find("em").html());
    if(commentFlag){
        $.ajax({
            type: 'POST',
            url: 'http://www.tecenet.com/ajax.php?action=comment&star='+star+'&moduleid=5&itemid=',
            success: function(){
                num = num + 1;
                $(ele).find("em").html(num);
                commentFlag = false;
            },
            error:function(){

            }
        });
    }
}

window._bd_share_config = {
    "common": {
        "bdSnsKey": {},
        "bdText": "",
        "bdMini": "2",
        "bdMiniList": false,
        "bdPic": "",
        "bdStyle": "1",
        "bdSize": "32"
    },
    "share": {},
    "selectShare": {"bdContainerClass": null, "bdSelectMiniList": ["weixin", "tsina", "tqq", "qzone"]}
};
with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
