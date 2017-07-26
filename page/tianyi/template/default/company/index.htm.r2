{php $CSS = array('catalog');}
{template 'header'}
<div class="header-banner">
	<img src="/skin/default/image/banner.jpg">
</div>
<div class="m">
	<div class="search-div">
		<ul>
			<li class="sel-city">
				省 份
			</li>
			<li class="sel-city">
				城 市
			</li>
			<li class="sel-cat">
				经营范围
			</li>
			<li class="sel-input">
				<input type="text" name="" value="" placeholder="请输入商家关键字" class="ser-input"/>
				<button class="searchbtn"></button>
			</li>
		</ul>
	</div>
	<script>
		$(function(){
			$(".good-cat-more").click(function(){
				var h = $(this).parent().parent().children(".cat-com").height();
				if(h == 310){
					$(this).children().html('收起');
					$(this).removeClass('down');
					$(this).addClass('up');
					var el = $(this).parent().parent().children(".cat-com"),
					curHeight = el.height(),
					autoHeight = el.css('height', 'auto').height();
					el.height(curHeight).animate({height: autoHeight}, "slow");
				}else{
					$(this).children().html('更多');
					$(this).removeClass('up');
					$(this).addClass('down');
					$(this).parent().parent().children(".cat-com").animate({height:'310px'},"slow");
				}
			});
		});
	</script>
	<div class="goods">
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(3,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>装修主材</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<!--{php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");}-->
								{loop $malls $k1 $t1}
								<li><a href="{$t1['linkurl']}" target="_blank"><img src="{$t1['thumb']}" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
								{/loop}
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<!--{php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");}-->
								{loop $malls $k1 $t1}
								<li><a href="{$t1['linkurl']}" target="_blank"><img src="{$t1['thumb']}" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
								{/loop}
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(44,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>通风空调</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<!--{php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");}-->
								{loop $malls $k1 $t1}
								<li><a href="{$t1['linkurl']}" target="_blank"><img src="{$t1['thumb']}" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
								{/loop}
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<!--{php $malls=tag("moduleid=16&condition=username='".$t['username']."' and elite=1&order=itemid desc&pagesize=2&template=null&debug=0");}-->
								{loop $malls $k1 $t1}
								<li><a href="{$t1['linkurl']}" target="_blank"><img src="{$t1['thumb']}" onerror="showImgDelay(this,'/skin/default/image/pro2.png',2);"/></a></li>
								{/loop}
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(45,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>电工电气/安防</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(46,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>管材管件</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);" /></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(47,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>实验室家具</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(48,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>仪器设备</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(49,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>采暖/热泵</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="cat-detail">
			<!--{php $companys=tag("moduleid=4&condition=FIND_IN_SET(50,catid) and groupid>5&&order=userid desc&pagesize=9&template=null&debug=0");}-->
			<div class="cat-title-bak">
				<div class="good-cat-title">
					<span>辅材/工具</span>
				</div>
				{if count($companys) > 3}
				<div class="good-cat-more down">
					<span>更多</span>
				</div>
				{/if}
			</div>
			<div class="c_b"></div>
			<div class="cat-com">
				<div class="com-list">
					{loop $companys $k $t}
					{if in_array($k,array(0,3,6))}
					<div class="com-show">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{else}
					<div class="com-show com-show-m">
						<div class="com-show-left">
							<div class="com-img">
								<a href="{$t['linkurl']}" target="_blank"><img src="{$t['thumb']}" onerror="showImgDelay(this,'/skin/default/image/defaultlogo.png',2);"/></a>
							</div>
							<div class="com-name"><a href="{$t['linkurl']}" target="_blank">{$t['company']}</a></div>
							<div>
								<button class="com-concern">关注</button>
								<button class="com-ask">立即咨询</button>
							</div>
						</div>
						<div class="com-show-right">
							<ul>
								<li><img src="/skin/default/image/pro1.png"/></li>
								<li><img src="/skin/default/image/pro2.png"/></li>
							</ul>
						</div>
					</div>
					{/if}
					{/loop}
				</div>
			</div>
		</div>
		<div class="c_b"></div>
	</div>
	<div class="c_b"></div>
</div>
{template 'footer'}