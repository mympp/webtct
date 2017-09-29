<?php defined('IN_DESTOON') or exit('Access Denied');?><table cellpadding="0" cellspacing="0" width="700" align="center" style="font-family:Verdana,Arial;">
<tr>
<td style="background:#FF6600;line-height:30px;font-size:14px;font-weight:bold;color:#FFFFFF;">&nbsp;&nbsp;<?php echo $title;?></td>
</tr>
<tr>
<td style="border:#CCCCCC 1px solid;padding:20px 20px 20px 20px;line-height:180%;font-size:13px;">
<strong>尊敬的<?php echo $username;?></strong>：<br/>
您好！您使用了<?php echo $DT['sitename'];?>的<span style="color:#FF1100;">修改Email</span>功能，请点击下面的链接完成您的Email修改（如果显示的不是链接，请将下面的地址复制到浏览器的地址栏里按下回车键）<br/>
<a href="<?php echo $authurl;?>" target="_blank"><?php echo $authurl;?></a><br/>
<?php if($MOD['auth_days']) { ?>链接有效期为 <strong style="color:red"><?php echo $MOD['auth_days'];?></strong> 天<?php } ?>
</td>
</tr>
<tr>
<td style="background:#333333;padding:10px;line-height:180%;font-size:12px;color:#FFFFFF;">请注意：此邮件系 <a href="<?php echo DT_PATH;?>" target="_blank" style="color:#FFFFFF;"><?php echo $DT['sitename'];?></a> 自动发送，请勿直接回复。<br/>如果此邮件不是您请求的，请忽略并删除！</td>
</tr>
</table>