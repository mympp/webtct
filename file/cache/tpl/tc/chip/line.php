<?php defined('IN_DESTOON') or exit('Access Denied');?>var destoon_userid = <?php echo $_userid;?>;
var destoon_username = '<?php echo $_username;?>';
var destoon_message = <?php echo $_message;?>;
var destoon_chat = <?php echo $_chat;?>;
var destoon_moduleid = <?php echo $moduleid;?>;
var destoon_stip = '';
var destoon_member = '';
<?php if($_COOKIE['memberpath']<>"") { ?>
<?php $MODULE['2']['linkurl']=$MODULE['1']['linkurl'].$_COOKIE['memberpath'].'/';?>
<?php } ?>
<?php if($_userid) { ?>
<?php if($moduleid==16 || $moduleid==6 || $moduleid==12 || $moduleid==13 || $moduleid==4) { ?>
destoon_member += '<div class="menunav"><ul><li><a href="<?php echo $MODULE['2']['linkurl'];?>" title="<?php if($_online) { ?>点击隐身<?php } else { ?>点击上线<?php } ?>
"><span class="ocolor" title="<?php echo $MG['groupname'];?>-<?php echo $_truename;?>-<?php echo $DT['credit_name'];?>:<?php echo $_credit;?>-<?php echo $DT['money_name'];?>:<?php echo $_money;?>"><?php echo dsubstr($_truename,12,'..');?></span> (<?php if($_online) { ?><span class="gcolor">在线</span><?php } else { ?><span class="hcolor">隐身</span><?php } ?>
)</a></li><li><a href="<?php echo $MODULE['2']['linkurl'];?>logout.php">退出</a></li><li><a href="<?php echo $MODULE['2']['linkurl'];?>trade.php">我的订单</a></li><li><a href="#">收藏夹</a><ul><li><a href="#">收藏的产品</a></li><li><a href="#">收藏的品牌</a></li><li><a href="#">我的经销商</a></li><li><a href="#">我的供应商</a></li></ul></li><li><a href="#">客户服务</a> <ul><li><a href="#">联系客户</a></li><li><a href="#">帮助中心</a></li><li><a href="#">会员反馈</a></li><li> <a href="<?php echo $MODULE['2']['linkurl'];?>message.php">站内信(<span id="destoon_message">0</span>)</a></li><li><a href="<?php echo $MODULE['2']['linkurl'];?>chat.php">对话(<span id="destoon_chat">0</span>)</a></li></ul></li></ul></div>';
<?php } else { ?>
destoon_member += '<a href="<?php echo $MODULE['2']['linkurl'];?>" title="<?php if($_online) { ?>点击隐身<?php } else { ?>点击上线<?php } ?>
"><span class="ocolor" title="<?php echo $MG['groupname'];?>-<?php echo $_truename;?>-<?php echo $DT['credit_name'];?>:<?php echo $_credit;?>-<?php echo $DT['money_name'];?>:<?php echo $_money;?>"><?php echo dsubstr($_truename,12,'..');?></span> (<?php if($_online) { ?><span class="gcolor">在线</span><?php } else { ?><span class="hcolor">隐身</span><?php } ?>
)</a> | <a href="<?php echo $MODULE['2']['linkurl'];?>message.php">站内信(<span id="destoon_message">0</span>)</a> | <a href="<?php echo $MODULE['2']['linkurl'];?>chat.php">对话(<span id="destoon_chat">0</span>)</a> | <a href="<?php echo $MODULE['2']['linkurl'];?>logout.php">退出</a>';
<?php } ?>
<?php } else { ?>
destoon_member += '<span class="f_red">您是游客</span> | &nbsp;<a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_register'];?>">请先注册</a> |&nbsp; <a href="<?php echo $MODULE['2']['linkurl'];?><?php echo $DT['file_login'];?>">直接登录</a>';
<?php } ?>
try{Dd('destoon_member').innerHTML=destoon_member;}catch(e){}
<?php if($DT['city']) { ?>
try{Dd('destoon_city').innerHTML='<?php echo $city_name;?>';}catch(e){}
<?php } ?>
<?php if($_message) { ?>
Dd('destoon_message').innerHTML='<strong class="f_red"><?php echo $_message;?></strong>';
<?php if($_sound) { ?>destoon_stip += sound('message_<?php echo $_sound;?>');<?php } ?>
<?php } ?>
<?php if($_chat && $DT['im_web']) { ?>
Dd('destoon_chat').innerHTML='<strong class="f_red"><?php echo $_chat;?></strong>';
destoon_stip += sound('chat_new');
<?php } ?>
var destoon_cart = substr_count(get_cookie('cart'), ',');
Dd('shopcart').style.display='block';
if(destoon_cart > 0){Dd('destoon_cart').innerHTML='<strong class="f_red">'+destoon_cart+'</strong>';}else{Dd('shopcart').className='nocart';}
if(destoon_stip) Dd('tb_c').innerHTML = destoon_stip;
<?php if($push && $DT['pushtime']) { ?>window.setInterval('PushNew()',<?php echo $DT['pushtime'];?>*1000);<?php } ?>
