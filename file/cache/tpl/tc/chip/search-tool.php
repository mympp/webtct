<?php defined('IN_DESTOON') or exit('Access Denied');?><div class="topSearchInner clearfix" onmouseover="Dd('hotkey').className=''" onmouseout="Dd('hotkey').className='hotkey'">
    <form id="destoon_search" action="http://www.tecenet.com/search.php" onsubmit="return Dsearch();">   
        <div class="searchBox clearfix">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>" id="destoon_moduleid"/>
<input type="hidden" name="from" value="<?php echo $moduleid;?>" />
<input type="hidden" name="spread" value="0" id="destoon_spread"/>
<input type="hidden" name="action" value="" id="sresume"/>
<input type="text" name="kw" value="<?php echo $kw;?>" id="topkeyword" class="tokw" />
            <div class='searchs'>
                <div onclick="chulai('sellists')">
                <span class='lenstr' id='topkws'><?php if($moduleid>2) { ?><?php echo $MODULE[$moduleid]['name'];?><?php } else { ?>默认全站<?php } ?>
<i></i></span>
                </div>
                <ul id='sellists' class='hd'>
                <li ><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',0);guanbi('sellists');"  rel="nofollow">默认全站</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',9);guanbi('sellists');"  rel="nofollow">服务需求</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',9);guanbi('sellists');Dd('sresume').value='resume'" class='f12'  rel="nofollow">技术工程师</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',13);guanbi('sellists');"  rel="nofollow">厂商品牌</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',4);guanbi('sellists');"  rel="nofollow">厂商网店</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',16);guanbi('sellists');"  rel="nofollow">产品平台</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',5);guanbi('sellists');"  rel="nofollow">供应信息</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',6);guanbi('sellists');"  rel="nofollow">求购信息</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',21);guanbi('sellists');"  rel="nofollow">文章中心</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',10);guanbi('sellists');"  rel="nofollow">问答平台</a></li>
                <li><a href='javascript:void(0)' onclick="selectlist('topkws',this.innerText,'destoon_moduleid',15);guanbi('sellists');"  rel="nofollow">共享下载</a></li>
                </ul>
            </div>
            <input type="submit" class='seasubmit' value="搜本站">
        </div>
    </form>
    <form action="http://so.tecenet.com/search.php" method="post" target="_blank" onsubmit="return soTecnentValue();">
        <input type="text" name="keyword" value="" id="soInputTxt" class="so-input-txt" autocomplete="off">
        <input class="so-input-submit" type="submit" value="搜医搜">
    </form>
    <div class="hotkey" id="hotkey"><?php echo tag("moduleid=1&table=keyword&condition=moduleid=16 and length(word)>4   and length(word)<10 and status=3 &pagesize=20&order=month_search desc&key=month_search&template=list-search_kw&debug=0", -2);?></div>
</div>
<script>
    function soTecnentValue(){
        var sokeyword = document.getElementById("topkeyword").value;
        document.getElementById("soInputTxt").value = sokeyword;
        return true;
    }
</script>