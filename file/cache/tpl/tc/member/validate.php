<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header',$module);?>
<style>
    .upload-msg p{
        font-size:12px;
        color: #888;
        margin:8px 0;
    }
    .upload-msg p:last-child{
        margin-bottom:20px;
    }
</style>
<?php if($action == 'list') { ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>相关认证项目</span></a></td>
            <td class="tab_nav">&nbsp;</td>
        </tr>
    </table>
</div>
<style type="text/css">
    .vt {
        background: #e7e7e7;
    }
    .vt td {
        background: #fff;
        text-align: center
    }
</style>
<table cellpadding="10" cellspacing="5" width="100%" class="vt">
    <Tr>
        <?php if($MOD['vemail']) { ?>
        <td><a href="validate.php?action=email"><img src="<?php echo DT_PATH;?>member/image/v/email<?php if($d['vemail']) { ?>v<?php } ?>
.png"><br>
            <?php if($d['vemail']) { ?>已通过<?php } else { ?>未通过<?php } ?>
邮件认证</a> &nbsp;</td>
        <?php } ?>
        <?php if($MOD['vmobile']) { ?>
        <td>
            <a href="validate.php?action=mobile"><img src="<?php echo DT_PATH;?>member/image/v/mobile<?php if($d['vmobile']) { ?>v<?php } ?>
.png"><br>
                <?php if($d['vmobile']) { ?>已通过<?php } else { ?>未通过<?php } ?>
手机认证</a> &nbsp;</td>
        <?php } ?>
        <?php if($MOD['vbank']) { ?>
        <td><a href="validate.php?action=bank"><img src="<?php echo DT_PATH;?>member/image/v/bank<?php if($d['vbank']) { ?>v<?php } ?>
.png"><br>
            <?php if($d['vbank']) { ?>已通过<?php } else { ?>未通过<?php } ?>
银行认证</a> &nbsp;</td>
        <?php } ?>
        <?php if($MOD['vtruename']) { ?>
        <td>
            <a href="validate.php?action=truename"><img src="<?php echo DT_PATH;?>member/image/v/truename<?php if($d['vtruename']) { ?>v<?php } ?>
.png"><br>
                <?php if($d['vtruename']) { ?>已通过<?php } else { ?>未通过<?php } ?>
实名认证</a> &nbsp;</td>
        <?php } ?>
        <?php if($MOD['vcompany']) { ?>
        <td>
            <a href="validate.php?action=company"><img src="<?php echo DT_PATH;?>member/image/v/company<?php if($d['vcompany']) { ?>v<?php } ?>
.png"><br>
                <?php if($d['vcompany']) { ?>已通过<?php } else { ?>未通过<?php } ?>
企业认证</a> &nbsp;</td>
        <?php } ?>
    </tr>
</table>
<?php } else if($action == 'email') { ?>
<?php if($itemid==1) { ?>
<div class="warn">尊敬的用户，为了保证信息的真实有效，请先<strong>认证</strong>您的<strong>Email</strong>，认证通过之后即可发布信息</div><?php } ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>1、发送认证信</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab1"><a href="?action=<?php echo $action;?>"><span>2、接收认证信</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab2"><a href="?action=<?php echo $action;?>"><span>3、通过认证</span></a></td>
        </tr>
    </table>
</div>
<form method="post" action="validate.php" onsubmit="return check();" id="dform">
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <tr>
            <td class="tl"><span class="f_red">*</span> 您的Email</td>
            <td class="tr"><input type="text" size="30" name="email" id="email" value="<?php echo $user['email'];?>"/>
                <span id="demail" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 验证码</td>
            <td class="tr"><?php include template('captcha', 'chip');?> <span id="dcaptcha" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl">提示信息</td>
            <td class="tr">提交后，系统将发送一封验证邮件至您的Email，请接收邮件完成认证</td>
        </tr>
        </tbody>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="30"><input type="submit" name="submit" value=" 下一步 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    function check() {
        if (Dd('email').value.length < 7) {
            Dmsg('请填写Email', 'email');
            return false;
        }
        if (!is_captcha(Dd('captcha').value)) {
            Dmsg('请填写正确的验证码', 'captcha');
            return false;
        }
        return true;
    }
