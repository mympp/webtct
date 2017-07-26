<?php 
include template('module-header');

include 'menu.php';
?>


<div class="content w1200 box-center">

<div class="crumb" id="weizhi">
	您当前的位置：
	<a class="a05" href="<?php echo DT_PATH; ?>">天成官网</a>
	&gt;
	<a class="a05" href="<?php echo DT_PATH.'hot'; ?>">热门关键词</a>
	&gt;
	<a class="a05" href="<?php echo $MODULE[1]['linkurl'].'hot/category-'.$mid; ?>"><?php  echo $module_arr[$mid].'关键词';?></a>
</div>
<style type="text/css">
.category-nav{font-size: 16px;margin: 10px 0;font-weight: bold;}
.module-link{font-size: 16px;margin-top:8px;padding: 20px 0;text-align: center;}
.module-link .selected{color:#F77602}
.module-link a{margin: 0 10px; font-weight: bold;}
.keyword{padding: 20px 0;width: 970px;margin: 0 auto;}
.keyword span{display: inline-block;width: 190px;line-height: 30px;}
.keyword span>a{display: inline-block;padding: 3px 10px;margin: 10px 0;border: 1px solid #eaeaea;background-color: #f9f9f9;}
.keyword span>a:hover{background-color: #fff;}
.keyword-footer{margin: 20px 0 0 0;}
.pages .pages_btn{width:32px;height:20px;}
</style>

<div class="module-link">
|
<?php
foreach ($module_arr as $key => $value) {
	$selected='';
	if($mid==$key){
		$selected='class="selected"';
	}
	echo '&nbsp;&nbsp;<a href="/hot/category-'.$key.'" '.$selected.'>'.$value.'</a>&nbsp;&nbsp;|';
}?>
</div>
<div class="keyword">
<?php
	if ($keyword_arr) {
		$i = 0;
		foreach ($keyword_arr as $key => $value) {
			if($i%5==0){
				echo "<br>";
			}
			printf('<span><a href="/hot/show-%s.html" title="%s"> %s </a></span>',$value['itemid'],$value['keyword'],dsubstr($value['keyword'],28,'...'));
			$i++;
		}
	}
?>
</div>
<div class="pages keyword-footer">
<?php
if($pages){
	echo $pages;	
}
?>
</div>
</div>
<?php
include template('footer2017');
?>
