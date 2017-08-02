<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<form method="post">
<input type="hidden" name="itemid" value="<?php echo $v[itemid];?>"/>
<input type="hidden" name="buyitemid" value="<?php echo $v[buyitemid];?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">信息标题</td>
<td><input name="title" type="text" id="title" size="60" value="<?php echo $v[title];?>"/> </td>
</tr>
<tr>
<td class="tl">详细内容</td>
<td><textarea name="content" id="content" class="dsn"><?php echo $v[content]; ?></textarea>
<?php echo deditor($moduleid,'content', $MOD['editor'], '100%', 550);?><span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl">应标方</td>
<td><input name="fromuser" type="text"  size="20" value="<?php echo $v[fromuser];?>" id="fromuser"/> <a href="javascript:_user('<?php echo $v['fromuser'];?>')" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">招标方</td>
<td><input name="touser" type="text"  size="20" value="<?php echo $v[touser];?>" id="touser"/> <a href="javascript:_user('<?php echo $v['touser'];?>')" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">招标方阅读状态</td>
<td>
<input type="radio" name="isread" value="1" <?php if($v[isread] == 1) echo 'checked';?>/> 已阅
<input type="radio" name="isread" value="0" <?php if($v[isread] == 0) echo 'checked';?>/> 未阅
</td>
</tr>
<tr>
<td class="tl">招标方同意状态</td>
<td>
<input type="radio" name="agree" value="1" <?php if($v[agree] == 1) echo 'checked';?>/> 同意
<input type="radio" name="agree" value="0" <?php if($v[agree] == 0) echo 'checked';?>/> 未同意
</td>
</tr>
<tr>
<td class="tl">网站审核</td>
<td>
<input type="radio" name="status" value="3" <?php if($v[status] == 3) echo 'checked';?>/> 通过
<input type="radio" name="status" value="2" <?php if($v[status] == 2) echo 'checked';?>/> 待审
<input type="radio" name="status" value="1" <?php if($v[status] == 1) echo 'checked';?> onclick="if(this.checked) Dd('note').style.display='';"/> 拒绝
<input type="radio" name="status" value="4" <?php if($v[status] == 4) echo 'checked';?>/> 过期
<input type="radio" name="status" value="0" <?php if($v[status] == 0) echo 'checked';?>/> 删除
</td>
</tr>
<tr>
<td class="tl">中标状态</td>
<td>
<input type="radio" name="selitemid" value="0" <?php if($d[selitemid]!=$v[itemid]) echo 'checked';?>/> 未中标
<input type="radio" name="selitemid" value="<?php echo $v[itemid];?>" <?php if($d[selitemid] ==$v[itemid]) echo 'checked';?>/> 中标
</td>
</tr>
<tr>
<td class="tl">添加时间</td>
<td><input type="text" size="22" name="addtime" value="<?php echo timetodate($v[addtime], 5);?>"/></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>