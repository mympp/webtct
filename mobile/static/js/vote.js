$(function(){
// $(".main-one").click(function(){
//     $("#gou").css("background","url(img/tick1.jpg) no-repeat");
//     $(".main-one ul").css("background","#7ebe2c");
// });

    var vote_max = $('#vote_max').html();
    var i = 1;
    $('.main').each(function(index, el) {
        $('.main').eq(index).click(function(event) {
            if($('.main ul').eq(index).hasClass('lv')||$('.main ul li span').eq(index).hasClass('cuo')){
                $('.main ul').eq(index).removeClass('lv');
                $('.main ul li span').eq(index).removeClass('cuo');                 
                $('.main ul input').eq(index).attr('checked',false);
                i--;
            }else{
                if (i > vote_max) {alert("最多只能选"+vote_max+"项");return false;}
                $('.main ul').eq(index).addClass('lv');
                $('.main ul li span').eq(index).addClass('cuo');                
                $(".main ul input").eq(index).attr('checked',true);
                i++; 
            }                       
        });        
    });










});