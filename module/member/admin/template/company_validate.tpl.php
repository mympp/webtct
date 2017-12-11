<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">帅选内容</div>
<div class="btns">
    &nbsp;&nbsp;
    <input type="button" value="已通过"
           onclick="window.location.href='?moduleid=2&file=company_validate&status=3'" class="btn" />
    &nbsp;&nbsp;
    <input type="button" value="待审核"
           onclick="window.location.href='?moduleid=2&file=company_validate&status=2'" class="btn" />
    &nbsp;&nbsp;
    <input type="button" value="已拒绝"
           onclick="window.location.href='?moduleid=2&file=company_validate&status=4'" class="btn" />
</div>
<style>
	#Dtop{width: auto !important;max-width: 1000px;}
	#Dtop .dbox img{max-width: 100%;}
</style>

<form method="post" >
    <div class="tt">公司资质审核</div>
    <table cellpadding="2" cellspacing="1" class="tb">
        <tr>
            <th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
            <th>用户名</th>
            <th>公司名</th>
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
                <td><a href="javascript:_user('<?php echo $v['username']; ?>');" ><?php echo $v['username'];?></a></td>
                <td><?php echo $v['company']; ?></td>
                <td>
                    <?php if($v['business_license']) {?>
                    <a href="javascript:_preview('<?php echo $v['business_license'];?>');">
                            <img src="admin/image/img.gif" width="10" height="10" alt=""/></a>
                    <?php } ?>
                </td>
                <td>
                    <?php if($v['business_license_totime']) echo date('Y-m-d',$v['business_license_totime']); ?>
                </td>
                <td>
                    <?php if($v['isBL_long_term']) echo '长期有效'; ?>
                </td>
                <td>
                    <?php if($v['product_license']) {?>
                        <a href="javascript:_preview('<?php echo $v['product_license'];?>');">
                            <img src="admin/image/img.gif" width="10" height="10" alt=""/></a>
                    <?php } ?>
                </td>
                <td>
                    <?php if($v['product_license_totime']) echo date('Y-m-d',$v['product_license_totime']); ?>
                </td>
                <td>
                    <?php if($v['other']) {?>
                        <a href="javascript:_preview('<?php echo $v['other'];?>');">
                            <img src="admin/image/img.gif" width="10" height="10" alt=""/></a>
                    <?php } ?>
                </td>
                <td class="px11"><a href="javascript:_ip('<?php echo $v['ip'];?>');" title="显示IP所在地"><?php echo $v['ip'];?></a></td>
                <td class="px11"><?php echo date('Y-m-d',$v['addtime']);?></td>
                <td>
                    <?php
                    if($v['status'] == 3){
                        echo '<span>已通过</span>';
                    }elseif($v['status'] == 4){
                        echo '<span class="f_red">已拒绝</span>';
                    }else{
                        echo '<span class="f_green">待审核</span>';
                    }
                    ?>
                </td>
            </tr>
        <?php }?>
    </table>
    <table>
        <tr>
            <td>操作原因：</td>
            <td><textarea name="note" id="reason" onfocus="if(this.value=='操作原因')this.value='';"/></textarea></td>
        </tr>
        <tr>
            <td>快捷选择理由：</td>
            <td id="reasonSelectWrap"></td>
        </tr>

    </table>
    <div class="pages"><?php echo $pages;?></div>
    <div class="btns">
        <input type="submit" value=" 通过认证 " class="btn"
               onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
        <input type="submit" value=" 拒绝认证 " class="btn"
               onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;
    </div>
</form>

<style>
    #reason{width: 480px;height:48px;}
    .reason-select{width: 900px;height: 24px;}
</style>
<script>
var selectOption = [
    '请选择理由',
    '你好，公司认证需要按照要求上传相关资质。你上传的证照图片有误，请重新上传，感谢您对天成医疗网的关注与支持。如有疑问可以在上班时间咨询在线客服。',
    '你好，公司认证需要按照要求上传相关资质。你上传的证照图片有效期于跟你填写的不一致，请核实后填写再提交，感谢您对天成医疗网的关注与支持。如有疑问可以在上班时间咨询在线客服。',
    '你好，公司认证需要按照要求上传相关资质。你上传的证照图片名称与你填写的不一致，请核实后填写再提交，感谢您对天成医疗网的关注与支持。如有疑问可以在上班时间咨询在线客服。'
];
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

<script>
    Menuon(1);
</script>
<?php include tpl('footer');?>
