<?php
include tpl('header');
?>
<?php if($lists){ ?>
<table cellpadding="2" cellspacing="1" class="tb">
<tr align="center">
<th>创意id</th>
<th>创意标题</th>
<th>创意描述</th>
<th>操作</th>
</tr>
<?php foreach($lists as $k => $v){ ?>
<tr  align="center">
<td><?php echo $v['ideaid']; ?></td>
<td><?php echo $v['name']; ?></td>
<td><?php echo $v['description']; ?></td>
<td><input type="button" onclick="select_id(<?php echo $v['ideaid']; ?>)" value="选择" class="btn" /></td>
</tr>
<?php }?>
</table>
<script>
function select_id(i){
	$('#key_id',parent.document).val(i);
	$('#Dmid',parent.document).remove();
	$('#Dtop',parent.document).remove();
}
</script>
<?php } ?>

<?php if($idea) { ?>
<style>
.result{font-size: 13px;line-height: 1.54;word-wrap: break-word;word-break: break-word;font-family:inherit;}
.result h3 a {color: #2319DF;}
.result em {color: #c00;font-style:normal;}
.result h3{display: block;font-weight: 400;font-size: 16px;padding: 0px;white-space: normal;margin:0px;}
.c-row{clear: both;display: block;height: 100px;}
.result_img{float: left;margin-right: 10px;}
.result_c{float: left;width: 400px;}
.result p{text-align: left;word-break: break-all;word-wrap: break-word;z-index: 1;margin:0px;}
.res-linkinfo b {font-weight: normal;color: #008000;}
.blue{color: #2b99ff;}
</style>
<?php
$wtitle=get_wildcard($idea['name'],$kw,50);
$wdescription=get_wildcard($idea['description'],$kw,180);
?>
<div class="result">
<h3><a href="#" target="_blank"><?php if($wtitle){echo dsubstr($wtitle,50,'...');}else{echo dsubstr($idea['default_name'],50,'...');} ?></a></h3>
	<?php if($idea['thumb']){ ?>
	<div class="c-row clearfix">
	<div class="result_img">
		<a href="#"  ><img class="res-img" width=120 height=90 src="<?php echo $idea['thumb']; ?>" /></a> 		
	</div>
	<div class="result_c">
	<?php } ?>
		<p class="res-desc" ><?php if($wdescription){ echo dsubstr($wdescription,180,'...');}else{echo dsubstr($idea['default_description'],180,'...');} ?></p>
		<?php $host = parse_url($idea['url']); ?>
		<p class="res-linkinfo"><b><?php echo $host['host']; ?></b>--<a href="#" target="_blank"><?php echo $company;?></a>--<span class="blue">推广链接</span>&nbsp;&nbsp;</p>		
	<?php if($idea['thumb']){ ?>
	</div>			
	</div>
	<?php } ?>
</div>
<?php } ?>

<?php if( empty($lists) && empty($idea) ){ ?>
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr align="center">
		<td>没有找到该用户的可用创意</td>
	</tr>
	</table>
<?php } ?>
<?php include tpl('footer');?>
