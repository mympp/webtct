<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">公司审核</div>
<form method="post">
    <div class="tt">认证记录</div>
    <table cellpadding="2" cellspacing="1" class="tb">
        <tr>
            <th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
            <th>用户名</th>
            <th>营业执照</th>
            <th>到期时间</th>
            <th>是否长期有效</th>
            <th>生产/经营许可证</th>
            <th>到期时间</th>
            <th>其他</th>
            <th>IP</th>
            <th width="130">申请时间</th>
            <th>当前状态</th>
        </tr>
        <?php foreach($lists as $k=>$v) {?>
            <tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
                <td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
                <td><?php echo $V[$v['type']];?></td>
                <td><?php echo $v['title'];?></td>
                <td><?php if($v['thumb']) {?> <a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
                <td><?php if($v['thumb1']) {?> <a href="javascript:_preview('<?php echo $v['thumb1'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
                <td><?php if($v['thumb2']) {?> <a href="javascript:_preview('<?php echo $v['thumb2'];?>');"><img src="admin/image/img.gif" width="10" height="10" alt=""/></a><?php } ?></td>
                <td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
                <td class="px11"><a href="javascript:_ip('<?php echo $v['ip'];?>');" title="显示IP所在地"><?php echo $v['ip'];?></a></td>
                <td class="px11"><?php echo $v['addtime'];?></td>
                <td title="<?php echo timetodate($v['edittime']);?>"><?php echo $v['editor'];?></td>
                <td><?php echo $v['status'] == 3 ? '<span class="f_green">已认证</span>' : '<span class="f_red">未认证</span>';?></td>
            </tr>
        <?php }?>
    </table>
    <table>
        <tr>
            <td>
                &nbsp;<textarea style="width:300px;height:16px;" name="reason" id="reason" onfocus="if(this.value=='操作原因')this.value='';"/>操作原因</textarea>
            </td>
            <td>
                <input type="checkbox" name="msg" id="msg" value="1" onclick="Dn();" checked/><label for="msg"> 站内通知</label>
                <input type="checkbox" name="eml" id="eml" value="1" onclick="Dn();"/><label for="eml"> 邮件通知</label>
                <input type="checkbox" name="sms" id="sms" value="1" onclick="Dn();"/><label for="sms"> 短信通知</label>
                <input type="checkbox" name="wec" id="wec" value="1" onclick="Dn();"/><label for="wec"> 微信通知</label>
            </td>
        </tr>
    </table>
    <div class="btns">
        <input type="submit" value=" 通过认证 " class="btn" onclick="if(_check()){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';}else{return false;}"/>&nbsp;
        <input type="submit" value=" 拒绝认证 " class="btn" onclick="if(_reject()){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';}else{return false;}"/>&nbsp;
        <input type="submit" value=" 取消认证 " class="btn" onclick="if(_cancel()){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=cancel';}else{return false;}"/>
    </div>
</form>
<?php include tpl('footer');?>
