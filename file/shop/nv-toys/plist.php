<?php
	require 'config.php'; 
	$typeid = isset($_GET['typeid']) ? $_GET['typeid'] : '0';
	$kw = isset($_GET['kw']) ? $_GET['kw'] : '';
	
	$type = new tcdb('type');
	if($typeid){
		$usertype = $type->where(['typeid'=>$typeid])->one();
		$childtype = $type->field('typeid,typename')->where(['parentid'=>$typeid])->all();
		if($usertype['parentid'] == 0){		//一级分类
			$seo_title = $usertype['typename'].'成人用品商店，专业批发，代发'.$usertype['typename'].'成人用品大全 - 安芮成人用品网';
			$seo_keywords = $usertype['typename'].'成人用品,'.$usertype['typename'].'情趣用品';
			$child_type_name = [];
			foreach($childtype as $v){
				$child_type_name[] = $v['typename'];
			}
			
			$im_ctn = implode(',',$child_type_name);
			$seo_description = '安芮'.$usertype['typename'].'成人用品商店，专业批发，代发'.$usertype['typename']."成人用品的".$im_ctn."，各个商品价格，图片等产品大全 - 安芮成人用品网";
		}else{
			$parent_type = $type->where(['typeid'=>$usertype['parentid']])->one();
			$seo_title = $parent_type['typename'].$usertype['typename'].'成人用品商店，专业批发，代发'.$parent_type['typename'].$usertype['typename'].'成人用品大全 - 安芮成人用品网';
			$seo_keywords = $parent_type['typename'].$usertype['typename'].'成人用品,'.$parent_type['typename'].$usertype['typename'].'情趣用品';
			$seo_description = '安芮'.$parent_type['typename'].$usertype['typename'].'成人用品商店，专业批发，代发'.$parent_type['typename'].$usertype['typename'].'成人用品，包含'.$parent_type['typename'].$usertype['typename'].'情趣用品商品的价格，图片等产品大全 - 安芮成人用品网';
		}
		
	}else{
		$seo_title = '安芮情趣用品专卖店，专业批发，代发安芮成人用品大全 - 安芮成人用品网';
		$seo_keywords = '成人用品大全,情趣用品商店,安芮成人用品,nvtoys情趣用品';
		$seo_description = '安芮成人用品商城，专业批发，加盟代理男女成人情趣用品。包含男女性性用品、自慰用品、振动棒，飞机杯跳蛋等男女性情趣用品。欢迎批发，加盟，和代售购买。';
		$childtype = $type->field('typeid,typename')->where(['item'=>'mall-'.USERID,'parentid'=>0])->all();
	}
	
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

				<?php if($kw){ ?>
					<?php require 'template/kw-list.php'; ?>
				<?php }else{ ?>
					<?php require 'template/type-list.php'; ?>
				<?php } ?>
                
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