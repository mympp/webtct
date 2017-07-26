<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<style>
	.channel-class ul{ border-left:1px solid #ccc;}
	.channel-class ul li{float:left;height:33px;text-align: center;line-height: 33px;font-size:12px;padding:2px;margin-left:-1px;min-width:120px;background:white;border:1px solid #ccc;}
	.channel-class .current{border-bottom:0px;}
	.content {background:white;border-right:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;}
</style>
<div class="channel-class">
    <ul class="channel-class-hd">
        <li class="current">国产器械</li>
        <li class="">进口器械</li>
        <li class="">食品生成许可证（SC）</li>
        <li class="">食品生产许可证（QS）</li>
       	<li class="">更多内容</li>
    </ul>
    <div style="clear:both;"></div>
    <div class="channel-class-bd">
        <div class="content" id="tableid26" style="display: block;">
        <br/>
        <?php echo $keyword_list_26; ?>
        <br/>
        <?php echo $title_list_26; ?>
        </div>
        <div class="content" id="tableid27" style="display: none;">
        1234
        </div>
        <div class="content" id="tableid120" style="display: none;">
        12345
        </div>
        <div class="content" id="tableid91" style="display: none;">
        12345
        </div>
    </div>
</div>
<script>
	$(function(){
        var $li = $('.channel-class-hd>li');
        var $ul = $('.channel-class-bd>div');
        $li.mouseover(function(){
            var $this = $(this);
            var $t = $this.index();
            $li.removeClass();
            $this.addClass('current');
            $ul.css('display','none');
            $ul.eq($t).css('display','block');
        })
    });
   
</script>
<?php include tpl('footer');?>