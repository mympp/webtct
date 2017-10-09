<?php defined('IN_DESTOON') or exit('Access Denied');?><?php $head_css = [DT_SKIN.'tecenet.login.css'];?>
<?php $footer_js = [DT_PATH.'file/script/tecenet.notify.min.js'];?>
<?php include template('header2017');?>
<div class="login-wrap">
    <div class="w1200 box-center clearfix">
        <div class="login-box pull-right">
            <div class="login-hd clearfix">
                <h2 class="pull-left">登录</h2>
                <span class="pull-right link">还没有账号？<a href="register.php">注册用户</a>。忘记密码？<a href="send.php">找回密码</a></span>
            </div>
            <div class="login-bd">
                <form action="login.php" method="post" role="form" onsubmit="return checkFrm(this)">
                <input type="hidden" name="submit" value="1" />
                <input type="hidden" name="backto" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />
                <input type="hidden" name="forward" value="<?php echo $forward;?>" />
                    <div class="form-item">
                        <div class="item-tip">用户名/手机号码/邮箱</div>
                        <input type="text" name="username" class="form-input form-control" tabindex="1" autocomplete="off">
                    </div>
                    <div class="form-item">
                        <div class="item-tip">密 码</div>
                        <input type="password" name="password" class="form-input form-control" tabindex="2" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" >
                    </div>
                    <div class="form-item captcha clearfix">
                        <div class="item-tip">验证码</div>
                        <input type="text" name="captcha" class="form-input form-control" tabindex="3">
                        <img src="<?php echo DT_PATH;?>api/captcha.png.php?action=image?r=1482116554719" alt="图形验证码">
                        <a tabindex="4" href="javascript:void(0);" class="captcha-tips" onclick="changeCaptcha();">看不清 <br> 换一张</a>
                    </div>
                    <div class="form-item">
                        <input type="submit" class="btn btn-success" value="登 录" tabindex="5">
                    </div>
                </form>
                <!--第三方登录-->
                <div class="other-signup clearfix">
                    <span class="name">第三方账号登录</span>
                    <div class="btn-area">
                        <a title="微信登录" class="icon wechat" href="<?php echo DT_PATH;?>api/oauth/wechat/connect.php">微信帐号登录</a>
                        <a title="QQ帐号登录" class="icon qq" href="<?php echo DT_PATH;?>api/oauth/qq/connect.php">QQ帐号登录</a>
                    </div>
                </div>
                <!--第三方登录 end-->
            </div>
        </div>
    </div>.
</div>
<script src="<?php echo DT_PATH;?>file/script/tecenet.notify.min.js"></script>
<script>
function getCookie(name){
var search = name + "="//查询检索的值
    var returnvalue = "";//返回值
    if (document.cookie.length > 0) {
    sd = document.cookie.indexOf(search);
    if (sd!= -1) {
        sd += search.length;
        end = document.cookie.indexOf(";", sd);
        if (end == -1)
        end = document.cookie.length;
         //unescape() 函数可对通过 escape() 编码的字符串进行解码。
        returnvalue=document.cookie.substring(sd, end);
     }
   } 
   return decodeURIComponent(returnvalue);
}
function delCookie(name){
 $.ajax({
 type:'POST',
 url:"<?php echo DT_PATH;?>ajax.php?action=delcookie&name="+name,
 success:function(){},
 error:function(){}
 });
}
var tip = getCookie('errorTip');
if(tip){
$.notify(tip, {
        type: "danger",
        offset: 0
    });
    delCookie('errorTip');
}
</script>
<script>
    // input框美化
    function login_reg_input(obj) {
        $(obj).blur(function() {
            if ($.trim($(this).val()) == "") {
                $(this).removeClass("form-input-focus");
                $(this).prev(".item-tip").removeClass("item-tip-focus")
            }
        });
        $(obj).focus(function() {
            if (!$(this).hasClass("form-input-focus")) {
                $(this).addClass("form-input-focus");
                $(this).prev(".item-tip").addClass("item-tip-focus")
            }
        });
        $(".item-tip").click(function() {
            $(this).next().focus()
        })
    }
    function SetInputCss(obj) {
        $(obj).each(function() {
            if ($.trim($(this).val()) != "") {
                $(this).addClass("form-input-focus");
                $(this).prev(".item-tip").addClass("item-tip-focus")
            }
        })
    }
    login_reg_input(".form-input");
    SetInputCss(".form-input");
    // 更换图片验证码
    function changeCaptcha(){
        $(".captcha img").attr("src","<?php echo DT_PATH;?>api/captcha.png.php?action=image&height=42&refresh="+Math.random());
    }
    // 表单控制验证
    function checkFrm(frm){
        var username = $("input[name='username']");
        var password = $("input[name='password']");
        var captcha = $("input[name='captcha']");
        if( username.val() == ""){
            username.focus();
            username.parent().addClass("shake");
            setTimeout(function(){username.parent().removeClass("shake")},1000);
            return false;
        }
        if( password.val() == ""){
            password.focus();
            password.parent().addClass("shake");
            setTimeout(function(){password.parent().removeClass("shake")},1000);
            return false;
        }
        if( captcha.val() == ""){
            captcha.focus();
            captcha.parent().addClass("shake");
            setTimeout(function(){captcha.parent().removeClass("shake")},1000);
            return false;
        }
        return true;
    }
</script>
<?php include template('footer2017');?>