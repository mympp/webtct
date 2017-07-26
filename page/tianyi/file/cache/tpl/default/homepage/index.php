<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $template);?>
<!--<script src="<?php echo DT_STATIC;?>file/script/layer.min.js"></script>-->
<script src="<?php echo DT_STATIC;?>company/layer/layer.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['4']['moduledir'];?>/skin/company_profile.css"/>
<div class="c_b"></div>
<div class="m">
    <div class="com-intro-img">
        <img src="<?php echo $COM['image'];?>"/>
    </div>
    <div class="com-intro-text">
        <div class="profiles">
            <span>COMPANY PROFILES</span>
            <div class="profiles-line">企业简介</div>
            <div class="company_line"></div>
        </div>
        <div class="com-desc">
            <?php echo $notimgcontent;?>
        </div>
        <div class="com-desc-more">
            <span><a href="<?php echo $introduceurl;?>" class="color5fbc31">查看详细</a></span>
        </div>
    </div>
</div>
<div class="c_b"></div>
<div class="m">
    <div class="com-honner">
        <div class="desc-title">
            <div class="title-show">
                <div class="icon-line"></div>
                <div class="icon-text">荣誉资质</div>
                <div class="icon-line"></div>
            </div>
            <div class="c_b"></div>
            <div class="title-eng">
                <span>HONORS AND QUALIFICATIONS</span>
            </div>
        </div>
        <div class="honors-list">
            <div>
                <div class="point-left" onclick="javascript:void(0);"></div>
            </div>
            <div id="honors-list-img">
                <ul id="imgs">
                    <?php if(is_array($honor_list)) { foreach($honor_list as $k => $v) { ?>
                    <li class="bor-r">
                        <div class="div-img"><img src="<?php echo $v['image'];?>" data-title="<?php echo $v['title'];?>"/></div>
                        <div><span><?php echo $v['title'];?></span></div>
                    </li>
                    <?php } } ?>
                </ul>
            </div>
            <div>
                <div class="point-right" onclick="javascript:void(0);"></div>
            </div>
        </div>
    </div>
</div>
<div class="c_b"></div>
<script type="text/javascript" src="<?php echo DT_STATIC;?><?php echo $MODULE['4']['moduledir'];?>/skin/company_img.js"></script>
<div class="m">
    <div class="com-goods">
        <div class="desc-title">
            <div class="title-show">
                <div class="icon-line"></div>
                <div class="icon-text">产品展示</div>
                <div class="icon-line"></div>
            </div>
            <div class="c_b"></div>
            <div class="title-eng">
                <span>PRODUCT DISPLAY</span>
            </div>
        </div>
        <div class="goods-list">
            <?php if(is_array($mall_list)) { foreach($mall_list as $k => $v) { ?>
            <div class="mall_product <?php if(($k+1)%5!=0) { ?>marginright22<?php } ?>
">
                <a href="<?php echo $v['linkurl'];?>">
                    <img src="<?php echo $v['image'];?>"/>
                    <span><?php echo $v['title'];?></span>
                </a>
            </div>
            <?php } } ?>
            <div class="c_b"></div>
            <div class="goods-more"><a href="<?php echo $mallurl;?>" class="color5fbc31">查看更多</a></div>
        </div>
    </div>
</div>
<div class="c_b"></div>
<div class="m">
    <div class="com-projects">
        <div class="desc-title">
            <div class="title-show">
                <div class="icon-line"></div>
                <div class="icon-text">项目案例</div>
                <div class="icon-line"></div>
            </div>
            <div class="c_b"></div>
            <div class="title-eng">
                <span>PROJECT CASS</span>
            </div>
        </div>
        <div class="company_white_not_bg">
            <ul id="brand_nr">
                <?php $num_a=1; ?>
                <?php if(is_array($tycase_list)) { foreach($tycase_list as $k => $v) { ?>
                <li class="f_l
                <?php if($num_a<3) { ?>
                    <?php if($num_a==2) { ?>brand_li_2<?php } ?>
                    <?php $num_a++;?>
                <?php } else { ?>
                    <?php $num_a=1;?>
                <?php } ?>
">
                    <div class="brand_img">
                        <img src="<?php echo $v['image'];?>" alt="<?php echo $v['title'];?>" data-content="<?php echo $v['centent'];?>"/>
                        <div class="brand_title"></div>
                        <span><?php echo $v['title'];?></span>
                    </div>
                </li>
                <?php } } ?>
            </ul>
            <div class="c_b"></div>
            <div class="goods-more"><a href="<?php echo $tycaseurl;?>" class="color5fbc31">查看更多</a></div>
        </div>
    </div>
</div>
<div class="c_b"></div>
<div class="m">
    <div class="com-contact">
        <div class="desc-title">
            <div class="title-show">
                <div class="icon-line"></div>
                <div class="icon-text">联系我们</div>
                <div class="icon-line"></div>
            </div>
            <div class="c_b"></div>
            <div class="title-eng">
                <span>CONTACT US</span>
            </div>
        </div>
        <div class="contact-detail">
            <div class="contact-left">
                <?php $map_height = 250;?>
                <?php @include DT_ROOT.'/api/map/'.$api_map.'/show.inc.php';?>
                <?php $coname = urlencode($COM['company']);?>
                <?php $uaddress = urlencode($COM['address']);?>
            </div>
            <div class="contact-right">
                <div class="contact-com-name"><span><?php echo $COM['company'];?></span></div>
                <div class="contact-mobi-addr">
                    <ul>
                        <li>电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话：<?php echo $COM['telephone'];?></li>
                        <li>移动电话 :<?php echo $COM['mobilePhone'];?></li>
                        <li>传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真：<?php echo $COM['fax'];?></li>
                        <li>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：<?php echo $COM['postcode'];?></li>
                        <li>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：<?php echo $COM['address'];?></li>
                    </ul>
                </div>
                <div class="contact-more"><a href="<?php echo $contacturl;?>" class="color5fbc31">查看详情</a></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".brand_img").click(function () {
        layer.photos({
            photos: '#brand_nr'
            , anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
        layer.iframeAuto(index)
    });
    layer.photos({
        photos: '#imgs'
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    });
</script>
<?php include template('footer');?>
