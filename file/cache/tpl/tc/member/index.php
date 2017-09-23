<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $module);?>
<link rel="stylesheet" href="<?php echo DT_PATH;?>skin/teceskin/tc.lib.min.css">
<link rel="stylesheet" href="<?php echo DT_PATH;?>skin/teceskin/member-index.min.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_410104_374fnnfaya54s4i.css">
<style>.product-img {height:160px;}</style>
<td valign="top" class="main" id="main" >
<!--index-content-->
<div class="index-content">
<!--index-main-->
<div class="index-main">
<div class="index-main-inner">
<!--个人信息-->
<div class="module">
<div class="module-body pad-ver-30 pad-hor-30 clearfix pos-rel">
<div class="index-avatar pull-left">
<img src="<?php echo useravatar($_username, 'large');?>" alt="avatar">
<a href="avatar.php">修改头像</a>
</div>
<div class="user-info pull-left mar-top-5 mar-lft-20">
<div>
<strong class="user-name" title="修改个人资料"><a href=""><?php echo $_username;?></a></strong>
<a href="grade.php?action=grade"  class="user-grade"><?php echo $MG['groupname'];?></a>
<a href="edit.php" class="user-setting pos-abs" title="修改个人资料"><i class="iconfont icon-shezhi"></i></a>
</div>
<div class="authenticate mar-top-15">
<?php if($MOD['vmember']) { ?>
<a href="validate.php?action=email" class="authenticate-item <?php if(!$vemail) { ?>disable<?php } ?>
"
   title="<?php if($vemail) { ?>已通过<?php } else { ?>未通过<?php } ?>
邮件认证"><i class="iconfont icon-youxiang"></i>邮箱认证</a>
<a href="validate.php?action=mobile" class="authenticate-item <?php if(!$vmobile) { ?>disable<?php } ?>
"
   title="<?php if($vmobile) { ?>已通过<?php } else { ?>未通过<?php } ?>
手机认证"><i class="iconfont icon-shouji"></i>手机认证</a>
<a href="validate.php?action=truename" class="authenticate-item <?php if(!$vbank) { ?>disable<?php } ?>
"
   title="<?php if($vbank) { ?>已通过<?php } else { ?>未通过<?php } ?>
银行帐号认证"><i class="iconfont icon-shenfengzheng4"></i>实名认证</a>
<?php } ?>
</div>
<div class="wealth mar-top-25 clearfix">
<a href="credit.php" class="wealth-item pull-left">
<i class="iconfont icon-jifen"></i>
<span class="wealth-item-title">我的积分<em><?php echo $credit;?></em></span>
</a>
<a href="record.php" class="wealth-item pull-left">
<i class="iconfont icon-qianbao"></i>
<span class="wealth-item-title">我的天成币<em><?php echo $money;?></em></span>
</a>
<a href="message.php" class="wealth-item pull-left">
<i class="iconfont icon-sixin"></i>
<span class="wealth-item-title">我的站内信<em><?php if($_message>0) { ?><?php echo $_message;?><?php } else { ?>0<?php } ?>
</em></span>
</a>
</div>
</div>
</div>
<div class="module-foot pad-ver-30 pad-hor-15">
<div class="login-date">
<span>会员ID：</span><em><?php echo $userid;?></em>
<span class="mar-lft-20">注册时间：</span><em><?php echo timetodate($regtime,3);?></em>
<span class="mar-lft-20">最后登录时间：</span>
<em><?php echo timetodate($logintime,3);?><a href="record.php?action=login" class="text-underline mar-lft-5">登录记录</a></em>
</div>
</div>
</div>
<!--个人信息 end-->
<!--快捷搜索-->
<div class="module index-search">
<div class="module-head clearfix">
<h3 class="module-head-title pull-left">快捷搜索</h3>
<a href="http://so.tecenet.com" class="module-head-control pull-right">天成医搜<i class="iconfont icon-gengduo"></i></a>
</div>
<div class="module-body">
<form class="site-frm mar-btm-20 mar-ver-20 clearfix" action="http://www.tecenet.com/search.php" onsubmit="return Dsearch();">
<div class="select-group" id="select-tab">
<button type="button" class="select-btn" id="select-btn">全站<span class="caret"></span></button>
<ul class="dropdown-menu" role="menu" id="search-type" style="display: none;">
<li><a href="javascript:void(0)" data-mid="0" data-mname="全站" rel="nofollow">全站</a></li>
<li><a href="javascript:void(0)" data-mid="4" data-mname="厂商" rel="nofollow">厂商</a></li>
<li><a href="javascript:void(0)" data-mid="16" data-mname="产品" rel="nofollow">产品</a></li>
<li><a href="javascript:void(0)" data-mid="6" data-mname="求购" rel="nofollow">求购</a></li>
<li><a href="javascript:void(0)" data-mid="21" data-mname="资讯" rel="nofollow">资讯</a></li>
</ul>
</div>
<input type="hidden" name="moduleid" value="6" id="destoon_moduleid">
<input type="hidden" name="from" value="1">
<input type="hidden" name="spread" value="0" id="destoon_spread">
<input type="hidden" name="action" value="" id="sresume">
<input type="text" name="kw" value="" id="topkeyword" placeholder="请输入关键词" class="site-txt pull-left">
<input type="submit" class="site-submit  pull-right" value="搜索">
</form>
</div>
</div>
<!--快捷搜索 end-->
<!--您可能感兴趣-->
<div class="module index-search">
<div class="module-head clearfix">
<h3 class="module-head-title pull-left">您可能感兴趣</h3>
</div>
<div class="module-body pad-btm-20 pad-ver-20">
<ul class="module-tab-head clearfix">
<li class="module-tab-item pull-left active">求购</li>
<li class="module-tab-item pull-left">厂商</li>
<li class="module-tab-item pull-left">产品</li>
</ul>
<div class="module-tab-body">
<!--求购模块内容-->
<div class="module-tab-content">
<div class="demand-module">
<!--10个默认求购内容-->
<?php $sell_tags_type0 = tag("moduleid=5&fields=linkurl,title,areaid,hits,addtime,catid&condition=status=3 and typeid=1&pagesize=10&order=itemid desc&template=null&debug=0&showcat=1");?>
<?php if(is_array($sell_tags_type0)) { foreach($sell_tags_type0 as $k => $t) { ?>
<div class="item">
<div class="title">
<h3 class="text-overflow"><a title="<?php echo $t['title'];?>" href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h3>
</div>
<ul class="param-list clearfix">
<li class="tag">
<span class="key">需求分类：</span>
<?php $catename = get_cat($t['catid'])?>
<span class="val"><a href="/gongying/<?php echo sell_rewrite(['catid'=>$catename['catid'],'typeid'=>1]);?>" title="<?php echo $catename['catname'];?>"><?php echo $catename['catname'];?></a></span>
</li>
<li class="date">
<span class="key">发布时间：</span>
<span class="val"><?php echo date('Y/m/d',$t['addtime']);?></span>
</li>
<li class="local">
<span class="key">所在地区：</span>
<?php $areaname = area_pos($t['areaid'], '/', 2)?>
<span class="val"><a href="/gongying/<?php echo sell_rewrite(['areaid'=>$t['areaid'],'typeid'=>1]);?>" title="<?php echo $areaname;?>"><?php echo $areaname;?></a></span>
</li>
<li class="num">
<span class="key">采购数量：</span>
<span class="val"><?php if($t['amount']) { ?><?php echo $t['amount'];?><?php } else { ?>详谈<?php } ?>
</span>
</li>
</ul>
</div>
<?php } } ?>
</div>
<a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['typeid'=>1,'catid'=>0]);?>" class="module-tab-more">点击查看更多</a>
</div>
<!--求购模块内容 end-->
<!--厂商模块内容-->
<div class="module-tab-content" style="display: none;">
<div class="company-module">
<div class="company-module-inner">
<!--厂商模块默认8个-->
<?php $company_recom_tags = tag("moduleid=4&fields=linkurl,thumb,company,areaid,pnum,business&condition=pnum>0 and hits>20 and groupid=7 and closeshop=0&pagesize=8&order=pnum desc,level desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($company_recom_tags)) { foreach($company_recom_tags as $k => $t) { ?>
<div class="item">
<a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['company'];?>">
<img class="company-avatar" src="<?php echo $t['thumb'];?>" alt="<?php echo $t['company'];?>"
                                                    onerror="javascript:this.src='<?php echo DT_SKIN;?>image/tip/nopic-md-1-1.png';"
                                                >
</a>
<h4 class="company-title text-overflow"><a href="<?php echo $t['linkurl'];?>"><?php echo $t['company'];?></a></h4>
<ul>
<li><span class="key">所在地区：</span><em class="val text-overflow"><?php echo area_pos($t['areaid'], '/', 2);?></em></li>
<li><span class="key">销售产品：</span><em class="val line-clamp line-clamp-2"><?php echo $t['business'];?></em></li>
<li><span class="key">产品数量：</span><em class="val text-overflow"><?php echo $t['pnum'];?></em></li>
</ul>
</div>
<?php } } ?>
</div>
</div>
<a href="<?php echo $MODULE['4']['linkurl'];?>search.php?vip=1&validated=1" class="module-tab-more">点击查看更多</a>
</div>
<!--厂商模块内容 end-->
<!--产品模块内容-->
<div class="module-tab-content" style="display: none;">
<div class="product-module clearfix">
<!--产品模型默认6个-->
<?php $mall_tc_tags = tag("moduleid=16&table=mall&fields=linkurl,username,thumb,title,company&condition=groupid=7 and status = 3&pagesize=6&order=hits desc &template=null")?>
<?php if(is_array($mall_tc_tags)) { foreach($mall_tc_tags as $k => $t) { ?>
<div class="product-item">
<div class="product-img">
<a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt=""></a>
</div>
<h3 class="product-title"><a href="<?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></h3>
<div class="product-company">
<a href="<?php echo str_replace('www',$t['username'],DT_PATH);?>" target="_blank" title="<?php echo $t['company'];?>"><i class="iconfont icon-gongsi"></i><?php echo $t['company'];?></a>
</div>
</div>
<?php } } ?>
</div>
<a href="<?php echo $MODULE['16']['linkurl'];?><?php echo rewrite('search.php?tc=1');?>" class="module-tab-more">点击查看更多</a>
</div>
<!--产品模块内容 end-->
</div>
</div>
</div>
<!--您可能感兴趣 end-->
</div>
</div>
<!--index-main end-->
<!--index-side-->
<div class="index-side">
<div class="index-side-inner">
<!--在线客服-->
<div class="module">
<div class="module-body pad-top-15 pad-lft-20 side-service">
<p class="side-service-title">联系客服</p>
<p class="side-service-sub text-muted">Online Service</p>
<p class="side-service-400">400-617-3599</p>
<a href="javascript:window.open('http://p.qiao.baidu.com/cps/chat?siteId=3215492&userId=6452136&s=tecenet.com','newwindow','height=530,width=600,top=100,left=200,toolbar=no,menubar=no,scrollbars=no,resizeable=no,lacation=no,status=no');_hmt.push(['_trackPageview', '/im/qiao']);" class="side-service-btn box-inline">在线咨询</a>
</div>
</div>
<!--在线客服 end-->
<!--我的便签-->
<div class="module">
<div class="module-head">
<h3 class="module-head-title">我的便签</h3>
</div>
<div class="module-body index-mark">
<form method="post" action="index.php" onsubmit="return check();">
<textarea name="note" id="note"><?php echo $note;?></textarea>
<div class="clearfix mar-top-10">
<input type="submit" name="submit" value="更新" class="btn pull-left">
<span class="pull-left mar-lft-10 mar-top-5 text-warning">[可记录一些文字备忘，限1000字]</span>
</div>
</form>
</div>
</div>
<!--我的便签 end-->
<!--我的收藏-->
<div class="module">
<div class="module-head clearfix">
<h3 class="module-head-title pull-left">我的收藏</h3>
<a href="favorite.php" class="module-head-control pull-right">查看全部<i class="iconfont icon-gengduo"></i></a>
</div>
<div class="module-body">
<?php $my_favorite = tag("moduleid=2&table=favorite&fields=title,addtime,itemid,url&condition=userid=$userid&pagesize=5&order=itemid desc &template=null")?>
<!--<ul class="index-favorites-list pad-btm-20 pad-ver-20"></ul>-->
<?php if(empty($my_favorite)) { ?>
<ul class="index-favorites-list pad-btm-20 pad-ver-20"></ul>
<?php } else { ?>
<?php if(is_array($my_favorite)) { foreach($my_favorite as $k => $t) { ?>
<?php $favor_url = (DT_PATH.'api/redirect.php?url='.urlencode(fix_link($t['url'])))?>
<ul class="index-favorites-list pad-btm-20 pad-ver-20">
<li class="clearfix">
<a class="index-favorites-title text-overflow" href="<?php echo $favor_url;?>" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a>
<span class="index-favorites-time pull-right text-muted text-right"><?php echo timetodate($t['addtime'],3);?></span>
</li>
<?php } } ?>
</ul>
<?php } ?>
</div>
</div>
<!--我的收藏 end-->
<!--我的好友-->
<div class="module">
<div class="module-head">
<h3 class="module-head-title">我的好友</h3>
<a href="friend.php" class="module-head-control pull-right">查看全部<i class="iconfont icon-gengduo"></i></a>
</div>
<div class="module-body">
<?php $my_friend = tag("moduleid=2&table=friend&fields=itemid,username,truename,homepage&condition=userid=$userid&pagesize=5&order=itemid desc &template=null")?>
<?php if(empty($my_friend)) { ?>
<ul class="index-friend-list pad-btm-20 pad-ver-20"></ul>
<?php } else { ?>
<ul class="index-friend-list pad-btm-20 pad-ver-20">
<!--默认五个-->
<?php if(is_array($my_friend)) { foreach($my_friend as $k => $t) { ?>
<li class="clearfix">
<a href="friend.php?action=show&itemid=<?php echo $t['itemid'];?>" target="_blank"><img class="pull-left index-friend-avatar" src="<?php echo useravatar($t['username'], 'large');?>" alt=""></a>
<a href="friend.php?action=show&itemid=<?php echo $t['itemid'];?>" target="_blank" class="index-friend-name"><?php echo $t['truename'];?><span>(<?php echo $t['username'];?>)</span></a>
<a href="message.php?action=send&touser=<?php echo $t['username'];?>" class="index-friend-btn">私信</a>
</li>
<?php } } ?>
</ul>
<?php } ?>
</div>
</div>
<!--我的好友 end-->
</div>
</div>
<!--index-side end-->
<!--index-footer-->
<div class="index-footer mar-lft-15 pull-left">
<p class="text-muted">版权所有 ©广州天成医疗技术股份有限公司CopyRight ©Guangzhou TianCheng Medical Technology Co.,Ltd.</p>
<p class="text-muted">ICP备案号：粤ICP备13045514号 互联网药品信息服务经营许可证：(粤)-经营性-2013-0006</p>
</div>
<!--index-footer end-->
</div>
<!--index-content end-->
<script>
// 快捷搜索
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
});
// tab
$(function(){
var $li = $('.module-tab-head>li');
var $ul = $('.module-tab-body>div');
$li.mouseover(function(){
var $this = $(this);
var $t = $this.index();
$li.removeClass('active');
$this.addClass('active');
$ul.css('display','none');
$ul.eq($t).css('display','block');
})
});
</script>
</td>
</tr>
</table>
<?php include template('footer', $module);?>