<?php defined('IN_DESTOON') or exit('Access Denied');?><div class="webmenu">
<div class="youcan">
<h4 id="youcan">
<a href="<?php if($page=='index') { ?>javascript:void(0)<?php } else { ?><?php echo DT_PATH;?><?php } ?>
"><font id="youcantext" class="wcolor">天成网首页</font></a>
<?php if($page=='index') { ?><span>&nbsp;</span><?php } ?>
</h4>
<div class="leftmenu" id="leftmenu" >
<div id="sidebar">
</div> 
</div>
</div>
<div  class="webmenulist" id="mini-dropdown-2">
<ul class="dropdown" id="nav">
<?php $menuy=" class='menuy'";?>
<?php $menun=" class='menun'";?>
<li <?php echo $menun;?>><a title="医疗器械-技术服务需求" href="<?php echo $MODULE['9']['linkurl'];?>"  class="wcolor">设备技术服务<font id="topfw" class="f12 fontsong"></font></a>
<ul>
<li><a href="<?php echo $MODULE['9']['linkurl'];?>search-htm-action-job.html">寻找设备服务需求</a></li>
<li><a href="<?php echo $MODULE['9']['linkurl'];?>search-htm-action-resume.html">寻找技术工程师</a></li>
<li><a href="<?php echo $MODULE['16']['linkurl'];?>search-htm-tc-9-list-1-catid-0-stype-1.html">寻找配件耗材</a></li>
</ul>
</li>
<li <?php echo $menun;?>><a title="医疗器械产品目录" href="<?php echo $MODULE['16']['linkurl'];?>"  class="wcolor">产品服务平台<font id="topmall" class="f12 fontsong"></font></a>
        <ul>
<li><a href="<?php echo $MODULE['16']['linkurl'];?>index.php?action=mall">医疗产品库</a></li>
<li><a href="<?php echo $MODULE['16']['linkurl'];?>search-htm-stype-1-list-1.html">配件耗材专区</a></li>
<li><a href="<?php echo $MODULE['12']['linkurl'];?>">科室解决方案</a></li>
        </ul>
</li>
<li <?php echo $menun;?> id="buypaymenu"><a href="<?php echo $MODULE['6']['linkurl'];?>"   class="wcolor">招标采购平台<font id="buypay" class="f12 fontsong"></font></a>
<ul>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=1816');?>">设备类招标专区</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=1817');?>">服务类招标专区</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=2077');?>">试剂类招标专区</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=1818');?>">药品类招标专区</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=2149');?>">耗材类招标专区</a></li>
<li><a href="<?php echo $MODULE['6']['linkurl'];?><?php echo rewrite('list.php?catid=2150');?>">其他类招标专区</a></li>
</ul>
</li>
<li <?php echo $menun;?>><a title="医疗器械厂家目录" href="<?php echo $MODULE['13']['linkurl'];?>" class="wcolor">厂家品牌推广<font id="topbrand" class="f12 fontsong"></font></a>
<ul>
<li><a href="<?php echo $MODULE['13']['linkurl'];?>list-htm-catid-858.html">国内厂家/品牌信息</a></li>
<li><a href="<?php echo $MODULE['13']['linkurl'];?>list-htm-catid-859.html">国外厂家/品牌信息</a></li>
<li><a title="厂家/供应商宣传网" href="<?php echo $MODULE['4']['linkurl'];?>">各地厂家网站</a></li>
</ul>
</li>
<li <?php echo $menun;?>><a href="javascript:void(0)" class="wcolor mou_i">供需服务平台<font id="topbrand" class="f12 fontsong"></font></a>
<ul>
<?php if($MODULE['7']['linkurl']) { ?><li><a href="<?php echo $MODULE['7']['linkurl'];?>" >医疗科技网</a></li><?php } ?>
<li><a href="<?php echo $MODULE['5']['linkurl'];?>">供求信息中心</a></li>
<?php if($MODULE['28']['linkurl']) { ?><li><a href="<?php echo $MODULE['28']['linkurl'];?>">医疗行业人才网</a></li><?php } ?>
<li><a href="<?php echo $MODULE['1']['linkurl'];?>taoxinxi/">实时行情信息</a></li>
</ul>
</li>
<li <?php echo $menun;?>><a href="javascript:void(0)" class="wcolor mou_i">更多精彩频道<font id="moremodule" class="f12 fontsong"></font></a>
<ul>
<?php if($MODULE['21']['linkurl']) { ?><li><a href="<?php echo $MODULE['21']['linkurl'];?>" >医疗资讯新闻</a></li><?php } ?>
<?php if($MODULE['10']['linkurl']) { ?><li><a href="<?php echo $MODULE['10']['linkurl'];?>">天成问答平台</a></li><?php } ?>
<?php if($MODULE['8']['linkurl']) { ?><li><a href="<?php echo $MODULE['8']['linkurl'];?>" >医疗展会信息</a></li><?php } ?>
<?php if($MODULE['14']['linkurl']) { ?><li><a href="<?php echo $MODULE['14']['linkurl'];?>">医疗视频教程</a></li><?php } ?>
<?php if($MODULE['15']['linkurl']) { ?><li><a href="<?php echo $MODULE['15']['linkurl'];?>">技术资料共享</a></li><?php } ?>
<!-- <li><a href="http://www.yixieweixiu.com" target="_blank">医疗技术论坛</a></li> -->
</ul>
</li>
</ul>
</div>
<script type="text/javascript">
$(function(){
    $('#mini-dropdown-2 .dropdown').miniDropdown({
      animation: 'slide', 
      show: 100,
      hide: 100,
      delayIn: 100,
      delayOut: 100
    });
});
</script>
<div class="webmem">
<ul id="mstatus">
<li><img src="<?php echo DT_SKIN;?>image/loadb.gif" style="padding-top:5px;"></li>
</ul>
<?php if($head_mobile!='http://www.tecenet.com/wap/down.html') { ?><span id="joinusto" class="hd"></span><?php } ?>
</div>
</div>