</script>
<?php } else if($action == 'vemail') { ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>邮件认证</span></a></td>
        </tr>
    </table>
</div>
<table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">邮件地址</td>
        <td class="tr"><strong><?php echo $_email;?></strong> <a href="send.php?action=email" class="t">[修改]</a></td>
    </tr>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_green">已认证</td>
    </tr>
</table>
<?php } else if($action == 'mobile') { ?>
<script type="text/javascript">s('sms');</script>
<?php if($itemid==1) { ?>
<div class="warn">尊敬的用户，为了保证信息的真实有效，请先<strong>认证</strong>您的<strong>手机号码</strong>，认证通过之后即可发布信息</div><?php } ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>1、发送认证码</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab1"><a href="?action=<?php echo $action;?>&code=1"><span>2、接收认证码</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab2"><a href="?action=<?php echo $action;?>"><span>3、通过验证</span></a></td>
        </tr>
    </table>
</div>
<?php if(isset($code)) { ?>
<form method="post" action="validate.php" onsubmit="return check();" id="dform">
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <tr>
            <td class="tl"><span class="f_red">*</span> 认证码</td>
            <td class="tr"><input type="text" size="10" name="auth" id="auth"/> <span id="dauth" class="f_red"></span>
                请输入你收到的短信认证码
            </td>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="30">
                <input type="submit" value=" 下一步 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 重 发 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    Dd('Tab0').className = 'tab';
    Dd('Tab1').className = 'tab_on';
    function check() {
        if (Dd('auth').value.length < 6) {
            Dmsg('请填写认证码', 'auth');
            return false;
        }
        return true;
    }
</script>
<?php } else { ?>
<form method="post" action="validate.php" onsubmit="return check();" id="dform">
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <tr>
            <td class="tl"><span class="f_red">*</span> 您的手机号码</td>
            <td class="tr"><input type="text" size="30" name="mobile" id="mobile" value="<?php echo $user['mobile'];?>"/>
                <span id="dmobile" class="f_red"></span></td>
        </tr>
        <?php if($fee && $_sms<1) { ?>
        <tr>
            <td class="tl">接收短信收费</td>
            <td class="tr"><span class="f_b f_red"><?php echo $fee;?></span> <?php echo $DT['money_unit'];?></td>
        </tr>
        <tr>
            <td class="tl">帐户余额</td>
            <td class="tr"><span class="f_b f_blue"><?php echo $_money;?></span> <?php echo $DT['money_unit'];?> <?php if($fee>$_money) { ?>&nbsp;<span class="f_red">余额不足</span>&nbsp;<?php } ?>
                <a href="charge.php?action=pay" class="t" target="_blank">[充值]</a></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 支付密码</td>
            <td class="tr"><?php include template('password', 'chip');?> <span id="dpassword" class="f_red"></span></td>
        </tr>
        <?php } ?>
        <tr>
            <td class="tl">提示信息</td>
            <td class="tr">提交后，系统将发送一条短信至您的手机号码，请注意接收</td>
        </tr>
        </tbody>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="30"><input type="submit" name="submit" value=" 下一步 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    function check() {
        if (Dd('mobile').value.length < 7) {
            Dmsg('请填写手机号码', 'mobile');
            return false;
        }
        {
            if $fee && $_sms < 1}
        if (Dd('password').value.length < 6) {
            Dmsg('请填写支付密码', 'password');
            return false;
        }
        {/
            if}
        return true;
    }
</script>
<?php } ?>
<?php } else if($action == 'vmobile') { ?>
<script type="text/javascript">s('sms');</script>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>手机认证</span></a></td>
        </tr>
    </table>
</div>
<table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">手机号码</td>
        <td class="tr"><strong><?php echo $user['mobile'];?></strong> <a href="send.php?action=mobile" class="t">[修改]</a></td>
    </tr>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_green">已认证</td>
    </tr>
</table>
<script type="text/javascript">s('mobile');</script>
<?php } else if($action == 'truename') { ?>
<?php if($itemid==1) { ?>
<div class="warn">尊敬的用户，为了保证信息的真实有效，请先<strong>认证</strong>您的<strong>真实姓名</strong>，认证通过之后即可发布信息</div><?php } ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>1、提交证件</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab1"><a href="?action=<?php echo $action;?>"><span>2、通过认证</span></a></td>
        </tr>
    </table>
</div>
<form method="post" action="validate.php" onsubmit="return check();" id="dform">
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <tr>
            <td class="tl"><span class="f_red">*</span> 真实姓名</td>
            <td class="tr"><input type="text" size="10" name="truename" id="truename" value="<?php echo $user['truename'];?>"/>
                <span id="dtruename" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 身份证正面</td>
            <td class="tr">
                <input name="thumb" id="thumb" type="text" size="60" readonly/>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb').value, true);" class="t">[上传]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="_preview(Dd('thumb').value);" class="t">[预览]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dd('thumb').value='';" class="t">[删除]</a>
                <span id="dthumb" class="f_red"></span>
            </td>
        </tr>

<tr>
            <td class="tl"><span class="f_red">*</span> 身份证反面</td>
            <td class="tr">
                <input name="thumb1" id="thumb1" type="text" size="60" readonly/>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb1').value, true);" class="t">[上传]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="_preview(Dd('thumb1').value);" class="t">[预览]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dd('thumb1').value='';" class="t">[删除]</a>
                <span id="dthumb1" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span>身份证有效期</td>
            <td class="tr">
                <script type="text/javascript" src="http://www.tecenet.com/file/script/calendar.js"></script>
                <input type="text" name="validDate" id="validDate" value="" size="10" onfocus="ca_show('validDate', this, '-');" readonly="" ondblclick="this.value='';">
                <img src="http://www.tecenet.com/file/image/calendar.gif" align="absmiddle" onclick="ca_show('validDate', this, '-');" style="cursor:pointer;">

                <label><input title="长期有效" type="checkbox" class="longTime" name="longTime" value="" >长期有效</label>
                <span id="dvalidDate" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl">认证说明</td>
            <td class="tr lh18 upload-msg">
                <p>1.请上传清晰个人有效证件（身份证或护照等）电子版本，以便网站核实认证</p>
                <p>2.证件上的姓名必须与填写的真实姓名一致</p>
                <p>3.支持.jpg .jpeg .bmp .png格式照片，图片清晰，大小不超过3M</p>
            </td>
        </tr>
        </tbody>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="30"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
            </td>
        </tr>
    </table>
</form>
<?php echo load('clear.js');?>
<?php if($MOD['vfax']) { ?>
<br/>
<!-- <table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">传真认证</td>
        <td class="tr">
            您可以传真有效证件至 <?php echo $MOD['vfax'];?> 进行认证，复印件上需注明会员名
        </td>
    </tr>
</table> -->
<?php } ?>
<script type="text/javascript">
    function check() {
        if (Dd('truename').value.length < 2) {
            Dmsg('请填写真实姓名', 'truename');
            return false;
        }
        if (Dd('thumb').value.length < 15) {
            Dmsg('请上传身份证正面', 'thumb');
            return false;
        }
        if (Dd('thumb1').value.length < 15) {
            Dmsg('请上传身份证反面', 'thumb1');
            return false;
        }
       if (Dd('validDate').value.length < 8 && !$(".longTime").is(':checked') ) {
            Dmsg('请选择身份证有效期', 'validDate');
            return false;
        }
        return true;
    }
</script>
<script>
$(document).on("click",".longTime",function(){
var $dateInput = $(this).parent().parent().find("input[type='text']");
if($(this).is(':checked')){
$dateInput.attr("disabled",true);
$dateInput.val("");
}else{
$dateInput.attr("disabled",false);
}
});
</script>
<?php } else if($action == 'vtruename') { ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>实名认证</span></a></td>
        </tr>
    </table>
</div>
<table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">真实姓名</td>
        <td class="tr f_b"><?php echo $user['truename'];?></td>
    </tr>
    <?php if($user['vtruename'] || $v['status'] == 3) { ?>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_green">已认证</td>
    </tr>
    <?php } else { ?>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_red">审核中</td>
    </tr>
    <?php } ?>
</table>
<?php } else if($action == 'company') { ?>
<?php if($itemid==1) { ?>
<div class="warn">尊敬的用户，为了保证信息的真实有效，请先<strong>认证</strong>您的<strong>公司信息</strong>，认证通过之后即可发布信息</div><?php } ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>1、提交证件</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab1"><a href="?action=<?php echo $action;?>"><span>2、通过认证</span></a></td>
        </tr>
    </table>
</div>
<form method="post" action="validate.php" onsubmit="return check();" id="dform">
    <input type="hidden" name="action" value="<?php echo $action;?>"/>
    <table cellpadding="6" cellspacing="1" class="tb">
        <tr>
            <td class="tl">公司名</td>
            <td class="tr">
                <?php echo $user['company'];?>
                <span id="dcompany" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 营业执照</td>
            <td class="tr">
                <input name="post[business_license]" id="thumb" type="text" size="60" readonly/>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb').value, true);" class="t">[上传]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="_preview(Dd('thumb').value);" class="t">[预览]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dd('thumb').value='';" class="t">[删除]</a>
                <span id="dthumb" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span>证照有效期</td>
            <td class="tr">
                <script type="text/javascript" src="http://www.tecenet.com/file/script/calendar.js"></script>
                <input type="text" name="post[business_license_totime]" id="validDate" value="" size="10" onfocus="ca_show('validDate', this, '-');" readonly="" ondblclick="this.value='';">
                <img src="http://www.tecenet.com/file/image/calendar.gif" align="absmiddle" onclick="ca_show('validDate', this, '-');" style="cursor:pointer;">
                <label><input title="长期有效" type="checkbox" class="longTime" name="post[isBL_long_term]" value="1" >长期有效</label>
                <span id="dvalidDate" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"></td>
            <td class="tr upload-msg">
                <p>1.请将原件拍照或扫描上传，如果是复印件请加盖企业红色公章后拍照上传。</p>
                <p>2.支持.jpg .jpeg .bmp .png格式照片，大小不超过3M。</p>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span>生产/经营许可证</td>
            <td class="tr">
                <input name="post[product_license]" id="thumb1" type="text" size="60" readonly/>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb1').value, true, 'thumb1');" class="t">[上传]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="_preview(Dd('thumb1').value);" class="t">[预览]</a>
                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dd('thumb1').value='';" class="t">[删除]</a>
                <span id="dthumb1" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span>证照有效期</td>
            <td class="tr">
                <input type="text" name="post[product_license_totime]" id="validDate1" value="" size="10" onfocus="ca_show('validDate1', this, '-');" readonly="" ondblclick="this.value='';">
                <img src="http://www.tecenet.com/file/image/calendar.gif" align="absmiddle" onclick="ca_show('validDate1', this, '-');" style="cursor:pointer;">
                <span id="dvalidDate1" class="f_red"></span>
            </td>
        </tr>
        <tr>
            <td class="tl"></td>
            <td class="tr upload-msg">
                <p>1.请将原件拍照或扫描上传，如果是复印件请加盖企业红色公章后拍照上传。</p>
                <p>2.支持.jpg .jpeg .bmp .png格式照片，大小不超过3M。</p>
            </td>
        </tr>
        </tbody>
        <tr>
            <td class="tl">&nbsp;</td>
            <td class="tr" height="30">
                <input type="submit" name="submit" value=" 确 定 " class="btn"/>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
            </td>
        </tr>
    </table>
</form>
<script>
$(document).on("click",".longTime",function(){
var $dateInput = $(this).parent().parent().find("input[type='text']");
if($(this).is(':checked')){
$dateInput.attr("disabled",true);
$dateInput.val("");
}else{
$dateInput.attr("disabled",false);
}
});
</script>
<?php echo load('clear.js');?>
<?php if($MOD['vfax']) { ?>
<br/>
<!-- <table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">传真认证</td>
        <td class="tr">
            您可以传真有效证件至 <?php echo $MOD['vfax'];?> 进行认证，复印件上需注明会员名
        </td>
    </tr>
</table> -->
<?php } ?>
<script type="text/javascript">
    function check() {
        if (Dd('thumb').value.length < 15) {
            Dmsg('请上传营业执照', 'thumb');
            return false;
        }
        if (Dd('thumb1').value.length < 15) {
            Dmsg('请上传生产/经营许可证', 'thumb1');
            return false;
        }
        if (Dd('validDate').value.length < 8 && !$(".longTime").is(':checked') ) {
            Dmsg('请选择证照有效期', 'validDate');
            return false;
        }
        if (Dd('validDate1').value.length < 8 ) {
            Dmsg('请选择证照有效期', 'validDate1');
            return false;
        }
        return true;
    }
</script>
<?php } else if($action == 'vcompany') { ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>公司认证</span></a></td>
        </tr>
    </table>
</div>
<table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">公司名</td>
        <td class="tr f_b"><?php echo $user['company'];?></td>
    </tr>
    <?php if(!empty($validateData['business_license'])) { ?>
    <tr>
        <td class="tl">营业执照</td>
        <td class="tr f_b">
            <img src="<?php echo $validateData['business_license'];?>" width="280px" height="160px" />
        </td>
    </tr>
    <?php } ?>
    <?php if(!empty($validateData['isBL_long_term'])) { ?>
    <tr>
        <td class="tl">到期时间</td>
        <td class="tr f_b">长期有效</td>
    </tr>
    <?php } else if(!empty($validateData['business_license_totime'])) { ?>
    <tr>
        <td class="tl">到期时间</td>
        <td class="tr f_b"><?php echo date('Y-m-d',$validateData['business_license_totime']);?></td>
    </tr>
    <?php } ?>
    <?php if(!empty($validateData['product_license'])) { ?>
    <tr>
        <td class="tl">生产/经营许可证</td>
        <td class="tr f_b">
            <img src="<?php echo $validateData['product_license'];?>" width="280px" height="160px" />
        </td>
    </tr>
    <?php } ?>
    <?php if(!empty($validateData['product_license_totime'])) { ?>
    <tr>
        <td class="tl">到期时间</td>
        <td class="tr f_b"><?php echo date('Y-m-d',$validateData['product_license_totime']);?></td>
    </tr>
    <?php } ?>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_green"><?php if($isWaitValidate) { ?>审核中<?php } else { ?>已通过<?php } ?>
</td>
    </tr>
</table>
<?php } else if($action == 'bank') { ?>
<div class="menu">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="tab_on" id="Tab0"><a href="?action=<?php echo $action;?>"><span>银行帐号验证</span></a></td>
            <td class="tab_nav">&nbsp;</td>
            <td class="tab" id="Tab1"><a href="cash.php?action=setting"><span>银行帐号设置</span></a></td>
        </tr>
    </table>
</div>
<table cellpadding="10" cellspacing="1" class="tb">
    <tr>
        <td class="tl">收款方式</td>
        <td class="tr"><?php if($user['bank']) { ?><?php echo $user['bank'];?><?php } else { ?>未设置<?php } ?>
</td>
    </tr>
    <tr>
        <td class="tl">收款帐号</td>
        <td class="tr"><?php if($user['account']) { ?><?php echo $user['account'];?><?php } else { ?>未设置<?php } ?>
</td>
    </tr>
    <tr>
        <td class="tl">收款人</td>
        <td class="tr"><?php echo $user['truename'];?></td>
    </tr>
    <?php if($user['vbank']) { ?>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_green">已认证</td>
    </tr>
    <?php } else { ?>
    <tr>
        <td class="tl">认证状态</td>
        <td class="tr f_gray">未认证</td>
    </tr>
    <tr>
        <td class="tl">认证说明</td>
        <td class="tr f_red">银行帐号在申请提现后，由网站进行认证</td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
<?php include template('footer',$module);?>