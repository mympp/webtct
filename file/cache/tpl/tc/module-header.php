<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if(!isset($head_css)) $head_css = [];?>
<?php array_unshift($head_css,DT_SKIN.'tc.page.header.css?v=05.08.01');?>
<?php require_once DT_ROOT.'/include/tcdb.class.php';?>
<!DOCTYPE html>
<html lang="zh-CN">
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
<meta name="viewport" content="width=1240" />
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/jquery.js"></script>
<script>var _hmt = _hmt || [];</script>
<link rel="stylesheet" href="<?php echo DT_SKIN;?>tecenet.base.css">
<?php if(is_array($head_css)) { foreach($head_css as $k => $v) { ?>
<link rel="stylesheet" href="<?php echo $v;?>">
<?php } } ?>
<?php if(is_array($head_js)) { foreach($head_js as $k => $v) { ?>
<script type="text/javascript" src="<?php echo $v;?>"></script>
<?php } } ?>
</head>
<body>
<!--top-bar-->
<div class="top-bar">
    <div class="top-bar-box clearfix">
        <div class="top-bar-menu top-bar-dropdown pull-left">
            <div class="dropdown-title"><a href="<?php echo DT_PATH;?>">天成医疗网</a><i class="arrow"></i></div>
            <ul class="dropdown-body clearfix">
                <li><a href="<?php echo $MODULE['16']['linkurl'];?>" target="_blank">产品</a></li>
            <li><a href="<?php echo $MODULE['9']['linkurl'];?>" target="_blank">维修</a></li>
            <li><a href="<?php echo $MODULE['5']['linkurl'];?>" target="_blank">供需</a></li>
            <li><a href="<?php echo $MODULE['6']['linkurl'];?>" target="_blank">招标</a></li>
            <li><a href="<?php echo $MODULE['7']['linkurl'];?>" target="_blank">资质</a></li>
            <li><a href="<?php echo $MODULE['28']['linkurl'];?>" target="_blank">招聘</a></li>
            <li><a href="<?php echo $MODULE['4']['linkurl'];?>" target="_blank">厂商</a></li>
            <li><a href="<?php echo $MODULE['21']['linkurl'];?>" target="_blank">资讯</a></li>
            <li><a href="<?php echo $MODULE['15']['linkurl'];?>" target="_blank">共享</a></li>
            <li><a href="<?php echo $MODULE['10']['linkurl'];?>" target="_blank">问答</a></li>
            </ul>
        </div>
        <div class="top-bar-divide pull-left"></div>
        <!-- <a class="top-bar-link pull-left" href="" target="_blank" rel="nofollow">招标宝</a> -->
        <!-- <a class="top-bar-link pull-left" href="" target="_blank" rel="nofollow">医单客</a> -->
        <a class="top-bar-link pull-left" href="http://so.tecenet.com/" target="_blank" rel="nofollow" title="医疗器械产业专业搜索引擎">天成医搜</a>
        <a class="top-bar-link pull-left" href="http://hao.tecenet.com/" target="_blank" rel="nofollow" title="中国最大医疗器械厂家导航">医疗厂家导航</a>
        <!--<div class="top-bar-divide pull-left"></div>-->
        <!--<a class="top-bar-link pull-left" href="http://www.sharedour.com/" target="_blank" rel="nofollow" title="国内最全面的在线医疗产品服务平台">享道医械所</a>-->
        <!--<a class="top-bar-link pull-left" href="http://www.medcha.com" target="_blank" rel="nofollow" title="跨境电商">MEDCHA</a>-->
        <div class="top-bar-link pull-right" title="天成医疗网客服"><i class="t-b-i tel"></i>400-617-3599</div>
        <div class="top-bar-divide pull-right"></div>
        <a class="top-bar-link pull-right" href="javascript:;" onclick="javascript:window.open('http://p.qiao.baidu.com/cps/chat?siteId=3215492&amp;userId=6452136&amp;s=tecenet.com','newwindow','height=530,width=600,top=100,left=200,toolbar=no,menubar=no,scrollbars=no,resizeable=no,lacation=no,status=no');_hmt.push(['_trackPageview', '/im/qiao']);"><i class="t-b-i service"></i>在线客服</a>
        <div class="top-bar-divide pull-right"></div>
        <div class="top-bar-mobile top-bar-dropdown pull-right">
            <div class="dropdown-title">移动应用<i class="arrow"></i></div>
            <ul class="dropdown-body clearfix">
                <li><a href="http://shouji.baidu.com/software/7042751.html" target="_blank" onclick="_hmt.push(['_trackEvent', 'TecenetHeader', 'click', 'TecenetApp']);">手机客户端</a></li>
                <li><a href="http://wap.tecenet.com/">WAP站</a></li>
                <li>
                    <a href="javascript:;" onclick="_hmt.push(['_trackEvent', 'TecenetHeader', 'click', 'TecenetWeChatQrcode']);">微信公众号</a>
                    <img src="http://www.tecenet.com/file/image/weixin.jpg" alt="天成医疗网微信公众平台二维码">
                </li>
            </ul>
        </div>
        <div class="top-bar-divide pull-right"></div>
