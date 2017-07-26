    <!--加盟咨询-->
    <div class="contact" id="contact" style="background-color: #2d2d2d;">
        <div class="layout">
            <div class="layout-hd">
                <h2>加盟咨询</h2>
                <p>CONTACT</p>
            </div>
            <div class="layout-bd clearfix">
                <form action="contact.php" class="form-wrap pull-left" method="post">
                	<input type="hidden" name="job" value="guestbook">
                	<input type="hidden" name="title" id="title" />
                	<input type="hidden" name="username" value="<?php echo USERNAME  ?>">
                	<input type="hidden" name="action" value="send">
                    <div class="form-hd">
                        <strong>欢迎咨询加盟代理事宜</strong>
                        <p>勾选您需要咨询的问题</p>
                    </div>
                    <div class="checkbox-area">
                        <label for="check-1"><input type="checkbox" name="qc" id="check-1" value="请问加盟NV TOYS网店所需条件有哪些？">请问加盟NV TOYS网店所需条件有哪些？</label>
                        <label for="check-2"><input type="checkbox" name="qc" id="check-2" value="我想详细了解贵品牌的加盟流程，请与我联系！">我想详细了解贵品牌的加盟流程，请与我联系！</label>
                        <label for="check-3"><input type="checkbox" name="qc" id="check-3" value="我有兴趣，请问贵品牌拿货折扣和调换货政策？">我有兴趣，请问贵品牌拿货折扣和调换货政策？</label>
                        <label for="check-4"><input type="checkbox" name="qc" id="check-4" value="作为贵品牌项目的网店加盟商能得到哪些支持？">作为贵品牌项目的网店加盟商能得到哪些支持？</label>
                        <label for="check-5"><input type="checkbox" name="qc" id="check-5" value="我已留下邮箱，请将详细资料发邮件给我。">我已留下邮箱，请将详细资料发邮件给我。</label>
                    </div>
                    <textarea id=""  placeholder="留言补充…" name="content"></textarea>
                    <p class="msg">请填写联系方式以便我们及时与您取得联系（我们会对您的资料予以保密！）</p>
                    <div class="form-group pull-left">
                        <label class="form-label" for="name">您的姓名：</label>
                        <input class="form-text" type="text" id="name" name="truename" >
                    </div>
                    <div class="form-group pull-right">
                        <label class="form-label" for="area">所在地区：</label>
                        <input class="form-text" type="text" id="area" placeholder="填写您的所在地" name="company">
                    </div>
                    <div class="form-group pull-left">
                        <label class="form-label" for="tel">移动电话：</label>
                        <input class="form-text" type="text" id="tel" name="telephone" >
                    </div>
                    <div class="form-group pull-right">
                        <label class="form-label" for="qq_email">QQ /邮箱：</label>
                        <input class="form-text" type="text" id="qq_email" name="qq" >
                    </div>

                    <input type="submit" value=">>>> 提交咨询 <<<<">
                </form>
                <div class="already pull-right">
                    <div class="hd">已加盟伙伴</div>
                    <div class="bd">
                        <ul class="already-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    	function reloadcaptcha() {
			document.getElementById('captchapng').src = 'http://www.tecenet.com/api/captcha.png.php?action=image&refresh='+Math.random();
			document.getElementById('captchapng').innerHTML = '';
			document.getElementById('captchapng').value = '';
		}
    </script>
    <!--加盟咨询 end-->