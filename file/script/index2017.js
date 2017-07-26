jQuery(".demand-col").slide({titCell:".col-hd ul", mainCell:"ul.demand-col-bd", effect:"leftLoop", autoPage:true, vis:2, scroll:2});
jQuery(".supply-col").slide({titCell:".col-hd ul", mainCell:"ul.supply-col-bd", effect:"leftLoop", autoPage:true, vis:2, scroll:2, switchLoad:"_src"});
jQuery(".product-col").slide({titCell:".col-hd ul", mainCell:".col-bd .ulWrap", autoPage:true, effect:"leftLoop", vis:2, switchLoad:"_src",autoPlay: true,interTime: 6000});
jQuery(".company-col").slide({titCell:".col-hd ul", mainCell:".col-bd ul", autoPage:true, effect:"leftLoop", vis:2, switchLoad:"_src",autoPlay: true,interTime: 5000});
jQuery(".company-list").slide({titCell:".company-list-hd ul", mainCell:".company-list-bd ul", autoPage:true, effect:"leftLoop", vis:11, scroll:5, switchLoad:"_src" });
jQuery(".img-change").slide({mainCell:"ul", autoPage:true, switchLoad:"_src"    });
jQuery(".links-tab").slide({titCell:".links-tab-hd ul li", mainCell:".links-tab-bd", delayTime:100});
jQuery(".full-slide").slide({titCell:".hd ul", mainCell:".bd ul", autoPlay: true, effect:"fold", interTime:6000, autoPage:true, trigger:"click" });
jQuery(".mod-tab").slide({titCell:".mod-tab-hd ul li", mainCell:".mod-tab-bd", delayTime:100});
jQuery(".mod-cate-wrp").slide({type:"menu", titCell:".mod-cate", targetCell:".mod-cate-bd", effect:"fade", delayTime:200, triggerTime:50, defaultPlay:false, returnDefault:true});
jQuery(".mod-tab-notice").slide({titCell:".hd ul", mainCell:".bd ul", autoPage:true, effect:"top", scroll:4, vis:4, trigger:"click", prevCell:".notice-prev", nextCell:".notice-next"});
jQuery(".media-news").slide({titCell:".col-hd ul", mainCell:"ul.col-bd", effect:"leftLoop", autoPage:true, vis:2, scroll:2, switchLoad:"_src"});
jQuery(".tc-news").slide({titCell:".col-hd ul", mainCell:"ul.col-bd", effect:"topLoop", autoPage:true, vis:3, scroll:2,autoPlay: true,interTime: 8000});

$(function() {
    $("img.lazy").lazyload();
});
function soTecnentValue(){
    var sokeyword = document.getElementById("topkeyword").value;
    document.getElementById("soInputTxt").value = sokeyword;
    return true;
}
function dialogMsg(){
    $(".dialog-wrp").fadeIn();
}
function closeDialogMsg(){
    $(".dialog-wrp").hide();
}
$(document).mouseup(function(e){
    var _con = $(".dialog");   // 设置目标区域
    if(!_con.is(e.target) && _con.has(e.target).length === 0){
        $('.dialog-wrp').hide();
    }
});
// elevator
jQuery(function($) {
    $(document).ready( function() {
        $('.elevator ul').stickUp({
            parts: {
                0:'supply',
                1:'product',
                2:'company',
                3:'equipment',
                4:'service',
                5:'news'
            },
            itemClass: 'menu-item',
            itemHover: 'active'
        });
    });
});
$('.elevator ul a[href*=#],.to-top').anchor({
    transitionDuration : 500
});
window.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if( t >= 640 ) {
        $(".elevator").fadeIn(500);
    } else {
        $(".elevator").fadeOut(200);
    }
}

$(document).ready(function(){
    $('#search-type a').click(function(){
        $('#select-btn').html($(this).data('mname')+'<span class="caret"></span>');
        $('#destoon_moduleid').val($(this).data('mid'));
        if($(this).data('mid') == 9 && $(this).data('action') == 'resume') $('#sresume').val('resume');
        $('#search-type').hide();
    });
    $('#select-tab').mouseover(function(){
        $('#search-type').show();
    });
    $('#select-tab').mouseout(function(){
        $('#search-type').hide();
    });
    $('#job-select-tab > span').click(function(){
        $('#job-action').val($(this).data('action'));
        $('#job-select-tab').children('span').each(function(){
            if($(this).is('.on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
        });
    });
    $('#hr-select-tab > span').click(function(){
        $('#hr-action').val($(this).data('action'));
        $('#hr-select-tab').children('span').each(function(){
            if($(this).is('.on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
        });
    });
});
// 职帅最新招聘数据
function getJobData(){
    $.ajax({
        type : "GET",
        url : "http://www.tecejob.com/api/zsopen/index.php",
        dataType : "jsonp",
        data:{
            method: 'getNewJobsList',
            format: 'json',
            appKey: '561040800081',
            sign: '23DFB8B5D06F12EF1727AD60BD94E4D58E2ACEE2'
        }, 
        success:function(data) {
            var html ='';
            for(var i=0;i<data.length;i++){
                html += '<div class="job-item pull-left">'
                    +'<div class="job-title text-overflow"><a href="'+data[i].jobUrl+'" title="'+data[i].jobName+'" target="_blank">'+data[i].jobName+'</a></div>'
                    +'<div class="job-salary"><em>'+data[i].jobSalary+'</em>'+data[i].jobAddr+'</div>'
                    +'<div class="desc">'+data[i].comName+'</div>'
                    +'</div>'
            }
            $(".job-col .col-bd").html(html);
        },  
        error:function(){
            console.log('fail load job data');
        }
    });
}
// 职帅最新招聘类型
function GetjobClass(){
    $.ajax({
        type : "GET",
        url : "http://www.tecejob.com/api/zsopen/index.php",
        dataType : "jsonp",
        data:{
            method: 'getClassJobList',
            format: 'json',
            appKey: '561040800081',
            sign: 'B21460B27E03B05E061241ABEE4836856E8E8276'
        },
        success:function(data) {
            var html ='';
            for(var i=0;i<data.length;i++){
                html += '<option value="'+data[i].url+'">'+data[i].name+'</option>'
            }
            $("#jobClass").html('<option value="javascript:;">请选择</option>'+html);
        },  
        error:function(){
            console.log('fail load job class');
        }
    });
}
function jobClassLink(){
    var jobClassUrl = $("#jobClass").val();
    $("#jobClassLink").attr("href",jobClassUrl);
}
getJobData();
GetjobClass();
