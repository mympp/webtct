function dslide(id, time) {
			var _this = this;
			this.w = $(document).width();
			this.h = $('#'+id).height();
			this.c = 0;
			this.src = [];
			this.url = [];
			this.alt = [];
			this.tar = [];
			$('#'+id).find('a').each(function(i) {
				_this.src.push($(this).find('img')[0].src);
				_this.alt.push($(this).find('img')[0].alt);
				_this.url.push(this.href);
				_this.tar.push(this.target);
			});
			if(!this.src[0]) return;
			this.max = this.src.length;
			this.htm = '<ul id="'+id+'_ul" style="position:relative;width:'+this.w*(this.max+1)+'px;height:'+this.h+'px;z-index:1;overflow:hidden;">';
			for(var i = 0; i < this.max; i++) {
				this.htm += '<li style="background: url(\''+this.src[i]+'\') center no-repeat;float:left;"><a href="'+this.url[i]+'" target="'+this.tar[i]+'"><img src="" width="'+this.w+'"/></a></li>';
			}
			this.htm += '</ul><div style="clear:both;"></div>';
			if(this.alt[0]) this.htm += '<div style="width:'+this.w+'px;height:24px;line-height:24px;overflow:hidden;z-index:2;position:relative;top:-24px;background:#000;filter:Alpha(Opacity=80);opacity:0.3;">&nbsp;</div>';
			if(this.alt[0]) this.htm += '<div id="'+id+'_alt" style="width:'+(this.w-12)+'px;height:24px;line-height:24px;overflow:hidden;z-index:3;position:relative;top:-48px;padding:0 6px 0 6px;color:#F8F0F0;">'+this.alt[0]+'</div>';
			this.htm += '<div style="width:'+this.w+'px;height:20px;overflow:hidden;z-index:2;position:relative;top:-'+(this.alt[0] ? 68 : 30)+'px;text-align:center;padding-left:6px;">';
			for(var i = 0; i < this.max; i++) {
				this.htm += '<span id="'+id+'_no_'+i+'" style="display:inline-block;width:6px;height:6px;border-radius:6px;margin-right:6px;'+(i == this.c ? 'background:#FFFFFF;' : 'background:#FFFFFF;')+'"></span>';
			}
			this.htm += '</div>';
			$('#'+id).html(this.htm);
			if(this.max == 1) return;
			this.t;
			this.p = 0;
			$('#'+id).mouseover(function() {_this.p=1;});
			$('#'+id).mouseout(function() {_this.p=0;});
			$('#'+id).find('span').each(function(i) {
				$(this).mouseover(function() {
					_this.slide(i);
				});
			});
			this.slide = function(o) {
				if(o == this.c) return;
				if(o < 0 || o >= this.max) return;
				if(o == 0 && this.c == this.max - 1) {
					$('#'+id+'_ul').append($('#'+id+'_ul li:first').clone());
					$('#'+id+'_ul').animate({'left':-this.w*this.max},500,function() {
						$('#'+id+'_ul').css('left','0');
						$('#'+id+'_ul li:last').remove();
					});
				} else {
					$('#'+id+'_ul').animate({'left':-o*this.w},500);
				}
				$('#'+id+'_no_'+this.c).css('background','#FFFFFF');
				$('#'+id+'_no_'+o).css('background','#007AFF');
				if(this.alt[0]) $('#'+id+'_alt').html(this.alt[o]);
				this.c = o;
			}
			this.start = function() {
				if(this.p) return;
				if(this.c == this.max - 1) {
					this.slide(0);
				} else {
					this.slide(this.c+1);
				}
			}
			if(!time) time = 5000;
			this.t = setInterval(function() {_this.start();}, time);
		}
		var ds = new dslide('mobile-slide');
		$('#mobile-slide').on('swipeleft',function(){
			ds.slide(ds.c+1);
		});
		$('#mobile-slide').on('swiperight',function(){
			ds.slide(ds.c-1);
		});
		$(window).bind('orientationchange.slide', function(e){
			ds.w = $(document).width();
			$('#mobile-slide').find('ul').css('width', ds.w*(ds.max+1));
			$('#mobile-slide').find('img').css('width', ds.w);
			$('#mobile-slide').find('div').css('width', ds.w);
		});