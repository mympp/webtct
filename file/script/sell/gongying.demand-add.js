var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
var AJPath = DMURL+'ajax.php';

// 筛选展开更多
function slValShowMore(obj){
    if($(obj).html() == "更多"){
        $(obj).parent().find(".sl-v-list").css("height","auto");
        $(obj).html("收起");
    }else{
        $(obj).parent().find(".sl-v-list").css("height","30px");
        $(obj).html("更多");
    }
}
// radio框美化
$(".frm-wrap").on("click","label.radio-label",function(){
    $(this).addClass("current").siblings(".current").removeClass("current");
});
//新增产品
var idx=0;
$(".product-add-btn").click(function(){
    idx++;
    var obj= $(".product-group .product-group-bd").eq(0).clone(true);
    $(".product-group-ft").before(obj);
    $(".product-group .product-group-bd").eq(idx).find('input').val('');
    $(".product-group .product-group-bd").eq(idx).find('input').each(function(){
        var str= $(this).attr('name');
        $(this).attr('name',str.replace(/[0]/,idx));
    });
});
//日期插件
$(function() {
    $("#endDate").datepicker({
        minDate: new Date()
    });
});
// 表单验证
$('#frmWrap').validator({
    msgWrapper: 'div',
    msgMaker: function(opt){
        return '<span class="'+ opt.type +'">' + opt.msg + '</span>';
    }
});
// 表单提交成功后触发百度事件统计
// $('#frmWrap').on('valid.form', function(e, form){
//      _hmt.push(['_trackEvent', 'gongying', 'click', 'demandSubmit']);
//     $("#frmWrap").submit();
// });

