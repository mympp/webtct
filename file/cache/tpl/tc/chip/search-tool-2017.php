<?php defined('IN_DESTOON') or exit('Access Denied');?><!--tc-search-->
        <div class="tc-search pull-left">
            <form id="" class="site-frm pull-left" action="<?php echo DT_PATH;?>/search.php" onsubmit="return Dsearch();">
                <div class="select-group" id="select-tab">
                    <button type="button" class="select-btn" id="select-btn">
                        默认全站<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" id="search-type">
                        <li><a href="javascript:void(0)" data-mid="0" data-mname="默认全站" rel="nofollow">默认全站</a></li>
                        <li><a href="javascript:void(0)" data-mid="9" data-mname="服务需求" rel="nofollow">服务需求</a></li>
                        <li><a href="javascript:void(0)" data-mid="9" data-mname="技术工程师" data-action="resume" rel="nofollow">技术工程师</a></li>
                        <li><a href="javascript:void(0)" data-mid="13" data-mname="厂商品牌" rel="nofollow">厂商品牌</a></li>
                        <li><a href="javascript:void(0)" data-mid="4" data-mname="厂商网店" rel="nofollow">厂商网店</a></li>
                        <li><a href="javascript:void(0)" data-mid="16" data-mname="产品平台" rel="nofollow">产品平台</a></li>
                        <li><a href="javascript:void(0)" data-mid="5" data-mname="供应信息" rel="nofollow">供应信息</a></li>
                        <li><a href="javascript:void(0)" data-mid="6" data-mname="求购信息" rel="nofollow">求购信息</a></li>
                        <li><a href="javascript:void(0)" data-mid="21" data-mname="文章中心" rel="nofollow">文章中心</a></li>
                        <li><a href="javascript:void(0)" data-mid="10" data-mname="问答平台" rel="nofollow">问答平台</a></li>
                        <li><a href="javascript:void(0)" data-mid="15" data-mname="共享下载" rel="nofollow">共享下载</a></li>
                    </ul>
                </div>
                <input type="hidden" name="moduleid" value="0" id="destoon_moduleid">
                <input type="hidden" name="from" value="1">
                <input type="hidden" name="spread" value="0" id="destoon_spread">
                <input type="hidden" name="action" value="" id="sresume">
                <input type="text" name="kw" value="" id="topkeyword" class="site-txt pull-left">
                <input type="submit" class="site-submit  pull-left" value="搜本站">
            </form>
            <form class="so-frm pull-left" action="http://so.tecenet.com/search.php" method="get" target="_blank" onsubmit="return soTecnentValue();">
                <input type="text" name="keyword" value="" id="soInputTxt" class="so-txt" autocomplete="off">
                <input class="so-submit" type="submit" value="搜医搜">
            </form>
        </div>
<script>
    function soTecnentValue(){
        var sokeyword = document.getElementById("topkeyword").value;
        document.getElementById("soInputTxt").value = sokeyword;
        return true;
    }
    $(document).ready(function(){
        $('#search-type a').click(function(){
            $('#select-btn').html($(this).data('mname')+'<span class="caret"></span>');
            $('#destoon_moduleid').val($(this).data('mid'));
            if($(this).data('mid') == 9 && $(this).data('action') == 'resume') $('#sresume').val('resume');
            $('#search-type').hide();
        });
        $('#select-tab').mouseover(function(){
            $('#search-type').show();
        });
        $('#select-tab').mouseout(function(){
            $('#search-type').hide();
        });
    });
</script>
<!--tc-search end-->