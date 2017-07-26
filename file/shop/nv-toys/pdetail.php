<?php
	require 'config.php'; 
	if(!isset($_GET['itemid'])) header('index.php');
	$itemid = $_GET['itemid'];
	$item = $mall->field('itemid,title,mycatid')->where(['itemid'=>$itemid])->one();
	$mall_data = new tcdb('mall_data');
	$content = $mall_data->where(['itemid'=>$itemid])->one();
	$type = new tcdb('type');
	$user_type = $type->field('typename')->where(['typeid'=>$item['mycatid']])->one();
	$seo_title = $item['title'].'-'.$user_type['typename'].' - 安芮成人用品网';
	$seo_keywords = $item['title'].','.$user_type['typename'].',安芮成人用品';
	$seo_description = $item['title'].'图片、价格、品牌尽在安芮成人用品网！';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $seo_title; ?></title>
    <meta name="keywords" content="<?php echo $seo_keywords; ?>" />
    <meta name="description" content="<?php echo $seo_description; ?>" />

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
                    <a href="plist.html">所有产品</a>
                </div>
                <!--crumb end-->

                <!--product-area-->
                <div class="product-area">

                    <h1><?php echo $item['title']; ?></h1>

                    <img src="./images/yjdf.jpg" alt="意见代发">

                    <div class="product-img">
                        <?php echo $content['content']; ?>
                    </div>
                </div>
                <!--product-area end-->
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
<script>
    window.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        var num = $("#top").height() + $("#index").height() + $(".nav-bar").height() + $(".list-wrap .side .pro-cate").height() +  $(".list-wrap .side .pro-search").height() + 40;
        btmNum = $("#top").height() + $("#index").height() + $(".nav-bar").height()  + $(".list-wrap").height() - $(".pro-rec").height()/2 - 100;

        if( t >= num) {
            $(".pro-rec").addClass("fixed");
            if( t>=btmNum){
                $(".pro-rec").removeClass("fixed");
            }
        }else {
            $(".pro-rec").removeClass("fixed");
        }
    }
</script>
<?php require 'template/analytics.php'; ?>

</body>
</html>