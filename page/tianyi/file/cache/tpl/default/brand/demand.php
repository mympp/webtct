<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?>file/script/webuploader.css">
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/webuploader.js"></script>
<div class="m">
<div class="m_toppos border_ff9c33">
<li class="buy_top_li"><span>提交需求</span></li>
</div>
<div class="top">
<dl class="demand_tab">
<dt>选择需求类型：</dt>
<?php if(is_array($demand_arr)) { foreach($demand_arr as $k => $v) { ?>
<dd class="<?php echo $v['value'];?> <?php if($v['value']==$demand) { ?>cursor<?php } ?>
" onclick="show_class('<?php echo $v['value'];?>')"><?php echo $v['title'];?></dd>
<?php } } ?>
</dl>
</div>
<div class="demand_form">
<form action="" method ="post" >
<table>
<tr>
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>项目名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入项目名称" class="w398"></li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>单位名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入单位或公司名" class="w398"></li>
</ul>
</td>
</tr>
<tr class="costs_tr" style="display: none">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>单位名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入单位或公司名" class="w398"></li>
</ul>
</td>
</tr>
<tr class="construction_tr" style="display: none">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>业主单位名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入业主单位名称或公司名" class="w398"></li>
</ul>
</td>
</tr>
<tr class="construction_tr" style="display: none">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>总包单位名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入总包单位名称或公司名" class="w398"></li>
</ul>
</td>
</tr>
<tr class="maintain_tr" style="display: none">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>单位名称：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入单位或公司名" class="w398"></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>项目地址：</span><div class="c_b"></div></li>
<li><select name=""><option value="">--省份--</option></select><select name=""><option value="">--县市--</option></select><select name=""><option value="">--区镇--</option></select></li>
<li><input type="text" name="" placeholder="请输入详细地址" class="w398"></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>联系人：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入联系人" class="w398"></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>联系电话：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入联系电话" class="w398"></li>
</ul>
</td>
</tr>
<tr>
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>联系邮箱：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入联系邮箱" class="w398"></li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>项目类型：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入您的服务类型（如：医院检验科）" class="w398"></li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>建筑面积：</span><div class="c_b"></div></li>
<li><input type="text" name="" placeholder="请输入建筑总面积" class="w398 w268"><span class="p_l20">含地下建筑面积</span></li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>项目阶段：</span><div class="c_b"></div></li>
<li><select name="" class="w278"><option value="">--请选择项目阶段--</option></select></li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>服务内容：</span><div class="c_b"></div></li>
<li>
<label class="checkbox_lab" for="check1"><input type="checkbox" id="check1" name="sss" />平面图设计方案</label>
<label class="checkbox_lab" for="check2"><input type="checkbox" id="check2" />初步设计方案</label>
<label class="checkbox_lab" for="check3"><input type="checkbox" id="check3" />施工图设计方案</label>
<b class="c_b"></b>
</li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>服务周期：</span><div class="c_b"></div></li>
<li>
<table class="demand_small_tab" cellspacing=0 cellpadding=0 width=615 border=1>
<th class="pad_l_30">设计项目</th>
<th>正常设计周期</th>
<th>期望设计周期</th>
<tr>
<td  class="pad_l_30">平面图设计方案</td>
<td>2天</td>
<td><u>2天</u></td>
</tr>
<tr>
<td  class="pad_l_30">初步设计方案</td>
<td>3天</td>
<td><u>3天</u></td>
</tr>
<tr>
<td  class="pad_l_30">施工图设计方案</td>
<td>5天</td>
<td><u>5天</u></td>
</tr>
<tr>
<td  class="pad_l_30">合计</td>
<td>15天</td>
<td>15天</td>
</tr>
</table>
</li>
<li class='prompt'>
<span style="color: red!important;">提示：</span>您设置的期望服务周期不能低于正常操作周期的50%，若您设置的期望周期过短，我们将额外向您加收费用。
</li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>服务内容：</span><div class="c_b"></div></li>
<li>
<label class="radio_lab" for="radio1"><input type="radio" name="ra" id="radio1" value="1" />是</label>
<label class="radio_lab" for="radio2"><input type="radio" name="ra" id="radio2" value="0"/>否</label>
<b class="c_b"></b>
</li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>项目设计要求：</span><div class="c_b"></div></li>
<li>
<textarea placeholder="请输入您的项目要求"></textarea>
</li>
</ul>
</td>
</tr>
<tr class="design_tr">
<td>
<ul>
<li class="form_title"><span class="f_red">*&nbsp;</span><span>上传资料：</span><b class="f_size12 color999">为了能给您提供更优质的服务，请您尽量提供更全面的资料。</b><b class="f_size12 color666">本次需要上传的资料如下：</b><div class="c_b"></div></li>
<li>
<ul class="file_img">
<li>项目概况</li>
<li>设计图纸</li>
<li>招标文件</li>
<li>其它资料</li>
</ul>
<div class="c_b"></div>
</li>
<li>
<div id="uploader" class="wu-example">
<!--用来存放文件信息-->
<div id="thelist" class="uploader-list"></div>
<div class="btns">
<div id="picker">选择文件</div>
<!--<div id="ctlBtn" class="btn btn-default">开始</div>-->
</div>
</div>
</li>
<li>
<span class="f_red">提示：</span>仅支持JPG、PDF、CAD、ZIP、RAR等格式文件。<br>
如您在资料提交过程中有困难，请及时联系客服人员，我们会根据项目需要配合您完成相关资料的准备。
</li>
</ul>
</td>
</tr>
</table>
<div class="Uploaded">
<ul>
<li class="Uploaded_title">已上传资料:</li>
<li>
<table class="Uploaded_tab" cellspacing=0 cellpadding=0 width=615 border=1>
<th  width="48" align="center">序号</th>
<th class="pd_l_10">文件名</th>
<th align="center">上传时间</th>
<th width="50" align="center">操作</th>
</table>
</li>
</ul>
</div>
</form>
</div>
</div>
<?php include template('footer');?>
<script type="text/javascript">
var number=1;
var ntime=time();
function time(){
var mydate = new Date();
var str = "" + mydate.getFullYear() + ".";
str += (mydate.getMonth()+1) + ".";
str += mydate.getDate();
return str;
}
var arr=['design','costs','construction','maintain'];
function show_class(name){
$.each(arr,function(index,value){
$('.'+value+'_tr').hide();
$('.'+value).removeClass("cursor");
});
$('.'+name+'_tr').show();
$('.'+name).addClass("cursor");
}
//多选
$(".checkbox_lab").bind("click",function(e){
//防止2次点击
if(e.target.tagName!="INPUT")return;
if($(this).find('input').prop('checked')==true){
$(this).removeClass("checkbox_false").addClass("checkbox_true");
}else{
$(this).removeClass("checkbox_true").addClass("checkbox_false");
}
});
//单选
$(".radio_lab").bind("click",function(e){
if(e.target.tagName!="INPUT")return;
$(this).find('input').attr("checked",true);
$(this).parent('li').find('.radio_lab').removeClass("radio_true");
$(this).removeClass("radio_false").addClass("radio_true");
});
var uploader = WebUploader.create({
// swf文件路径
swf: '<?php echo DT_STATIC;?>file/script/Uploader.swf',
// 文件接收服务端。
server: '<?php echo $MOD['linkurl'];?>uploader.php',
// 选择文件的按钮。可选。
// 内部根据当前运行是创建，可能是input元素，也可能是flash.
pick: '#picker',
// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
resize: false,
auto:true
});
uploader.on( 'fileQueued', function( file ) {
$('.Uploaded_tab').append('<tr><td  align="center">'+number+'</td><td class="pd_l_10">'+file.name+'</td> <td align="center">'+ntime+'</td> <td align="center">删除</td></tr>');
number++;
});
uploader.on( 'uploadError', function( file ) {
console.log(1111);
});
//// 文件上传过程中创建进度条实时显示。
//uploader.on( 'uploadProgress', function( file, percentage ) {
//console.log(1111);
//var $li = $( '#'+file.id ),
//$percent = $li.find('.progress .progress-bar');
//// 避免重复创建
//if ( !$percent.length ) {
//$percent = $('<div class="progress progress-striped active">' +
//'<div class="progress-bar" role="progressbar" style="width: 0%">' +
//'</div></div>').appendTo( $li ).find('.progress-bar');
//}
//$li.find('p.state').text('上传中');
//$percent.css( 'width', percentage * 100 + '%' );
//});
uploader.on( 'uploadSuccess', function( file ) {
alert('已上传');
$( '#'+file.id ).find('p.state').text('已上传');
});
uploader.on( 'uploadError', function( file ) {
alert('上传出错');
$( '#'+file.id ).find('p.state').text('上传出错');
});
//uploader.on( 'uploadComplete', function( file ) {
//alert('上传');
//$( '#'+file.id ).find('.progress').fadeOut();
//});
</script>
