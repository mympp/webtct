<?php 
require 'config.php';
$news = new tcdb('article_21');
$usernews = $news->field('itemid,title,addtime')->where(['status'=>3,'username'=>USERNAME])->order('itemid desc')->all();
?> 

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>成人用品知识大全,如何购买成人用品及用法-安芮成人用品网</title>
    <meta name="keywords" content="如何购买成人用品,成人用品介绍,情趣用品怎么用,成人用品知识,成人用品资讯" />
    <meta name="description" content="成人用品资讯大全,介绍如何购买成人用品，情趣用品怎么用等相关成人用品相关知识,国内最全的成人用品资讯网。" />

    <link href="./css/NVToys.index.css?v=0.0.3" rel="stylesheet">
</head>
<body>

<!--wrap-->
<div class="wrap">
	<?php require 'template/header.php'; ?>

    <!--list-wrap-->
    <div class="list-wrap">
        <div class="layout clearfix">
            <div class="main pull-right">
                <!--crumb-->
                <div class="crumb">
                    <span>您当前的位置：</span>
                    <a href="index.html">首页</a> »
                    <a href="newlist.html">信息中心</a>
                </div>
                <!--crumb end-->

                <!--list-area-->
                <div class="list-area">
                    <ul class="news-list">
                    	 <?php foreach($usernews as $k=>$v){ ?>
						 	<li>
                            	<span class="title"><a href="news-<?php echo $v['itemid']; ?>.html"><?php echo $v['title']; ?></a></span>
                            	<span class="date"><?php date('Y-m-d',$v['addtime']); ?></span>
                        	</li>
						 <?php } ?>
                        
                    </ul>
                </div>
                <!--list-area end-->
            </div>
           
           <?php require 'template/pull-left.php'; ?>
           
        </div>
    </div>
    <!--list-wrap end-->

    <?php require 'template/contact.php'; ?>
	
	<?php require 'template/agents.php'; ?>
</div>
<!--wrap end-->

<script type="text/javascript" src="http://www.tecenet.com/file/script/jquery.js"></script>
<script type="text/javascript" src="./js/nv-toys.list.js"></script>
<?php require 'template/analytics.php'; ?>

</body>
</html>