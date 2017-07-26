$(document).ready(function() {
    console.log(111);
    var li_width = $(".bor-r").length * 218;
    var ul_width = 0;

    //$(".brand_img").click(function () {
    //    layer.use('extend/layer.ext.js', function () {
    //        //初始加载即调用，所以需放在ext回调里
    //        layer.ext = function () {
    //            layer.photosPage({
    //                html: '',
    //                title: '',
    //                id: '', //相册id，可选
    //                parent: '#brand_nr'
    //            });
    //        };
    //    });
    //});
    //$(".div-img").click(function () {
    //    layer.use('extend/layer.ext.js', function () {
    //        //初始加载即调用，所以需放在ext回调里
    //        layer.ext = function () {
    //            layer.photosPage({
    //                html: '',
    //                title: '',
    //                id: '', //相册id，可选
    //                parent: '#imgs'
    //            });
    //        };
    //    });
    //});
    $(".point-left").click(function () {
        if (ul_width < 0) {
            ul_width = ul_width + 218;
            $("#imgs").animate({'margin-left': ul_width + "px"});
        }
    });
    $(".point-right").click(function () {
        if (li_width + ul_width > 1090) {
            ul_width = ul_width - 218;
            $("#imgs").animate({'margin-left': ul_width + "px"});
        }
    });
});