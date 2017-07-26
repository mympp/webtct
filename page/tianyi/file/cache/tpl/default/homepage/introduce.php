<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $template);?>
<script src="<?php echo DT_STATIC;?>file/script/layer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['4']['moduledir'];?>/skin/company_profile.css"/>
<div class="c_b"></div>
<div class="m company_bg">
<div class="company_title">
<div class="company_words company_left">企业简介</div>
<span class="company_letter company_left">COMPANY PROFILES</span>
<div class="c_b"></div>
<div class="company_line"></div>
</div>
<div class="company_desc introduce_des">
<?php echo $content;?>
</div>
</div>
<div class="m company_bg">
<div class="company_title">
<div class="company_words company_left">工商注册信息</div>
<span class="company_letter company_left">BUSINESS REGISTRATION INFORMATION</span>
<div class="c_b"></div>
<div class="company_line"></div>
</div>
<div class="company_desc">
<div class="company_data company_left">
<div class="data_tr">
<div class="data_title company_left">公司名称：</div>
<div class="data_left company_left"><?php echo $COM['company'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">注册资本：</div>
<div class="data_left company_left"><?php echo $COM['regunit'];?><?php echo $COM['capital'];?>万元</div>
</div>
<div class="data_tr">
<div class="data_title company_left">注册号：</div>
<div class="data_left company_left"><?php echo $COM['register'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">登记机关：</div>
<div class="data_left company_left"><?php echo $COM['reoffice'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">营业期限：</div>
<div class="data_left company_left"><?php echo $COM['starttime'];?>  至  <?php echo $COM['endtime'];?></div>
</div>
</div>
<div class="company_data company_left">
<div class="data_tr">
<div class="data_title company_left">注册地址：</div>
<div class="data_left company_left"><?php echo $COM['readdress'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">成立日期：</div>
<div class="data_left company_left"><?php echo $COM['retime'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">法定代表人：</div>
<div class="data_left company_left"><?php echo $COM['legalPerson'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">企业类型：</div>
<div class="data_left company_left"><?php echo $COM['type'];?></div>
</div>
<div class="data_tr">
<div class="data_title company_left">年报时间：</div>
<div class="data_left company_left">暂无</div>
</div>
</div>
<div class="c_b"></div>
<div class="company_data_bottom">
<div class="data_title company_left">经营范围：</div>
<div class="data_bottom_left company_left">
<?php echo $COM['business'];?>
</div>
<div class="c_b"></div>
</div>
</div>
</div>
<div class="m company_bg">
<div class="com-honner">
<div class="company_title">
<div class="company_words company_left">荣誉资质</div>
<span class="company_letter company_left">HONORS AND QUALIFICATIONS</span>
<div class="c_b"></div>
<div class="company_line"></div>
</div>
<div class="honors-list">
<div>
<div class="point-left" onclick="javascript:void(0);"></div>
</div>
<div id="honors-list-img">
<ul id="imgs">
                    <?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
                    <li class="bor-r">
                        <div class="div-img">
<img src="<?php echo $v['image'];?>" data-title="<?php echo $v['title'];?>"/>
</div>
                        <div><span><?php echo $v['title'];?></span></div>
                    </li>
                    <?php } } ?>
<div class="c_b"></div>
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
<script type="text/javascript">
$(".div-img").click(function () {
layer.use('extend/layer.ext.js', function () {
//初始加载即调用，所以需放在ext回调里
layer.ext = function () {
layer.photosPage({
html: '',
title: '',
id: '', //相册id，可选
parent: '#imgs'
});
};
});
});
</script>
<?php include template('footer');?>
