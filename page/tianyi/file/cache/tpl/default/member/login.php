<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('min_header');?>
<style type="text/css">
.tips {position:absolute;z-index:100;width:300px;background:url('image/tips_bg.gif') no-repeat 0 bottom;overflow:hidden;margin:-5px 0 0 -10px;}
.tips div{background:url('image/tips_top.gif') no-repeat;line-height:22px;padding:8px 10px 8px 35px;}
</style>
<div class="logbg">
<div class="log_reg">
<div class="log_reg_ad">
<img src="/skin/default/image/log_reg_bg.png" alt=""/>
</div>
<div class="log_reg_tab">
<div class="userlogin">
<span>会员登录</span>
</div>
<form method="post" action="<?php echo $DT['file_login'];?>" onsubmit="return Dcheck();">
<input name="forward" type="hidden" value="<?php echo $forward;?>"/>
<input name="auth" type="hidden" value="<?php echo $auth;?>"/>
<div>
<input class="user_name" placeholder="用户名" name="username" type="text" id="username" value="<?php echo $username;?>"/>
<input class="user_pass" placeholder="密码" name="password" type="password" id="password"<?php if(isset($password)) { ?> value="<?php echo $password;?>"<?php } ?>
/>
<div class="saltinfo">
<input class="user_salt" placeholder="验证码"/>
<span class="user_salt_num">2345d</span>
</div>
<div class="c_b"></div>
<div class="user_tips">
<span class="forget_pass"><a href="send.php">忘记密码？</a></span>
<span class="go_reg" onclick="Go('<?php echo $DT['file_register'];?>?forward=<?php echo urlencode($forward);?>');">去注册>></span>
</div>
<button class="user_btn" name="submit">登录</button>
</div>
<div class="other_login">
<div>
<span class="o_line">------------------&nbsp;</span>
<span class="o_text">第三方账号登陆</span>
<span class="o_line">&nbsp;----------------</span>
</div>
<div class="log_wq">
<a href="<?php echo DT_PATH;?>api/oauth/wechat/connect.php"><img src="/skin/default/image/wei_log.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo DT_PATH;?>api/oauth/qq/connect.php"><img src="/skin/default/image/qq_log.png"/></a>
</div>
</div>
</form>
</div>
</div>
</div>
<script type="text/javascript">
if(Dd('username').value == '') {
Dd('username').focus();
} else {
Dd('password').focus();
}
function Dcheck() {
if(Dd('username').value == '') {
confirm('请输入登录名称');
Dd('username').focus();
return false;
}
if(Dd('password').value == '') {
confirm('请输入密码');
Dd('password').focus();
return false;
}
<?php if($MOD['captcha_login']) { ?>
if(!is_captcha(Dd('captcha').value)) {
confirm('请填写验证码');
Dd('captcha').focus();
return false;
}
<?php } ?>
return true;
}
</script>
<?php include template('min_footer');?>