<?php if(!$_userid) { ?>
        <!--注册&登录 -->
        <a class="top-bar-link pull-right" href="<?php echo $MODULE['2']['linkurl'];?>register.php">注册</a>
        <div class="top-bar-login top-bar-dropdown pull-right">
            <div class="dropdown-title">登录<i class="arrow"></i></div>
            <ul class="dropdown-body clearfix">
                <li class="tecenet"><a href="<?php echo $MODULE['2']['linkurl'];?>login.php" rel="nofollow"><i></i>天成账号登录</a></li>
                <li class="wechat"><a href="<?php echo DT_PATH;?>api/oauth/wechat/connect.php" rel="nofollow"><i></i>微信账号登录</a></li>
                <li class="qq"><a href="<?php echo DT_PATH;?>api/oauth/qq/connect.php" rel="nofollow"><i></i>QQ账号登录</a></li>
            </ul>
        </div>
        <!--注册&登录 end-->
<?php } else { ?>
        <!--会员中心-->
        <?php $member_message = new tcdb('message');?>
        <?php $message_count = $member_message->field('count(*) as c')->where(['touser'=>$_username,'status'=>3])->one();?>
        <a href="<?php echo $MODULE['2']['linkurl'];?>message.php" class="top-bar-link top-bar-message pull-right" title="站内信" rel="nofollow"><i class="t-b-i message"></i><?php if($message_count['c']) { ?><em></em><?php } ?>
</a>
        <div class="top-bar-divide pull-right"></div>
        <div class="top-bar-add top-bar-dropdown pull-right">
            <div class="dropdown-title" title="发布"><i class="t-b-i add"></i></div>
            <ul class="dropdown-body clearfix">
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=9" rel="nofollow">设备服务需求</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=9&resume=1" rel="nofollow">技术工程师</a></li>
                <!--<li><a href="">厂家品牌管理</a></li>-->
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=16" rel="nofollow">产品中心管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=5" rel="nofollow">供求行情管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=6" rel="nofollow">招标采购管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=21" rel="nofollow">信息资讯管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=15" rel="nofollow">资料共享管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=7" rel="nofollow">医疗科技管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=10" rel="nofollow">行业问答管理</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=28" rel="nofollow">职位招聘信息</a></li>
                <li><a href="<?php echo $MODULE['2']['linkurl'];?>my.php?mid=28&resume=1" rel="nofollow">个人求职简历</a></li>
            </ul>
        </div>
        <div class="top-bar-divide pull-right"></div>
        <div class="top-bar-member top-bar-dropdown pull-right">
            <div class="dropdown-title"><img class="thumb" src="<?php echo useravatar($_username,'large');?>" alt="avatar"><?php echo $_username;?><i class="arrow"></i></div>
            <div class="dropdown-body user-info">
                <div class="user-info-hd">
                    <a href="<?php echo $MODULE['2']['linkurl'];?>" target="_blank" rel="nofollow"><img class="avatar pull-left" src="<?php echo useravatar($_username,'large');?>" alt="avatar"></a>
                    <dl class="clearfix">
                        <dt class="user-name"><a href="<?php echo $MODULE['2']['linkurl'];?>" target="_blank" rel="nofollow"><?php echo $_username;?></a><?php if($_groupid == 7) { ?><i class="t-b-i vip disable"></i><?php } ?>
</dt>
                        <dd class="clearfix">
                            <a href="<?php echo $MODULE['2']['linkurl'];?>credit.php" target="_blank" rel="nofollow">积分<span><?php echo $_credit;?></span></a>
                            <a href="<?php echo $MODULE['2']['linkurl'];?>" target="_blank" rel="nofollow">天成币<span><?php echo $_money;?></span></a>
                        </dd>
                    </dl>
                </div>
                <ul class="user-info-bd clearfix">
                    <li class="t-b-i order"><a href="<?php echo $MODULE['2']['linkurl'];?>trade.php" target="_blank" rel="nofollow">我的订单</a></li>
                    <li class="t-b-i purchase"><a href="<?php echo $MODULE['2']['linkurl'];?>purchase.php" target="_blank" rel="nofollow">我的采购</a></li>
                    <li class="t-b-i mark"><a href="<?php echo $MODULE['2']['linkurl'];?>favorite.php" target="_blank" rel="nofollow">我的收藏</a></li>
                    <li class="t-b-i friend"><a href="<?php echo $MODULE['2']['linkurl'];?>friend.php" target="_blank" rel="nofollow">我的好友</a></li>
                </ul>
                <div class="user-info-ft">
                    <a href="<?php echo $MODULE['2']['linkurl'];?>member.php" target="_blank" rel="nofollow">会员中心</a>|<a href="<?php echo $MODULE['2']['linkurl'];?>logout.php" rel="nofollow">退出</a>
                </div>
            </div>
        </div>
        <!--会员中心 end-->
        <?php } ?>
    </div>
</div>
<!--top-bar end-->
<!--page-header-->
<div class="page-header">
    <div class="w1200 box-center clearfix">
        <!--logo-->
        <?php if(isset($logo_title) && isset($logo_url)) { ?>
        <a href="<?php echo $MODULE[$moduleid]['linkurl'];?>" class="logo pull-left">
            <h1>天成医疗网<em><?php echo $logo_title;?></em></h1>
            <span><?php echo $logo_url;?></span>
        </a>
        <?php } else { ?>
         <a href="<?php echo DT_PATH;?>" class="logo pull-left">
            <h1>天成医疗网</h1>
            <span><?php echo DT_PATH;?></span>
        </a>
        <?php } ?>
        <!--logo end-->
        <?php include template('search-tool-2017','chip');?>
    </div>
</div>
<!--page-header end-->
<?php include template('menu',$module);?>