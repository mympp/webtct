<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if($moduleid>2&&!$itemid&&!$catid&&!$kw) { ?>
<?php $tagt = tag("table=link&condition=status=3 and link_moduleid=$moduleid&areaid=$cityid&pagesize=".$DT['page_text']."&order=listorder asc,itemid desc&template=null")?>
<?php if($tagt) { ?>
<div class="whitebg grayb pd10">
<b>友情链接：</b><?php if(is_array($tagt)) { foreach($tagt as $z => $t) { ?><a href="<?php echo $t['linkurl'];?>" title="<?php echo $t['alt'];?>" class="mr10" target="_blank"><?php echo $t['title'];?></a><?php } } ?>
<a href="<?php echo $EXT['link_url'];?><?php echo rewrite('index.php?action=reg');?>" class="rcolor f12"  rel="nofollow">申请加入>></a>
</div> 
<?php } ?>
<?php } ?>
<?php if($page=='index') { ?>
<div class="autoheight grayb whitebg">
<div class="seltype">
<div class="fr mr5"><a href="<?php echo $EXT['link_url'];?><?php echo rewrite('index.php?action=reg');?>" class="rcolor f14"  rel="nofollow">申请加入>></a></div>
<ul>
<?php $tagt = tag("table=type&condition=item='link'&pagesize=10&order=listorder asc&template=null")?>
<?php $co=count($tagt);?>
<?php if(is_array($tagt)) { foreach($tagt as $z => $t) { ?>
<li  <?php if($z==0) { ?>class="typey"  <?php } else { ?>  class="typen" <?php } ?>
 onmouseover="selecttab('type',<?php echo $co;?>,<?php echo $z+1;?>);"  id="typetab<?php echo $z+1;?>"><a href="<?php echo $EXT['link_url'];?>index.php?typeid=<?php echo $t['typeid'];?>"><?php echo $t['typename'];?></a></li>
<?php } } ?>
</ul>
</div>
<div class='divline'></div>
<div class="pd5 friendlink">
<?php if(is_array($tagt)) { foreach($tagt as $z => $t) { ?>
<?php $tags = tag("table=link&condition=status=3  and link_moduleid=0 and typeid=".$t['typeid']."&pagesize=".$DT['page_text']."&order=listorder asc,itemid desc&template=null")?>
<div id="typediv<?php echo $z+1;?>" <?php if($z!=0) { ?> class="hd"<?php } ?>
>
 <?php if(is_array($tags)) { foreach($tags as $z => $v) { ?><span class="lenstr w140 ml10"> · <a href="<?php echo $v['linkurl'];?>" title="<?php echo $v['alt'];?>" class="mr10" target="_blank"><?php echo $v['title'];?></a></span><?php } } ?>
 </div>
<?php } } ?>
</div>
</div>
<?php } ?>
<?php if($kw != '' && is_numeric($items)) { ?>
<!--so-tc-vs-->
<div class="so-tc-vs">
<div class="so-tc-vs-hd">关于“<span class="so-tc-vs-kw"></span>”的搜索结果</div>
<div class="so-tc-vs-bd">
<div class="tc-data"><i>天成医疗网总共有</i><span><?php echo $items;?></span><i>条数据</i></div>
<div class="so-data"><i>医搜总共有</i><span>0</span><i>条数据</i></div>
<a href="http://so.tecenet.com/" target="_blank" class="so-btn">进入医搜</a>
</div>
</div>
<script>
function getSearchCountData(){
var keyword = $("#topkeyword").val();
if ( keyword == "" ){
$(".so-tc-vs").hide();
}else{
$(".so-tc-vs").show();
$(".so-tc-vs-kw").html(keyword);
$(".so-btn").attr("href","http://so.tecenet.com/search.php?type=0&keyword="+keyword);
$.ajax({
type : 'GET',
url: 'http://'+window.location.host+'/ajax.php',
data : 'action=sogex_count&keyword='+keyword,
cache:true,
success:function(data,status){
if(data == '-1'){
console.log("参数错误");
}else{
$(".so-tc-vs .so-data span").html(data);
}
}
});
}
}
getSearchCountData();
</script>
<!--so-tc-vs end-->
<?php } ?>
<br class='clear'></div><!-- 白色区结束-->
<br class='clear'></div><!-- 固定宽度1003结束-->
</div><!--背景结束-->
<div class="foot autoheight <?php if($moduleid==1) { ?>footbg<?php } else { ?>footbg2<?php } ?>
"><!-- 底部栏目开始 -->
<div class="webw">
<?php if(!$level) { ?>
<dl class="h30 lh30 grayb nt nl nr cut" style="width:995px;">
<dt class='fl f14 pt5'><a href="<?php echo $MODULE['1']['linkurl'];?>" class=" <?php if($moduleid==1) { ?>color<?php } ?>
" title="医疗器械网">天成医疗网</a></dt>
<dd class="fl ml10"><a href="<?php echo $MODULE['9']['linkurl'];?>" title="医疗器械维修服务">设备技术服务网</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['16']['linkurl'];?>" title="医疗器械产品大全">产品服务网</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['6']['linkurl'];?>" title="医疗器械求购">招标采购平台</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['16']['linkurl'];?>search-htm-stype-1-list-1.html" title="医疗器械维修配件">配件销售网</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['13']['linkurl'];?>" title="医疗器械厂家品牌">品牌信息网</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['21']['linkurl'];?>" title="医疗资讯网">医疗资讯网</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['4']['linkurl'];?>">厂商网店</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['5']['linkurl'];?>" title="医疗器械供应信息">供应平台</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['15']['linkurl'];?>" title="医疗资料共享">医疗资料共享</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['10']['linkurl'];?>" title="医疗问答平台">医疗问答平台</a></dd>
<dd class="fl ml10"><a href="<?php echo $MODULE['1']['linkurl'];?>taoxinxi">群内行情信息</a></dd>
</dl>
<div class='abouttece'>
<dl >
<dt>关于本站</dt>
<?php echo tag("table=webpage&condition=item=1 and level=1&areaid=$cityid&order=listorder&template=list-webpage&pagesize=5");?>
</dl>
<dl>
<dt>会员服务</dt>
<dd><a  href="<?php echo $MODULE['1']['linkurl'];?>member/register.php">会员注册</a></dd>
<dd><a href="<?php echo $MODULE['1']['linkurl'];?>member/grade.php">会员升级</a></dd>
<dd><a  href="<?php echo $MODULE['1']['linkurl'];?>member/grade.php" rel="nofollow">权限说明</a></dd>
<?php if($EXT['guestbook_enable']) { ?> <dd><a  href="<?php echo $EXT['guestbook_url'];?>" rel="nofollow">在线留言</a></dd><?php } ?>
<?php if($EXT['gift_enable']) { ?> <dd><a  href="<?php echo $EXT['gift_url'];?>" rel="nofollow">积分换礼</a></dd><?php } ?>
<?php if($EXT['poll_enable']) { ?> <dd><a  href="http://www.eydsp.com/eytopic/yiliao/index.html" target="_blank">广告推广</a></dd><?php } ?>

<dd><a href="http://www.eydsp.com/500mb/020/pc/yl/index.html" target="_blank">网站建设</a></dd>

</dl>
<dl>
<style type="text/css">.abouttece dl{width: 165px;}</style>
<dt>增值服务</dt>
<dd><a href="http://www.tecenet.com/about/intro.html#tianYiEngineering">医学工程服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#tianJiaoMedical">设备管理服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#chengTianTrading">供应和信息系统服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#keLangMedical">科技服务平台</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#yiLiantongLogistics">物流服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#hospitalInvestment">康复护理医养结合服务</a></dd>
</dl>
<dl>
<dt>&nbsp;</dt>
<dd><a href="http://www.tecenet.com/about/intro.html#humanResources">人力资源服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#productsServices">产业服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#E-businessMarketing">电子商务服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#importExport">综合外贸服务</a></dd>
<dd><a href="http://www.tecenet.com/about/intro.html#healthServices">健康管理服务</a></dd>
<dd><a href="http://yiliantong.tecenet.com/" rel="nofollow">物流快递查询</a></dd>
</dl>
<dl>
<dt>关注我们</dt>
<dd><a href="<?php echo $head_mobile;?>" rel="nofollow"><img src="<?php echo DT_SKIN;?>image/mobile.gif" class="mid"> 手机版天成</a></dd>
<dd><a href="http://weibo.com/tecenet" target="_blank"  rel="nofollow"><img src="<?php echo DT_SKIN;?>image/is_03.gif" class="mid"> 新浪微博</a></dd>
<dd><a href="http://t.qq.com/GZtianchengyiliao" target="_blank"  rel="nofollow"><img src="<?php echo DT_SKIN;?>image/is_09.gif" class="mid"> 腾讯微博</a></dd>
<dd><a href="http://user.qzone.qq.com/2990334470 " target="_blank"  rel="nofollow"><img src="<?php echo DT_SKIN;?>image/is_13.gif" class="mid"> QQ空间</a></dd>
</dl>
<dl>
<dt>Q群平台</dt>
<dd><a target="_blank"  href="http://wp.qq.com/wpa/qunwpa?idkey=36521899e56af426ede6c2335f41131172b7b130ea717a4a22bce0d26bce3820"  rel="nofollow"><div class='qqgroup'>维修技术群</div></a></dd>
<dd><a target="_blank"  href="http://wp.qq.com/wpa/qunwpa?idkey=c7e5fc9f68e781cad6b598caaef8fc6ba4e7552cfe3a8adf46b4023780552f41"  rel="nofollow"><div class='qqgroup'>器械买卖群</div></a></dd>
<dd><a target="_blank"  href="http://wp.qq.com/wpa/qunwpa?idkey=438ebd7bfa07429507fe607834ec01b4ab218f46f1883ce6b597de19b0332d19"  rel="nofollow"><div class='qqgroup'>供应商群</div></a></dd>
<dd><a target="_blank"  href="http://wp.qq.com/wpa/qunwpa?idkey=30ecef7c1c1f940add0714e3849c62f5631801493171e6d8e7c8988d34eba578"  rel="nofollow"><div class='qqgroup'>实验室装修</div></a></dd>
</dl>
</div>
<?php } ?>
<div class='divline'></div>
<hr size=2 >
<div class="copyright">
<div class="tecehonor" id="tecehonor">
<img src="<?php echo DT_SKIN;?>image/tecesprite.gif">
<a href="http://www.baidu.com/s?wd=www.tecenet.com%40v"  target="_blank"   rel="nofollow"><img src="<?php echo DT_SKIN;?>image/ebs.png"></a>
<a href="http://app1.sfda.gov.cn/datasearch/face3/content.jsp?tableId=28&tableName=TABLE28&Id=5329" target="_blank"   rel="nofollow"><img src="<?php echo DT_SKIN;?>image/fda.png"></a>
</div>
<script type="text/javascript">
if(getcookie('clt')=='pc'){Dd('tecehonor').innerHTML='<div class="tc pd10"><A class="pd10 f16 tc grayb whitebg color" href="http://wap.tecenet.com/index.php?moduleid=<?php echo $moduleid;?>&itemid=<?php echo $itemid;?>&clt=touch">转入手机版</a></div><div class="divline"></div>';}
</script>
<div class='tececontact'>
<?php echo $DT['copyright'];?>
<a href="http://www.51.la/?14914538" target="_blank" id="tjs"  rel="nofollow">_</a>
<a href="http://tongji.baidu.com/web/welcome/ico?s=2b363fb3d03ff9991c4971afddf8731d" target="_blank" id="tjsc"  rel="nofollow">_</a>
<?php if($moduleid == 28) { ?>
<a href="http://www.51.la/?17742009" target="_blank" id="tjs"  rel="nofollow">_</a>
<?php } ?>
</div>
</div>
</div>
<div class='divline'></div>
</div>
<?php if(DT_DEBUG) { ?><div class="f12"><?php echo debug();?></div><?php } ?>
<?php if(!$nokefu) { ?>
<script>
$(document).ready(function(){
  $("#ico1").bind("click",function(){$('#onlineService').animate({width: 'show', opacity: 'show'}, 'normal');icos('1');seltab('kefutab',1,3);return false;});
  $("#ico2").bind("click",function(){$('#onlineService').animate({width: 'show', opacity: 'show'}, 'normal');icos('2');seltab('kefutab',2,3);return false;});
  $("#ico3").bind("click",function(){$('#onlineService').animate({width: 'show', opacity: 'show'}, 'normal');icos('3');seltab('kefutab',3,3);return false;});
  $("#ico5").bind("click",function(){$("html, body").animate({scrollTop:0}, 200);});
  $(document).bind("click",function(event){
if ($(event.target).isChildOf("#online_qq_layer") == false)
{$('#onlineService').animate({width: 'hide', opacity: 'hide'}, 'normal',function(){ $('#onlineService').hide(); }); icos(0);}});
jQuery.fn.isChildAndSelfOf = function(b){ return (this.closest(b).length > 0);};
jQuery.fn.isChildOf = function(b){ return (this.parents(b).length > 0);};
});
</script>
<div id="online_qq_layer">
<div id="online_qq_tab">
<div class="online_icon">
<ul>
<li><a href="javascript:void(0);"  id="ico1"rel="nofollow"><img src="<?php echo DT_SKIN;?>image/blank.gif" ></a></li>
<li><a href="javascript:void(0);"  id="ico2" rel="nofollow" ><img src="<?php echo DT_SKIN;?>image/blank.gif" ></a></li>
<li><a href="javascript:void(0);"  id="ico3" rel="nofollow" ><img src="<?php echo DT_SKIN;?>image/blank.gif" ></a></li>
<li><a href="javascript:void(0);"  id="ico4" rel="nofollow" onmouseover="if(Dd('destoon_member').innerText.indexOf('册')>0){this.href='<?php echo $MODULE['1']['linkurl'];?>guestbook/#ask';}else{this.href='<?php echo $MODULE['1']['linkurl'];?>member/ask.php?action=add';}"><img src="<?php echo DT_SKIN;?>image/blank.gif" ></a></li>
<li><a href="javascript:void(0);"   id="ico5" rel="nofollow" style="height:22px;"><img src="<?php echo DT_SKIN;?>image/blank.gif"  height=22  style="height:22px;"></a></li>
</ul>
</div>
</div>
<div id="onlineService">
<div class="online_windows">
<div class="online_w_c">
<dl id="kefutab1"  class="h30">
<dt>本站在线QQ客服</dt>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1465794385&site=qq&menu=yes"  rel="nofollow" ><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 产品服务：小宇 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2300379865&site=qq&menu=yes"  rel="nofollow"><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 招商推广：小天 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1928771453&site=qq&menu=yes"  rel="nofollow" ><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 设备技术：小谭 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=3381476778&site=qq&menu=yes"  rel="nofollow" ><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 配件耗材：小湛 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=379255200&site=qq&menu=yes"  rel="nofollow" ><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 资质服务：小孙 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1391268333&site=qq&menu=yes"  rel="nofollow"><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 管理软件：小张 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1515050627&site=qq&menu=yes"  rel="nofollow"><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 医疗人才：小张 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=786466321&site=qq&menu=yes"  rel="nofollow"><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 工程装修：小赵 </a></dd>
<dd><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=657911476&site=qq&menu=yes"    rel="nofollow"><img src='<?php echo DT_SKIN;?>image/blank.gif' class="qqico"> 网站客服：小成 </a></dd>
</dl>
<dl id="kefutab2" style="display:none" class="h30">
<dt>天成服务热线</dt>
<dd><font class="f16 ocolor">总机：020-22017999</font> </dd>
<dd>传真号码：<font class="f12">020-22017998</font> </dd>
<dd>产品服务：<font class="f12">4009669717</font> </dd>
<dd>网络推广：<font class="f12">4006173599</font> </dd>
<dd>供 应 链：<font class="f12">分机号（8003）</font> </dd>
<dd>物流服务：<font class="f12">分机号（8010）</font> </dd>
<dd>科研转化：<font class="f12">分机号（8016）</font> </dd>
<dd>设备技术：<font class="f12">分机号（8058）</font> </dd>
<dd>招聘培训：<font class="f12">020-22017981</font> </dd>
<dd>进 出 口：<font class="f12">020-22017991</font> </dd>
<dd>工程装修：<font class="f12">020-28955875</font> </dd>
</dl>
<dl id="kefutab3" style="display:none" class="sjapp">
<dt>手机APP及微信</dt>
<dd><a href='javascript:void(0)' onmouseover="seltab('sjapp',1,2);"  rel="nofollow">打开安卓手机应用二维码</a><p id="sjapp1" ><img src='<?php echo DT_PATH;?>file/image/and.png' width="110" height="110"><br>二维码扫一扫</p></dd>
<dd><a href='javascript:void(0)' onmouseover="seltab('sjapp',2,2);"  rel="nofollow">打开官方微信平台二维码</a><p id="sjapp2" style="display:none"><img src='<?php echo DT_PATH;?>file/image/weixin.jpg' width="110" height="110"><br>手机微信扫一扫</p></dd>
</dl>
</div>
</div>
</div>
</div>
<?php } ?>
<script type="text/javascript">
<?php if($destoon_task) { ?>
show_task('<?php echo $destoon_task;?>');
<?php } else { ?>
<?php include DT_ROOT.'/api/task.inc.php';?>
<?php } ?>
<?php if($lazy) { ?>$(function(){$("img").lazyload();});<?php } ?>
</script>
<script type="text/javascript" src="<?php echo $MODULE['2']['linkurl'];?>mem.php"></script>
<span style="display:none">
<?php if($baiduhm == 1) { ?>
<script type="text/javascript"> var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://"); document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F7366d5ce748c7a306307317faaf241ad' type='text/javascript'%3E%3C/script%3E")) </script>
<?php } ?>
<?php include template('analytics','include');?>
<?php if($moduleid == 28) { ?>
<script language="javascript" type="text/javascript" src="http://js.users.51.la/17742009.js"></script>
<?php } ?>
</span>
</body>
</html>
