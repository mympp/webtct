<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('title', 'member');?>
<script type="text/javascript" src="<?php echo DT_PATH;?>file/script/miniDropdown.js"></script>
<div id="msgbox" style="display:none;" onclick="this.style.display='none'"></div>
<?php echo dmsg();?>
<div class="head" id="head">
<div class="head_m">
<div class="head_logo"><a href="./"><img src="<?php echo DT_SKIN;?>image/member/logo.png" alt="商务中心"/></a></div>
<div class="head_main"id="mini-dropdown-2">
<ul class="dropdown" id="nav">
<?php if($_userid) { ?>
<li class="menu_1" id="menu_0" onclick="c(0);" onmouseover="if(this.className=='menu_2')this.className='menu_3'" onmouseout="if(this.className=='menu_3')this.className='menu_2'">会员服务
<ul id="meminfo1"></ul>
</li>
<li class="menu_2" id="menu_1" onclick="c(1);" onmouseover="if(this.className=='menu_2')this.className='menu_3'" onmouseout="if(this.className=='menu_3')this.className='menu_2'">发布&管理
<ul id="meminfo2"></ul></li>
<li class="menu_2" id="menu_2" onclick="c(2);" onmouseover="if(this.className=='menu_2')this.className='menu_3'" onmouseout="if(this.className=='menu_3')this.className='menu_2'">交易管理
<ul id="meminfo3"></ul></li>
<?php if($_groupid>5) { ?><li class="menu_2" onclick="c(3);" id="menu_3" onmouseover="if(this.className=='menu_2')this.className='menu_3'" onmouseout="if(this.className=='menu_3')this.className='menu_2'">网站管理
<ul id="meminfo4"></ul></li>
<?php } else if($_groupid==5) { ?><li class="menu_3" id="menu_3"></li>
<?php } ?>
<?php } ?>
<li class="menu_2" onclick="Go('<?php echo DT_PATH;?>');">网站首页</li>
</ul>
</div>
<script type="text/javascript">
$(function(){
    $('#mini-dropdown-2 .dropdown').miniDropdown({
      animation: 'slide', 
      show: 100,
      hide: 100,
      delayIn: 100,
      delayOut: 100
    });
});
</script>
<div class="head_user">
<?php if($_userid) { ?>
<ul>
<li onmouseover="Ds('profile');" onmouseout="Dh('profile');"><a href="avatar.php"><img src="<?php echo useravatar($_username, 'small');?>" width="20" height="20" id="myavatar"/></a>
<div id="profile" style="display:none;">
<div>
<dl>
<dt><span class="f_r"><a href="edit.php"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/setting.gif" width="10" height="10" align="absmiddle" title="资料设置"/></a></span><?php if(!$_childusername) { ?><?php echo $MG['groupname'];?><?php } else { ?>子账号：<?php } ?>
<span class="f_black" title="<?php echo $_username;?>"><?php if($_childusername) { ?><?php echo $_childusername;?><?php } else { ?><?php echo $_truename;?><?php } ?>
</span> (<a href="line.php" title="<?php if($_online) { ?>点击隐身<?php } else { ?>点击上线<?php } ?>
"><?php if($_online) { ?><span class="f_green">在线</span><?php } else { ?><span class="f_gray">隐身</span><?php } ?>
</a>)</dt>
<?php if($_groupid>5) { ?><dt><a href="<?php echo userurl($_username);?>" target="_blank" title="<?php echo $_company;?>"><span class="f_black"><?php echo $_company;?></span></a></dt><?php } ?>
<dt><a href="record.php"><span class="f_black"><?php echo $DT['money_name'];?>(<?php echo $_money;?>)</span></a> <span class="f_gray">|</span> 
<a href="credit.php"><span class="f_black"><?php echo $DT['credit_name'];?>(<?php echo $_credit;?>)</span></a>
</dt>
</dl>
</div>
</div>
</li>
<li id="destoon_message"><a href="message.php">站内信</a><?php if($_message) { ?><font><?php echo $_message;?></font><?php } ?>
</li>
<?php if($DT['im_web']) { ?><li id="destoon_chat"><a href="chat.php">对话</a><?php if($_chat) { ?><font><?php echo $_chat;?></font><?php } ?>
</li><?php } ?>
<li><a href="logout.php?forward=">退出</a></li>
<?php if($admin_user) { ?><li><a href="index.php?action=logout">注销授权</a></li><?php } ?>
</ul>
<?php } else { ?>
<a href="<?php echo $DT['file_login'];?>">立即登录</a> | 
<a href="<?php echo $DT['file_register'];?>">注册会员</a>
<?php } ?>

