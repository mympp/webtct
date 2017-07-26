var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
var AJPath = DMURL+'ajax.php';
// 产品图片轮换
    jQuery(".slide-box").slide({
        mainCell:".bd ul",
        titCell:".hd ul",
        effect:"leftLoop",
        autoPlay:true,
        autoPage:true,
        interTime: 5000
    });
// 筛选框固定
    $(".frm-box").pin({
        containerSelector: ".container"
    });