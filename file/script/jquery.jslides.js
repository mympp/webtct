/*
	[QQ93645493] Copyright (c) 2008-2013 temnet.cn
	This is NOT a freeware, use is subject to license.txt
*/
$(function(){
	var numpic = $('#b_slides li').size()-1;
	var nownow = 0;
	var inout = 0;
	var TT = 0;
	var SPEED = 7000;


	$('#b_slides li').eq(0).siblings('li').css({'display':'none'});


	var ulstart = '<ul id="pagination">',
		ulcontent = '',
		ulend = '</ul>';
	ADDLI();
	var pagination = $('#pagination li');
	var paginationwidth = $('#pagination').width();
     $('#pagination').css('margin-left',(0-paginationwidth/2))
	
	pagination.eq(0).addClass('current')
		
	function ADDLI(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic; i++){
			ulcontent += '<li>' + '<a href="javascript:void(0)">' + (i+1) + '</a>' + '</li>';
		}
		
		$('#b_slides').after(ulstart + ulcontent + ulend);	
	}

	pagination.on('click',DOTCHANGE)
	
	function DOTCHANGE(){
		
		var changenow = $(this).index();
		
		$('#b_slides li').eq(nownow).css('z-index','2');
		$('#b_slides li').eq(changenow).css({'z-index':'1'}).show();
		pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
		$('#b_slides li').eq(nownow).fadeOut(400,function(){$('#b_slides li').eq(changenow).fadeIn(500);});
		nownow = changenow;
		inout = 1;
	}
	
	$('#b_slides li').mouseenter(function(){
		inout = 1;
	})
	
	$('#b_slides li').mouseleave(function(){
		inout = 0;
	})
	
	function GOGO(){
		
		var NN = nownow+1;
		
		if( inout == 1 ){
			} else {
			if(nownow < numpic){
			$('#b_slides li').eq(nownow).css('z-index','2');
			$('#b_slides li').eq(NN).css({'z-index':'1'}).show();
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
			$('#b_slides li').eq(nownow).fadeOut(400,function(){$('#b_slides li').eq(NN).fadeIn(500);});
			nownow += 1;

		}else{
			NN = 0;
			$('#b_slides li').eq(nownow).css('z-index','2');
			$('#b_slides li').eq(NN).stop(true,true).css({'z-index':'1'}).show();
			$('#b_slides li').eq(nownow).fadeOut(400,function(){$('#b_slides li').eq(0).fadeIn(500);});
			pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

			nownow=0;

			}
		}
		TT = setTimeout(GOGO, SPEED);
	}
	
	TT = setTimeout(GOGO, SPEED); 

})