<<<<<<< .mine
<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt">修改评论 </div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 评论人</td>
<td><a href="javascript:_user('<?php echo $username;?>');" class="t"><?php echo $username ? $passport : 'Guest';?></a> <input type="checkbox" name="post[hidden]" value="1" <?php if($hidden) echo 'checked';?>/> 匿名评论</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> IP</td>
<td><?php echo $ip;?> - <?php echo ip2area($ip);?> </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 评论原文</td>
<td><a href="<?php echo DT_PATH;?>api/redirect.php?mid=<?php echo $item_mid;?>&itemid=<?php echo $item_id;?>" target="_blank" class="t"><?php echo $item_title;?></a></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 引用内容</td>
<td><textarea name="post[quotation]" id="quotation"  rows="8" cols="70"><?php echo $quotation;?></textarea><br/>请不要修改代码结构，仅可修改文字内容</td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 评论内容</td>
<td>
<input type="radio" name="post[star]" value="3" id="star_3"<?php echo $star == 3 ? ' checked' : '';?>/><label for="star_3"> 好评 <img src="<?php echo DT_PATH;?>file/image/star3.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="post[star]" value="2" id="star_2"<?php echo $star == 2 ? ' checked' : '';?>/><label for="star_2"> 中评 <img src="<?php echo DT_PATH;?>file/image/star2.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="post[star]" value="1" id="star_1"<?php echo $star == 1 ? ' checked' : '';?>/><label for="star_1"> 差评 <img src="<?php echo DT_PATH;?>file/image/star1.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<br/>
<textarea name="post[content]" id="content"  rows="8" cols="70"><?php echo $content;?></textarea></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 回复评论</td>
<td>
<textarea name="post[reply]" id="reply" rows="8" cols="70"><?php echo $reply;?></textarea>
<?php 
if($reply) echo $editor ? '<br/>管理员 '.$editor.' 于 '.$replytime.' 回复' : '<br/>会员 '.$replyer.' 于 '.$replytime.' 回复';
?>
</td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 评论状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">Menuon(<?php echo $status == 3 ? 0 : 1;?>);</script>
=======
<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt">修改评论 </div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 评论人</td>
<td><a href="javascript:_user('<?php echo $username;?>');" class="t"><?php echo $username ? $passport : 'Guest';?></a> <input type="checkbox" name="post[hidden]" value="1" <?php if($hidden) echo 'checked';?>/> 匿名评论</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> IP</td>
<td><?php echo $ip;?> - <?php echo ip2area($ip);?> </td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 评论原文</td>
<td><a href="<?php echo DT_PATH;?>api/redirect.php?mid=<?php echo $item_mid;?>&itemid=<?php echo $item_id;?>" target="_blank" class="t"><?php echo $item_title;?></a></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 引用内容</td>
<td><textarea name="post[quotation]" id="quotation"  rows="8" cols="70"><?php echo $quotation;?></textarea><br/>请不要修改代码结构，仅可修改文字内容</td>
</tr>

<tr>
<td class="tl"><span class="f_red">*</span> 评论内容</td>
<td>
<input type="radio" name="post[star]" value="3" id="star_3"<?php echo $star == 3 ? ' checked' : '';?>/><label for="star_3"> 好评 <img src="<?php echo DT_PATH;?>file/image/star3.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="post[star]" value="2" id="star_2"<?php echo $star == 2 ? ' checked' : '';?>/><label for="star_2"> 中评 <img src="<?php echo DT_PATH;?>file/image/star2.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="post[star]" value="1" id="star_1"<?php echo $star == 1 ? ' checked' : '';?>/><label for="star_1"> 差评 <img src="<?php echo DT_PATH;?>file/image/star1.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<br/>
<textarea name="post[content]" id="content"  rows="8" cols="70"><?php echo $content;?></textarea></td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 回复评论</td>
<td>
<textarea name="post[reply]" id="reply" rows="8" cols="70"><?php echo $reply;?></textarea>
<?php 
if($reply) echo $editor ? '<br/>管理员 '.$editor.' 于 '.$replytime.' 回复' : '<br/>会员 '.$replyer.' 于 '.$replytime.' 回复';
?>
</td>
</tr>
<tr>
<td class="tl"></td>
<td id="reasonSelectWrap">

</td>
</tr>

<tr>
<td class="tl"><span class="f_hid">*</span> 评论状态</td>
<td>
<input type="radio" name="post[status]" value="3" <?php if($status == 3) echo 'checked';?>/> 通过
<input type="radio" name="post[status]" value="2" <?php if($status == 2) echo 'checked';?>/> 待审
</td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<style>
    .reason-select{width: 513px;height: 24px;}
</style>
<script>
var selectOption = [
    '请选择快捷回复内容',
    '您好！感谢您一直以来对天成医疗网http://www.tecenet.com的关注！您还可以关注天成医疗网移动端wap.tecenet.com，天成医疗网微信号公众号：tianchengyiliao',
];
function reasonSelect(){
    var $wrap = $("#reasonSelectWrap");
    var $input = $("#reply");
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

<script type="text/javascript">Menuon(<?php echo $status == 3 ? 0 : 1;?>);</script>
>>>>>>> .r2727
<?php include tpl('footer');?>