<?php
defined('IN_DESTOON') or exit('Access Denied');
if($username){//黄浩彬开发抢单平台提醒功能开始
$sendtime=1279992761;
$to = isset($to) ? intval($to) : 0;
$sql="SELECT * FROM {$DT_PRE}member  WHERE username ='$username' ";
$m=$db->get_one($sql);
$sql="SELECT * FROM {$DT_PRE}alert  WHERE username ='$username' order by itemid desc";
$alert=$db->query($sql);
$num=0;
					while($r = $db->fetch_array($alert)) {
						if($r['word'])$keyword= " or content  like '%".$r['word']."%' ";
							$word=$word.','.$r['word'];$kw=$r['word'];
							//$sendtime=$r['sendtime'];
							$num=$num+1;
					}
					$word=ltrim($word, ",");
			if($keyword){//有关键词的情况下
				$f_word=explode(',', $word);
				$sql=" and ( content  like '%".$f_word[$to]."%' ) and addtime>".$sendtime;
					//echo $sql."<br>";
						$total=$db->get_one("SELECT count(*) as num FROM {$DT_PRE}taoxinxi WHERE (status>0 ".$sql.") ");
						$total=$total['num'];
						 if($total>15)$total=15;
			}
			else{//无关键词，不发送邮件
			$total=$num=0;
			$sql="";
			}
}//黄浩彬开发抢单平台提醒功能结束
if($num&&$to&&$num==$to){echo "<h1 style='text-align:center;margin-top:200px;'>".$username."的关注的关键词".$word."全部发送完毕！</h1>";exit;}
include tpl('header');
show_menu($menus);
?>
<div class="tt">发送商机</div>
<form method="post" action="?" id="dform" name="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="send" value="1"/>
<input type="hidden" name="first" value="1"/>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($userid){?>
<tr>
<td class="tl"><span class="f_red">*</span> 群发列表</td>
<td><input type="text" size="50" name="userid" value="<?php print_r($userid);?>"/></td>
</tr>
<?}?>
<?php if($word){?>
<tr>
<td class="tl"><span class="f_red">*</span> 关键词</td>
<td><input type="text" size="20" name="word" value="<?php echo $word;?>"/>
</td>
</tr>
<?}?>
<tr>
<td class="tl"><span class="f_red">*</span> 邮件标题</td>
<?php if($username)$title="会员 ".$username." 您好, 以下是您关注上“".$f_word[$to]."”的业务需求信息提醒";?>
<td><input type="text" size="50" name="title" value="<?php echo $title;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 总共多少轮</td>
<td><input type="text" size="5" name="num" value="<?php echo $num;?>"/> 轮/封，当前发送
<?php echo $f_word[$to];?> <input type="text" size="2" name="to" value="<?php echo $to;?>"/>的内容 </td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 商机数量</td>
<td><?php if($alertcount){?>总数<input type="text" size="5" name="alertcount" value="<?php echo $alertcount;?>"/> /<?}?><input type="text" size="5" name="total" value="<?php echo $total;?>"/> 条</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 查询条件</td>
<?php if($_REQUEST['addtime'])$sql .=" and addtime>='".$_REQUEST['addtime']."' ";?>
<td><input type="text" size="60" name="sql" value="<?php echo $sql;?>"/> <?php tips('附加的SQL查询条件 以AND开头');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 指定会员</td>
<td><input type="text" size="10" name="username" value="<?php echo $_REQUEST['username'];?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 指定QQ</td>
<td><input type="text" size="20" name="qq" value="<?php if($_REQUEST['qq']){ echo $_REQUEST['qq'];}else{ echo $m['qq'];}?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
<?php if($m['qq']){?>
<img src="<?php echo DT_SKIN;?>image/is_13.gif" valign="middle"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php if($_REQUEST['qq']){ echo $_REQUEST['qq'];}else{ echo $m['qq'];}?>&site=qq&menu=yes">点击对聊</a>
<?}?>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 抄送邮箱</td>
<td><input type="text" size="60" name="email" value=""/></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 排序方式</td>
<td><input type="text" size="20" name="ord" value="<?php echo $ord;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 选择模板</td>
<td><?php echo tpl_select('alert', 'mail', 'template', '默认模板', $tpl);?></td>
</tr>
</table>
<div class="sbt"><input type="submit"  class="btn"/></div>

</form>
<?php if($to&&$num>$to){?>
<div style="background:rgba(255, 255, 255, 0.8) none repeat scroll 0 0 !important;filter:Alpha(opacity=80);background:#fff;position:absolute;z-index:2777;top:80px;height:200px;line-height:200px;;width:auto;left:200px;;text-align:center;padding:10px;color:red;font-size:30px;">正在继续发布关于“<?php echo $f_word[$to];?>”邮件</div>
<script>
function sub(){dform.submit();}
setTimeout(sub,3000);
</script>
<?}?>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>