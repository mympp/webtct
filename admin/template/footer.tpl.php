<?php
defined('DT_ADMIN') or exit('Access Denied');
if(DT_DEBUG) {
	echo '<br/><center class="f_gray px11">';
	debug();
	echo '</center><br/>';
}
?>
<div class="back2top"><a href="javascript:void(0);" title="���ض���">&nbsp;</a></div>
<script type="text/javascript">
<?php if($_message) { ?>
Dnotification('new_message', '<?php echo $MODULE[2]['linkurl'];?>message.php', '<?php echo useravatar($_username, 'large');?>', 'վ����(<?php echo $_message;?>)', '�յ��µ�վ���ż�������鿴');
<?php } ?>
<?php if($_chat) { ?>
Dnotification('new_chat', '<?php echo $MODULE[2]['linkurl'];?>chat.php', '<?php echo useravatar($_username, 'large');?>', '�¶Ի�(<?php echo $_chat;?>)', '�յ��µĶԻ����󣬵����̸');
<?php } ?>
</script>
</body>
</html>