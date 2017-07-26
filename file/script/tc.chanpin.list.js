/**
 * Created by hetc on 2017/3/12.
 */
// 筛选展开更多
function slValShowMore(obj){
    if($(obj).html() == "更多"){
        $(obj).parent().find(".sl-v-list").addClass("sl-v-list-more");
        $(obj).html("收起");
    }else{
        $(obj).parent().find(".sl-v-list").removeClass("sl-v-list-more");
        $(obj).html("更多");
    }
}

jQuery(".slide-show").slide({
    titCell:".module-hd ul",
    mainCell:".module-bd ul",
    effect:"topLoop",
    autoPage: true,
    autoPlay: false,
    scroll:3,
    vis:3,
    delayTime:0
});

//产品对比
(function ($) {
    var list = [];
    //添加到对比项
    $(document).on('click', '.compare-btn input', function () {
        $(this).parent().hasClass("checked") ? $(this).parent().removeClass("checked") : $(this).parent().addClass("checked");
        $(".compare-box").show();
        var productID = $(this).val();
        var inArray = $.inArray(productID,list);
        if (inArray < 0) {
            if (list.length < 4) {
                list.push(productID);
                $(".compare-box-hd>span>em").html(list.length);
                var productBox = $(this).parents().parents().parents(".cp-card");
                var displayTitle = productBox.find(".cp-txt h3").text();
                var image = productBox.find(".cp-img img").attr('src');
                var link = productBox.find(".cp-img>a").attr('href');
                $(".compare-box-bd ul").append('<li id="compareItem'+productID+'" class="compare-item">' +
                    '<a href="javascript:;" class="cp-i compare-item-remove"></a>' +
                    '<a href="'+ link +'" target="_blank"><img class="compare-item-img" src="'+ image +'" alt="'+ displayTitle +'"></a>' +
                    '<p class="compare-item-title"><a href="'+ link +'" target="_blank">'+ displayTitle +'</a></p>' +
                    '</li>');
            }else{
                alert('最多只能选择4个产品');
                $(this).removeAttr("checked");
                $(this).parent().removeClass("checked");
                
                return;
            }
        } else {
            list.splice($.inArray(productID, list), 1);
            var prod = productID.replace(" ", "");
            $('#compareItem' + prod).remove();
            $(".compare-box-hd>span>em").html(list.length);
            compareBoxClose();
        }
        // 2个产品执行对比
        if (list.length > 1) {
            $(".compare-box-btn").addClass("active");
            $(".compare-box-btn").removeAttr('disabled');
        } else {
            $(".compare-box-btn").removeClass("active");
            $(".compare-box-btn").attr('disabled', '');
        }
    });
    //删除对比项
    $(document).on('click', '.compare-item-remove', function () {
        var removeID = $(this).parents().attr('id').split("compareItem")[1];
        console.log(removeID);
        $('#check_'+ removeID +'').click();
        compareBoxClose();
    });

    // 跳转对比
    $(document).on('click', '.compare-box-btn.active', function () {
        $("#mallForm").attr("action","http://www.tecenet.com/chanpin/compare.php");
        $("#mallForm").submit();
    });
    function compareBoxClose() {
        if (!list.length) {
            $(".comparePan").empty();
            $(".compare-box").hide();
        }
    }
})(jQuery);




