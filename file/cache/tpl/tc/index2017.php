<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $footer_js = [DT_PATH.'file/script/index2017.js?v2017050901'];?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
<title><?php if($ztitle=='') { ?><?php if($seo_title) { ?><?php echo $seo_title;?><?php } else { ?><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
<?php if($city_sitename) { ?><?php echo $city_sitename;?><?php } else { ?><?php echo $DT['sitename'];?><?php } ?>
<?php } ?>
<?php } else { ?><?php echo $ztitle;?><?php } ?>
</title>
<?php if($head_keywords||$zkeywords) { ?>
<meta name="keywords" content="<?php if($zkeywords) { ?><?php echo $zkeywords;?><?php } else { ?><?php echo $head_keywords;?><?php } ?>
"/>
<?php } ?>
<?php if($head_description||$zdescription) { ?>
<meta name="description" content="<?php if($zdescription) { ?><?php echo $zdescription;?><?php } else { ?><?php echo $head_description;?><?php } ?>
"/>
<?php } ?>
<?php if($head_mobile) { ?>
<meta http-equiv="mobile-agent" content="format=xhtml; url=<?php echo $head_mobile;?>"> 
<meta http-equiv="mobile-agent" content="format=html5; url=<?php echo $head_mobile;?>">
<?php } ?>
<meta http-equiv="mobile-agent" content="format=xhtml; url=http://wap.tecenet.com/">
<meta http-equiv="mobile-agent" content="format=html5; url=http://wap.tecenet.com/">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo DT_PATH;?>favicon.ico"/>
<link rel="bookmark" type="image/x-icon" href="<?php echo DT_PATH;?>favicon.ico"/>
<link rel="stylesheet" href="<?php echo DT_SKIN;?>tecenet.base.css?v=201708241043">
<link rel="stylesheet" href="<?php echo DT_SKIN;?>tecenet.index.css?v=201708241043">
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/jquery.SuperSlide.2.1.1.source.js"></script>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/elevator.min.js"></script>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/jquery.lazyload.min.js"></script>
<script>var _hmt = _hmt || [];</script>
</head>
<body <?php if(isMobile()) { ?>style="position: absolute;"<?php } ?>
>
<!-- top-nav -->
<div class="tc-top-nav" id="tcTopNav">
<div class="w1200 box-center">
<div class="welcome pull-left">
欢迎来到国内专业医疗产业服务平台
</div>
<div class="tools pull-right">
<div class="wap-qrcode">
<a href="javascript:;">手机版</a>
<img src="<?php echo DT_SKIN;?>image/wap-qrcode.png" alt="手机天成医疗网二维码" />
</div>
<?php if(!$_userid) { ?>
<a class="tn-login" href="<?php echo $MODULE['2']['linkurl'];?>login.php" target="_self">登录</a>
<a class="tn-reg" href="<?php echo $MODULE['2']['linkurl'];?>register.php" target="_self">立即注册</a>
<?php } else { ?>
<a href="<?php echo $MODULE['2']['linkurl'];?>" title="会员中心"><span class="ocolor" title="<?php echo $_username;?>"><?php echo $_username;?></span></a>
<a href="<?php echo $MODULE['2']['linkurl'];?>message.php">站内信</a>
<a href="<?php echo $MODULE['2']['linkurl'];?>chat.php">对话</a>
<a href="<?php echo $MODULE['2']['linkurl'];?>logout.php">退出</a>
<?php } ?>
</div>
</div>
</div>
<!--tc-top-nav end-->
<!-- tc-header -->
<div class="tc-header">
<div class="w1200 box-center clearfix">
<!--logo-->
<h1 class="logo pull-left"><a href="<?php echo DT_PATH;?>" target="_self"><img src="<?php echo DT_SKIN;?>image/logo.gif" alt="天成医疗网"></a></h1>
<!--logo end-->
<?php include template('search-tool-2017','chip');?>
<!--tc-custom-service-->
<div class="tc-custom-service pull-right">
<div class="tel pull-left">
<div class="hd">天成医疗网客服</div>
<div class="bd">400-617-3599</div>
</div>
<a class="online  pull-left" href="javascript:;" onclick="javascript:window.open('http://p.qiao.baidu.com/cps/chat?siteId=3215492&amp;userId=6452136&amp;s=tecenet.com','newwindow','height=530,width=600,top=100,left=200,toolbar=no,menubar=no,scrollbars=no,resizeable=no,lacation=no,status=no');_hmt.push(['_trackPageview', '/im/qiao']);">在线咨询</a>
</div>
<!--tc-custom-service end-->
</div>
</div>
<!-- tc-header end -->
<!-- tc-nav -->
<div class="tc-nav">
<div class="w1200 box-center">
<div class="menu-hd pull-left">热门服务<i></i></div>
<ul class="tc-nav-item pull-right">
<li><a href="<?php echo DT_PATH;?>" target="_blank">首页</a></li>
<li class="other">
<a href="<?php echo $MODULE['16']['linkurl'];?>" target="_self">产品</a>
<div class="sub-nav">
                    <a href="<?php echo $MODULE['16']['linkurl'];?>" target="_blank">产品大全</a>
                    <a href="http://www.sharedour.com/" target="_blank">产品服务<i>享道</i></a>
                    <a href="http://medcha.com/" target="_blank">进出口服务<i>medcha</i></a>
                    <a href="http://so.tecenet.com/" target="_blank">产品搜索</a>