</div>
<div class="c_b"></div>
</div>
</div>
<div class="head_s" id="destoon_space">&nbsp;</div>
<div class="main_tb">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" class="side" id="side">
<div id="sub_0" style="display:<?php if($_userid) { ?><?php } else { ?>none<?php } ?>
">
<?php if($_userid || $show_menu) { ?>
<div class="side_head" id="h_0"><div>会员服务</div></div>
<div class="side_body" id="b_0">
<ul id="leftm1">
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='grade'><span class="f_r"><a href="validate.php?action=list" class="m">认证</a></span><a href="grade.php?action=grade" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">会员升级</a></li>
<?php if($MG['inbox_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='message'><span class="f_r"><a href="message.php?action=send" class="m">发信</a></span><a href="message.php" class="<?php if($MG['inbox_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">站内信件<?php if($_message) { ?><font><?php echo $_message;?></font><?php } ?>
</a></li>
<?php } ?>
<?php if($MG['chat'] || $show_menu) { ?>
<?php if($DT['im_web']) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='chats'><span class="f_r"><a href="chat.php?action=add" class="m">查看</a></span><a href="chat.php" class="<?php if($MG['inbox_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">站内交谈<?php if($_chat) { ?><font><?php echo $_chat;?></font><?php } ?>
</a></li>
<?php } ?>
<?php } ?>
<?php if($_groupid>5) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='child'><span class="f_r"><a href="child.php?action=add" class="m">添加</a></span><a href="child.php" class="<?php if($MG['friend_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">子账号管理</a></li>
<?php } ?>
<?php if($MG['friend_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='friend'><span class="f_r"><a href="friend.php?action=add" class="m">添加</a></span><a href="friend.php" class="<?php if($MG['friend_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">我的商友</a></li>
<?php } ?>
<?php if($MG['favorite_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='favorite'><span class="f_r"><a href="favorite.php?action=add" class="m">添加</a></span><a href="favorite.php" class="<?php if($MG['favorite_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">商机收藏</a></li>
<?php } ?>
<?php if($MG['alert_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='alert'><span class="f_r"><a href="alert.php?action=add" class="m">添加</a></span><a href="alert.php" class="<?php if($MG['alert_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">业务提醒</a></li>
<?php } ?>
<?php if($MOD['vmobile']&&($MG['sms'] || $show_menu)) { ?>
<?php if($DT['sms']) { ?><li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='sms'><span class="f_r"><a href="sms.php?action=add" class="m">发送</a></span><a href="sms.php" class="<?php if($MG['sms']) { ?>n<?php } else { ?>f<?php } ?>
">手机短信</a></li><?php } ?>
<?php } ?>
<?php if($MG['mail'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='mail'><span class="f_r"><a href="sendmail.php" class="m">电邮</a></span><a href="mail.php" class="<?php if($MG['mail']) { ?>n<?php } else { ?>f<?php } ?>
">邮件订阅</a></li>
<?php } ?>
<?php if($MG['spread'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='spread'><span class="f_r"><a href="spread.php?action=add" class="m">购买</a></span><a href="spread.php" class="<?php if($MG['spread']) { ?>n<?php } else { ?>f<?php } ?>
">排名推广</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID="ideas"><span class="f_r"><a href="ideas.php?action=add" class="m">申请</a></span><a href="ideas.php" class="<?php if($MG['spread']) { ?>n<?php } else { ?>f<?php } ?>
">创意推广</a></li>
<?php } ?>
<?php if($MG['ad'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='ad'><span class="f_r"><a href="ad.php?action=add" class="m">购买</a></span><a href="ad.php" class="<?php if($MG['ad']) { ?>n<?php } else { ?>f<?php } ?>
">广告预定</a></li>
<?php } ?>
<?php if($show_oauth) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='oauth'><span class="f_r"><a href="oauth.php" class="m">绑定</a></span><a href="oauth.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">一键登录</a></li>
<?php } ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='edit'><span class="f_r"><a href="avatar.php" class="m">头像</a></span><a href="edit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">修改资料</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='ask'><span class="f_r"><a href="ask.php?action=add" class="m">提问</a></span><a href="ask.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">客服中心</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='carriage'><span class="f_r"></span><a href="carriage.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">运费设置</a></li>
</ul>
</div>
<?php } ?>
</div>
<div id="sub_1" style="display:<?php if($_userid) { ?>none<?php } else { ?><?php } ?>
">
<?php if($MYMODS || $show_menu) { ?>
<div class="side_head" id="h_1"><div>信息管理</div></div>
<div class="side_body" id="b_1">
<ul id="leftm2">
<?php if(is_array($MENUMODS)) { foreach($MENUMODS as $k => $v) { ?>
<?php if($v==9) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='mid_job'><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=9&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=9" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">设备服务需求</a></li>
<?php } else if($v==-9) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='mid_resume'><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=9&action=add&resume=1" class="m">加入</a></span><a href="<?php echo $DT['file_my'];?>?mid=9&resume=1" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">技术工程师</a></li>
<?php } else if($v==28) { ?>
<li class="<?php if($mid==28 && $resume!=1) { ?>side_b<?php } else { ?>side_a<?php } ?>
" ID='mid_hrjob'><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=28&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=28" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">职位招聘信息</a></li>
<?php } else if($v==-28) { ?>
<li class="<?php if($mid==28 && $resume==1) { ?>side_b<?php } else { ?>side_a<?php } ?>
" ID='mid_hrresume'><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=28&action=add&resume=1" class="m">创建</a></span><a href="<?php echo $DT['file_my'];?>?mid=28&resume=1" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
">个人求职简历</a></li>
<?php } else { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='mid_<?php echo $v;?>'><span class="f_r"><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>&action=add" class="m">发布</a></span><a href="<?php echo $DT['file_my'];?>?mid=<?php echo $v;?>" class="<?php if(in_array($v, $MYMODS)) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $MODULE[$v]['name'];?>管理</a></li>
<?php } ?>
<?php } } ?>
<?php if($_groupid>5 || $_groupid ==1) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='mid_vote'><span class="f_r"><a href="vote.php?action=add" class="m">发布</a></span><a href="vote.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">投票调查管理</a></li>
<?php } ?>

</ul>
</div>
<?php } ?>
</div>
<div id="sub_2" style="display:none;">
<?php if($_userid || $show_menu) { ?>
<div class="side_head" id="h_2"><div>交易管理</div></div>
<div class="side_body" id="b_2">
<ul id="leftm3">
<?php if(isset($MODULE['16'])) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='trade'><span class="f_r"><a href="trade.php?action=order" class="m">买家</a></span><a href="trade.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">我的订单</a></li>
<?php } ?>
<?php if(isset($MODULE['6'])) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='purchase'><span class="f_r"><a href="purchase.php?action=supply" class="m">应标</a></span><a href="purchase.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">收到的采购清单</a></li>
<?php } ?>
<?php if(isset($MODULE['17'])) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='group'><span class="f_r"><a href="group.php?action=order" class="m">买家</a></span><a href="group.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">团购订单</a></li>
<?php } ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='record'><span class="f_r"><a href="record.php?action=pay" class="m">站内</a></span><a href="record.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>流水</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='charge'><span class="f_r"><a href="charge.php?action=pay" class="m">充值</a></span><a href="charge.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
">充值记录</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='cash'><span class="f_r"><a href="cash.php" class="m">提现</a></span><a href="cash.php?action=record" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['money_name'];?>提现</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='credit'><span class="f_r"><a href="credit.php?action=buy" class="m">购买</a></span><a href="credit.php" class="<?php if($_userid) { ?>n<?php } else { ?>f<?php } ?>
"><?php echo $DT['credit_name'];?>管理</a></li>
<?php if($MG['address_limit']>-1 || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='addr'><span class="f_r"><a href="address.php?action=add" class="m">添加</a></span><a href="address.php" class="<?php if($MG['address_limit']>-1) { ?>n<?php } else { ?>f<?php } ?>
">收货地址</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
</div>
<div id="sub_3" style="display:none;">
<?php if($MG['homepage'] || $show_menu) { ?>
<div class="side_head" id="h_3"><div>网站管理</div></div>
<div class="side_body" id="b_3">
<ul id="leftm4">
<?php if($MG['homepage'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='homepage'><span class="f_r"><a href="home.php?tab=2" class="m">栏目</a></span><a href="home.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">网站设置</a></li>
<?php } ?>
<?php if($MG['homepage'] || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='style'><span class="f_r"><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1" target="_blank" class="m">更新</a></span><a href="style.php" class="<?php if($MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">模板风格</a></li>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='stylev'><span class="f_r"><a href="edit.php?tab=4" class="m">介绍</a></span><a href="edit.php?tab=2"  class="f">公司资料</a></li>
<?php } ?>
<?php if(($MG['news_limit']>-1 && $MG['homepage']) || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='news'><span class="f_r"><a href="news.php?action=add" class="m">发布</a></span><a href="news.php" class="<?php if($MG['news_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">公司新闻</a></li>
<?php } ?>
<?php if(($MG['page_limit']>-1 && $MG['homepage']) || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='page'><span class="f_r"><a href="page.php?action=add" class="m">添加</a></span><a href="page.php" class="<?php if($MG['page_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">公司单页</a></li>
<?php } ?>
<?php if(($MG['honor_limit']>-1 && $MG['homepage']) || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='honor'><span class="f_r"><a href="honor.php?action=add" class="m">添加</a></span><a href="honor.php" class="<?php if($MG['honor_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">荣誉资质</a></li>
<?php } ?>
<?php if(($MG['link_limit']>-1 && $MG['homepage']) || $show_menu) { ?>
<li class="side_a" onmouseover="v(this.id);" onmouseout="t(this.id);" ID='link'><span class="f_r"><a href="link.php?action=add" class="m">添加</a></span><a href="link.php" class="<?php if($MG['link_limit']>-1 && $MG['homepage']) { ?>n<?php } else { ?>f<?php } ?>
">友情链接</a></li>
<?php } ?>
</ul>
</div>
<?php } ?>
</div>
<?php if($_userid) { ?>
<script type="text/javascript">
Dd('meminfo1').innerHTML=strre('leftm1');
Dd('meminfo2').innerHTML=strre('leftm2');
Dd('meminfo3').innerHTML=strre('leftm3');
<?php if($_groupid>5) { ?>
Dd('meminfo4').innerHTML=strre('leftm4');
<?php } ?>
<?php if($_groupid==5) { ?>
Dd('menu_3').innerHTML="<a href='grade.php?action=grade&sj=yes&groupid=6&kd=1#UP'><font class='f_white'>免费升级建站</font></a>";
<?php } ?>
function strre(str){
var s="";
var k=0;
$("#"+str+" li").each(function() {
        k=k+1;
s=s+'<li id="m'+str+k+'">'+$(this).html()+'</li>';
           });
return s;
}
</script>
<?php } ?>
</td>
<td class="side_h" onclick="oh(this);" title="点击展开/隐藏侧栏" id="side_oh">&nbsp;</td>
<td valign="top" class="main" id="main">