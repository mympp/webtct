<?php defined('IN_DESTOON') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/jquery.js"></script>
<link rel="stylesheet" href="<?php echo DT_SKIN;?>tecenet.base.css?v=201708241053">
<?php if(is_array($head_css)) { foreach($head_css as $v) { ?>
<link rel="stylesheet" href="<?php echo $v;?>" />
<?php } } ?>
</head>
<body>
<!-- top-nav -->
<div class="tc-top-nav" id="tcTopNav">
    <div class="w1200 box-center">
        <ul class="tc-top-nav-item pull-left">
            <li class="current"><a href="<?php echo DT_PATH;?>" target="_blank">天成首页</a></li>
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
        <div class="tools pull-right">
            <div class="wap-qrcode">
                <a href="javascript:;">手机版</a>
                <img src="<?php echo DT_SKIN;?>image/wap-qrcode.png" alt="手机天成医疗网二维码" />
            </div>
            <a class="tn-login" href="<?php echo $MODULE['2']['linkurl'];?>login.php" target="_self">登录</a>
            <a class="tn-reg" href="<?php echo $MODULE['2']['linkurl'];?>register.php" target="_self">立即注册</a>
        </div>
    </div>
</div>
<!--tc-top-nav end-->
<!-- tc-header -->
<div class="tc-header page-header">
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
