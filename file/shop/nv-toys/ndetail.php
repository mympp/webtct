<?php 
require 'config.php';
if(!isset($_GET['itemid'])) header('index.php');
$itemid = $_GET['itemid'];
$news = new tcdb('article_21');
$news_data = new tcdb('article_data_21');
$usernews = $news->field('title,keyword,introduce')->where(['itemid'=>$itemid])->one();
$usernews_data = $news_data->field('content')->where(['itemid'=>$itemid])->one();
?> 
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $usernews['title']; ?> - 安芮成人用品网</title>
    <meta name="keywords" content="<?php echo $usernews['keyword'].','.$usernews['title']; ?>"/>
    <meta name="description" content="<?php  
    	if(empty($usernews['introduce'])){
			echo $usernews['title'];
		}else{
			echo $usernews['introduce'];
		}
    ?>" />

    <link href="./css/NVToys.index.css?ver=0.0.3" rel="stylesheet">
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
                    <a href="nlist.html">信息中心</a>
                </div>
                <!--crumb end-->

                <!--article-->
                <div class="article">
                    <h1><?php echo $usernews['title']; ?></h1>
                    <div class="content">
                        <?php echo $usernews_data['content']; ?>
                    </div>
                </div>
                <!--article end-->
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