</div>
</li>
<li><a href="<?php echo $MODULE['9']['linkurl'];?>" target="_blank">维修</a></li>
<li><a href="<?php echo $MODULE['5']['linkurl'];?>" target="_blank">供需</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">招标</a></li>
<li><a href="<?php echo $MODULE['7']['linkurl'];?>" target="_blank">资质</a></li>
<li><a href="http://www.tecejob.com" target="_blank">招聘</a></li>
<li><a href="<?php echo $MODULE['4']['linkurl'];?>" target="_blank">厂商</a></li>
<li><a href="<?php echo $MODULE['21']['linkurl'];?>" target="_blank">资讯</a></li>
<li><a href="<?php echo $MODULE['15']['linkurl'];?>" target="_blank">共享</a></li>
<li><a href="<?php echo $MODULE['10']['linkurl'];?>" target="_blank">问答</a></li>
<li><a href="http://image.tecenet.com/" target="_blank">图库</a></li>
</ul>
</div>
</div>
<!-- tc-nav end -->
<!--tc-banner-->
<div class="tc-banner">
<!-- full-slide -->
<div class="full-slide">
<div class="bd">
<ul>
<?php $index_ad_tags = tag("moduleid=2&table=ad&condition=pid=226 and fromtime<$DT_TIME and totime>$DT_TIME and status=3&pagesize=5&order=listorder asc&template=null")?>
<?php if(is_array($index_ad_tags)) { foreach($index_ad_tags as $k => $t) { ?>
<li style="background:url(<?php echo $t['image_src'];?>) center center no-repeat;<?php if($k != 0) { ?>display:none;<?php } ?>
">
<a target="_blank" href="<?php echo $t['image_url'];?>"></a>
</li>
<?php } } ?>
</ul>
</div>
<div class="hd">
<ul></ul>
</div>
</div>
<!-- full-slide end-->
<!--left-area-->
<div class="left-area">
<ul class="mod-cate-wrp">
<li class="mod-cate mod-cate-product">
<strong><i class="icon"></i>找产品</strong>
<div class="mod-cate-bd " style="display: none;">
<form class="mod-search" action="<?php echo $MODULE['16']['linkurl'];?>search.php" method="get">
<div class="input-group">
<span class="input-group-hd">器械产品分类</span>
<select name="catid" class="form-control">
<option value="0" >全部</option>
<?php if(is_array($mall_catid)) { foreach($mall_catid as $t) { ?>
<option value="<?php echo $t['catid'];?>"><?php echo $t['catname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">产品属性</span>
<select name="stype" class="form-control">
<option value="">全部</option>
<option value="0">整机</option>
<option value="1">配件</option>
<option value="2">耗材</option>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索">
</form>
<div class="mod-cate-img">
<a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=16" target="_blank"><img src="<?php echo DT_SKIN;?>image/mod-cate-product-img.jpg" alt="发布产品"></a>
</div>
</div>
</li>
<li class="mod-cate mod-cate-company">
<strong><i class="icon"></i>找供应商</strong>
<div class="mod-cate-bd " style="display: none;">
<form class="mod-search" action="<?php echo $MODULE['4']['linkurl'];?>search.php" >
<div class="input-group">
<span class="input-group-hd">运作模式</span>
<select name="mode" class="form-control">
<option value="1">生产商</option>
<option value="2">贸易商</option>
<option value="3">服务商</option>
<option value="4">其他机构</option>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">地区</span>
<select name="areaid" class="form-control">
<option value="0">全国</option>
<?php if(is_array($area_first)) { foreach($area_first as $t) { ?>
<option value="<?php echo $t['areaid'];?>"><?php echo $t['areaname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">经营范围</span>
<select name="catid" class="form-control">
<option value="0">全部</option>
<?php if(is_array($company_catid)) { foreach($company_catid as $t) { ?>
<option value="<?php echo $t['catid'];?>"><?php echo $t['catname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索">
</form>
<div class="mod-cate-img">
<a href="<?php echo $MODULE['4']['linkurl'];?>" target="_blank"><img src="<?php echo DT_SKIN;?>image/mod-cate-company-img.jpg" alt="找供应商"></a>
</div>
</div>
</li>
<li class="mod-cate mod-cate-repair">
<strong><i class="icon"></i>找维修</strong>
<div class="mod-cate-bd " style="display: none;">
<div class="mod-cate-tab" id="job-select-tab">
<span class="on" data-action="">找 维 修</span>
<span data-action="resume">找工程师</span>
</div>
<form class="mod-search" action="<?php echo $MODULE['9']['linkurl'];?>search.php" method="get">
<input type="hidden" name="action" value="" id="job-action" />
<div class="input-group">
<span class="input-group-hd">服务分类</span>
<select name="catid" class="form-control">
<option value="0">全部</option>
<?php if(is_array($job_catid)) { foreach($job_catid as $t) { ?>
<option value="<?php echo $t['catid'];?>"><?php echo $t['catname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">地区</span>
<select name="areaid" class="form-control">
<option value="0">全国</option>
<?php if(is_array($area_first)) { foreach($area_first as $t) { ?>
<option value="<?php echo $t['areaid'];?>"><?php echo $t['areaname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索">
</form>
<div class="mod-cate-img">
<a href="<?php echo $MODULE['9']['linkurl'];?>" target="_blank"><img src="<?php echo DT_SKIN;?>image/mod-cate-repair-img.jpg" alt="找维修，找工程师"></a>
</div>
</div>
</li>
<li class="mod-cate mod-cate-sell">
<strong><i class="icon"></i>找买卖</strong>
<div class="mod-cate-bd " style="display: none;">
<div class="mod-search-hd "><i class="icon"></i>找买卖</div>
<form class="mod-search" action="<?php echo $MODULE['5']['linkurl'];?>search.php" method="get">
<div class="input-group">
<span class="input-group-hd">服务分类</span>
<select name="catid" class="form-control">
<option value="0">全部</option>
<?php if(is_array($sell_catid)) { foreach($sell_catid as $t) { ?>
<option value="<?php echo $t['catid'];?>"><?php echo $t['catname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">地区</span>
<select name="areaid" class="form-control">
<option value="0">全国</option>
<?php if(is_array($area_first)) { foreach($area_first as $t) { ?>
<option value="<?php echo $t['areaid'];?>"><?php echo $t['areaname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索">
</form>
<div class="mod-search-hd mod-search-hd-ztb"><i class="icon"></i>招投标</div>
<form class="mod-search" action="<?php echo $MODULE['6']['linkurl'];?>search.php" method="get">
<div class="input-group">
<span class="input-group-hd">服务分类</span>
<select name="catid" class="form-control">
<option value="0">全部</option>
<?php if(is_array($buy_catid)) { foreach($buy_catid as $t) { ?>
<option value="<?php echo $t['catid'];?>"><?php echo $t['catname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">地区</span>
<select name="areaid" class="form-control">
<option value="0">全国</option>
<?php if(is_array($area_first)) { foreach($area_first as $t) { ?>
<option value="<?php echo $t['areaid'];?>"><?php echo $t['areaname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索">
</form>
<div class="mod-cate-img">
<a href="<?php echo $MODULE['5']['linkurl'];?>" target="_blank"><img src="<?php echo DT_SKIN;?>image/mod-cate-sell-img.jpg" alt="找维修，找工程师"></a>
</div>
</div>
</li>
<li class="mod-cate mod-cate-market">
<strong><i class="icon"></i>找推广</strong>
<div class="mod-cate-bd " style="display: none;">
<a href="http://www.eydsp.com" target="_blank"><img style="margin-top:5px" src="<?php echo DT_SKIN;?>image/mod-cate-market-img.jpg" alt="找维修，找工程师"></a>
</div>
</li>
<li class="mod-cate mod-cate-job">
<strong><i class="icon"></i>找人才</strong>
<div class="mod-cate-bd " style="display: none;">
<div class="mod-cate-tab" id="hr-select-tab">
<span class="on" data-action="">岗位招聘</span>
<!-- <span data-action="resume">人才资源</span> -->
</div>
<div class="mod-search clearfix">
<!-- <input type="hidden" name="action" value="" id="hr-action" /> -->
<div class="input-group">
                            <span class="input-group-hd">类型</span>
                            <select name="catid" class="form-control" id="jobClass" onchange="jobClassLink()">
                                
                            </select>
                        </div>
                        <a href="" id="jobClassLink" class="pull-left" target="_blank">搜  索</a>
<!-- <div class="input-group">
<span class="input-group-hd">地区</span>
<select name="areaid" class="form-control">
<option value="0">全国</option>
<?php if(is_array($area_first)) { foreach($area_first as $t) { ?>
<option value="<?php echo $t['areaid'];?>"><?php echo $t['areaname'];?></option>
<?php } } ?>
</select>
</div>
<div class="input-group">
<span class="input-group-hd">关键字</span>
<input type="text" name="kw" class="form-control" />
</div>
<input type="submit" value="搜  索"> -->
</div>
<div class="mod-cate-img">
<a href="http://www.tecejob.com/" target="_blank"><img src="<?php echo DT_SKIN;?>image/mod-cate-job-img.jpg" alt="找岗位招聘，找人才资源"></a>
</div>
</div>
</li>
<li class="mod-cate mod-cate-service">
<strong><i class="icon"></i>找服务</strong>
<div class="mod-cate-bd " style="display: none;">
<dl class="mod-cate-dl-1">
<dt><i class="icon"></i>资质服务</dt>
<dd>
<p>①科技成果转化</p>
<p>②立项申报咨询</p>
<p>③生产/经营报证</p>
<div class="btn-area">
<a href="<?php echo DT_PATH;?>about/intro.html#keLangMedical">了解更多</a>
<a href="http://wpa.qq.com/msgrd?v=3&uin=379255200&site=qq&menu=yes" target="_blank">客   服</a>
</div>
</dd>
</dl>
<dl class="mod-cate-dl-2">
<dt><i class="icon"></i>物流服务</dt>
<dd>
<p>①平台一体化集约物流配送</p>
<p>②信息系统可视化</p>
<p>③专业化团队管理</p>
<div class="btn-area">
<a href="<?php echo DT_PATH;?>about/intro.html#yiLiantongLogistics">了解更多</a>
<a href="http://wpa.qq.com/msgrd?v=3&uin=657911476&site=qq&menu=yes" target="_blank">客   服</a>
</div>
</dd>
</dl>
<dl class="mod-cate-dl-3">
<dt><i class="icon"></i>医学工程</dt>
<dd>
<p>①ISO国际标准/GMP标准设计</p>
<p>②专业资质整体施工</p>
<p>③优质设备耗材供应</p>
<p>④一站式完整服务</p>
<div class="btn-area">
<a href="<?php echo DT_PATH;?>about/intro.html#tianYiEngineering">了解更多</a>
<a href="http://wpa.qq.com/msgrd?v=3&uin=657911476&site=qq&menu=yes" target="_blank">客   服</a>
</div>
</dd>
</dl>
<dl class="mod-cate-dl-4">
<dt><i class="icon"></i>进出口服务</dt>
<dd>
<div class="pull-left">
<p>①医疗器械出口服务</p>
<p>②跨境电商平台</p>
<p>③海量产品数据库</p>
</div>
<div class="pull-right">
<p>④采购安装一站式</p>
<p>⑤多平台异国采购 </p>
<p>⑥整体打包外贸服务</p>
</div>
<div class="btn-area pull-left" style="margin-top:40px">
<a href="<?php echo DT_PATH;?>about/intro.html#importExport">了解更多</a>
<a href="http://wpa.qq.com/msgrd?v=3&uin=657911476&site=qq&menu=yes" target="_blank">客   服</a>
</div>
</dd>
</dl>
</div>
</li>
</ul>
</div>
<!--left-area end-->
<!--right-area-->
<div class="right-area">
<!--member-->
<div class="member">
<div class="user-info">
<?php $now_hour = date('H',time())?>
<p>HI，<?php if($_username) { ?><?php echo $_username;?> <?php } ?>
<?php if($now_hour >= 6 && $now_hour < 12) { ?>早上好 !<?php } else if($now_hour >= 12 && $now_hour < 18) { ?>下午好 !<?php } else { ?>晚上好 !<?php } ?>
</p>
<p>欢迎<?php if($_userid) { ?>回到<?php } else { ?>来到<?php } ?>
天成医疗网！</p>
</div>
<div class="btn-area clearfix">
<?php if(!$_userid) { ?>
<a href="<?php echo $MODULE['2']['linkurl'];?>login.php" class="login-btn pull-left"><i class="icon"></i>登录</a>
<a href="<?php echo $MODULE['2']['linkurl'];?>register.php" class="reg-btn pull-right"><i class="icon"></i>注册</a>
<?php } else { ?>
<a href="<?php echo $MODULE['2']['linkurl'];?>" class="login-btn box-center"><i class="icon"></i>会员中心</a>
<?php } ?>
</div>
</div>
<!--member end-->
<!--mod-tab-->
<div class="mod-tab">
<div class="mod-tab-hd">
<ul class="clearfix">
<li class="item-1"><i class="icon"></i>客服咨询</li>
<li class="item-2 on"><i class="icon"></i>平台资质</li>
<li class="item-3"><i class="icon"></i>在线公告</li>
</ul>
</div>
<ul class="mod-tab-bd">
<li class="mod-tab-customer" style="display:none;">
<form action="<?php echo DT_PATH;?>guestbook/index.php#ask" method="get">
<textarea  name="content"  placeholder="请详细输入您的疑问以及联系方式，我们会第一时间为您解答"></textarea>
<input type="submit" value="发表留言" >
</form>
<div class="btn-area">
<a class="pull-left" href="http://wpa.qq.com/msgrd?v=3&uin=657911476&site=qq&menu=yes" target="_blank"><i class="icon"></i>QQ客服</a>
<a class="pull-right" href="javascript:window.open('http://p.qiao.baidu.com/cps/chat?siteId=3215492&userId=6452136','newwindow','height=530,width=600,top=100,left=200,toolbar=no,menubar=no,scrollbars=no,resizeable=no,lacation=no,status=no');_hmt.push(['_trackPageview', '/im/qiao']);" target="_blank"><i class="icon"></i>在线客服</a>
</div>
</li>
<li class="mod-tab-quality">
<dl class="mod-tab-quality-1">
<dt>食药监管局认可</dt>
<dd>互联网药认：粤-经营性-2013-0006</dd>
</dl>
<dl class="mod-tab-quality-2">
<dt>上市公司投资支持</dt>
<dd>达安基因投资与天成共同协办</dd>
</dl>
<dl class="mod-tab-quality-3">
<dt>认证资质的颁发</dt>
<dd>卫生部医药生物工程技术研究中心授权</dd>
</dl>
</li>
<li class="mod-tab-notice" style="display:none;">
<div class="bd">
<ul>
<?php $announces = tag("table=announce&order=listorder DESC,itemid DESC&fields=title,linkurl,edittime&pagesize=12&template=null")?>
<?php if(is_array($announces)) { foreach($announces as $k => $t) { ?>
<li class="item clearfix">
<a href="<?php echo $t['linkurl'];?>" target="_blank" class="pull-left text-overflow"><?php echo $t['title'];?></a>
<p class="pull-right">[<?php echo date('m-d',$t['edittime']);?>]</p>
</li>
<?php } } ?>
</ul>
</div>
<div class="hd">
<a class="notice-prev"></a>
<a class="notice-next"></a>
<ul class="hidden"></ul>
</div>
</li>
</ul>
</div>
<!--mod-tab end-->
</div>
<!--right-area end-->
</div>
<!--tc-banner end-->
<!-- tc-data -->
<div class="tc-data">
<div class="w1200 box-center clearfix">
<style>
.tc-data-show li{
padding: 0 43px;
}
</style>
<ul class="tc-data-show pull-left" id="count">
<!-- <li>
<span>订单市场金额</span>
<em id="span_num">
<a class="span_num_link" href="javascript:;" style="display: none;" onclick="getSpanNum();">点击显示</a>
</em>
</li> -->
<!-- <li>
<span>首页关注次数</span>
<em><script type="text/javascript" src="module/count.php"></script></em>
</li> -->
<!--
<?php $job = $db->count($DT_PRE.'job', "status=3", 60);?>
<?php $resume = $db->count($DT_PRE.'resume', "status in (2,3)", 60);?>
<?php $buy = $db->count($DT_PRE.'buy_6', "status=3", 60);?>
<?php $buy = number_format($buy,0,'.',',');?>
<?php $fuwu=$job+$resume;?>
<?php $fuwu=number_format($fuwu,0,'.',',')?>
<?php $sell = $db->count($DT_PRE.'sell_5', "status=3", 60);?>
<?php $sell=number_format($sell,0,'.',',')?>
<?php $company_num = number_format($db->count($DT_PRE.'member',"groupid=6",60),0,'.',',');?>
<?php $mall_num = number_format($db->count($DT_PRE.'mall','status=3',60),0,'.',',');?>
-->
<li>
<span>招标信息</span>
<em><?php echo $buy;?></em>
</li>
<li>
<span>供需信息</span>
<em><?php echo $sell;?></em>
</li>
<li>
<span>技术服务信息</span>
<em><?php echo $fuwu;?></em>
</li>
<li>
<span>供应商总数</span>
<em>
<?php echo $company_num;?>
</em>
</li>
<li>
<span>产品总数</span>
<em>
<?php echo $mall_num;?>
</em>
</li>
</ul>
<a class="tc-data-btn tc-data-regBtn pull-right" href="<?php echo $MODULE['2']['linkurl'];?>my.php"><i class="pull-left"></i><span class="pull-left">注册会员享受特权</span></a>
        <a class="tc-data-btn tc-data-introBtn pull-right" href="http://www.tecenet.com/about/intro.html"><i class="pull-left"></i><span class="pull-left">天成医疗产业服务平台介绍</span></a>
</div>
</div>
<!-- tc-data end-->
<!-- tc-recommend-->
<div class="tc-recommend">
<div class="w1200 box-center clearfix">
<div class="tc-recommend-hd pull-left">
<p>推荐企业</p>
<a href="<?php echo $MODULE['2']['linkurl'];?>grade.php" target="_blank">我要上首页</a>
</div>
<ul class="pull-right">
<li><?php echo ad(38);?></li>
<li><?php echo ad(39);?></li>
<li><?php echo ad(40);?></li>
<li><?php echo ad(41);?></li>
</ul>
</div>
</div>
<!-- tc-recommend -->
<!--wrap-->
<div class="wrap">
<!-- 供求行情 -->
<div class="layout yellow-skin" id="supply">
<div class="layout-hd clearfix">
<h2>供求行情</h2>
<em class="intro">最新实时有效的供应和需求信息</em>
<a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=5" target="_blank" class="btn-action">发布供求信息</a>
</div>
<div class="layout-bd clearfix">
<div class="left-area w260 pd-20">
<!--供求行情分类-->
<dl class="cate-list cate-list-md">
<dt><strong><?php echo $MODULE['5']['name'];?>分类</strong></dt>
<?php $sell_cat_tags = tag("moduleid=5&table=category&fields=catid,catname,style&condition=moduleid=5 and parentid=0&pagesize=30&order=listorder ASC&template=null")?>
<dd class="mgt-10">
<?php if(is_array($sell_cat_tags)) { foreach($sell_cat_tags as $k => $t) { ?>
<a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['catid'=>$t['catid'],'typeid'=>0]);?>" class="text-overflow"><?php echo set_style($t['catname'],$t['style']);?></a>
<?php } } ?>
</dd>
</dl>
<dl class="cate-list cate-list-sm mgt-20">
<dt><strong>各地需求信息</strong></dt>
<dd class="mgt-10">
<?php $sell_area_tags = tag("table=area&fields=areaid,areaname&condition=parentid=0&pagesize=34&template=null&debug=0")?>
<?php if(is_array($sell_area_tags)) { foreach($sell_area_tags as $k => $t) { ?>
<a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['areaid'=>$t['areaid'],'typeid'=>1]);?>" class="text-overflow"><?php echo $t['areaname'];?></a>
<?php } } ?>
</dd>
</dl>
<!--供求行情分类 end-->
</div>
<div class="mid-area w640">
<!-- 最新医疗求购行情 -->
<div class="col demand-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['typeid'=>1,'catid'=>0]);?>" target="_blank">求购行情</a></h3>
<div class="btn-area pull-right">
<a class="prev font-hide" href="javascript:;">上一页</a>
<a class="next font-hide" href="javascript:;">下一页</a>
</div>
<ul class="hidden"></ul>
</div>
<ul class="col-bd demand-col-bd clearfix">
<?php $sell_tags_type0 = tag("moduleid=5&fields=linkurl,title,areaid,hits&condition=status=3 and typeid=1&pagesize=12&order=itemid desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($sell_tags_type0)) { foreach($sell_tags_type0 as $k => $t) { ?>
<li class="demand-item">
<h4 class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h4>
<p><span class="desc">地区：<?php echo area_pos($t['areaid'], '/', 2);?></span><span class="desc mgl-10"><i class="num"><?php echo $t['hits'];?></i>人关注</span></p>
<a class="btn" href="<?php echo $t['linkurl'];?>" target="_blank">我要供货</a>
</li>
<?php } } ?>
</ul>
</div>
<!-- 最新医疗求购行情 end-->
<!-- 最新医疗供应行情 -->
<div class="col supply-col line-t-1">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['5']['linkurl'];?><?php echo sell_rewrite(['typeid'=>0,'catid'=>0]);?>" target="_blank">供应行情</a></h3>
<div class="btn-area pull-right">
<a class="prev font-hide" href="javascript:;">上一页</a>
<a class="next font-hide" href="javascript:;">下一页</a>
</div>
<ul class="hidden"></ul>
</div>
<ul class="col-bd supply-col-bd clearfix">
<?php $sell_tags_type1 = tag("moduleid=5&fields=thumb,title,areaid,hits,linkurl&condition=status=3 and typeid=0 and thumb <> ''&pagesize=12&order=itemid desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($sell_tags_type1)) { foreach($sell_tags_type1 as $k => $t) { ?>
<li class="supply-item">
<a href="<?php echo $t['linkurl'];?>" target="_blank">
<div class="img-area pull-left"><img class="lazy-img" src="<?php echo DT_SKIN;?>image/blank.gif" _src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"></div>
<div class="txt-area pull-right">
<h4 class="text-overflow" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></h4>
<div class="info">
<p class="desc">所在地：<?php echo area_pos($t['areaid'], '/', 2);?></p>
<p class="desc">关注数：<i class="num"><?php echo $t['hits'];?></i>人</p>
</div>
</div>
</a>
</li>
<?php } } ?>
</ul>
</div>
<!-- 最新医疗供应行情 end-->
</div>
<div class="right-area w260">
<!-- 招标采购 -->
<div class="col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">招标采购</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">更多</a>
</div>
<ul class="col-bd txt-list pd-20">
<?php $buy_tags = tag("moduleid=6&fields=linkurl,title&condition=status=3&pagesize=5&order=itemid desc&template=null")?>
<?php if(is_array($buy_tags)) { foreach($buy_tags as $k => $t) { ?>
<li><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></li>
<?php } } ?>
</ul>
</div>
<!-- 招标采购 end-->
</div>
</div>
</div>
<!-- 供求行情 end-->
<!-- 产品信息 -->
<div class="layout green-skin" id="product">
<div class="layout-hd clearfix">
<h2>产品信息</h2>
<em class="intro">海量产品精准分类，快捷找到适合的货品</em>
<a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=16" target="_blank" class="btn-action">发布产品信息</a>
</div>
<div class="layout-bd clearfix">
<div class="left-area w260 pd-20">
<!-- 医疗器械分类 -->
<dl class="cate-list cate-list-lg">
<dt><strong>医疗器械分类</strong></dt>
<dd class="mgt-10">
<?php if(is_array($mall_catid)) { foreach($mall_catid as $k => $t) { ?>
<?php if($t['catid'] == '1027') continue; ?>
<?php if($k > 24) break; ?>
<a class="text-overflow" href="<?php echo $MODULE['16']['linkurl'];?><?php echo $t['catdir'];?>/" title="<?php echo $t['catname'];?>"><?php echo $t['catname'];?></a>
<?php } } ?>
</dd>
</dl>
<!--医疗器械分类 end-->
<!--医院科室分类-->
<dl class="cate-list cate-list-md mgt-20">
<dt><strong>医院科室分类</strong></dt>
<dd class="mgt-10">
<?php if(is_array($keshi_catid)) { foreach($keshi_catid as $k => $t) { ?>
<?php if($k > 35) break; ?>
<a class="text-overflow" href="<?php echo $MODULE['16']['linkurl'];?><?php echo keshi_rewrite(['kcatid'=>$t['catid']]);?>"><?php echo $t['catname'];?></a>
<?php } } ?>
</dd>
</dl>
<!-- 医院科室分类 end-->
</div>
<div class="mid-area w640">
<!-- 推荐医疗产品信息 -->
<div class="col product-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['16']['linkurl'];?><?php echo rewrite('search.php?tc=1');?>" target="_blank">推荐医疗产品信息</a></h3>
<div class="btn-area pull-right">
<a class="prev font-hide" href="javascript:;">上一页</a>
<a class="next font-hide" href="javascript:;">下一页</a>
</div>
<ul class="hidden"></ul>
</div>
<div class="col-bd pd-10 clearfix">
<div class="ulWrap">
<?php $mall_tc_tags = tag("moduleid=16&table=mall&fields=linkurl,thumb,title&condition=groupid=7 and status = 3&pagesize=16&order=hits desc &template=null")?>
<?php if(is_array($mall_tc_tags)) { foreach($mall_tc_tags as $k => $t) { ?>
<?php if($k%4 == 0) { ?><ul><?php } ?>
<li class="product-item pd-10">
<a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="lazy-img" src="<?php echo DT_SKIN;?>image/blank.gif" _src="<?php echo $t['thumb'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/no-pic.png';" alt="<?php echo $t['title'];?>" /></a>
<p class="title"><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['title'];?>" target="_blank"><?php echo $t['title'];?></a></p>
</li>
<?php if(($k+1)%4 == 0) { ?></ul><?php } ?>
<?php } } ?>
</div>
</div>
</div>
<!-- 推荐医疗产品信息 end-->
</div>
<div class="right-area w260">
<!-- 产品服务平台 -->
<div class="col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left">产品服务平台</h3>
</div>
<div class="col-bd pd-10">
<a href="http://www.sharedour.com/" target="_blank"><img class="lazy"  src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-xd.jpg" width="240" height="160" alt=""></a>
<a href="http://www.medcha.com/" target="_blank"><img class="lazy mgt-10" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-tl.jpg" width="240" height="160" alt=""></a>
</div>
</div>
<!-- 产品服务平台 end-->
</div>
</div>
</div>
<!-- 产品信息 end-->
<!--厂商信息-->
<div class="layout violet-skin" id="company">
<div class="layout-hd clearfix">
<h2>厂商信息</h2>
<em class="intro">海量优质供应商资源，连通上下游</em>
<a href="<?php echo $MODULE['2']['linkurl'];?>grade.php" target="_blank" class="btn-action">立即开设网店</a>
</div>
<div class="layout-bd clearfix">
<div class="left-area w260 pd-20">
<!--厂商类型-->
<dl class="cate-list cate-list-md">
<dt><strong>厂商类型</strong></dt>
<dd class="mgt-10">
<a class="text-overflow" href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['mode'=>1]);?>">生产商</a>
<a class="text-overflow" href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['mode'=>2]);?>">贸易商</a>
<a class="text-overflow" href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['mode'=>3]);?>">服务商</a>
</dd>
</dl>
<!--厂商类型 end-->
<!-- 经营范围 -->
<dl class="cate-list cate-list-lg mgt-20">
<dt><strong>经营范围</strong></dt>
<dd class="mgt-10">
<?php $company_cat_tags = tag("moduleid=4&table=category&fields=linkurl,catid,catname&condition=moduleid=4 and parentid=0&pagesize=50&order=listorder asc&template=null")?>
<?php if(is_array($company_cat_tags)) { foreach($company_cat_tags as $k => $t) { ?>
<a class="text-overflow" href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['catid'=>$t['catid']]);?>"><?php echo $t['catname'];?></a>
<?php } } ?>
</dd>
</dl>
<!--经营范围 end-->
</div>
<div class="mid-area w640">
<!-- 推荐厂商网店 -->
<div class="col company-col line-t-1">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['4']['linkurl'];?>search.php?vip=1&validated=1" target="_blank">推荐厂商网店</a></h3>
<div class="btn-area pull-right">
<a class="prev font-hide" href="javascript:;">上一页</a>
<a class="next font-hide" href="javascript:;">下一页</a>
</div>
<ul class="hidden"></ul>
</div>
<div class="col-bd mg-10 clearfix">
<ul class="ulWrap">
<?php $company_recom_tags = tag("moduleid=4&fields=linkurl,thumb,company,areaid,pnum&condition=pnum>0 and hits>20 and groupid=7 and closeshop=0&pagesize=16&order=pnum desc,level desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($company_recom_tags)) { foreach($company_recom_tags as $k => $t) { ?>
<?php if($k%4 == 0) { ?><li><?php } ?>
<a class="company-item" href="<?php echo $t['linkurl'];?>" target="_blank">
<div class="img-area pull-left"><img class="lazy-img" src="<?php echo DT_SKIN;?>image/blank.gif" _src="<?php echo $t['thumb'];?>" onerror="javascript:this.src='<?php echo DT_SKIN;?>image/no-pic.png';" alt="<?php echo $t['company'];?>LOGO"></div>
<div class="txt-area pull-right">
<h4 class="text-overflow" title="<?php echo $t['company'];?>"><?php echo $t['company'];?></h4>
<div class="info">
<p class="desc">所在地区：<?php echo area_pos($t['areaid'], '/', 2);?></p>
<p class="desc">产品总数：<i class="num"><?php echo $t['pnum'];?></i></p>
</div>
</div>
</a>
<?php if(($k+1)%4 == 0) { ?></li><?php } ?>
<?php } } ?>
</ul>
</div>
</div>
<!-- 推荐厂商网店 end-->
</div>
<div class="right-area w260">
<!-- 医疗机构 -->
<div class="col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['catid'=>2365]);?>" target="_blank">医疗机构</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['4']['linkurl'];?><?php echo com_rewrite(['catid'=>2365]);?>" target="_blank">更多</a>
</div>
<ul class="col-bd txt-list pd-20">
<?php $company_hos_tags = tag("moduleid=4&fields=linkurl,company&condition=closeshop=0 and catids like '%2365%'&pagesize=7&order=level desc,userid desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($company_hos_tags)) { foreach($company_hos_tags as $k => $t) { ?>
<li class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['company'];?>"><?php echo $t['company'];?></a></li>
<?php } } ?>
</ul>
</div>
<!-- 医疗机构 end-->
</div>
</div>
<div class="layout-ft">
<div class="company-list">
<div class="company-list-hd">
<div class="btn-area">
<a class="prev font-hide" href="javascript:;">上一页</a>
<a class="next font-hide" href="javascript:;">下一页</a>
</div>
<ul class="hidden"></ul>
</div>
<div class="company-list-bd pdt-20 pdb-20">
<ul>
<?php $company_new_tags = tag("moduleid=4&fields=linkurl,thumb,company&condition=groupid>5 and groupid<>8 and thumb <> '' and closeshop=0&pagesize=24&order=userid desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($company_new_tags)) { foreach($company_new_tags as $k => $t) { ?>
<li><a href="<?php echo $t['linkurl'];?>" target="_blank"><img class="lazy-img" src="<?php echo DT_SKIN;?>image/blank.gif" _src="<?php echo $t['thumb'];?>" alt="<?php echo $t['company'];?>"><p><?php echo dsubstr($t['company'],24,'');?></p></a></li>
<?php } } ?>
</ul>
</div>
</div>
</div>
</div>
<!--厂商信息 end-->
<!--天成DSP-->
<div class="layout" style="padding:0;">
<?php echo ad(42);?>
</div>
<!--天成DSP end-->
<!--设备服务-->
<div class="layout red-skin" id="equipment">
<div class="layout-hd clearfix">
<h2>设备服务</h2>
<em class="intro">全国分地区分类，提供便捷的工程师上门服务</em>
<a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=9" target="_blank" class="btn-action">发布设备服务信息</a>
</div>
<div class="layout-bd clearfix">
<div class="left-area w470">
<!--设备服务需求-->
<div class="col equipment-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?type=99');?>" target="_blank">设备服务需求</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?type=99');?>" target="_blank">更多</a>
</div>
<div class="col-bd">
<?php $job_new_tags=tag("moduleid=9&fields=catid,linkurl,title,areaid,hits&condition=status=3 and step<4 &pagesize=8&order=itemid desc&debug=0&showcat=1&template=null")?>
<?php foreach($job_catid as $r){
                    $job_category[$r['catid']] = $r['catname'];
                    }
                    ?>
<?php if(is_array($job_new_tags)) { foreach($job_new_tags as $k => $t) { ?>
<div class="equipment-item">
<div class="title clearfix">
<a class="type" href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?catid='.$t['catid']);?>"><?php echo str_replace('服务','',$job_category[$t['catid']]);?></a>
<h4 class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h4>
</div>
<div class="info">
<span class="desc"><b>地区：</b><a href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?areaid='.$t['areaid']);?>"><?php echo area_pos($t['areaid'], '/', 2);?></a></span>
<span class="desc mgl-10"><b>关注：</b><i class="num"><?php echo $t['hits'];?></i></span>
</div>
</div>
<?php } } ?>
</div>
</div>
<!--设备服务需求 end-->
</div>
<div class="mid-area w470">
<!--技术工程师-->
<div class="col engineer-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?action=resume');?>" target="_blank">技术工程师</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?action=resume');?>" target="_blank">更多</a>
</div>
<div class="col-bd">
<?php $resume_new_tags = tag("moduleid=9&fields=linkurl,thumb,title,truename,username,areaid&table=resume&condition=status=3 and thumb <> ''&pagesize=8&order=itemid desc&template=null&debug=0&showcat=1")?>
<?php if(is_array($resume_new_tags)) { foreach($resume_new_tags as $k => $t) { ?>
<?php $com = $db->get_one("select thumb from {$db->pre}company where username = '".$t['username']."'")?>
<div class="engineer-item">
<a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="avatar pull-left lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo useravatar($t['username'],'large');?>" alt="<?php echo $t['title'];?>"></a>
<div class="txt-area pull-right">
<h4 class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h4>
<div class="info">
<span class="desc"><i class="user-icon"></i><?php echo $t['truename'];?></span>
<span class="desc mgl-10"><i class="local-icon"></i><a href="<?php echo $MODULE['9']['linkurl'];?><?php echo rewrite('search.php?ation=resume&areaid='.$t['areaid']);?>" title="<?php echo $t['title'];?>"><?php echo area_pos($t['areaid'], '/', 2);?></a></span>
</div>
</div>
</div>
<?php } } ?>
</div>
</div>
<!--技术工程师 end-->
</div>
<div class="right-area w260">
<!--技术资料共享-->
<div class="col doc-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['15']['linkurl'];?>" target="_blank">技术资料共享</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['15']['linkurl'];?>">更多</a>
</div>
<div class="col-bd pd-20">
<?php $gongxiang_new_tags = tag("moduleid=15&catid=404&fields=thumb,linkurl,title,fileext,hits,download,catid&condition=status=3 &pagesize=5&order=itemid desc&template=null&debug=0")?>
<?php if(is_array($gongxiang_new_tags)) { foreach($gongxiang_new_tags as $k => $t) { ?>
<div class="doc-item">
<h4 class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><img class="lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/down/file/<?php echo $t['fileext'];?>.jpg" alt="<?php echo $t['fileext'];?>"><?php echo $t['title'];?></a></h4>
<div class="info">
<?php $cat = get_cat($t['catid'])?>
<span class="desc"><i class="type-icon"></i><?php echo $cat['catname'];?></span>
<span class="desc mgl-10"><i class="view-icon"></i><?php echo $t['hits'];?></span>
<span class="desc mgl-10"><i class="down-icon"></i><?php echo $t['download'];?></span>
</div>
</div>
<?php } } ?>
</div>
</div>
<!--技术资料共享 end-->
</div>
</div>
</div>
<!--设备服务 end-->
<!--天成DSP-->
<div class="layout" style="padding:0;">
<?php echo ad(43);?>
</div>
<!--天成DSP end-->
<!--产业服务-->
<div class="layout blue-skin" id="service">
<div class="layout-hd clearfix">
<h2>产业服务</h2>
<em class="intro">服务于医疗行业全产业链，提供全面完整的解决方案</em>
</div>
<div class="layout-bd clearfix">
<div class="left-area w470">
<!--人才服务-->
<div class="col job-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="http://www.tecejob.com/" target="_blank">人才服务</a><em>职帅</em></h3>
<a class="more pull-right" href="<?php echo $MODULE['28']['linkurl'];?>" target="_blank">回到旧版</a>
<a class="more pull-right bdln" href="http://www.tecejob.com/member/index.php?c=jobadd" target="_blank">发布招聘</a>
<a class="more pull-right bdln" href="http://www.tecejob.com/member/index.php?c=expect" target="_blank">发布简历</a>
</div>
<div class="col-bd pdt-10 pdb-10 clearfix">
<a href="http://www.tecejob.com/" target="_blank">
<img class="lazy" src="<?php echo DT_SKIN;?>image/blank.png" data-original="<?php echo DT_SKIN;?>image/tecejob-fail-img.png" width="448" alt="职帅" style="margin:0 auto;">
</a>
</div>
</div>
<!--人才服务 end-->
</div>
<div class="mid-area w470">
<!--科技服务-->
<div class="col tech-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['7']['linkurl'];?>" target="_blank">科技服务</a><em>科琅</em></h3>
<a class="more pull-right" href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=7" target="_blank">发布资质信息</a>
</div>
<div class="col-bd pdt-10 pdb-10 clearfix">
<a class="item-1" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=kyxmzh#kyxmzh_div" target="_blank">科研项目转化</a>
<a class="item-2" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=zltxfd#zltxfd_div" target="_blank">开放实验室</a>
<a class="item-3" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=sczyxk#sczyxk_div" target="_blank">质量体系辅导</a>
<a class="item-4" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=cpzc#cpzc_div" target="_blank">注册临床咨询</a>
<a class="item-5" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=lczx#lczx_div" target="_blank">生产经营许可证</a>
<a class="item-6" href="<?php echo $MODULE['7']['linkurl'];?>solution.php?action=zfzjxmsb#zfzjxmsb_div" target="_blank">政府资金项目申报</a>
</div>
</div>
<!--科技服务 end-->
<!--宣传广告-->
<div class="col pd-10 clearfix">
<a href="http://yiliantong.tecenet.com/" target="_blank"><img class="pull-left lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-ylt.jpg" width="218" height="96"  alt="医链通"></a>
<a href="http://www.tecenet.com/about/jiankang.html" target="_blank"><img class="pull-right lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-yy.jpg" width="218" height="96" alt="医养健康事业部"></a>
</div>
<!--宣传广告 end-->
</div>
<div class="right-area w260">
<div class="col">
<div class="pd-10">
<a href="http://www.tecenet.com/about/tianyi.html" target="_blank"><img class="lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-ty.jpg" width="240" height="96" alt="医学工程"></a>
</div>
<div class="pd-10 line-t-1">
<a href="http://www.eydsp.com/" target="_blank"><img class="lazy"  src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-ey.jpg" width="240" height="96" alt="电子商务"></a>
</div>
<div class="pd-10 line-t-1">
<a href="http://www.tecenet.com/about/yirongjia.html" target="_blank"><img class="lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo DT_SKIN;?>image/about-yrj.jpg" width="240" height="96" alt="供应和信息系统"></a>
</div>
</div>
</div>
</div>
</div>
<!--产业服务 end-->
<!--天成DSP-->
<div class="layout" style="padding:0;">
<?php echo ad(44);?>
</div>
<!--天成DSP end-->
<!--产业资讯-->
<div class="layout orange-skin" id="news">
<div class="layout-hd clearfix">
<h2>产业资讯</h2>
<em class="intro">最值得关心的医疗产业最新消息</em>
<a href="<?php echo $MODULE['2']['linkurl'];?>my.php?action=add&mid=21" target="_blank" class="btn-action">发布产业资讯信息</a>
</div>
<div class="layout-bd clearfix">
<div class="left-area w300">
<!--资讯动态-->
<div class="col top-news-col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?>" target="_blank">资讯动态</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['21']['linkurl'];?>" target="_blank">更多</a>
</div>
<div class="col-bd pd-10">
<div class="img-change">
<ul>
<?php $article_new_tags = tag("moduleid=21&fields=title,linkurl,thumb&condition=status=3 and level>0 and thumb<>'' and catid!=2018&order=level desc,addtime desc&pagesize=5&template=null&showcat=1")?>
<?php if(is_array($article_new_tags)) { foreach($article_new_tags as $k => $t) { ?>
<li>
<a href="<?php echo $t['linkurl'];?>" target="_blank"><img class="lazy-img" src="<?php echo DT_SKIN;?>image/blank.gif" _src="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"></a>
<p class="text-overflow"><a href="<?php echo $t['linkurl'];?>"><?php echo $t['title'];?></a></p>
</li>
<?php } } ?>
</ul>
<a href="javascript:;" class="prev font-hide">上一页</a>
<a href="javascript:;" class="next font-hide">下一页</a>
</div>
<ul class="txt-list">
<?php $article_new_tags = tag("moduleid=21&fields=title,linkurl&condition=status=3 and level>0 and thumb<>'' and catid!=2018&order=level desc,addtime desc&pagesize=6&page=2&template=null&showcat=1")?>
<?php if(is_array($article_new_tags)) { foreach($article_new_tags as $k => $t) { ?>
<li class="text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<!--资讯动态 end-->
</div>
<div class="mid-area w640">
<!--天成动态-->
<div class="col tc-news">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>2371]);?>" target="_blank">天成动态</a></h3>
<div class="btn-area pull-right">
                            <a class="prev font-hide" href="javascript:;">上一页</a>
                            <a class="next font-hide" href="javascript:;">下一页</a>
                        </div>
                        <ul class="hidden"></ul>
</div>
<ul class="col-bd pd-20">
<?php $catid_data = $db->query("select catid from {$db->pre}category where arrparentid like '%2371%'")?>
<?php
                    $cat = array();
                    while($r = $db->fetch_array($catid_data)){
$cat[] = $r['catid'];
}
$cat[] = '2371';
$cat_str = implode(',',$cat);
?>
<?php $article_2371_tags = tag("moduleid=21&fields=linkurl,title,edittime,introduce,thumb&condition=status=3 and catid in ($cat_str)&order=itemid desc&pagesize=6&template=null")?>
<?php if(is_array($article_2371_tags)) { foreach($article_2371_tags as $k => $t) { ?>
<li class="tc-news-item <?php if(!$t['thumb']) { ?>tc-news-item-nopic<?php } ?>
">
<?php if($t['thumb']) { ?>
                            <img class="news-item-img lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"/ >
<?php } ?>
                            <div class="news-item-txt">
                                <div class="title clearfix"><h4 class="pull-left text-overflow"><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></h4></div>
                                <div class="desc"><?php echo $t['introduce'];?></div>
                            </div>
                        </li>
<?php } } ?>
</ul>
</div>
<!--天成动态 end-->
<!--媒体报道-->
<div class="col media-news line-t-1">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo DT_PATH;?>link/<?php echo rewrite('index.php?typeid=225');?>" target="_blank">媒体报道</a></h3>
<div class="btn-area pull-right">
                            <a class="prev font-hide" href="javascript:;">上一页</a>
                            <a class="next font-hide" href="javascript:;">下一页</a>
                        </div>
                        <ul class="hidden"></ul>
</div>
<ul class="col-bd pd-10 clearfix">
<?php $link_tags = tag("table=link&condition=status=3 and typeid=225&areaid=$cityid&pagesize=4&order=level desc,listorder asc,itemid desc&template=null")?>
<?php if(is_array($link_tags)) { foreach($link_tags as $k => $t) { ?>
<li class="media-news-item">
<a class="img-area pull-left" href="<?php echo $t['linkurl'];?>" target="_blank"><img class="lazy" src="<?php echo DT_SKIN;?>image/blank.gif" data-original="<?php echo $t['thumb'];?>" alt="<?php echo $t['title'];?>"></a>
<h4><a href="<?php echo $t['linkurl'];?>" target="_blank"><?php echo $t['title'];?></a></h4>
</li>
<?php } } ?>
</ul>
</div>
<!--媒体报道 end-->
</div>
<div class="right-area w260">
<!--政策法规-->
<div class="col">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>840]);?>" target="_blank">政策法规</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>840]);?>" target="_blank">更多</a>
</div>
<ul class="col-bd txt-list pd-20">
<?php $catid_data = $db->query("select catid from {$db->pre}category where arrparentid like '%844%'")?>
<?php
                    $cat = array();
                    while($r = $db->fetch_array($catid_data)){
$cat[] = $r['catid'];
}
$cat[] = '840';
$cat_str = implode(',',$cat);
?>
<?php $article_840_tags = tag("moduleid=21&fields=linkurl,title&condition=status=3 and catid in ($cat_str)&order=itemid desc&pagesize=3&template=null")?>
<?php if(is_array($article_840_tags)) { foreach($article_840_tags as $k => $t) { ?>
<li><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></li>
<?php } } ?>
</ul>
</div>
<!--政策法规 end-->
<!--展会信息-->
<div class="col line-t-1">
<div class="col-hd pd-10 clearfix">
<h3 class="pull-left"><a href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>844]);?>" target="_blank">展会信息</a></h3>
<a class="more pull-right" href="<?php echo $MODULE['21']['linkurl'];?><?php echo article_rewrite(['catid'=>844]);?>" target="_blank">更多</a>
</div>
<ul class="col-bd txt-list pd-20">
<?php $catid_data = $db->query("select catid from {$db->pre}category where arrparentid like '%844%'")?>
<?php
                    $cat = array();
                    while($r = $db->fetch_array($catid_data)){
$cat[] = $r['catid'];
}
$cat[] = '844';
$cat_str = implode(',',$cat);
?>
<?php $article_844_tags = tag("moduleid=21&fields=title,linkurl&condition=status=3 and catid in ($cat_str)&order=itemid desc&pagesize=3&template=null")?>
<?php if(is_array($article_844_tags)) { foreach($article_844_tags as $k => $t) { ?>
<li><a href="<?php echo $t['linkurl'];?>" target="_blank" title="<?php echo $t['title'];?>"><?php echo $t['title'];?></a></li>
<?php } } ?>
</ul>
</div>
<!--展会信息 end-->
</div>
</div>
</div>
<!--产业资讯 end-->
<!-- 友情连接 -->
<div class="layout">
<div class="links-tab">
<div class="links-tab-hd">
<ul class="clearfix">
<?php $link_title_tags = tag("table=type&condition=item='link'&pagesize=10&order=listorder asc&template=null")?>
<?php if(is_array($link_title_tags)) { foreach($link_title_tags as $k => $t) { ?>
<?php if($t['typeid'] == 225) continue; ?>
<li><a href="<?php echo $EXT['link_url'];?>index.php?typeid=<?php echo $t['typeid'];?>"><?php echo $t['typename'];?></a></li>
<?php } } ?>
</ul>
<a class="join-btn" href="<?php echo DT_PATH;?>link/<?php echo rewrite('index.php?action=reg');?>">申请加入</a>
</div>
<div class="links-tab-bd">
<?php if(is_array($link_title_tags)) { foreach($link_title_tags as $k => $t) { ?>
<?php if($t['typeid'] == 225) continue; ?>
<ul>
<?php $link_web_tags = tag("table=link&condition=status=3  and link_moduleid=0 and typeid=".$t['typeid']."&pagesize=".$DT['page_text']."&order=listorder asc,itemid desc&template=null");?>
<?php if(is_array($link_web_tags)) { foreach($link_web_tags as $lk => $lt) { ?>
<li class="text-overflow"><a href="<?php echo $lt['linkurl'];?>"><?php echo $lt['title'];?></a></li>
<?php } } ?>
</ul>
<?php } } ?>
</div>
</div>
</div>
<!-- 友情连接 end-->
</div>
<!--wrap end-->
<!--elevator-->
<div class="elevator" style="display: none;">
<dl class="elevator-item elevator-service">
<dt><i></i>客服</dt>
<dd>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1465794385&amp;site=qq&amp;menu=yes" rel="nofollow">产品服务</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2300379865&amp;site=qq&amp;menu=yes" rel="nofollow">招商推广</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1928771453&amp;site=qq&amp;menu=yes" rel="nofollow">设备技术</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3381476778&amp;site=qq&amp;menu=yes" rel="nofollow">配件耗材</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=379255200&amp;site=qq&amp;menu=yes" rel="nofollow">资质服务</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1391268333&amp;site=qq&amp;menu=yes" rel="nofollow">管理软件</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1515050627&amp;site=qq&amp;menu=yes" rel="nofollow">医疗人才</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=786466321&amp;site=qq&amp;menu=yes" rel="nofollow">工程装修</a>
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=657911476&amp;site=qq&amp;menu=yes" rel="nofollow">网站客服</a>
</dd>
</dl>
<dl class="elevator-item elevator-tel">
<dt><i></i>电话</dt>
<dd>
<p>400-617-3599</p>
</dd>
</dl>
<dl class="elevator-item elevator-msg">
<dt><a href="http://www.tecenet.com/guestbook/#ask" target="_blank"><i></i>留言</a></dt>
</dl>
<ul>
<li class="menu-item"><a href="#supply">供求行情</a></li>
<li class="menu-item"><a href="#product">产品信息</a></li>
<li class="menu-item"><a href="#company">厂商信息</a></li>
<li class="menu-item"><a href="#equipment">设备服务</a></li>
<li class="menu-item"><a href="#service">产业服务</a></li>
<li class="menu-item"><a href="#news">产业资讯</a></li>
</ul>
<a class="elevator-item to-top" href="#tcTopNav">顶部</a>
</div>
<!-- elevator end-->
<?php include template('footer2017');?>
