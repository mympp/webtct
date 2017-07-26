<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $template);?>
<script src="<?php echo DT_STATIC;?>file/script/layer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['4']['moduledir'];?>/skin/company_profile.css"/>
<div class="c_b"></div>
<div class="m company_mall_bg">
<div class="company_title bgcolor_f8">
<div class="company_words company_left">项目案例</div>
<span class="company_letter company_left">PROJECT CASES</span>
<div class="c_b"></div>
<div class="company_line"></div>
</div>
<div class="company_white_bg">
<?php echo tag("table=_tycase&prefix=ty&condition=$condition&order=addtime desc&pagesize=$pagesize&page=$page&showpage=1&template=list-tycase");?>
</div>
</div>
<script type="text/javascript">
$(".brand_img").click(function () {
layer.use('extend/layer.ext.js', function () {
//初始加载即调用，所以需放在ext回调里
layer.ext = function () {
layer.photosPage({
html: '',
title: '',
id: '', //相册id，可选
parent: '#brand_nr'
});
};
});
});
</script>
<?php include template('footer');?>
