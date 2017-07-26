<?php 
include template('module-header'); 
include 'menu.php'; 
?>


<link rel="stylesheet" href="http://www.tecenet.com/skin/teceskin/style.css?v20161216">
<style>
img{display: inline-block;}
#topkeyword{width:310px;height:22px;line-height:22px}
</style>
<div class="content box-center" style="width:980px;margin-top:20px;">
<div id="weizhi">
	您当前的位置：
	<a class="a05" href="<?php echo $MODULE[1]['linkurl']; ?>">天成官网</a>
	&gt;
	<a class="a05" href="<?php echo $MODULE[1]['linkurl'].'hot'; ?> ">热门关键词</a>
	&gt;
	<a class="a05" href="#"><?php echo $keyword['word'];?></a>
</div>
<style>
.menu{width:100%;}
.menu ul{background:url('<?php echo DT_SKIN; ?>image/index/sel.png');}
.menu ul li{float:left;text-align: center;width:66px;;margin:0px;border-left:1px solid #ccc;height:28px;line-height:28px;border-top:1px solid #ccc;}
.menu ul li span{}
.menu ul .typey{
	border-top:2px solid #FF9C00;background: white;
}
.menu ul .typey span{
	color:#FF9C00;font-weight:bold;
}
.menu ul .typen{
	border-bottom:1px solid #ccc;
}
.keyword_list{}
.keyword_list dt{height:28px;line-height:28px;padding-left:8px;border:1px solid #ccc;}
.keyword_list dt font{font-weight:bold;font-size:14px;}
.keyword_list dd{border-width: 0px 1px 1px 1px;padding-top:3px;padding-bottom:3px;border-style: solid;border-color:#ccc;padding-left:3px;overflow:hidden;height:auto;}
.keyword_list dd span{margin:3px 1px;}
.keyword_list dd span a {margin:2px;padding:1px 3px;border:1px solid #ccc;}
.keyword_list dd span a:hover{margin:2px;padding:1px 3px;border:1px solid #fd862f;background:#fefeda;}
.keyword_list ul{width:100%;}
.keyword_content{padding:10px 0px;height:auto;overflow:hidden;border-width:0px 1px 1px 1px;border-color:#ccc;border-style: solid;background:white;}
.content{padding:10px 50px 10px 0px;}
.contentleft{width:672px;}
.showy{display:block;}
.shown{display:none;}
.more {float:right;margin-right:18px;margin-bottom:30px;}
.more a {font-size:14px;font-weight:bold;text-decoration:underline;}
.flw{display: inline-block;padding:2px 1px;}
.keyword_link{width:95%;border:1px solid #dcdcdc;height:70px;margin-top:20px;}
.keylink_a{padding-right:25px;}
</style>
<script>
	function selecttype(id){
		var arr=new Array('16','9','6','7','5','13','4','21','15','10');
		var key=0;
		for(var k in arr){
			document.getElementById('menu_'+arr[k]).className='typen';
			var a=parseInt(k)+1;
			document.getElementById('content'+a).className='shown';
			if(arr[k]==id){key=a;}
		}
		document.getElementById('menu_'+id).className='typey';
		document.getElementById('content'+key).className='showy';
	}
</script>

<?php
	function getLink($itemid,$selected){
		global $db;
		$condition="keyword_id=$itemid";
		$sql="select $selected from {$db->pre}keyword_link where $condition";
		$mysql_result=$db->query($sql);
		$link_data=array();
		while($m=mysql_fetch_array($mysql_result,MYSQL_ASSOC)){
                array_push($link_data,$m);
        }
		return $link_data;
     }
?>
<?php 
function get_keyword_hot(){
	$back = cache_read('hot_keyword.php');
	if(empty($back)){
		global $db;
		$keyword_hot=$db->query("select * from {$db->pre}keyword where status=3 group by keyword order by month_search desc limit 0,22");
		$write = array();
		while($r = $db->fetch_array($keyword_hot)){
			$write[] = $r;
		}
		cache_write('hot_keyword.php',$write);
		$back = $write;
	}
	return $back;
}

function get_keyword_new(){
	$back = cache_read('new_keyword.php');
	if(empty($back)){
		global $db;
		$keyword_new = $db->query("select * from {$db->pre}keyword where status = 3 group by keyword order by month_search asc,itemid desc limit 0,18");
		$write = array();
		while($r = $db->fetch_array($keyword_new)){
			$write[] = $r;
		}
		cache_write('new_keyword.php',$write);
		$back = $write;
	}
	return $back;
}
?>
<div class="divline"></div>
<div class="contentleft">

<div class="menu">
<ul>
<?php foreach($module_arr as $k=>$v){ ?>
<li id="<?php echo 'menu_'.$k; ?>" onmouseover="selecttype(<?php echo $k; ?>)" class="<?php if($k==$keyword['moduleid']){echo 'typey';}else{echo 'typen';} ?>" style="<?php if($k==10){echo 'border-right:1px solid #ccc;';} ?>" >
<span><?php echo $v; ?></span>
</li>
<?php } ?>
</ul>
</div>

<div style="clear:both;"></div>

<div class="keyword_content" >

<?php include 'show-mall.php'; ?>

<?php include 'show-fuwu.php'; ?>

<?php include 'show-zhaobiao.php'; ?>

<?php include 'show-tech.php'; ?>

<?php include 'show-sell.php'; ?>

<?php include 'show-brand.php'; ?>

<?php include 'show-company.php'; ?>

<?php include 'show-article.php'; ?>

<?php include 'show-down.php'; ?>

<?php include 'show-know.php'; ?>


</div>

</div>

<div class="contentright">
	<dl class="keyword_list contentright">
	<dt style="background:#FF9C00"><font style="color:white;">最热商品</font></dt>
	<?php $keyword_hot=get_keyword_hot(); ?>
 	<dd>

	<?php foreach($keyword_hot as $v){ ?>
	<span class="flw" >
	<a href="<?php echo $MODULE[1]['linkurl'].'hot/show-'.$v['itemid'].'.html'; ?>"><?php echo $v['keyword']; ?></a>
	</span>
	<?php } ?>

	</dd>
	</dl>
	
	<div class="divline"></div>
	
	<dl class="keyword_list contentright">
	<dt style="background:#FF9C00"><font style="color:white;">最新商品</font></dt>
	<?php $keyword_new = get_keyword_new(); ?>
	<dd>
		<?php foreach($keyword_hot as $v){ ?>
			<span class="flw"><a href="<?php echo $MODULE[1]['linkurl'].'hot/show-'.$v['itemid'].'.html'; ?>"><?php echo $v['keyword']; ?></a></span>
		<?php } ?>
	</dd>
	</dl>
	
	<div class="divline"></div>
	
	<dl class="keyword_list contentright">
		<dt style="background:#FF9C00;"><font style="color:white;">猜你喜欢</font></dt>
		<dd>
<?php 

$so=scws_new();
$so->set_charset('utf8');
$so->send_text($keyword['word']);
$word_arr=array();      //对关键词进行分词
while($v=$so->get_result()){
foreach($v as $sv){
array_push($word_arr,$sv['word']);
}
}
$so->close();
$condition='';
$scws_num=count($word_arr);
if($scws_num>3){ //如果分出来的词组超过3个，则取后三个分词作为关联词对象
$condition="word like '%".$word_arr[($scws_num-1)]."%' or word like '%".$word_arr[($scws_num-2)]."%' or word like '%".$word_arr[($scws_num-3)]."%' ";
}else{
	foreach($word_arr as $k=>$v){
		if($k==0){
			$condition.="word like '%".$v."%' ";
		}else{
			$condition.="or word like '%".$v."%' ";
		}
	}
}
$keyword_relevant=$db->query("select * from {$db->pre}keyword where status=3 and $condition group by keyword order by updatetime desc limit 0,15",'hot_relevant_keyword');

?>
<?php while($v=$db->fetch_array($keyword_relevant)){ ?>
	<span class="flw" >
	<a href="<?php echo $MODULE[1]['linkurl'].'hot/show-'.$v['itemid'].'.html'; ?>"><?php echo $v['keyword']; ?></a>
	</span>
<?php } ?>
</dd>
	</dl>
	
	<div class="divline"></div>
	
	<dl>
		<dl class="keyword_list contentright">
		<dt style="background:#FF9C00"><font style="color:white;">关于我们</font>
		</dt>
		<dd style="padding:5px;">
			天成医疗网为您提供供应<?php echo $keyword['word']; ?>的最新产品供应商、制造商，囊括了供应<?php echo $keyword['word']; ?>产品的参数、型号、图片、价格等信息，<?php echo $keyword['word']; ?>维修，招标，相关品牌公司等全方面的信息，是供应<?php echo $keyword['word']; ?>产品的权威数据库。我们会尽全力为您提供准确、全面的信息!
		</dd>
		</dl>
	</dl>
</div>


</div>
<div class="divline"></div>
<?php $link_list=getLink($itemid,"link_name,link_url");?>
<div class="keyword_link" <?php if(!$link_list){?>style="display:none;"<?php }?> >
	<span style="color:#222;font-size:15px;padding-top:10px;display:block;margin-bottom:10px;">&nbsp;&nbsp;<b>友情链接</b></span>
	&nbsp;&nbsp;&nbsp;&nbsp;<?php foreach($link_list as $v){?><a class="keylink_a" title="<?php echo $v['link_name'];?>" href="<?php echo $v['link_url'];?>"><?php echo $v['link_name'];?></a><?php }?>
</div>
<?php include template('footer2017'); ?>
