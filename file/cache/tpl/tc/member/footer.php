<?php defined('IN_DESTOON') or exit('Access Denied');?></td>
</tr>
</table>
</div>
<?php if($_childusername) { ?>
<?php $m= $db->get_one("SELECT * FROM {$db->pre}member_child WHERE  username='$_childusername' and userid=$_userid");?>
<?php $nsystems=$m['systems'];?>
<script type="text/javascript">
<?php if(strpos('@'.$nsystems,';message;')) { ?>Dd('message').style.display='none';Dd('mleftm12').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,';grade;')) { ?>Dd('grade').style.display='none';Dd('mleftm11').style.display='none';Dd('menu_3').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,';child;')) { ?>Dd('child').style.display='none';Dd('mleftm13').style.display='none';Dd('menu_3').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,';edit;')) { ?>Dd('edit').style.display='none';Dd('mleftm110').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,';ad;')) { ?>Dd('ad').style.display='none';Dd('mleftm18').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,';friend;')) { ?>Dd('friend').style.display='none';Dd('mleftm14').style.display='none';<?php } ?>
<?php if(strpos('@'.$nsystems,'trade;')||strpos('@'.$nsystems,'credit;')||strpos('@'.$nsystems,'record;')) { ?>Dd('menu_2').style.display='none';<?php } ?>
   </script>
<?php } ?>
<script type="text/javascript">
if(document.body.clientHeight > Dd('main').scrollHeight) Dd('main').style.height=document.body.clientHeight+'px';
if(get_cookie('m_side') == 11 && Dd('side_oh').className == 'side_h') {Dh('side');Dd('side_oh').className = 'side_s';}
var destoon_message = <?php echo $_message;?>;
var destoon_chat = <?php echo $_chat;?>;
<?php if($_message && $_sound) { ?>
if(window.location.href.indexOf('message.php') == -1) $('#destoon_space').html(sound('message_<?php echo $_sound;?>'));
<?php } ?>
<?php if($_chat) { ?>
if(window.location.href.indexOf('chat.php') == -1) $('#destoon_space').html(sound('chat_new'));
<?php } ?>
<?php if($_userid && $DT['pushtime']) { ?>
window.setInterval('PushNew()',<?php echo $DT['pushtime'];?>*1000);
<?php } ?>
$(document).ready(function(){  //这个就是传说的ready
        $(".tb tr").mouseover(function(){  
                 $(this).addClass("graybg");}).mouseout(function(){  $(this).removeClass("graybg");})});
var form=Dd('dform');
 for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
      if(e.type=='text')
  {e.className="inputtext"; }
    }
</script>
<span style="display:none">
<?php include template('analytics','include');?>
</span>
</body>
</html>