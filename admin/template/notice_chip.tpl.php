<table>
<tr>
<td style="padding:15px 10px;">提示内容：</td>
<td style="padding:15px 10px;">
	<textarea name="reason" id="reason" onfocus="if(this.value=='操作原因')this.value='';"/></textarea> 
</td>
<td style="padding:15px 10px;">
<input type="checkbox" name="msg" id="msg" value="1" onclick="Dn();" checked="checked" /><label for="msg"> 站内通知</label>
<input type="checkbox" name="eml" id="eml" value="1" onclick="Dn();"/><label for="eml"> 邮件通知</label>
<input type="checkbox" name="sms" id="sms" value="1" onclick="Dn();"/><label for="sms"> 短信通知</label>
<input type="checkbox" name="wec" id="wec" value="1" onclick="Dn();"/><label for="wec"> 微信通知</label>
<?php tips('仅发送点击下方通过审核、拒绝、回收站、彻底删除、上架、下架商品按钮的操作通知，如果填写了操作原因，默认会发送站内通知');?>
</td>
</tr>
<tr>
	<td style="padding:15px 10px;">快捷选择理由：</td>
	<td style="padding:15px 10px;" id="reasonSelectWrap" colspan="2"></td>
</tr>

</table>

<style>
	#reason{width: 480px;height:48px;}
	.reason-select{width: 900px;height: 24px;}
</style>
<script>
function reasonSelect(){
	var $wrap = $("#reasonSelectWrap");
	var $input = $("#reason");
	var $options = "";

	for(var i=0; i<selectOption.length; i++ ){
        $options += '<option value="'+selectOption[i]+'">'+selectOption[i]+'</option>'
	}

	$wrap.html("<select class='reason-select'>"+$options+"</select>");

	$(document).on("change",".reason-select",function(){
		var $val = $(this).val();
		$input.val($val);
	});
}
reasonSelect();
</script>